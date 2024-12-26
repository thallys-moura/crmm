{!! view_render_event('admin.daily_controls.index.total_expenses.before') !!}

<!-- Total Daily Expenses Vue Component -->
<v-daily_controls-total-expenses>
    <!-- Shimmer -->
    <x-admin::shimmer.daily_controls.total-expenses-stats />
</v-daily_controls-total-expenses>

{!! view_render_event('admin.daily_controls.index.total_expenses.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-daily_controls-total-expenses-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.daily_controls.total-expenses-stats />
        </template>

        <!-- Total Expenses Section -->
        <template v-else>
            <div class="grid gap-4 rounded-lg border border-gray-200 bg-white px-4 py-2 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col justify-between gap-1">
                    <p class="text-base font-semibold dark:text-gray-300">
                        @lang('admin::app.daily_controls.total-expenses.title')
                    </p>
                </div>

                <!-- Bar Chart -->
                <div class="flex w-full max-w-full flex-col gap-4">
                    <x-admin::charts.bar
                        style='max-height: 300px;'
                        ::labels="chartLabels"
                        ::datasets="chartDatasets"
                    />

                    <div class="flex justify-center gap-5">
                        <div
                            class="flex items-center gap-2"
                            v-for="(dataset, index) in chartDatasets"
                            :key="index"
                        >
                            <span
                                class="h-3.5 w-3.5 rounded-sm"
                                :style="{ backgroundColor: dataset.backgroundColor }"
                            ></span>
                            
                            <p class="text-xs dark:text-gray-300">
                                @{{ dataset.label }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-daily_controls-total-expenses', {
            template: '#v-daily_controls-total-expenses-template',
    
            data() {
                return {
                    report: [],
                    colors: [
                        '#8979FF',
                        '#63CFE5',
                        '#FFA8A1',
                        '#FFC107',
                        '#28A745',
                        '#DC3545',
                    ],
                    isLoading: true,
                };
            },
    
            computed: {
                chartLabels() {
                    // Assume que todos os grupos compartilham o mesmo eixo de tempo
                    const groups = Object.keys(this.report.statistics);
                    if (groups.length > 0) {
                        return this.report.statistics[groups[0]].over_time.map(({ label }) => label);
                    }
                    return [];
                },
    
                chartDatasets() {
                    const datasets = [];
                    let colorIndex = 0;
    
                    for (const [groupName, groupData] of Object.entries(this.report.statistics)) {
                        datasets.push({
                            label: groupName,
                            data: groupData.over_time.map(({ total }) => total),
                            barThickness: 24,
                            backgroundColor: this.colors[colorIndex % this.colors.length],
                        });
                        colorIndex++;
                    }
    
                    return datasets;
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
    
                    filters.type = 'total-expenses';
    
                    this.$axios.get("{{ route('admin.daily_controls.stats') }}", {
                            params: filters
                        })
                        .then(response => {
                            this.report = response.data;
    
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.error('Error fetching daily controls data:', error);
                        });
                }
            }
        });
    </script>
    
@endPushOnce
