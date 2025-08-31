<x-base-layout>
    <div class="bg-white dark:bg-slate-800">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="sm:flex sm:items-baseline sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Tienda</h1>
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
                                    <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400" aria-current="page">Tienda</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $products->total() }} productos encontrados</p>
            </div>

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
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se encontraron productos en la tienda.</p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Volver al inicio
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
        </div>
    </div>
</x-base-layout>