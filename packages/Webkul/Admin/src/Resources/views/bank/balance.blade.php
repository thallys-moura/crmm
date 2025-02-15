{!! view_render_event('admin.bank.index.balance.before') !!}

<v-bank-balance-stats>
    <x-admin::shimmer.bank.balance />
</v-bank-balance-stats>

{!! view_render_event('admin.bank.index.balance.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-bank-balance-stats-template">
        <template v-if="isLoading">
            <x-admin::shimmer.bank.balance />
        </template>

        <template v-else>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Saldo Atual</h2>

                <div class="flex justify-between mt-2 border-b pb-2">
                    <span class="text-gray-700 dark:text-gray-300 font-medium">Saldo Atual:</span>
                    <span class="font-bold text-green-500">@{{ balanceData.totalBalance.formatted_total }}</span>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-bank-balance-stats', {
            template: '#v-bank-balance-stats-template',

            data() {
                return {
                    balanceData: {},
                    isLoading: true,
                }
            },

            mounted() {
                this.getBalanceStats({});
                this.$emitter.on('reporting-filter-updated', this.getBalanceStats);
            },

            methods: {
                getBalanceStats(filters) {
                    this.isLoading = true;
                    filters.type = 'balance-stats';

                    this.$axios.get("{{ route('admin.bank.stats') }}", { params: filters })
                        .then(response => {
                            this.balanceData = response.data.statistics;
                            this.isLoading = false;
                        })
                        .catch(error => console.error('Erro ao obter dados de saldo:', error));
                }
            }
        });
    </script>
@endPushOnce
