<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.reset-password.title')
    </x-slot>

    <div class="flex h-[100vh] items-center justify-center bg-gray-50">
        <!-- Main Container -->
        <div class="flex h-full w-full max-w-4xl mx-auto">
            <!-- Left Image Section -->
            <div class="flex items-center justify-center w-1/2 bg-white p-8 left-section">
                <!-- Imagem ou Logo -->
                <img
                    class="w-3/4 h-auto"
                    src="{{ vite()->asset('images/logo-login.png') }}" 
                    alt="Login Illustration"
                />
            </div>

            <!-- Right Form Section -->
            <div class="flex items-center justify-center w-1/2 right-section">
                <div class="box-shadow flex min-w-[300px] flex-col rounded-md bg-white dark:bg-gray-900">
                    {!! view_render_event('admin.sessions.reset-password.form_controls.before') !!}

                    <!-- Formulário de Redefinição de Senha -->
                    <x-admin::form :action="route('admin.reset_password.store')">
                        <div class="p-4">
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                @lang('admin::app.users.reset-password.title')
                            </p>
                        </div>

                        <x-admin::form.control-group.control
                            type="hidden"
                            name="token"
                            :value="$token"
                        />

                        <div class="border-y p-4 dark:border-gray-800">
                            <!-- Email -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.reset-password.email')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="email"
                                    class="w-[254px] max-w-full"
                                    id="email"
                                    name="email"
                                    rules="required|email"
                                    :label="trans('admin::app.users.reset-password.email')"
                                    :placeholder="trans('admin::app.users.reset-password.email')"
                                />

                                <x-admin::form.control-group.error control-name="email" />
                            </x-admin::form.control-group>

                            <!-- Password -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.reset-password.password')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="password"
                                    class="w-[254px] max-w-full"
                                    id="password"
                                    name="password"
                                    rules="required|min:6"
                                    :label="trans('admin::app.users.reset-password.password')"
                                    :placeholder="trans('admin::app.users.reset-password.password')"
                                    ref="password"
                                />

                                <x-admin::form.control-group.error control-name="password" />
                            </x-admin::form.control-group>

                            <!-- Confirm Password -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.reset-password.confirm-password')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="password"
                                    class="w-[254px] max-w-full"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    rules="confirmed:@password"
                                    :label="trans('admin::app.users.reset-password.confirm-password')"
                                    :placeholder="trans('admin::app.users.reset-password.confirm-password')"
                                    ref="password"
                                />

                                <x-admin::form.control-group.error control-name="password_confirmation" />
                            </x-admin::form.control-group>
                        </div>

                        <div class="flex items-center justify-between p-4">
                            <!-- Back Button-->
                            <a
                                class="cursor-pointer text-xs font-semibold leading-6 text-brandColor"
                                href="{{ route('admin.session.create') }}"
                            >
                                @lang('admin::app.users.reset-password.back-link-title')
                            </a>

                            <!-- Submit Button -->
                            <button class="primary-button">
                                @lang('admin::app.users.reset-password.submit-btn')
                            </button>
                        </div>
                    </x-admin::form>

                    {!! view_render_event('admin.sessions.reset-password.form_controls.after') !!}
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
                    width: 100%;
                }
            }
        </style>
    @endpush
</x-admin::layouts.anonymous>
