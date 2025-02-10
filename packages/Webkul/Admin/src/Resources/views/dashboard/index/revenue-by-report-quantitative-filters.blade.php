{!! view_render_event('admin.dashboard.index.revenue_by_report_filters.before') !!}

<!-- Filtros de Relatório Vue Component -->
<v-dashboard-revenue-by-report-quantitative-filters>
    <!-- Shimmer para carregamento -->
    <x-admin::shimmer.dashboard.index.revenue-by-report-quantitative-filters />
</v-dashboard-revenue-by-report-quantitative-filters>

{!! view_render_event('admin.dashboard.index.revenue_by_report_filters.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-revenue-by-report-quantitative-filters-template"
    >
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.index.revenue-by-report-quantitative-filters />
        </template>

        <template v-else>
            <div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col justify-between gap-1">
                    <p class="text-base font-semibold text-gray-600 dark:text-gray-300">
                        @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.title')
                    </p>
                </div>

                <!-- Filtros -->
                <div class="flex gap-4 mt-4 items-start">
                    <!-- Data Inicial -->
                    <div class="flex flex-col w-full">
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">
                            @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.start-date')
                        </label>

                        <x-admin::flat-picker.date class="!w-[40px]" ::allow-input="false">
                            <input
                                type="date"
                                id="startDate"
                                v-model="filters.startDate"
                                class="flex min-h-[29px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 
                                    transition-all hover:border-gray-400 
                                    dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                                placeholder="@lang('Data inicio')"
                            />
                        </x-admin::flat-picker.date>
                    </div>

                    <!-- Data Final -->
                    <div class="flex flex-col w-full">
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">
                            @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.end-date')
                        </label>

                        <x-admin::flat-picker.date class="!w-[40px]" ::allow-input="false">
                            <input
                                type="date"
                                id="endDate"
                                v-model="filters.endDate"
                                class="flex min-h-[29px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 
                                    transition-all hover:border-gray-400 
                                    dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                                placeholder="@lang('Data Final')"
                            />
                        </x-admin::flat-picker.date>
                    </div>

                    <!-- Seleção de Produto -->
                    <div class="flex flex-col w-full">
                        <x-admin::form.control-group>
                            <!-- Label -->
                            <x-admin::form.control-group.label>
                                @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.product')
                            </x-admin::form.control-group.label>

                            <!-- Container para o select + ícone -->
                            <div class="relative">
                                <select
                                    v-model="filters.product"
                                    id="product"
                                    name="product"
                                    class="inline-flex w-full cursor-pointer appearance-none items-center justify-between gap-x-2 
                                        rounded-md border bg-white px-2.5 py-1.5 pr-9 text-left leading-6 text-gray-600 
                                        transition-all hover:border-gray-400 focus:border-gray-400 
                                        dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 
                                        dark:hover:border-gray-400 dark:focus:border-gray-400"
                                >
                                    <option value="">
                                        @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.select-product')
                                    </option>
                                    
                                    <option
                                        v-for="product in products"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        @{{ product.name }}
                                    </option>
                                </select>

                                <!-- Ícone de seta, mais à direita -->
                                <span 
                                    class="icon-down-arrow text-2xl absolute top-1/2 right-4 transform -translate-y-1/2 pointer-events-none"
                                    style="right: 0.15rem;"
                                ></span>

                            </div>
                            
                            <!-- Exibe mensagem de erro (caso exista validação) -->
                            <x-admin::form.control-group.error control-name="product" />
                        </x-admin::form.control-group>
                    </div>

                    <!-- Seleção de Vendedor -->
                    <div class="flex flex-col w-full">
                        <x-admin::form.control-group>
                            <!-- Label -->
                            <x-admin::form.control-group.label>
                                @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.seller')
                            </x-admin::form.control-group.label>

                            <!-- Container para o select + ícone -->
                            <div class="relative">
                                <select
                                    v-model="filters.seller"
                                    id="seller"
                                    name="seller"
                                    class="inline-flex w-full cursor-pointer appearance-none items-center justify-between gap-x-2 
                                        rounded-md border bg-white px-2.5 py-1.5 pr-9 text-left leading-6 text-gray-600 
                                        transition-all hover:border-gray-400 focus:border-gray-400 
                                        dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 
                                        dark:hover:border-gray-400 dark:focus:border-gray-400"
                                >
                                    <option value="">
                                        @lang('admin::app.dashboard.index.revenue-by-report-quantitative-filters.select-seller')
                                    </option>
                                    
                                    <option
                                        v-for="seller in sellers"
                                        :key="seller.id"
                                        :value="seller.id"
                                    >
                                        @{{ seller.name }}
                                    </option>
                                </select>

                                <!-- Ícone de seta, mais à direita -->
                                <span 
                                    class="icon-down-arrow text-2xl absolute top-1/2 right-4 transform -translate-y-1/2 pointer-events-none"
                                    style="right: 0.15rem;"
                                    ></span>
                            </div>
                            
                            <!-- Exibe mensagem de erro (caso exista validação) -->
                            <x-admin::form.control-group.error control-name="seller" />
                        </x-admin::form.control-group>
                    </div>
                </div>


                 <!-- Resultados em Cards -->
                <div class="flex gap-4 mt-4">
                    <!-- Card de Total de Vendas -->
                    <div class="flex-1 p-4 border border-gray-200 rounded-lg shadow-sm bg-white dark:bg-gray-800">
                        <h3 class="mb-2" style="font-weight: 500; font-size: 17px;">Total de Vendas</h3>
                        <p>Total de unidades vendidas: @{{ reportData.totalUnitsSold }}</p>
                    </div>
                    <!-- Card de Valor Total de Vendas -->
                    <div class="flex-1 p-4 border border-gray-200 rounded-lg shadow-sm bg-white dark:bg-gray-800">
                        <h3 class="mb-2" style="font-weight: 500; font-size: 17px;">Valor Total de Vendas</h3>
                        <p>Valor total vendido: U$ @{{ reportData.totalRevenue }}</p>
                    </div>
                </div>

                <!-- Resultados em Cards -->
                <div class="flex gap-4">
                    <!-- Card de Vendas por Vendedor -->
                    <div class="flex-1 p-4 border border-gray-200 rounded-lg shadow-sm bg-white dark:bg-gray-800">
                        <h3 class="mb-2" style="font-weight: 500; font-size: 17px;">Vendas por Vendedor</h3>
                        <ul>
                            <li v-for="seller in reportData.sellers" :key="seller.id">
                                @{{ seller.name }}: @{{ seller.sales }} vendas
                            </li>
                        </ul>
                    </div>

                    <!-- Card de Vendas por Produto -->
                    <div class="flex-1 p-4 border border-gray-200 rounded-lg shadow-sm bg-white dark:bg-gray-800">
                        <h3 class="mb-2" style="font-weight: 500; font-size: 17px;">Vendas por Produto</h3>
                        <ul>
                            <li v-for="product in reportData.products" :key="product.id">
                                @{{ product.name }}: @{{ product.sales }} vendas
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-revenue-by-report-quantitative-filters', {
            template: '#v-dashboard-revenue-by-report-quantitative-filters-template',

            data() {
                return {
                    filters: {
                        startDate: '',
                        endDate: '',
                        seller: '',
                        product: '',
                        allSellers: false,
                        allProducts: false,
                    },

                    sellers: [],
                    products: [],
                    reportData: {
                        sellers: [],
                        totalRevenue: 0,
                        totalUnitsSold: 0,
                        products: []
                    },

                    isLoading: false,
                }
            },

            mounted() {
                this.loadSellers();
                this.loadProducts();

                // Se os filtros já estiverem preenchidos, carrega os dados automaticamente
                if (this.filters.startDate && this.filters.endDate) {
                    this.applyFilters();
                }
            },

            watch: {
                'filters.startDate': function(newVal) {
                    if (newVal && this.filters.endDate) {
                        this.applyFilters();
                    }
                },
                'filters.endDate': function(newVal) {
                    if (newVal && this.filters.startDate) {
                        this.applyFilters();
                    }
                },
                'filters.seller': function(newVal) {
                    if (this.filters.startDate && this.filters.endDate) {
                        this.applyFilters();
                    }
                },
                'filters.product': function(newVal) {
                    if (this.filters.startDate && this.filters.endDate) {
                        this.applyFilters();
                    }
                }
            },

            methods: {
                loadSellers() {
                    this.$axios.get("{{ route('admin.settings.users.search') }}")
                        .then(response => {
                            this.sellers = response.data.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },

                loadProducts() {
                    this.$axios.get("{{ route('admin.products.search') }}")
                        .then(response => {
                            this.products = response.data.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },

                applyFilters() {
                    this.isLoading = true;

                    const params = {
                        startDate: this.filters.startDate,
                        endDate: this.filters.endDate,
                        seller: this.filters.seller,
                        product: this.filters.product,
                        allSellers: this.filters.allSellers,
                        allProducts: this.filters.allProducts,
                    };

                    var filtets = Object.assign({}, filtets);

                    filtets.type = 'quantitative-quotes-day';
                    filtets.params = params;
                    this.$axios.get("{{ route('admin.dashboard.stats') }}", { 
                        params: filtets
                     })
                        .then(response => {
                            //Preenchendo os dados dos resultados
                            this.reportData.sellers = response.data.statistics.sellers;
                            this.reportData.totalRevenue = response.data.statistics.totalRevenue;
                            this.reportData.totalUnitsSold = response.data.statistics.totalUnitsSold;
                            this.reportData.products = response.data.statistics.products;
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.error(error);
                            this.isLoading = false;
                        });
                }
            }
        });
    </script>
@endPushOnce
