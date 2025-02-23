{!! view_render_event('admin.daily_controls.over_all.before') !!}

<!-- Over Details Vue Component -->
<v-daily-controls-over-all-stats>
    <!-- Shimmer -->
    <x-admin::shimmer.daily_controls.over-all />
</v-daily-controls-over-all-stats>

{!! view_render_event('admin.daily_controls.over_all.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-daily-controls-over-all-stats-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.daily_controls.over-all />
        </template>

        <!-- Total Stats Section -->
        <template v-else>
            <!-- Stats Cards -->
            <!-- Average Revenue Card -->
            <div class="grid grid-cols-3 gap-4">
                <!-- Average Daily Calls -->
                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-dailycontrols')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_dailycontrols.formatted_total }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold text-green-500"
                                :class="[report.statistics.average_dailycontrols.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold text-green-500"
                                :class="[report.statistics.average_dailycontrols.progress < 0 ?  'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_dailycontrols.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-expenses-dailycontrols')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_expenses.formatted_expenses }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold text-green-500"
                                :class="[report.statistics.average_expenses.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold text-green-500"
                                :class="[report.statistics.average_expenses.progress < 0 ?  'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_expenses.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-leads-per-day')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_leads_per_day.current }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold text-green-500"
                                :class="[report.statistics.average_leads_per_day.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold text-green-500"
                                :class="[report.statistics.average_leads_per_day.progress < 0 ?  'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_leads_per_day.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-cost-per-lead')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_cost_per_lead.formatted_total }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold text-green-500"
                                :class="[report.statistics.average_cost_per_lead.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold text-green-500"
                                :class="[report.statistics.average_cost_per_lead.progress < 0 ?  'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_cost_per_lead.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-calls-per-day')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_calls_per_day.current }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold"
                                :class="[report.statistics.average_calls_per_day.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold"
                                :class="[report.statistics.average_calls_per_day.progress < 0 ? 'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_calls_per_day.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.average-sales-per-day')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.average_sales_per_day.current }}
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold"
                                :class="[report.statistics.average_sales_per_day.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p
                                class="text-xs font-semibold"
                                :class="[report.statistics.average_sales_per_day.progress < 0 ? 'text-red-500' : 'text-green-500']"
                            >
                                @{{ Math.abs(report.statistics.average_sales_per_day.progress.toFixed(2)) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white px-4 py-5 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        @lang('admin::app.daily_controls.over-all.roi')
                    </p>

                    <div class="flex gap-2">
                        <p class="text-xl font-bold dark:text-gray-300">
                            @{{ report.statistics.roi?.current?.toFixed(2) ?? 0 }}%
                        </p>

                        <div class="flex items-center gap-0.5">
                            <span
                                class="text-base !font-semibold"
                                :class="[report.statistics.roi.progress < 0 ? 'icon-stats-down text-red-500 dark:!text-red-500' : 'icon-stats-up text-green-500 dark:!text-green-500']"
                            ></span>

                            <p class="text-xs font-semibold"
                                :class="[report.statistics.roi?.progress < 0 ? 'text-red-500' : 'text-green-500']">
                                @{{ Math.abs(report.statistics.roi?.progress?.toFixed(2) ?? 0) }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </template>
    </script>

    <script type="module">
        app.component('v-daily-controls-over-all-stats', {
            template: '#v-daily-controls-over-all-stats-template',

            data() {
                return {
                    report: [],
                    isLoading: true,
                };
            },

            mounted() {
                this.getStats({});

                this.$emitter.on('reporting-filter-updated', this.getStats);
            },

            methods: {
                getStats(filters) {
                    this.isLoading = true;

                    filters = Object.assign({}, filters);

                    filters.type = 'over-all';

                    this.$axios
                        .get("{{ route('admin.daily_controls.stats') }}", { params: filters })
                        .then((response) => {
                            this.report = response.data;
                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },
            },
        });
    </script>
@endPushOnce
