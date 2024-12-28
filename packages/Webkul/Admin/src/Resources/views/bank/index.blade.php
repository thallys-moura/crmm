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
        <script
            type="text/x-template"
            id="v-bank-template"
        >
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

                    <div class="flex items-center gap-x-2.5">
                        <!-- Create button for Bank -->
                        <div class="flex items-center gap-x-2.5">
                            {!! view_render_event('admin.bank.index.create_button.before') !!}

                            {!! view_render_event('admin.bank.index.create_button.after') !!}
                        </div>
                    </div>
                    
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        <div class="grid grid-cols-2 gap-8">
                            <!-- Coluna 1: Hoje e Ontem -->
                            <div class="flex flex-col gap-4">
                                <h2 class="text-xl font-bold dark:text-white">Hoje</h2>
                                <div class="flex justify-between mt-2 gap-4">
                                    <span class="text font-bold dark:text-white">Recebidos: <span class="text-green-500">USD$ {{ number_format($todayRevenue, 2, ',', '.') }}</span></span>
                                    <span class="text font-bold dark:text-white">Gastos: <span class="text-red-500">USD$ {{ number_format($todayExpense, 2, ',', '.') }}</span></span>
                                </div>
                        
                                <h2 class="text-xl font-bold dark:text-white mt-4">Ontem</h2>
                                <div class="flex justify-between mt-2 gap-4">
                                    <span class="text font-bold dark:text-white">Recebidos: <span class="text-green-500">USD$ {{ number_format($yesterdayRevenue, 2, ',', '.') }}</span></span>
                                    <span class="text font-bold dark:text-white">Gastos: <span class="text-red-500">USD$ {{ number_format($yesterdayExpense, 2, ',', '.') }}</span></span>
                                </div>
                            </div>
                        
                            <!-- Coluna 2: Saldo Atual de Receitas por Tipo -->
                            <div class="flex flex-col gap-4">
                                <h2 class="text-xl font-bold dark:text-white">Saldo Atual de Receitas por Tipo</h2>
                                @forelse ($revenueBalances as $type => $balance)
                                    <div class="flex justify-between">
                                        <span class="text font-bold dark:text-white">{{ $type }}:</span>
                                        <span class="text-green-500">USD$ {{ number_format($balance, 2, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Nenhuma receita registrada.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

                {!! view_render_event('admin.bank.index.datagrid.before') !!}

                <!-- DataGrid -->
                <x-admin::datagrid :src="route('admin.bank.index')" />

                {!! view_render_event('admin.bank.index.datagrid.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-bank', {
                template: '#v-bank-template',
            });
        </script>
    @endPushOnce
</x-admin::layouts>
