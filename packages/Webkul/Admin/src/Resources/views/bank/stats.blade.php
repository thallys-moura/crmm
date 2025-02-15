{!! view_render_event('admin.bank.index.stats.before') !!}

<!-- Componente Vue para Estatísticas Financeiras -->
<v-bank-revenue-stats>
    <x-admin::shimmer.bank.stats />
</v-bank-revenue-stats>

{!! view_render_event('admin.bank.index.stats.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-bank-revenue-stats-template">
        <template v-if="isLoading">
            <x-admin::shimmer.bank.stats />
        </template>

        <template v-else>
            <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Movimentação Financeira</h2>

                <div class="mt-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Hoje</h3>
                    <div class="flex justify-between mt-2 border-b">
                        <span class="text-gray-700 dark:text-gray-300">Recebidos:</span>
                        <span class="font-bold text-green-500">@{{ report.statistics.todayRevenue.formatted_total }}</span>
                    </div>
                    <div class="flex justify-between border-b">
                        <span class="text-gray-700 dark:text-gray-300">Gastos:</span>
                        <span class="font-bold text-red-500">@{{ report.statistics.todayExpense.formatted_total }}</span>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-bank-revenue-stats', {
            template: '#v-bank-revenue-stats-template',

            data() {
                return {
                    report: {
                        statistics: {
                            todayRevenue: { formatted_total: 'USD$ 0.00' },
                            todayExpense: { formatted_total: 'USD$ 0.00' },
                            yesterdayRevenue: { formatted_total: 'USD$ 0.00' },
                            yesterdayExpense: { formatted_total: 'USD$ 0.00' }
                        }
                    },
                    isLoading: true
                }
            },

            mounted() {
                this.getStats({});
                this.$emitter.on('reporting-filter-updated', this.getStats);
            },

            methods: {
                getStats(filters) {
                    this.isLoading = true;
                    var filters = Object.assign({}, filters);
                    filters.type = 'revenue-stats';

                    this.$axios.get("{{ route('admin.bank.stats') }}", { params: filters })
                        .then(response => {
                            this.report.statistics = response.data.statistics;
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.error('Erro ao obter dados de receita:', error);
                            this.isLoading = false;
                        });
                }
            }
        });
    </script>
@endPushOnce
