@php
    $parentCategories = \App\Models\Category::with(['children' => function($q){
        $q->where('active', 1);
    }])->whereNull('parent_id')->where('active', 1)->get();
@endphp

@foreach($parentCategories as $parent)
    <div class="flex" x-data="{ open: false }" @keydown.escape="open = false">
        <div class="relative flex">
            <button type="button"
                class="relative z-10 flex items-center pt-px -mb-px text-sm font-medium text-gray-700 transition-colors duration-200 ease-out border-b-2 border-transparent dark:text-gray-100 hover:text-gray-800" :class="{ 'border-indigo-600 text-indigo-600': open, 'border-transparent text-gray-700 hover:text-gray-800': !(open) }" @click="open=!open" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                {{ $parent->name }}
            </button>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute inset-x-0 text-sm text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800 top-full"
            x-ref="panel" @click.away="open = false">
            <div class="absolute inset-0 bg-white shadow dark:bg-gray-800 top-1/2" aria-hidden="true"></div>
            <!-- Fake border when menu is open -->
            <div class="absolute inset-0 top-0 h-px px-8 mx-auto max-w-7xl" aria-hidden="true">
                <div class="w-full h-px transition-colors duration-200 ease-out bg-transparent" :class="{ 'bg-gray-200': open, 'bg-transparent': !(open) }"></div>
            </div>
            <div class="relative">
                <div class="px-8 mx-auto max-w-7xl">
                    <div class="grid grid-cols-3 py-16 text-sm gap-y-10 gap-x-8">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $parent->name }}</p>
                            <ul role="list" class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                @foreach($parent->children as $child)
                                    <li class="flex">
                                        <a href="{{ route('products.category', $child->slug) }}"
                                            class="hover:text-gray-800 dark:hover:text-white">{{ $child->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
