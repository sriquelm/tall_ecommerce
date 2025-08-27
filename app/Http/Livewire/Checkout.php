<?php

namespace App\Http\Livewire;

use App\Models\User;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use Facades\App\Helpers\SKU;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Facades\Cart as CartService;
use App\Models\Transaction;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Facades\App\Services\CouponService;
use Transbank\Webpay\WebpayPlus\Transaction as WebpayTransaction; // primary class
use Transbank\Webpay\Options; // correct Options class for SDK 5.x
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class Checkout extends Component
{
    public $total;
    public $content;
    public $promo;

    public $currency;
    public $coupon;
    public $couponApplied = false;
    public $discount;

    public $registration = true;
    public $email;
    public $address;
    public $city;
    public $states = [];
    public $cities = [];
    public $country;
    public $phone;
    public $firstname;
    public $lastname;
    public $state;
    public $delivery_method = 'standard';
    public $payment_method = 'webpay';
    public $grand_total = 0;

    protected $newUserCreated = false;
    protected $sendingResetLinkStatus;


    public $addresses;
    public $selected_address;
    public $add_new_address = true;


    public $transaction;
    public $new_order_number;
    public $tracking_id;
    public $paymentIntentCreated = false;

    public $delivery_charge = [
        'standard' => 5,
        'express' => 16,
        'store_pickup' => 0,
    ];

    public $taxrate = 27;
    public $taxable = 0;

    protected $listeners = ['addToCart' => 'updateCart', 'couponCleared', 'couponApplyEvent'];

    public function updateDeliveryMethod($method)
    {
        if ($this->delivery_method !== $method) {
            $this->delivery_method = $method;
        }
    }

    public function updateCart()
    {
        $this->total =  CartService::total();
        $this->content = CartService::content();
        $this->adjustGrandTotal();
    }

    protected function rules()
    {
        $user = Auth::user();
        return  [
            'promo' => 'nullable|alpha_num:ascii|min:5',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user?->id),
            ],
            'firstname' => 'required|min:3|max:100',
            'lastname' => 'nullable|min:3|max:100',
            'address' => 'required|string',
            'city' => 'required|exists:cities,id',
            'country' => 'required|string',
            'phone' => [
                'nullable',
                Rule::unique('customers', 'phone')->ignore($user?->customer?->id, 'id'),
            ],
            'state' => 'required|exists:states,id',
        ];
    }

    protected function messages()
    {
        return ['promo' => __('validation.promo')];
    }

    public function updated($name)
    {
        $this->resetValidation($name);

        if ($name === 'promo') {
            $this->validateOnly($name);
        }

        if ($name === 'phone' && $this->phone) {
            $this->phone = preg_replace('/\D+/', '', $this->phone);
        }

        if ($name === 'delivery_method') {
            $this->adjustGrandTotal();
        }
    }

    public function adjustGrandTotal()
    {
        $grand_total = $this->total ?: 0;

        if ($this->discount > 0) {
            $grand_total -= $this->discount;
        }

        $grand_total += $this->delivery_charge[$this->delivery_method];
        $taxable = $grand_total * ($this->taxrate / 100);
        $grand_total += $taxable;

        $this->fill(['grand_total' => $grand_total, 'taxable' => $taxable]);
    }

    public function mount(): void
    {
        $this->updateCart();
        $this->addCoupon(CartService::coupon());
        $this->adjustGrandTotal();
        $this->currency = CartService::getCurrency();
        // Default country for shipping
        if (!$this->country) {
            $this->country = 'Chile';
        }
        $this->states = State::where('active', true)->orderBy('name')->get();
        if ($this->state) {
            $this->cities = City::where('state_id', $this->state)->where('active', true)->orderBy('name')->get();
        }

        if (Auth::check()) {
            $user = Auth::user();

            $this->fill(['email' => $user->email]);

            $user->load('customer', 'customer.address');

            $customer = $user->customer; // may be null

            if ($customer) {
                $this->fill([
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'phone' => $customer->phone,
                ]);

                if ($customer->address->isNotEmpty()) {
                    $this->addresses = $customer->address;
                    $this->add_new_address = false;
                }
            }
        }
    }

    public function updatedState($value)
    {
        $this->cities = City::where('state_id', $value)->where('active', true)->orderBy('name')->get();
        $this->city = null;
    }

    public function render()
    {
        return view('livewire.checkout')
            ->layout('layouts.base');
    }

    public function removeFromCart(string $id): void
    {
        CartService::remove($id);
        $this->updateCart();
        $this->emit('cartChanged');
    }

    public function updateCartItem(string $id, string $action): void
    {
        CartService::update($id, $action);
        $this->updateCart();
        $this->emit('cartChanged');
    }

    public function clearCoupon()
    {
        CartService::clearCoupon();
        $this->emit('couponCleared');
        // $this->fill(['couponApplied' => false, 'coupon' => null, 'discount' => 0, 'promo' => '']);
    }

    public function couponCleared()
    {
        $this->fill(['couponApplied' => false, 'coupon' => null, 'discount' => 0, 'promo' => '']);
    }

    public function applyPromo()
    {
        $coupon = CouponService::getCoupon($this->promo);
        if ($coupon) {
            CartService::applyCoupon($coupon);
            $this->addCoupon($coupon);

            $this->emit('couponApplyEvent');
        } else {
            Notification::make()
                ->title(__('cart.promo_not_valid'))
                ->success()
                ->send();
        }
    }

    public function couponApplyEvent()
    {
        if (!$this->couponApplied) {
            $this->addCoupon(CartService::coupon());
        }
    }

    protected function addCoupon($coupon)
    {
        if ($coupon) {
            $this->fill(['discount' => CartService::getDiscount(), 'coupon' => $coupon, 'couponApplied' => true]);
        }
    }

    public function submit()
    {
        $this->currency = CartService::getCurrency();
        DB::beginTransaction();

        try {
            // Normalize phone before any validation
            if ($this->phone) {
                $this->phone = preg_replace('/\D+/', '', $this->phone);
            }

            // Validation is handled conditionally below per flow (guest/auth, new/existing address)
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $this->validateOnly('email');
                $user =  User::create(['name' => $this->firstname, 'email' => $this->email, 'password' => Str::password(10)]);
                $this->newUserCreated = true;
            }


            if ($user->customer()->exists()) {
                $customer = $user->customer;
            } else {
                $this->validateOnly('firstname');
                $this->validateOnly('lastname');
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'phone' => $this->phone,
                ]);
            }

            // if customer wants to add new address
            if ($this->add_new_address) {
                // field is named 'address' in rules/properties
                $this->validateOnly('address');
                $this->validateOnly('city');
                $this->validateOnly('state');
                $this->validateOnly('country');
                $address =  Address::create([
                    'customer_id' => $customer->id,
                    'address_line' => $this->address,
                    'city' => $this->city,
                    'country' => $this->country,
                    'phone' => $this->phone,
                    'state' => $this->state,
                ]);
                // if add_new_address is false and the selected address has value
            } else {
                $address = $this->selected_address
                    ? $this->addresses->firstWhere('id', $this->selected_address)
                    : $customer->defaultAddress;
                if (!$address) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'selected_address' => __('validation.required'),
                    ]);
                }
            }


            $order = Order::create([
                'order_number'       => SKU::make('ORD'),
                'customer_id'        => $customer->id,
                'items_count'        => CartService::totalQuantity(),
                'taxrate'            => $this->taxrate,
                'subtotal'           => $this->total,
                'taxable'            => $this->taxable,
                'discount'           => $this->discount,
                'coupon_id'          => $this->coupon?->id,
                // 'shipping_weight'    => $this->shipping_weight,
                'shipping_charge'    => $this->delivery_charge[$this->delivery_method],
                'total'              => $this->grand_total,
                'shipping_method'    => $this->delivery_method,
                // 'billing_address' => $this->billing_address, // We assume that billing & shipping is same
                'shipping_address'   => $address->full_address,
                'payment_method'     => $this->payment_method,
                'currency'           => $this->currency->code,
                'tracking_id'        => Str::password(10, symbols: false),
            ]);

            $orderItems = [];

            foreach ($this->content as $value) {
                $orderItems[] = [
                    'variant_id' => $value['variant_id'],
                    'quantity'   => $value['quantity'],
                    'unit_price' => $value['price'],
                    'item_description' => $this->flattenOptionsArray($value['options']),
                ];
            }

            $order->items()->createMany($orderItems);

            $this->clearCheckout();

            // Force Webpay as the only payment method
            $this->payment_method = 'webpay';

            // Commit DB BEFORE calling external API, so Order/Customer persist even if SDK fails
            DB::commit();

            if ($this->payment_method === 'webpay') {
                try {
                    $response = $this->full_checkout($order);
                    // Redirect to dedicated route that renders POST form to Webpay
                    return redirect()->route('webpay.redirect', ['code' => $this->transaction->code]);
                } catch (\Throwable $e) {
                    Log::error('Webpay create failed: '.$e->getMessage());
                    return redirect()->route('checkout.cancel');
                }
            }

            Notification::make()
                ->title('Your Order is Confirmed.')
                ->success()
                ->send();

            $this->new_order_number = $order->order_number;
            $orderNumber = $order->order_number;
            $this->tracking_id = $order->tracking_id;
        } catch (\Illuminate\Validation\ValidationException $ve) {
            DB::rollBack();
            throw $ve; // Let Livewire show field errors instead of redirecting
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::alert($th->getMessage(), [$th]);
            return redirect()->route('checkout.cancel');
        }

        // In non-webpay flow (not used), commit here
        DB::commit();

        if ($this->newUserCreated && $this->registration) {
            $this->sendReset($this->email);
        }

        // For Webpay we already redirected earlier
        if ($this->transaction && $this->payment_method !== 'webpay') {
            return redirect(route('checkout.payment', ['code' => $this->transaction->code]));
        }

        $route = Auth::check()
            ? route('order.success', ['order' => $orderNumber ?? $this->new_order_number])
            : route('order.confirmed', ['tracking' => $this->tracking_id]);
        return redirect($route);
    }

    protected function clearCheckout()
    {
        CartService::clear();
        $this->fill(['total' => 0]);
    }

    protected function flattenOptionsArray($optionsArray): string
    {
        if (empty($optionsArray)) return '';
        $description = '';
        foreach ($optionsArray as $key => $value) {
            $description .= "{$key}: {$value}, ";
        }
        // Remove the trailing comma and space from the description
        $description = rtrim($description, ', ');
        return $description;
    }

    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

    protected function sendReset($email)
    {
        $status = $this->broker()->sendResetLink(['email' => $email]);
        // "passwords.sent"
        $this->sendingResetLinkStatus = $status;
    }

    protected function full_checkout($order)
    {
        // Transbank Webpay Plus transaction creation
        $this->currency = CartService::getCurrency();

        // Webpay Plus only supports CLP/UF amounts without decimals
        $amount = round($this->grand_total);

        // Configure credentials from env
        $commerceCode = '597055555532'; // integration commerce code default
        $apiKey = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C'; // required for SDK 5.x
        $environment = 'TEST'; // 'TEST' or 'LIVE'

        if (!$apiKey) {
            throw new \RuntimeException('Missing TBK_API_KEY in .env. Please set your Transbank integration API key.');
        }

        // Build Transaction using the correct Options class expected by SDK 5.x
        $options = new Options($commerceCode, $apiKey, $environment);
        $transaction = new WebpayTransaction($options);

        // Create transaction
        $response = $transaction->create(
            buyOrder: Str::uuid()->toString(),
            sessionId: session()->getId(),
            amount: $amount,
            returnUrl: route('checkout.success', [], true)
        );

        // Persist token in Transaction model and link to order now
        $this->transaction = Transaction::create([
            'order_id' => $order->id,
            'customer_id' => Auth::id() ? Auth::user()->customer?->id : null,
            'code' => $response->getToken(),
            'client_secret' => $response->getUrl(),
            'amount' => $amount,
            'currency' => $this->currency->code,
        ]);

        return $response; // contains token and url to redirect
    }

    protected function createIntent($order)
    {
        // Deprecated for Webpay flow.

        $this->paymentIntentCreated = true;
    }
}
