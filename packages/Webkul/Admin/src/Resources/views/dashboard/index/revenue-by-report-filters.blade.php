{!! view_render_event('admin.dashboard.index.revenue_by_report_filters.before') !!}

<!-- Filtros de Relatório Vue Component -->
<v-dashboard-revenue-by-report-filters>
    <!-- Shimmer para carregamento -->
    <x-admin::shimmer.dashboard.index.revenue-by-report-filters />
</v-dashboard-revenue-by-report-filters>

{!! view_render_event('admin.dashboard.index.revenue_by_report_filters.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-revenue-by-report-filters-template"
    >
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.index.revenue-by-report-filters />
        </template>

        <template v-else>
            <div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col justify-between gap-1">
                    <p class="text-base font-semibold dark:text-gray-300">
                        @lang('admin::app.dashboard.index.revenue-by-report-filters.title')
                    </p>
                </div>

                <!-- Filtros -->
                <div class="flex gap-1.5 mt-4 items-center">
                    <div class="flex flex-col">
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.start-date')
                        </label>
                        <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                            <input
                                id="startDate"
                                type="date"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                                v-model="filters.startDate"
                                placeholder="@lang('Data inicio')"
                            />
                        </x-admin::flat-picker.date>
                    </div>

                    <div class="flex flex-col">
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.end-date')
                        </label>
                        <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                            <input
                                id="endDate"
                                type="date"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                                v-model="filters.endDate"
                                placeholder="@lang('Data Final')"
                            />
                        </x-admin::flat-picker.date>
                    </div>
                </div>



                <div class="flex flex-col w-full">
                    <x-admin::form.control-group>
                        <!-- Label -->
                        <x-admin::form.control-group.label>
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.seller')
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
                                    @lang('admin::app.dashboard.index.revenue-by-report-filters.select-seller')
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
                                class="icon-down-arrow text-2xl absolute top-1/2 transform -translate-y-1/2 pointer-events-none"
                                style="right: 0.15rem;"
                            ></span>
                        </div>
                        
                        <!-- Exibe mensagem de erro (caso exista validação) -->
                        <x-admin::form.control-group.error control-name="seller" />
                    </x-admin::form.control-group>
                </div>


                <div class="flex flex-col w-full">
                    <x-admin::form.control-group>
                        <!-- Label -->
                        <x-admin::form.control-group.label>
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.product')
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
                                    @lang('admin::app.dashboard.index.revenue-by-report-filters.select-product')
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
                                class="icon-down-arrow text-2xl absolute top-1/2 transform -translate-y-1/2 pointer-events-none"
                                style="right: 0.15rem;"
                            ></span>
                        </div>
                        
                        <!-- Exibe mensagem de erro (caso exista validação) -->
                        <x-admin::form.control-group.error control-name="product" />
                    </x-admin::form.control-group>
                </div>


                <!-- Checkboxes -->
                <div class="mt-4 flex flex-col gap-2">
                    <!-- Checkbox para Todos os Vendedores -->
                    <label class="relative inline-flex cursor-pointer items-center" style="gap: 10px;">
                        <input
                            type="checkbox"
                            v-model="filters.allSellers"
                            id="allSellers"
                            class="peer sr-only"
                        >
                        <div class="peer h-5 w-9 cursor-pointer rounded-full bg-gray-200 after:absolute after:top-0.5 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-blue-300 dark:bg-gray-800 dark:after:border-white dark:after:bg-white dark:peer-checked:bg-gray-950 after:ltr:left-0.5 peer-checked:after:ltr:translate-x-full after:rtl:right-0.5 peer-checked:after:rtl:-translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.all-sellers')
                        </span>
                    </label>

                    <!-- Checkbox para Todos os Produtos -->
                    <label class="relative inline-flex cursor-pointer items-center" style="gap: 10px;">
                        <input
                            type="checkbox"
                            v-model="filters.allProducts"
                            id="allProducts"
                            class="peer sr-only"
                        >
                        <div class="peer h-5 w-9 cursor-pointer rounded-full bg-gray-200 after:absolute after:top-0.5 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-blue-300 dark:bg-gray-800 dark:after:border-white dark:after:bg-white dark:peer-checked:bg-gray-950 after:ltr:left-0.5 peer-checked:after:ltr:translate-x-full after:rtl:right-0.5 peer-checked:after:rtl:-translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.all-products')
                        </span>
                    </label>
                </div>



                <!-- Botões -->
                <div class="mt-6 flex justify-between">
                    <button type="button" class="secondary-button" @click="resetFields()">
                        @lang('admin::app.dashboard.index.revenue-by-report-filters.clear-fields')
                    </button>
                    <button type="button" class="primary-button" @click="printReport()">
                        @lang('admin::app.dashboard.index.revenue-by-report-filters.print')
                    </button>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-revenue-by-report-filters', {
            template: '#v-dashboard-revenue-by-report-filters-template',

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

                    isLoading: false,
                }
            },

            mounted() {
                this.loadSellers();
                this.loadProducts();
                this.$emitter.on('reporting-filter-updated', this.applyFilters);
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

                resetFields() {
                    this.filters = {
                        startDate: '',
                        endDate: '',
                        seller: '',
                        product: '',
                        allSellers: false,
                        allProducts: false,
                    };
                },

                applyFilters() {
                    const params = {
                        startDate: this.filters.startDate,
                        endDate: this.filters.endDate,
                        seller: this.filters.seller,
                        product: this.filters.product,
                        allSellers: this.filters.allSellers,
                        allProducts: this.filters.allProducts,
                    };

                    this.$axios.get("{{ route('admin.reports.filter') }}", { params })
                        .then(response => {
                            // Manipular os dados retornados (response.data)
                            this.reportData = response.data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },

                printReport() {
                    const params = {
                        startDate: this.filters.startDate,
                        endDate: this.filters.endDate,
                        seller: this.filters.seller,
                        product: this.filters.product,
                        allSellers: this.filters.allSellers,
                        allProducts: this.filters.allProducts,
                    };
                    

                    this.$axios.get("{{ route('admin.reports.filter') }}", { params, responseType: 'blob' })
                        .then (response => {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'Relatorio_Vendas.pdf'); // Nome do arquivo PDF
                            document.body.appendChild(link);
                            link.click();
                        })
                        .catch (error => {
                            console.log(erro);
                        });
                },
            }
        });
    </script>
@endPushOnce
