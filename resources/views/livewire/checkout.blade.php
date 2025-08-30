<div class="max-w-2xl px-4 pt-12 pb-24 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
    <h2 class="block mb-10 text-3xl font-bold leading-8 tracking-tight text-center text-gray-900 dark:text-white sm:text-4xl">{{__('cart.checkout')}}</h2>

    @if($total>0)
    <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16" @submit.prevent>
        <div>
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{__('checkout.contact_info')}}</h2>

                <div class="mt-4">
                    @auth
                    <p class="dark:text-gray-200">{{__('form.email')}}: {{$email}}</p>
                    <p class="dark:text-gray-200">{{__('form.phone')}}: {{$phone}}</p>
                    @else
                    <x-form.input name="email" type="email" label="{{__('form.email')}}" autofocus autocomplete="email" value="{{auth()->check()?auth()->user()->email:''}}" />
                    
                    @if($showLoginSuggestion)
                    <div class="p-4 mt-3 bg-blue-50 border border-blue-200 rounded-md dark:bg-blue-900/20 dark:border-blue-700">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-blue-700 dark:text-blue-200">
                                    This email is already registered. 
                                    <a href="{{ route('login') }}" class="font-medium underline hover:no-underline">
                                        Sign in
                                    </a> 
                                    to use your saved information, or continue as guest.
                                </p>
                            </div>
                            <div class="ml-3 flex-shrink-0">
                                <button type="button" wire:click="dismissLoginSuggestion" class="text-blue-400 hover:text-blue-500">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>

            <div class="pt-8 mt-8 border-t border-gray-200 dark:border-gray-400">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{__('checkout.shipping_info')}}</h2>
                    @auth
                    <div class="flex items-center">
                        <button type="button" class="<?= $add_new_address ? 'bg-indigo-600' : 'bg-gray-200' ?> relative inline-flex flex-shrink-0 h-5 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" aria-checked="{{$add_new_address?'true':'false'}}" aria-labelledby="add-new-address-label" @click="$wire.set('add_new_address', {{!$add_new_address}})">
                            <span aria-hidden="true" class="<?= $add_new_address ? 'translate-x-5' : 'translate-x-0' ?> inline-block w-4 h-4 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
                        </button>
                        <span class="ml-3" id="add-new-address-label">
                            <span class="text-sm font-medium text-gray-900">Add New Address</span>
                        </span>
                    </div>
                    @endauth
                </div>

                @if (isset($addresses) && !$add_new_address)
                <div class="grid grid-cols-1 gap-3 mt-3 md:gap-4 md:grid-cols-3" x-data="{ address:@entangle('selected_address').defer }">
                    @foreach ($addresses as $address)
                    <label x-bind:class="{ 'ring-2 ring-indigo-500': address === '{{$address->id}}'  }" class="relative flex p-4 bg-white rounded-lg shadow-sm cursor-pointer dark:bg-gray-300 focus:outline-none">
                        <input type="radio" name="delivery-method" x-model="address" value="{{$address->id}}" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="description-{{$loop->index}}" @click="$wire.set('selected_address', address!=='{{$address->id}}' ? '{{$address->id}}': null)">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span id="delivery-method-0-label" class="block text-sm font-medium text-gray-900 capitalize">Address</span>
                                <span id="description-0" class="mt-1 text-sm text-gray-500"> {{ $address->address_line }}</span>
                                <span id="description-1" class="mt-1 text-sm text-gray-500"> {{ "{$address->city}, {$address->state}" }}</span>
                                <span id="description-2" class="mt-1 text-sm text-gray-500"> {{ $address->country }}</span>
                            </span>
                        </span>
                        <template x-if="address === '{{$address->id}}'">
                            <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <span x-bind:class="{ 'border-2 border-indigo-500': address === '{{$address->id}}'  }" class="absolute border rounded-lg pointer-events-none -inset-px" aria-hidden="true"></span>
                    </label>
                    @endforeach
                </div>
                @else
                <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-2 sm:gap-x-4" x-effect="initPhoneInput()">
                    <x-form.input name="firstname" label="{{__('form.firstname')}}" autocomplete="given-name" />
                <x-form.input name="lastname" label="{{__('form.lastname')}}" autocomplete="family-name" />

                <div class="sm:col-span-2">
                    <x-form.input name="address" label="{{__('form.address')}}" autocomplete="street-address" />
                </div>

                <x-form.dropdown name="state" label="{{__('form.state')}}" wire:model="state">
                    <option value="">{{__('checkout.select_state')}}</option>
                    @foreach($states as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                    @endforeach
                </x-form.dropdown>

                <x-form.dropdown name="city" label="{{__('form.city')}}" wire:model="city">
                    <option value="">{{__('checkout.select_city')}}</option>
                    @foreach($cities as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </x-form.dropdown>
                <input type="hidden" name="country" wire:model="country" value="Chile">
                <!--<x-form.dropdown name="country" label="{{__('form.country')}}">
                    <option value="">{{__('checkout.select_country')}}</option>
                    @foreach (['Chile'] as $country)
                    <option value="{{$country}}">{{$country}}</option>
                    @endforeach
                </x-form.dropdown>-->

                <div class="sm:col-span-2">
                    <x-form.input id="phone" name="phone" label="{{__('form.phone')}}" autocomplete="tel" />
                </div>
                @guest()
                <div class="flex items-center my-4">
                    <input type="checkbox" id="checkbox" class="w-5 h-5 text-indigo-600 form-checkbox dark:text-indigo-400" wire:model.lazy="registration">
                    <label for="checkbox" class="block ml-2 text-sm text-gray-900 dark:text-gray-200">{{__('checkout.keep_info')}}</label>
                </div>
                @endguest
            </div>
            @endif
        </div>

        <div class="pt-10 mt-10 border-t border-gray-200 dark:border-gray-400" x-data="{delivery:@entangle('delivery_method').defer }">
            <fieldset>
                <legend class="text-lg font-medium text-gray-900 dark:text-white">{{__('checkout.delivery_method')}}</legend>

                <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                    @foreach ($delivery_charge as $key => $value)
                    <label x-bind:class="{ 'ring-2 ring-indigo-500': delivery === '{{$key}}'  }" class="relative flex p-4 bg-white rounded-lg shadow-sm cursor-pointer dark:bg-gray-300 focus:outline-none">
                        <input type="radio" name="delivery-method" x-model="delivery" value="{{$key}}" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1" @click="delivery!=='{{$key}}'?$wire.updateDeliveryMethod('{{$key}}'):null">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span id="delivery-method-0-label" class="block text-sm font-medium text-gray-900 capitalize">{{ __("checkout.{$key}") }}</span>
                                <span id="delivery-method-0-description-0" class="flex items-center mt-1 text-sm text-gray-500"> {{__('checkout.business_days', ['days'=>$value==5?'5-10':'2-4'])}}</span>
                                <span id="delivery-method-0-description-1" class="mt-6 text-sm font-medium text-gray-900">{{format_money($value)}}</span>
                            </span>
                        </span>
                        <template x-if="delivery==='{{$key}}'">
                            <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <span x-bind:class="{ 'border-2 border-indigo-500': delivery === '{{$key}}'  }" class="absolute border rounded-lg pointer-events-none -inset-px" aria-hidden="true"></span>
                    </label>
                    @endforeach
                </div>
            </fieldset>
        </div>

        <!-- Payment (fixed to Webpay) -->
        <div class="pt-10 mt-10 border-t border-gray-200 dark:border-gray-400">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{__('checkout.payment')}}</h2>

            <div class="grid grid-cols-4 mt-6 gap-y-6 gap-x-4">
                <div class="flex col-span-4 items-center">
                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded bg-teal-100 text-teal-800">Webpay Plus</span>
                </div>
            </div>
        </div>
</div>

<!-- Order summary -->
<div class="mt-10 lg:mt-0" x-data="{ subtotal:@entangle('total').defer, modalOpen:false,
            isConfirm: function(cb, arg){
                this.modalOpen=true;
                this.execute=cb;
                this.args=arg;
            },
            closeConfirm:function(){
                this.modalOpen=false;
                this.execute=null;
                this.args=[];
            }, execute:null, args:[] }">
    <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('checkout.order_summary') }}</h2>


    <div class="relative mt-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-400">
        <h3 class="sr-only">Items in your cart</h3>
        <div class="h-max-[360px] overflow-y-auto">
            <ul role="list" class="px-4 divide-y divide-gray-200" wire:key="alpine">
                @foreach ($content as $id => $product)
                <li class="flex py-4" wire:key="{{$id}}-{{$product['slug']}}">
                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden border border-gray-300 rounded-md dark:border-gray-400">
                        <img src="{{$product['thumb']}}" alt="{{$product['title']}}" class="object-cover object-center w-full h-full">
                    </div>

                    <div class="flex flex-col flex-1 ml-4">
                        <div>
                            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-100">
                                <h3>
                                    <a href="{{route('product.view', $product['slug'])}}">{{$product['title']}}</a>
                                </h3>
                                <p class="ml-3 whitespace-nowrap">{{format_money($product['price'])}}</p>
                            </div>
                            @foreach ($product['options'] as $key=>$option)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-100">
                                {{$key}}:{{$option}}
                            </p>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between flex-1 text-sm">
                            <div class="flex items-center mt-2">
                                @php
                                $disallowMinus = $product['quantity'] <= 1; $disallowPlus=$product['quantity']>= $product['stock'];
                                    @endphp
                                    <button class="<?= $disallowMinus ? 'cursor-not-allowed' : '' ?> text-gray-500 dark:text-gray-300 focus:outline-none focus:text-gray-600 dark:focus:text-gray-100" wire:click="updateCartItem({{$id}}, 'minus')" <?= $disallowMinus ? 'disabled' : '' ?>>
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <p class="mx-2 text-gray-700 dark:text-gray-100">{{$product['quantity']}}</p>
                                    <!-- $wire.updateCartItem(id, 'plus') -->
                                    <button class="<?= $disallowPlus ? 'cursor-not-allowed' : '' ?> text-gray-500 dark:text-gray-300 focus:outline-none focus:text-gray-600 dark:focus:text-gray-100" wire:click="updateCartItem({{$id}}, 'plus')" <?= $disallowPlus ? 'disabled' : '' ?>>
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                            </div>
                            <!-- <p class="text-gray-500 dark:text-gray-100">Qty 1</p> -->

                            <div class="flex">
                                <button type="button" class="font-medium text-rose-500 hover:text-rose-400" @click="isConfirm($wire.removeFromCart, [{{$id}}])">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <dl class="px-4 py-6 space-y-6 border-t border-gray-200 dark:border-gray-400 sm:px-6">
            <div class="flex items-center justify-between">
                <dt class="text-sm dark:text-white">{{__('cart.subtotal')}}</dt>
                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{format_money($total)}}</dd>
            </div>
            @if ($couponApplied)
            <div class="flex items-center justify-between">
                <dt class="text-sm dark:text-white">{{__('checkout.discount')}} ({{$coupon->value}}{{$coupon->type === 'percent' ? '%':'' }})</dt>
                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{format_money($discount)}}</dd>
            </div>
            @endif
            <div class="flex items-center justify-between">
                <dt class="text-sm dark:text-white">{{__('checkout.shipping')}} ({{__("checkout.{$delivery_method}")}})</dt>
                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{format_money($delivery_charge[$delivery_method])}}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-sm dark:text-white">{{__('checkout.tax')}} ({{$taxrate}}%)</dt>
                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{format_money($taxable)}}</dd>
            </div>
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-400">
                <dt class="text-base font-medium dark:text-white">{{__('cart.total')}}</dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">{{format_money($grand_total)}}</dd>
            </div>
        </dl>

        <div class="px-4 py-6 border-t border-gray-200 dark:border-gray-400 sm:px-6">
            @if ($couponApplied)
            <x-base.small-alert wire:click="clearCoupon">{{$coupon->code}} {{__('cart.applied_successfully')}}</x-base.small-alert>
            @endif
            <div class="flex items-end w-full my-4 justify-items-stretch">

                <x-form.input name="promo" label="{{__('cart.apply_promo')}}" placeholder="{{ __('cart.promocode') }}" />

                <div class="flex-shrink-0 mb-1 ml-2">
                    <x-base.loading-button wire:click="applyPromo" wire:loading.attr="disabled" loading="true">
                        <span>{{__('cart.apply')}}</span>
                    </x-base.loading-button>
                    <!-- <button class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-500 border border-transparent rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" wire:click="applyPromo">Apply</button> -->
                </div>
            </div>
            <x-base.loading-button wire:click.prevent="submit" wire:loading.attr="disabled" loading="true" class="justify-center w-full px-4 py-3 text-base font-medium text-center text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 !ml-0">
                <span> {{ __('checkout.confirm_order') }}</span>
            </x-base.loading-button>
        </div>
        <div x-cloak x-show="modalOpen" class="absolute inset-0 z-10 w-full h-full bg-black opacity-25"></div>
        <div x-cloak x-show="modalOpen" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="absolute right-[33%] top-[10%] z-50 p-3 bg-white dark:bg-gray-200 rounded-lg max-w-[70%]" @click.away="closeConfirm()">
            <div class="mt-4 text-center md:mt-0 md:text-left">
                <p class="font-bold">{{ __('common.are_you_sure') }}</p>
                <p class="mt-1 text-sm text-gray-700">{{ __('cart.remove_product') }}</p>
            </div>
            <!-- </div> -->
            <div class="mt-4 text-center md:text-right md:flex md:justify-end">
                <button class="block w-full px-2 py-1 text-sm font-semibold text-red-700 bg-red-200 rounded-lg md:inline-block md:w-auto md:ml-2 md:order-2" @click="execute instanceof Function?(execute(...args), closeConfirm()):$store.toasts.createToast('Something went Wrong, try Again', 'error')">{{ __('common.yes') }}</button>
                <button class="block w-full px-2 py-1 mt-4 text-sm font-semibold bg-gray-200 rounded-lg md:inline-block md:w-auto md:mt-0 md:order-1" @click="closeConfirm()">{{ __('common.no') }}</button>
            </div>
        </div>
    </div>
</div>
</form>
@else
<div class="px-4 py-2 mx-4 mt-4 mb-auto text-center border-2 border-dashed dark:border-gray-400">
    <img src="{{asset('images/cart-empty.svg')}}" class="w-64 h-64 mx-auto" alt="cart is empty" />
    <a href="{{ url('/') }}" class="px-4 py-3 mx-auto my-8 text-base font-medium text-center text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">{{ __('checkout.continue_shopping') }}</a>
    <p class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">{{__('cart.cart_empty')}}</p>
    <p class="mt-2 text-base font-normal text-gray-500 dark:text-gray-300">{{__('cart.not_added_yet')}}</p>
</div>
@endif


@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
    function initPhoneInput() {
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        });
    }
</script>
@endpush
</div>