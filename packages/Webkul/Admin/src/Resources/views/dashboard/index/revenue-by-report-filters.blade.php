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
                <div class="flex gap-4 mt-4">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.start-date')
                        </label>
                        <input type="date" v-model="filters.startDate" id="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.end-date')
                        </label>
                        <input type="date" v-model="filters.endDate" id="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Seleção de Vendedor -->
                <div class="mt-4">
                    <label for="seller" class="block text-sm font-medium text-gray-700">
                        @lang('admin::app.dashboard.index.revenue-by-report-filters.seller')
                    </label>
                    <select v-model="filters.seller" id="seller" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.select-seller')
                        </option>
                        <option v-for="seller in sellers" :key="seller.id" :value="seller.id">@{{ seller.name }}</option>
                    </select>
                </div>

                <!-- Seleção de Produto -->
                <div class="mt-4">
                    <label for="product" class="block text-sm font-medium text-gray-700">
                        @lang('admin::app.dashboard.index.revenue-by-report-filters.product')
                    </label>
                    <select v-model="filters.product" id="product" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        <option value="">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.select-product')
                        </option>
                        <option v-for="product in products" :key="product.id" :value="product.id">@{{ product.name }}</option>
                    </select>
                </div>

                <!-- Checkboxes -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <input type="checkbox" v-model="filters.allSellers" id="allSellers" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="allSellers" class="ml-2 block text-sm text-gray-900">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.all-sellers')
                        </label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" v-model="filters.allProducts" id="allProducts" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="allProducts" class="ml-2 block text-sm text-gray-900">
                            @lang('admin::app.dashboard.index.revenue-by-report-filters.all-products')
                        </label>
                    </div>
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
