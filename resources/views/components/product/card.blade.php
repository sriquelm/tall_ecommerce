@props(['product'])
<a href="{{route('product.view', $product->slug)}}" class="block bg-white rounded-lg c-card">
    <div class="relative pb-48 ">
        @if($featuredImage = $product->featuredImage)
        <img class="absolute inset-0 object-cover w-full h-full" src="{{ $featuredImage->getUrl() }}" srcset="{{ $featuredImage->getSrcset() }}" sizes="(min-width: 768px) 50vw, 100vw" alt="{{ $featuredImage->name }}">
        @else
        <img class="absolute inset-0 object-cover w-full h-full" src="{{placeholder_image()}}" alt="product image">
        @endif
        
    </div>
    <div class="p-1">
        <h2 class="mt-2 mb-2 font-bold">{{$product->title}}</h2>
        <div class="flex items-center justify-between">
            
            <div class="flex flex-col items-start justify-start">
                <p class="relative text-2xl font-bold text-indigo-600"><span class="relative text-xs font-semibold text-gray-500 pr-1 line-through">{{format_money($product->variant->sale_price)}}</span>{{format_money($product->variant->final_price)}}</p>
            </div>
            <button @click.prevent="Livewire.emit('addToCart', '{{$product->variant->id}}')" class="px-3 py-2 font-bold bg-indigo-600 rounded text-md hover:bg-opacity-75"><svg class="flex-shrink-0 w-6 h-6 text-white group-hover:text-white dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
        </svg></button>
        </div>
    </div>
</a>