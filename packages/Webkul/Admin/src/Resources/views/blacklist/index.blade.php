<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.blacklist.index.title')
    </x-slot>

    <v-blacklist>
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <!-- Breadcrumbs -->
                        <x-admin::breadcrumbs name="blacklist" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.blacklist.index.title')
                    </div>
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </div>
    </v-blacklist>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-blacklist-template"
        >
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <!-- Breadcrumbs -->
                            <x-admin::breadcrumbs name="blacklist" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.blacklist.index.title')
                        </div>
                    </div>

                    <div class="flex items-center gap-x-2.5">
                        <!-- Create button for BlackList -->
                        <div class="flex items-center gap-x-2.5">
                            {!! view_render_event('admin.blacklist.index.create_button.before') !!}

                            @if (bouncer()->hasPermission('blacklist.create'))
                                <a 
                                    href="{{ route('admin.blacklist.create') }}"
                                    class="primary-button"
                                >
                                    @lang('admin::app.blacklist.index.create-btn')
                                </a>
                            @endif

                            {!! view_render_event('admin.blacklist.index.create_button.after') !!}
                        </div>
                    </div>
                </div>

                {!! view_render_event('admin.blacklist.index.datagrid.before') !!}

                <!-- DataGrid -->
                <x-admin::datagrid :src="route('admin.blacklist.index')" />

                {!! view_render_event('admin.blacklist.index.datagrid.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-blacklist', {
                template: '#v-blacklist-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>
