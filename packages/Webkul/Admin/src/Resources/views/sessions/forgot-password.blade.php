<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.forget-password.create.page-title')
    </x-slot>

    <div class="flex h-[100vh] items-center justify-center bg-gray-50">
        <!-- Main Container -->
        <div class="flex h-full w-full max-w-4xl mx-auto">
            <!-- Image on the Left -->
            <div class="flex items-center justify-center w-1/2 bg-white p-8 left-section">
                <img
                    class="w-3/4 h-auto"
                    src="{{ vite()->asset('images/logo-login.png') }}" 
                    alt="Login Illustration"
                />
            </div>

            <!-- Forgot Password Form on the Right -->
            <div class="flex items-center justify-center w-1/2 right-section">
                <div
                    class="w-full max-w-sm p-8 bg-white border border-gray-300 rounded-lg shadow-lg"
                    style="width: 450px; padding: 50px 20px;"
                >
                    <!-- Logo Above Form -->
                    <div class="flex justify-center mb-4">
                        <img
                            class="w-1/2 h-auto"
                            src="{{ vite()->asset('images/logo-mapos.png') }}" 
                            alt="Logo"
                            style="position: relative; top: -20px; width: 115px;"
                        />
                    </div>

                    <!-- Include Before Form Controls Event -->
                    {!! view_render_event('admin.sessions.forgot_password.form_controls.before') !!}

                    <!-- Forgot Password Form -->
                    <x-admin::form :action="route('admin.forgot_password.store')">
                        <!-- Title -->
                        <div class="p-4">
                            <p class="text-xl font-bold text-gray-800">
                                @lang('admin::app.users.forget-password.create.title')
                            </p>
                        </div>

                        <!-- Email Field -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.users.forget-password.create.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                class="w-full"
                                id="email"
                                name="email"
                                rules="required|email"
                                :value="old('email')"
                                :label="trans('admin::app.users.forget-password.create.email')"
                                :placeholder="trans('admin::app.users.forget-password.create.email')"
                            />
                            <x-admin::form.control-group.error control-name="email" />
                        </x-admin::form.control-group>

                        <!-- Back to Sign In Link -->
                        <div class="flex items-center justify-between mt-4">
                            <a
                                href="{{ route('admin.session.create') }}"
                                class="text-sm text-green-500"
                            >
                                @lang('admin::app.users.forget-password.create.sign-in-link')
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button
                            class="mt-6 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                            aria-label="{{ trans('admin::app.users.forget-password.create.submit-btn') }}"
                        >
                            @lang('admin::app.users.forget-password.create.submit-btn')
                        </button>
                    </x-admin::form>

                    <!-- Include After Form Controls Event -->
                    {!! view_render_event('admin.sessions.forgot_password.form_controls.after') !!}
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
