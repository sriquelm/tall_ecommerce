<x-base-layout>
    <div class="bg-white dark:bg-slate-800">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(!isset($products))
                <!-- Categories Only View -->
                <!-- Header -->
                <div class="sm:flex sm:items-baseline sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Categorías</h1>
                        <nav class="flex mt-2" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200">
                                            <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                            </svg>
                                            <span class="sr-only">Inicio</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                        </svg>
                                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400" aria-current="page">Categorías</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Explora nuestros productos por categoría</p>
                </div>

                <!-- Categories Grid -->
                <div class="grid grid-cols-1 mt-8 gap-y-6 sm:grid-cols-2 sm:grid-rows-2 sm:gap-x-6 lg:gap-8">
                    @forelse ($categories as $category)
                        <div class="overflow-hidden rounded-lg group aspect-w-2 aspect-h-1 sm:aspect-h-1 sm:aspect-w-1 {{ $loop->first ? 'sm:row-span-2' : '' }}">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="object-cover object-center group-hover:opacity-75">
                            <div aria-hidden="true" class="opacity-50 bg-gradient-to-b from-transparent to-black"></div>
                            <div class="flex items-end p-6">
                                <div>
                                    <h3 class="font-semibold text-white">
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            <span class="absolute inset-0"></span>
                                            {{ $category->name }}
                                        </a>
                                    </h3>
                                    <p aria-hidden="true" class="mt-1 text-sm text-white">Ver productos</p>
                                    @if($category->children->count() > 0)
                                        <p class="mt-2 text-xs text-gray-200">
                                            {{ $category->children->count() }} subcategorías
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay categorías</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se encontraron categorías disponibles.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- All Products Link -->
                <div class="mt-12 text-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ver todos los productos
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

            @else
                <!-- Products View (Shop/Products/Category) -->
                <!-- Header -->
                <div class="sm:flex sm:items-baseline sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            @if(isset($category))
                                {{ $category->name }}
                            @else
                                Tienda
                            @endif
                        </h1>
                        <nav class="flex mt-2" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200">
                                            <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                            </svg>
                                            <span class="sr-only">Inicio</span>
                                        </a>
                                    </div>
                                </li>
                                @if(isset($category))
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <a href="{{ route('categories.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Categorías</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400" aria-current="page">{{ $category->name }}</span>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400" aria-current="page">Tienda</span>
                                        </div>
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $products->total() }} productos encontrados</p>
                </div>

                <!-- Category Filter (if not in specific category) -->
                @if(!isset($category) && $categories->count() > 0)
                    <div class="mt-8 flex flex-wrap gap-2">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ !request('category') ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            Todas las categorías
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('products.category', $cat->slug) }}" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ request('category') === $cat->slug ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Products Grid -->
                <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @forelse ($products as $product)
                        <x-product.card :product="$product" />
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay productos disponibles</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    @if(isset($category))
                                        No se encontraron productos en esta categoría.
                                    @else
                                        No se encontraron productos en la tienda.
                                    @endif
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Ver categorías
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-base-layout>
