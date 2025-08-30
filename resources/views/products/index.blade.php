<x-base-layout>
    <div class="bg-white dark:bg-slate-800">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="sm:flex sm:items-baseline sm:justify-between">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Todos los Productos</h1>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay productos</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se encontraron productos disponibles.</p>
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
