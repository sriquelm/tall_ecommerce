<div class="fixed top-0 z-40 w-full">
    <div x-cloak x-show="open" class="relative z-40 lg:hidden" x-ref="dialog" aria-modal="true">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25"></div>
        <div class="fixed inset-0 z-40 flex ">
            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex flex-col w-full max-w-xs pb-12 overflow-y-auto bg-white shadow-xl dark:bg-gray-800" @click.away="open = false">
                <div class="flex justify-between px-4 pt-5 pb-2">
                    <button type="button" class="inline-flex items-center justify-center p-2 -m-2 text-gray-400 rounded-md" @click="open = false">
                        <span class="sr-only">Close menu</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="flex">


                        <a href="#" class="p-2 text-gray-400 hover:text-gray-500 dark:text-gray-400">
                            <span class="sr-only">Search</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links - matches desktop menu -->
                <div class="px-4 py-6 space-y-6 border-t border-gray-200">
                    <!-- Categories -->
                    @php
                        $parentCategories = \App\Models\Category::with(['children' => function($q){
                            $q->where('active', 1);
                        }])->whereNull('parent_id')->where('active', 1)->get();
                    @endphp
                    
                    @foreach($parentCategories as $parent)
                        <div class="flow-root">
                            <p class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">{{ $parent->name }}</p>
                            @if($parent->children->count() > 0)
                                <div class="ml-4 mt-2 space-y-2">
                                    @foreach($parent->children as $child)
                                        <div class="flow-root">
                                            <a href="{{ route('products.category', $child->slug) }}" class="block p-1 -m-1 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">{{ $child->name }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Main Navigation -->
                    <div class="flow-root">
                        <a href="{{ route('shop.index') }}" class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">Shop</a>
                    </div>

                    <div class="flow-root">
                        <a href="{{ route('blog.index') }}" class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">Blog</a>
                    </div>

                    <div class="flow-root">
                        <a href="#" class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">Contact</a>
                    </div>

                </div>

                <div class="px-4 py-6 space-y-6 border-t border-gray-200">
                    <div class="flow-root">
                        <a href="#" class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">Sign in</a>
                    </div>
                    <div class="flow-root">
                        <a href="#" class="block p-2 -m-2 font-medium text-gray-900 dark:text-white">Create account</a>
                    </div>
                </div>

                
            </div>

        </div>
    </div>

    <nav aria-label="Top" class="relative z-10 bg-white border-b border-gray-100 dark:bg-gray-800 bg-opacity-90 backdrop-blur-xl backdrop-filter dark:border-gray-600">
        <div class="pl-2 pr-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center h-16">
                <button type="button" class="p-2 text-gray-400 bg-white rounded-md dark:bg-gray-800 lg:hidden" @click="open = true">
                    <span class="sr-only">Open menu</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex ml-4 lg:ml-0">
                    <a href="{{url('/')}}">
                        <span class="sr-only">Your Company</span>
                        <img class="w-auto h-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&amp;shade=600" alt="">
                    </a>
                </div>

                <!-- Flyout menus -->
                <div class=" lg:ml-8 lg:block lg:self-stretch hidden lg:flex">
                    <div class="flex h-full space-x-8">
                        @include('components.base.categories-menu')

                        

                        <a href="{{route('shop.index')}}" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800 dark:text-gray-100 dark:hover:text-gray-300">Shop</a>

                        <a href="{{route('blog.index')}}" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800 dark:text-gray-100 dark:hover:text-gray-300">Blog</a>
                        <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800 dark:text-gray-100 dark:hover:text-gray-300">Contact</a>

                    </div>
                </div>

                <div class="flex items-center ml-auto">
                <div class="flex items-center hidden">
                    <button type="button" x-bind:class="darkMode ? 'bg-indigo-500' : 'bg-gray-200'" x-on:click="darkMode = !darkMode" class="relative inline-flex flex-shrink-0 h-6 mr-2 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" aria-checked="false">
                        <span class="sr-only">Dark mode toggle</span>
                        <span x-bind:class="darkMode ? 'translate-x-5 bg-gray-700' : 'translate-x-0 bg-white dark:bg-gray-800'" class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform rounded-full shadow pointer-events-none ring-0">
                            <span x-bind:class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                </svg>
                            </span>
                            <span x-bind:class="darkMode ?  'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'" class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    </button>

                    
                    
                </div>

                    <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:ml-6">
                        @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                                @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __lang('navigation.manage_account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __lang('navigation.profile') }}
                                </x-dropdown-link>


                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __lang('navigation.log_out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                        @else
                        <a href="{{route('login')}}" class="p-2 -m-2 text-gray-400 hover:text-gray-500 dark:text-gray-400">
                            <span class="sr-only">Account</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                            </svg>
                        </a>
                        @endauth
                    </div>


                    <!-- Search -->
                    <div class="hidden lg:flex lg:ml-6">
                        <button onclick="Livewire.emit('openModal', 'top-search')" class="p-2 text-gray-400 hover:text-gray-500 dark:text-gray-400">
                            <span class="sr-only">Search</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Cart -->
                    <livewire:top-cart wire:key="top-cart" />
                </div>
            </div>
        </div>
    </nav>
</div>