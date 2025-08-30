<x-base-layout>
    <div class="bg-white dark:bg-slate-800">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="sm:flex sm:items-baseline sm:justify-between">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Categorías</h1>
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
        </div>
    </div>
</x-base-layout>
