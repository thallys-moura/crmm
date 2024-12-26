{!! view_render_event('admin.daily_controls.index.expenses_by_source.before') !!}

<!-- Expenses by Sources Vue Component -->
<v-daily-controls-revenue-by-source>
    <!-- Shimmer -->
    <x-admin::shimmer.daily_controls.revenue-by-source />
</v-daily-controls-revenue-by-source>

{!! view_render_event('admin.daily_controls.index.expenses_by_source.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-daily-controls-revenue-by-source-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.daily_controls.revenue-by-source />
        </template>

        <template v-else>
            <div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col justify-between gap-1">
                    <p class="text-base font-semibold dark:text-gray-300">
                        @lang('admin::app.daily_controls.expenses-by-sources.title')
                    </p>
                </div>

                <!-- Doughnut Chart -->
                <div
                    class="flex w-full max-w-full flex-col gap-4 px-8 pt-8"
                    v-if="report.statistics.length"
                >
                    <x-admin::charts.doughnut
                        ::labels="chartLabels"
                        ::datasets="chartDatasets"
                    />

                    <div class="flex flex-wrap justify-center gap-5">
                        <div
                            class="flex items-center gap-2 whitespace-nowrap"
                            v-for="(stat, index) in report.statistics"
                        >
                            <span
                                class="h-3.5 w-3.5 rounded-sm"
                                :style="{ backgroundColor: colors[index] }"
                            ></span>

                            <p class="text-xs dark:text-gray-300">
                                @{{ stat.source_name }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Empty Product Design -->
                <div
                    class="flex flex-col gap-8 p-4"
                    v-else
                >
                    <div class="grid justify-center justify-items-center gap-3.5 py-2.5">
                        <!-- Placeholder Image -->
                        <img
                            src="{{ vite()->asset('images/empty-placeholders/default.svg') }}"
                            class="dark:mix-blend-exclusion dark:invert"
                        >

                        <!-- Add Variants Information -->
                        <div class="flex flex-col items-center">
                            <p class="text-base font-semibold text-gray-400">
                                @lang('admin::app.daily_controls.expenses-by-sources.empty-title')
                            </p>

                            <p class="text-gray-400">
                                @lang('admin::app.daily_controls.expenses-by-sources.empty-info')
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-daily-controls-revenue-by-source', {
            template: '#v-daily-controls-revenue-by-source-template',

            data() {
                return {
                    report: [],
                    colors: [
                        '#8979FF',
                        '#FF928A',
                        '#3CC3DF',
                    ],
                    isLoading: true,
                };
            },

            computed: {
                chartLabels() {
                    return this.report.statistics.map(({ source_name }) => source_name);
                },

                chartDatasets() {
                    return [{
                        data: this.report.statistics.map(({ total }) => total),
                        backgroundColor: this.colors,
                    }];
                },
            },

            mounted() {
                this.getStats({});
                this.$emitter.on('reporting-filter-updated', this.getStats);
            },

            methods: {
                getStats(filters) {
                    this.isLoading = true;

                    var filters = Object.assign({}, filters);
                    filters.type = 'revenue-by-source';

                    this.$axios.get("{{ route('admin.daily_controls.stats') }}", {
                        params: filters,
                    })
                    .then((response) => {
                        this.report = response.data;
                        this.isLoading = false;
                    })
                    .catch((error) => {
                        console.error('Erro ao obter dados do gráfico:', error);
                    });
                },
            },
        });
    </script>
@endPushOnce
