<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.login.title')
    </x-slot>

    <div class="flex h-[100vh] items-center justify-center bg-gray-50">
        <!-- Main Container -->
        <div class="flex h-full w-full max-w-4xl mx-auto">
            <!-- Left Image Section -->
            <div class="flex items-center justify-center w-1/2 bg-white p-8 left-section">
                <img
                    class="w-3/4 h-auto"
                    src="{{ vite()->asset('images/logo-login.png') }}" 
                    alt="Login Illustration"
                />
            </div>

            <!-- Right Login Form Section -->
            <div class="flex items-center justify-center w-1/2 right-section">
                <div class="w-full max-w-sm p-8 bg-white border border-gray-300 rounded-lg shadow-lg" style="width: 450px; padding: 50px 20px; border-radius: 10px;">
                    
                    <!-- Efeito de Máquina de Digitar -->
                    <h2 id="typing-effect" class="text-center text-gray-600 text-2xl mb-6"></h2>

                    <!-- Logo Above Form -->
                    <div class="flex justify-center mb-4">
                        <img
                            class="w-1/2 h-auto"
                            src="{{ vite()->asset('images/logo-mapos.png') }}" 
                            alt="Logo"
                            style="position: relative; top: -20px; width: 115px; "
                        />
                    </div>

                    <!-- Include Before Form Controls Event -->
                    {!! view_render_event('admin.sessions.login.form_controls.before') !!}

                    <!-- Login Form -->
                    <x-admin::form :action="route('admin.session.store')">
                        <!-- Email Field -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.login.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                class="w-full"
                                id="email"
                                name="email"
                                rules="required|email"
                                :label="trans('admin::app.users.login.email')"
                                :placeholder="trans('admin::app.users.login.email')"
                            />
                            <x-admin::form.control-group.error control-name="email" />
                        </x-admin::form.control-group>

                        <!-- Password Field -->
                        <x-admin::form.control-group class="relative w-full mt-4">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.login.password')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="password"
                                class="w-full pr-10"
                                id="password"
                                name="password"
                                rules="required|min:6"
                                :label="trans('admin::app.users.login.password')"
                                :placeholder="trans('admin::app.users.login.password')"
                            />

                            <span
                                class="icon-eye-hide absolute top-10 -translate-y-2/4 cursor-pointer text-2xl right-3"
                                onclick="switchVisibility()"
                                id="visibilityIcon"
                                role="presentation"
                                tabindex="0"
                                style="top: 45px;"
                            ></span>

                            <x-admin::form.control-group.error control-name="password" />
                        </x-admin::form.control-group>

                        <!-- Remember Me and Forgot Password Links -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember_me" name="remember" class="mr-2">
                                <label for="remember_me" class="text-gray-600 text-sm">Lembre-me</label>
                            </div>

                            <a href="{{ route('admin.forgot_password.create') }}" class="text-sm text-green-500">
                                @lang('admin::app.users.login.forget-password-link')
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button
                            class="mt-6 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                            aria-label="{{ trans('admin::app.users.login.submit-btn') }}"
                        >
                            @lang('admin::app.users.login.submit-btn')
                        </button>
                    </x-admin::form>

                    <!-- Include After Form Controls Event -->
                    {!! view_render_event('admin.sessions.login.form_controls.after') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Adicionar o bloco de estilos -->
    @push('styles')
        <style>
            @media (max-width: 768px) {
                .left-section {
                    display: none;
                }

                .right-section {
                    width: 90%;
                    margin: auto;
                }
            }

            /* Estilo para o efeito de digitação com cursor menor */
            #typing-effect {
                font-family: 'Manrope', 'Courier New', Courier, monospace;
                font-weight: bold;
                font-size: 27px;
                white-space: nowrap;
                border-right: 2px solid; /* Espessura do cursor menor */
                height: 1em; /* Altura do cursor ajustada */
                line-height: 0.9em; /* Reposiciona o cursor mais para baixo */
                width: fit-content;
                margin: 0 auto;
                animation: blink-caret 0.75s step-end infinite;
                position: relative;
                top: -140px;
            }

            /* Reduzir o cursor piscante */
            @keyframes blink-caret {
                from, to {
                    border-color: transparent;
                }
                50% {
                    border-color: black;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function switchVisibility() {
                const passwordField = document.getElementById("password");
                const visibilityIcon = document.getElementById("visibilityIcon");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    visibilityIcon.classList.remove("icon-eye-hide");
                    visibilityIcon.classList.add("icon-eye");
                } else {
                    passwordField.type = "password";
                    visibilityIcon.classList.remove("icon-eye");
                    visibilityIcon.classList.add("icon-eye-hide");
                }
            }

            // Efeito de digitação com saudação baseada na hora, seguido de "Bem-vindo ao sistema" e removendo o cursor
            document.addEventListener('DOMContentLoaded', function() {
                const now = new Date();
                const hour = now.getHours();
                let greeting;

                if (hour >= 0 && hour < 12) {
                    greeting = 'Olá! Bom dia';
                } else if (hour >= 12 && hour < 18) {
                    greeting = 'Olá! Boa tarde';
                } else {
                    greeting = 'Olá! Boa noite';
                }

                const welcomeText = 'Bem-vindo ao sistema!';
                let index = 0;
                const speed = 100; // Velocidade da digitação

                function typeWriter(text, elementId, callback) {
                    if (index < text.length) {
                        document.getElementById(elementId).innerHTML += text.charAt(index);
                        index++;
                        setTimeout(() => typeWriter(text, elementId, callback), speed);
                    } else if (callback) {
                        setTimeout(callback, 700); // Pequeno delay antes de iniciar a próxima fase
                    }
                }

                // Exibir saudação, então substituir pela frase "Bem-vindo ao sistema"
                typeWriter(greeting, 'typing-effect', function() {
                    document.getElementById('typing-effect').innerHTML = ''; // Limpar o texto da saudação
                    index = 0; // Reiniciar o índice para a próxima frase
                    typeWriter(welcomeText, 'typing-effect', function() {
                        document.getElementById('typing-effect').style.borderRight = 'none'; // Remover o cursor
                    });
                });
            });
        </script>
    @endpush 
</x-admin::layouts.anonymous>
