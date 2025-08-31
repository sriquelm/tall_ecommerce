<div class="max-w-2xl mx-auto overflow-hidden transition-all transform bg-white bg-opacity-50 divide-y divide-gray-500 shadow-2xl dark:bg-gray-800 dark:divide-gray-400 divide-opacity-10 rounded-xl ring-1 ring-black ring-opacity-5 dark:ring-opacity-2 backdrop-blur backdrop-filter">
    <!-- Search Input -->
    <div class="relative">
        <!-- Heroicon name: mini/magnifying-glass -->
        <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <input 
            wire:model.debounce.300ms="search" 
            type="text" 
            class="w-full h-12 pr-4 text-gray-900 placeholder-gray-500 bg-transparent border-0 dark:text-gray-100 pl-11 focus:ring-0 sm:text-sm" 
            placeholder="{{ __lang('search.search_products_placeholder') }}" 
            autofocus
        />
    </div>

    @if ($showResults && $results && count($results) > 0)
        <!-- Products Results -->
        <ul class="overflow-y-auto divide-y divide-gray-500 max-h-80 scroll-py-2 divide-opacity-10">
            <li class="p-2">
                <h2 class="px-3 mt-4 mb-2 text-xs font-semibold text-gray-900 dark:text-gray-100">{{ __lang('search.products_found') }}</h2>
                <ul class="text-sm text-gray-700 dark:text-gray-100">
                    @foreach($results as $product)
                        <li class="flex items-center px-3 py-2 rounded-md cursor-pointer select-none group hover:bg-gray-100 dark:hover:bg-gray-700" 
                            wire:click="selectProduct({{ $product->id }})">
                            <!-- Product Image -->
                            <div class="flex-none w-12 h-12 mr-3 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600">
                                @if($product->getFirstMediaUrl('gallery'))
                                    <img src="{{ $product->getFirstMediaUrl('gallery', 'thumb') }}" 
                                         alt="{{ $product->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-auto min-w-0">
                                <div class="font-medium text-gray-900 dark:text-white truncate">{{ $product->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($product->category)
                                        {{ $product->category->name }}
                                    @endif
                                </div>
                            </div>
                            <!-- Product Price -->
                            
                            <div class="flex flex-col items-start justify-start">
                                <p class="relative font-bold text-indigo-600"><span class="relative font-semibold text-gray-500 pr-1 line-through">{{format_money($product->variant->sale_price)}}</span>{{format_money($product->variant->final_price)}}</p>
                            </div>

                        </li>
                    @endforeach
                </ul>
                
                <!-- View All Results Button -->
                @if(count($results) >= 8)
                    <div class="px-3 pt-3">
                        <button 
                            wire:click="viewAllResults" 
                            class="w-full px-3 py-2 text-sm font-medium text-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors">
                            {{ __lang('search.view_all_results') }} "{{ $search }}"
                        </button>
                    </div>
                @endif
            </li>
        </ul>

    @elseif ($showResults && $results && count($results) === 0)
        <!-- No Results -->
        <div class="px-6 text-center py-14 sm:px-14">
            <!-- Heroicon name: outline/magnifying-glass -->
            <svg class="w-6 h-6 mx-auto text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <p class="mt-4 text-sm text-gray-900 dark:text-gray-100">{{ __lang('search.no_products_found') }} "{{ $search }}". {{ __lang('search.try_another_term') }}</p>
        </div>

    @else
        <!-- Initial State -->
        <div class="px-6 text-center py-14 sm:px-14">
            <!-- Heroicon name: outline/magnifying-glass -->
            <svg class="w-6 h-6 mx-auto text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <p class="mt-4 text-sm text-gray-900 dark:text-gray-100">{{ __lang('search.search_by_description') }}</p>
        </div>
    @endif
</div>