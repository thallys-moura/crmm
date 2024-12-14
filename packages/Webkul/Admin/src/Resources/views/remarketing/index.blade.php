<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.remarketing.index.title')
    </x-slot>

    <v-remarketing>
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <!-- Breadcrumbs -->
                        <x-admin::breadcrumbs name="remarketing" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.remarketing.index.title')
                    </div>
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </div>
    </v-remarketing>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-remarketing-template"
        >
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <!-- Breadcrumbs -->
                            <x-admin::breadcrumbs name="remarketing" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.remarketing.index.title')
                        </div>
                    </div>

                    <div class="flex items-center gap-x-2.5">
                        <!-- Create button for Remarketing -->
                        <div class="flex items-center gap-x-2.5">
                            {!! view_render_event('admin.remarketing.index.create_button.before') !!}

                            @if (bouncer()->hasPermission('remarketing.create'))
                                <a 
                                    href="{{ route('admin.remarketing.create') }}"
                                    class="primary-button"
                                >
                                    @lang('admin::app.remarketing.index.create-btn')
                                </a>
                            @endif

                            {!! view_render_event('admin.remarketing.index.create_button.after') !!}
                        </div>
                    </div>
                </div>

                {!! view_render_event('admin.remarketing.index.datagrid.before') !!}

                <!-- DataGrid -->
                <x-admin::datagrid :src="route('admin.remarketing.index')" />

                {!! view_render_event('admin.remarketing.index.datagrid.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-remarketing', {
                template: '#v-remarketing-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>
