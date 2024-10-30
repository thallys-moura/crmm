<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.expenses.index.title')
    </x-slot>

    <v-expense>
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <!-- Breadcrumbs -->
                        <x-admin::breadcrumbs name="expenses" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.expenses.index.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <!-- Create button for Expense -->
                    <div class="flex items-center gap-x-2.5">
                        @if (bouncer()->hasPermission('expenses.create'))
                            <a 
                                href="{{ route('admin.expenses.create') }}"
                                class="primary-button"
                            >
                                @lang('admin::app.expenses.index.create-btn')
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </div>
    </v-expense>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-expense-template"
        >
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <!-- Breadcrumbs -->
                            <x-admin::breadcrumbs name="expenses" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.expenses.index.title')
                        </div>
                    </div>

                    <div class="flex items-center gap-x-2.5">
                        <!-- Create button for Expense -->
                        <div class="flex items-center gap-x-2.5">
                            {!! view_render_event('admin.expenses.index.create_button.before') !!}

                            @if (bouncer()->hasPermission('expenses.create'))
                                <a 
                                    href="{{ route('admin.expenses.create') }}"
                                    class="primary-button"
                                >
                                    @lang('admin::app.expenses.index.create-btn')
                                </a>
                            @endif

                            {!! view_render_event('admin.expenses.index.create_button.after') !!}
                        </div>
                    </div>
                </div>

                {!! view_render_event('admin.expenses.index.datagrid.before') !!}

                <!-- DataGrid -->
                <x-admin::datagrid :src="route('admin.expenses.index')" />

                {!! view_render_event('admin.expenses.index.datagrid.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-expense', {
                template: '#v-expense-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>