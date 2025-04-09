<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <section class="login">
                <header class="login__header">
                    <h2 class="login__title">Авторизация</h2>
                </header>
                <div class="login__wrapper">
                    <form class="login__form" action="http://f0769682.xsph.ru/authorization.php" method="POST"
                        accept-charset="utf-8">
                        <label class="login__label" for="email" :value="__('Email')">
                            E-mail
                            <input
                                id="email"
                                class="login__input"
                                type="email"
                                placeholder="example@domain.xyz"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                            >
                        </label>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <label class="login__label" for="password" :value="__('Password')">
                            Пароль
                            <input
                                class="login__input"
                                type="password"
                                placeholder=""
                                name="password"
                                required
                                id="password"
                                autocomplete="current-password"
                            >
                        </label>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <div class="text-center">
                            <input value="Авторизоваться" type="submit" class="login__button">
                        </div>
                        <div class="mt-10 flex items-center justify-between text-lg">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-gray-600">{{ __('Запомнить') }}</span>
                            </label>
                            
                            <div>
                                @if (Route::has('password.request'))
                                    <a class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('password.request') }}">
                                        {{ __('Забыли пароль?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                    </form>
                </div>
            </section>
        </div>
    </form>
</x-guest-layout>
