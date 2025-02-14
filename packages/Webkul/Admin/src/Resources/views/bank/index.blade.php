<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.bank.index.title')
    </x-slot>

    <v-bank>
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <!-- Breadcrumbs -->
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
        <script type="text/x-template" id="v-bank-template">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <div class="flex cursor-pointer items-center">
                            <!-- Breadcrumbs -->
                            <x-admin::breadcrumbs name="bank" />
                        </div>

                        <div class="text-xl font-bold dark:text-white">
                            @lang('admin::app.bank.index.title')
                        </div>
                    </div>
                </div>

                <!-- Grid Principal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-800">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">Movimentação Financeira</h2>
                        <div class="mt-4">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Hoje</h3>
                            <div class="flex justify-between mt-2 border-b">
                                <span class="text-gray-700 dark:text-gray-300">Recebidos:</span>
                                <span class="font-bold text-green-500">USD$ {{ number_format($todayRevenue, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="text-gray-700 dark:text-gray-300">Gastos:</span>
                                <span class="font-bold text-red-500">USD$ {{ number_format($todayExpense, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Ontem</h3>
                            <div class="flex justify-between mt-2 border-b">
                                <span class="text-gray-700 dark:text-gray-300">Recebidos:</span>
                                <span class="font-bold text-green-500">USD$ {{ number_format($yesterdayRevenue, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="text-gray-700 dark:text-gray-300">Gastos:</span>
                                <span class="font-bold text-red-500">USD$ {{ number_format($yesterdayExpense, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-800">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">Saldo Atual  (Receitas - Despesas)</h2>
                            <div class="flex justify-between mt-2 border-b pb-2">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Saldo Atual:</span>
                                <span class="font-bold text-green-500">USD$ {{ number_format($revenueBalances, 2, ',', '.') }}</span>
                            </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-800">
                    {!! view_render_event('admin.bank.index.datagrid.before') !!}
                    <x-admin::datagrid :src="route('admin.bank.index')" />
                    {!! view_render_event('admin.bank.index.datagrid.after') !!}
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-bank', {
                template: '#v-bank-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>
