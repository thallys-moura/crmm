<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.bank.index.title')
    </x-slot>

    <v-bank>
        <div class="flex flex-col gap-4">
            <v-bank-filters>
                <!-- Shimmer -->
                <div class="flex gap-1.5">
                    <div class="light-shimmer-bg dark:shimmer h-[39px] w-[140px] rounded-md"></div>
                    <div class="light-shimmer-bg dark:shimmer h-[39px] w-[140px] rounded-md"></div>
                </div>
            </v-bank-filters>

            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <x-admin::breadcrumbs name="bank" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.bank.index.title')
                    </div>
                </div>
            </div>

            <!-- DataGrid Shimmer -->
            <x-admin::shimmer.datagrid />
        </div>
    </v-bank>

    @pushOnce('scripts')
        <script
            type="module"
            src="{{ vite()->asset('js/chart.js') }}"
        ></script>

        <script
            type="module"
            src="https://cdn.jsdelivr.net/npm/chartjs-chart-funnel@4.2.1/build/index.umd.min.js"
        ></script>

        <script type="text/x-template" id="v-bank-template">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <x-admin::breadcrumbs name="bank" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.bank.index.title')
                        </div>
                    </div>
                </div>

                <div class="flex gap-1.5">
                    <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                        <input
                            class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                            v-model="filters.start"
                            placeholder="@lang('admin::app.bank.index.start-date')"
                        />
                    </x-admin::flat-picker.date>

                    <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                        <input
                            class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                            v-model="filters.end"
                            placeholder="@lang('admin::app.bank.index.end-date')"
                        />
                    </x-admin::flat-picker.date>
                </div>

                {!! view_render_event('admin.bank.index.stats.before') !!}
                <div class="mt-3.5 flex gap-4 max-xl:flex-wrap">
                    <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                        @include('admin::bank.balance')
                    </div>
                </div>

                <div class="mt-3.5 flex gap-4 max-xl:flex-wrap">
                    <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                        @include('admin::bank.stats')
                    </div>
                </div>

                {!! view_render_event('admin.bank.index.stats.after') !!}

                {!! view_render_event('admin.bank.index.datagrid.before') !!}

                <!-- DataGrid -->
                <x-admin::datagrid :src="route('admin.bank.index')" />

                {!! view_render_event('admin.bank.index.datagrid.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-bank', {
                template: '#v-bank-template',

                data() {
                    return {
                        filters: {
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
