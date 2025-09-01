<footer aria-labelledby="footer-heading" class="bg-white dark:bg-slate-800">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="py-20 xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                <div class="space-y-16 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __lang('footer.shop') }}</h3>
                        <ul role="list" class="mt-6 space-y-6">
                            
                            <li class="text-sm">
                                <a href="{{ route('products.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.all_products') }}</a>
                            </li>
                            <li class="text-sm">
                                <a href="{{ route('products.category', 'tienda') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Tienda</a>
                            </li>
                            <li class="text-sm">
                                <a href="{{ route('products.category', 'libros') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Libros</a>
                            </li>
                            <li class="text-sm">
                                <a href="{{ route('products.category', 'recorridos') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Recorridos</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __lang('footer.company') }}</h3>
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="text-sm">
                                <a href="{{ route('blog.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.blog') }}</a>
                            </li>
                            <li class="text-sm">
                                <a href="{{ route('terms.show') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.terms_of_service') }}</a>
                            </li>
                            <li class="text-sm">
                                <a href="{{ route('policy.show') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.privacy_policy') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="space-y-16 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __lang('footer.account') }}</h3>
                        <ul role="list" class="mt-6 space-y-6">
                            @auth
                                <li class="text-sm">
                                    <a href="{{ route('profile.show') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.profile') }}</a>
                                </li>
                                <li class="text-sm">
                                    <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('footer.orders') }}</a>
                                </li>
                            @else
                                <li class="text-sm">
                                    <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('auth.login') }}</a>
                                </li>
                                <li class="text-sm">
                                    <a href="{{ route('register') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">{{ __lang('auth.register') }}</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">Connect</h3>
                        <ul role="list" class="mt-6 space-y-6">

                            <li class="text-sm">
                                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Contact Us</a>
                            </li>

                            <li class="text-sm">
                                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Twitter</a>
                            </li>

                            <li class="text-sm">
                                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Instagram</a>
                            </li>

                            <li class="text-sm">
                                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Facebook</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-16 md:mt-16 xl:mt-0">
                <h3 class="font-medium text-gray-900 dark:text-white">{{ __lang('footer.newsletter_signup') }}</h3>
                <p class="mt-2 text-sm text-gray-500">{{ __lang('footer.newsletter_description') }}</p>
                <livewire:subscription-form />
            </div>
        </div>

        <div class="py-10 border-t border-gray-200">
            <p class="text-sm text-gray-500">{{ __lang('footer.copyright') }}</p>
        </div>
    </div>
</footer>