<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.daily_controls.index.title')
    </x-slot>

    <v-daily-controls>
        <div class="flex flex-col gap-4">
            <v-daily-controls-filters>
                <!-- Shimmer -->
                <div class="flex gap-1.5">
                    <div class="light-shimmer-bg dark:shimmer h-[39px] w-[140px] rounded-md"></div>
                    <div class="light-shimmer-bg dark:shimmer h-[39px] w-[140px] rounded-md"></div>
                </div>
            </v-daily-controls-filters>

            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <!-- Breadcrumbs -->
                        <x-admin::breadcrumbs name="daily_controls" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.daily_controls.index.title')
                    </div>
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </div>
    </v-daily-controls>

    @pushOnce('scripts')
    <script
        type="module"
        src="{{ vite()->asset('js/chart.js') }}"
    >
    </script>

    <script
        type="module"
        src="https://cdn.jsdelivr.net/npm/chartjs-chart-funnel@4.2.1/build/index.umd.min.js"
    >
    </script>
        <script
            type="text/x-template"
            id="v-daily-controls-template"
        >


            <div class="flex flex-col gap-4">

                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <!-- Breadcrumbs -->
                            <x-admin::breadcrumbs name="daily_controls" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.daily_controls.index.title')
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2.5">

                        <!-- Create button for DailyControls -->
                        <div class="flex items-center gap-x-2.5">
                            {!! view_render_event('admin.daily_controls.index.create_button.before') !!}

                            @if (bouncer()->hasPermission('daily_controls.create'))
                                <a
                                    href="{{ route('admin.daily_controls.create') }}"
                                    class="primary-button"
                                >
                                    @lang('admin::app.daily_controls.index.create-btn')
                                </a>
                            @endif

                            {!! view_render_event('admin.daily_controls.index.create_button.after') !!}
                        </div>
                    </div>
                </div>
                <div class="flex gap-1.5">
                    <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                        <input
                            class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                            v-model="filters.start"
                            placeholder="@lang('admin::app.daily_controls.index.start-date')"
                        />
                    </x-admin::flat-picker.date>

                    <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                        <input
                            class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                            v-model="filters.end"
                            placeholder="@lang('admin::app.daily_controls.index.end-date')"
                        />
                    </x-admin::flat-picker.date>
                </div>
                {!! view_render_event('admin.daily_controls.index.revenue.before') !!}

                <div class="mt-3.5 flex gap-4 max-xl:flex-wrap">
                    <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                        @include('admin::daily_controls.revenue')
                        @include('admin::daily_controls.total-expenses-stats')

                    </div>
                    <div class="flex w-[378px] max-w-full flex-col gap-4 max-sm:w-full">
                        @include('admin::daily_controls.revenue-by-source')
                        @include('admin::daily_controls.expenses-by-product-group')
                    </div>
                </div>
                <div class="mt-3.5 flex gap-4 max-xl:flex-wrap">
                    <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                    </div>
                </div>
                {!! view_render_event('admin.daily_controls.index.revenue.after') !!}

                {!! view_render_event('admin.daily_controls.index.datagrid.before') !!}

                    <!-- DataGrid -->
                    <x-admin::datagrid :src="route('admin.daily_controls.index')" />

                {!! view_render_event('admin.daily_controls.index.datagrid.after') !!}

            </div>
        </script>

        <script type="module">
            app.component('v-daily-controls', {
                template: '#v-daily-controls-template',
                data() {
                    return {
                        filters: {
                            channel: '',

                            start: "{{ $startDate->format('Y-m-d') }}",

                            end: "{{ $endDate->format('Y-m-d') }}",
                        }
                    }
                },

                watch: {
                    filters: {
                        handler() {
                            this.$emitter.emit('reporting-filter-updated', this.filters);
                        },

                        deep: true
                    }
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
