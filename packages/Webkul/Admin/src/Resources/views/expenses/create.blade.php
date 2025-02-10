<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.expenses.create.title')
    </x-slot>

    {!! view_render_event('admin.expenses.create.form_controls.before') !!}

    <x-admin::form :action="route('admin.expenses.store')">
    <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 max-xl:flex-wrap">
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <x-admin::breadcrumbs name="expenses.create" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.expenses.create.title')
                    </div>
                </div>

                {!! view_render_event('admin.expenses.create.save_button.before') !!}

                <div class="flex items-center gap-x-2.5">
                    <!-- Save button for expenses -->
                    <div class="flex items-center gap-x-2.5">
                        {!! view_render_event('admin.expenses.create.form_buttons.before') !!}

                        <button type="submit" class="primary-button">
                            @lang('admin::app.expenses.create.save-btn')
                        </button>

                        {!! view_render_event('admin.expenses.create.form_buttons.after') !!}
                    </div>
                </div>

                {!! view_render_event('admin.expenses.create.save_button.after') !!}
            </div>
            <div class="grid w-full">
                <div class="flex flex-col gap-1" style="padding: 25px;">
                    <div class="w-full" style="width: 50rem;">
                         <!-- Expense Type -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.expenses.create.type')
                            </label>
                            <div class="flex gap-4">
                                <select name="type_id" class="w-1/2 rounded border custom-select border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required>
                                    <option value="" selected disabled>Selecione...</option> <!-- Opção padrão -->
                                    @foreach($expenseTypes as $type)
                                        <option value="{{ $type->id }}" {{ (isset($expense) && $expense->type_id == $type->id) ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- User Selection -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.expenses.create.user')
                            </label>
                            <div class="flex gap-4">
                                <select name="user_id" class="w-1/2 rounded border custom-select border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required>
                                    <option value="" selected disabled>Selecione...</option> <!-- Opção padrão -->
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Expense Value -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.expenses.create.value')
                            </label>
                            <div class="flex gap-4">
                                <input type="number" name="value" step="0.01" class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required />
                            </div>
                        </div>

                        <!-- Expense Date -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.expenses.create.date')
                            </label>
                            <div class="flex gap-4">
                                <input type="date" name="date" class="w-1/3 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required />
                            </div>
                        </div>

                        <!-- Expense Description -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.expenses.create.description')
                            </label>
                            <div class="flex gap-4">
                                <textarea name="description" class="w-full rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required></textarea>
                            </div>
                        </div>

                        <!-- Observation (Optional) -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.expenses.create.observation')
                            </label>
                            <div class="flex gap-4">
                                <textarea name="observation" class="w-full rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
    </div>
</div>

    </x-admin::form>

    {!! view_render_event('admin.expenses.create.form.after') !!}

    @pushOnce('scripts')
        <script type="module">
            app.component('v-expense-create', {
                template: '#v-expense-create-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>
