{!! view_render_event('admin.leads.index.kanban.before') !!}

<!-- Kanabn Vue Component -->
<v-leads-kanban>
    <div class="flex flex-col gap-4">
        <!-- Shimmer -->
        <x-admin::shimmer.leads.index.kanban />
    </div>
</v-leads-kanban>

{!! view_render_event('admin.leads.index.kanban.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-leads-kanban-template">
        <template v-if="isLoading">
            <div class="flex flex-col gap-4">
                <x-admin::shimmer.leads.index.kanban />
            </div>
        </template>

        <template v-else>
            <!-- Modal Component -->
            <v-dialog ref="dialog"></v-dialog>
            <div class="flex flex-col gap-4">
                @include('admin::leads.index.kanban.toolbar')

                {!! view_render_event('admin.leads.index.kanban.content.before') !!}

                <div class="flex gap-2.5 overflow-x-auto">
                    <!-- Stage Cards -->
                    <div
                        class="flex min-w-[275px] max-w-[275px] flex-col gap-1 rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
                        v-for="(stage, index) in stageLeads"
                    >
                        {!! view_render_event('admin.leads.index.kanban.content.stage.header.before') !!}

                        <!-- Stage Header -->
                        <div class="flex flex-col px-2 py-3">
                            <!-- Stage Title and Action -->
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium dark:text-white">
                                    @{{ stage.name }} (@{{ stage.leads.meta.total }})
                                </span>
                            </div>

                            <!-- Stage Total Leads and Amount -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-medium dark:text-white">
                                    @{{ $admin.formatPrice(stage.lead_value) }}
                                </span>

                                <!-- Progress Bar -->
                                <div class="h-1 w-36 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-800">
                                    <div
                                        class="h-1 bg-green-500"
                                        :style="{ width: (stage.lead_value / totalStagesAmount) * 100 + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        {!! view_render_event('admin.leads.index.kanban.content.stage.header.after') !!}
                       
                        {!! view_render_event('admin.leads.index.kanban.content.stage.body.before') !!}

                        <!-- Draggable Stage Lead Cards -->
                        <draggable
                            class="flex h-[calc(100vh-317px)] flex-col gap-2 overflow-y-auto p-2"
                            :class="{ 'justify-center': stage.leads.data.length === 0 }"
                            ghost-class="draggable-ghost"
                            handle=".lead-item"
                            v-bind="{animation: 200}"
                            :list="stage.leads.data"
                            item-key="id"
                            group="leads"
                            @scroll="handleScroll(stage, $event)"
                            @change="updateStage(stage, $event)"
                        >
                            <template #header>
                                <div 
                                    class="flex flex-col items-center justify-center"
                                    v-if="! stage.leads.data.length"
                                >
                                    <img
                                        class="dark:mix-blend-exclusion dark:invert"
                                        src="{{ vite()->asset('images/empty-placeholders/pipedrive.svg') }}"    
                                    >

                                    <div class="flex flex-col items-center gap-4">
                                        <div class="flex flex-col items-center gap-2">
                                            <p class="text-xl font-semibold dark:text-white">
                                                @lang('admin::app.leads.index.kanban.empty-list')
                                            </p>

                                            <p class="text-gray-400 dark:text-gray-400">
                                                @lang('admin::app.leads.index.kanban.empty-list-description')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Lead Card -->
                            <template #item="{ element, index }">
                                {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.before') !!}

                                <div
                                    class="lead-item flex cursor-pointer flex-col gap-5 rounded-md border border-gray-100 bg-gray-50 p-2 dark:border-gray-400 dark:bg-gray-400"
                                    @click="openLeadDetails('{{ route('admin.leads.view', 'replaceId') }}'.replace('replaceId', element.id))"
                                >
                                    {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.header.before') !!}

                                    <!-- Header -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-1">
                                            <x-admin::avatar ::name="element.person.name" />
                                  
                                            <div class="flex flex-col gap-0.5">
                                                <span class="text-xs font-medium">
                                                    @{{ element.person.name }}
                                                </span>

                                                <span class="text-[10px] leading-normal">
                                                    @{{ element.person.organization?.name }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div
                                            class="group relative"
                                            v-if="element.rotten_days > 0"
                                        >
                                            <span class="icon-rotten cursor-default text-xl text-rose-600"></span>

                                            <div class="absolute -top-1 right-7 hidden w-max flex-col items-center group-hover:flex">
                                                <span class="whitespace-no-wrap relative rounded-md bg-black px-4 py-2 text-xs leading-none text-white shadow-lg">
                                                    @{{ "@lang('admin::app.leads.index.kanban.rotten-days', ['days' => 'replaceDays'])".replace('replaceDays', element.rotten_days) }}
                                                </span>

                                                <div class="absolute -right-1 top-2 h-3 w-3 rotate-45 bg-black"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.header.after') !!}

                                    {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.title.before') !!}

                                    <!-- Lead Title -->
                                    <p class="text-xs font-medium">
                                        @{{ element.title }}
                                    </p>

                                    <div v-if="element.billing_status_id === STATUS_PAGO" class="flex flex-wrap gap-1">
                                        <a @click.stop :href="`{{ route('admin.leads.print', '') }}/${element.id}`" target="_blank">
                                            <div class="flex items-center gap-2">
                                                <span class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center icon-print"></span>
                                                Recibo
                                            </div>
                                        </a>
                                    </div>

                                    {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.title.after') !!}

                                    <div class="flex flex-wrap gap-1">
                                        <div
                                            class="flex items-center gap-1 rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white"
                                            v-if="element.user"
                                        >
                                            <span class="icon-settings-user text-sm"></span>
                                            
                                            @{{ element.user.name }}
                                        </div>

                                        <div class="rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white" @click.stop style="user-select: text;">
                                            @{{ element.formatted_lead_value }}
                                        </div>
                                        <div class="rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white" @click.stop style="user-select: text;">
                                            @{{element.quotes[0].paymentMethod.name}}
                                        </div>

                                        <div class="rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white" @click.stop style="user-select: text;">
                                            @{{element.person.contact_numbers[0].value}}
                                        </div>

                                        <div v-if="element.tracking_link" class="rounded-xl bg-green-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white">
                                            <!-- Verifica se há um tracking link vinculado -->
                                            <button v-if="element.tracking_link"
                                                    @click.stop="openTrackingLink(element)" 
                                                    class="tracking-button">
                                                @lang('admin::app.leads.index.kanban.track-shipment')
                                            </button>
                                        </div>
                                        <!-- Tags -->
                                        <template v-for="tag in element.tags">
                                            {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.tag.before') !!}

                                            <div
                                                class="rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800"
                                                :style="{
                                                    backgroundColor: tag.color,
                                                    color: tagTextColor[tag.color]
                                                }"
                                            >
                                                @{{ tag.name }}
                                            </div>
                                                <!-- Modal de confirmação -->
                                                {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.tag.after') !!}
                                            </template>
                                        </div>
                                </div>

                                {!! view_render_event('admin.leads.index.kanban.content.stage.body.card.after') !!}
                            </template>
                        </draggable>

                        {!! view_render_event('admin.leads.index.kanban.content.stage.body.after') !!}
                    </div>
                </div>

                {!! view_render_event('admin.leads.index.kanban.content.after') !!}
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-leads-kanban', {
            template: '#v-leads-kanban-template',

            data: function () {
                return {
                    available: {
                        columns: @json($columns),
                    },

                    applied: {
                        filters: {
                            columns: [],
                        }
                    },

                    stages: @json($pipeline->stages->toArray()),

                    stageLeads: {},

                    isLoading: true,

                    tagTextColor: {
                        '#FEE2E2': '#DC2626',
                        '#FFEDD5': '#EA580C',
                        '#FEF3C7': '#D97706',
                        '#FEF9C3': '#CA8A04',
                        '#ECFCCB': '#65A30D',
                        '#DCFCE7': '#16A34A',
                    },
                    showModal: false,  // Controla a visibilidade do modal
                    selectedLead: null,  // Armazena o lead selecionado
                    trackingLink: null,
                };
            },

            computed: {
                totalStagesAmount() {
                    let totalAmount = 0;

                    for (let [key, stage] of Object.entries(this.stageLeads)) {
                        totalAmount += parseFloat(stage.lead_value);
                    }

                    return totalAmount;
                },
                STATUS_PAGO() {
                    return 1;
                },
            },

            mounted: function () {
                this.boot();
            },

            methods: {
                openTrackingLink(element) {
                    this.trackingLink = element.tracking_link;

                    window.open(this.trackingLink, '_blank'); // Abre o link de rastreamento em uma nova aba
                },

                logElementData(element) {
                    console.log(element);
                },

                openLeadDetails(url) {
                    window.location.href = url; // Simula o comportamento do <a>
                },

                openModal() {
                    this.$refs.observacaoModal.open();
                },

                /**
                 * Confirma a marcação do lead como concluído.
                 */
                confirmMarkAsCompleted() {
                    if (!this.selectedLead) {
                        return;
                    }

                    // Realiza a requisição para marcar o lead como concluído
                    this.$axios
                        .put(`{{ route('admin.leads.update', 'replace') }}`.replace('replace', this.selectedLead.id), {
                            status: 'completed'
                        })
                        .then(response => {
                            this.$emitter.emit('add-flash', { type: 'success', message: 'Lead marcado como concluído!' });

                            // Atualiza o status do lead localmente
                            this.selectedLead.status = 'completed';

                            // Fecha o modal
                            this.closeModal();
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: 'Erro ao marcar o lead como concluído!' });

                            // Fecha o modal
                            this.closeModal();
                        });
                },

                /**
                 * Initialization: This function checks for any previously saved filters in local storage and applies them as needed.
                 *
                 * @returns {void}
                 */
                 boot() {
                    let kanbans = this.getKanbans();

                    if (kanbans?.length) {
                        const currentKanban = kanbans.find(({ src }) => src === this.src);

                        if (currentKanban) {
                            this.applied.filters = currentKanban.applied.filters;

                            this.get()
                                .then(response => {
                                    for (let [stageId, data] of Object.entries(response.data)) {
                                        this.stageLeads[stageId] = data;
                                    }
                                });

                            return;
                        }
                    }

                    this.get()
                        .then(response => {
                            for (let [stageId, data] of Object.entries(response.data)) {
                                this.stageLeads[stageId] = data;
                            }
                        });
                },

                /**
                 * Fetches the leads based on the applied filters.
                 *
                 * @param {object} requestedParams - The requested parameters.
                 * @returns {Promise} The promise object representing the request.
                 */
                get(requestedParams = {}) {
                    let params = {
                        search: '',
                        searchFields: '',
                        pipeline_id: "{{ request('pipeline_id') }}",
                        limit: 10,
                    };

                    this.applied.filters.columns.forEach((column) => {
                        if (column.index === 'all') {
                            if (! column.value.length) {
                                return;
                            }

                            params['search'] += `title:${column.value.join(',')};`;
                            params['searchFields'] += `title:like;`;

                            return;
                        }

                        /**
                         * If the column is a searchable dropdown, then we need to append the column value
                         * with the column label. Otherwise, we can directly append the column value.
                         */
                        params['search'] += column.filterable_type === 'searchable_dropdown'
                            ? `${column.index}:${column.value.map(option => option.value).join(',')};`
                            : `${column.index}:${column.value.join(',')};`;

                        params['searchFields'] += `${column.index}:${column.search_field};`;
                    });

                    return this.$axios
                        .get("{{ route('admin.leads.get') }}", {
                            params: {
                                ...params,

                                ...requestedParams,
                            }
                        })
                        .then(response => {
                            this.isLoading = false;

                            this.updateKanbans();

                             // Aplica ordenação pelos leads dentro de cada estágio
                            for (let [stageId, data] of Object.entries(response.data)) {
                                this.stageLeads[stageId] = data;

                                // Ordena os leads pela coluna created_at (pode ajustar para desc ou asc)
                                this.stageLeads[stageId].leads.data.sort((a, b) => {
                                    return new Date(b.created_at) - new Date(a.created_at); // Para ordenar de forma descendente
                                });
                            }


                            return response;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },

                /**
                 * Filters the leads based on the applied filters.
                 *
                 * @param {object} filters - The filters to be applied.
                 * @returns {void}
                 */
                filter(filters) {
                    this.applied.filters.columns = [
                        ...(this.applied.filters.columns.filter((column) => column.index === 'all')),
                        ...filters.columns,
                    ];

                    this.get()
                        .then(response => {
                            for (let [stageId, data] of Object.entries(response.data)) {
                                this.stageLeads[stageId] = data;
                            }
                        });
                },

                /**
                 * Searches the leads based on the applied filters.
                 *
                 * @param {object} filters - The filters to be applied.
                 * @returns {void}
                 */
                search(filters) {
                    this.applied.filters.columns = [
                        ...(this.applied.filters.columns.filter((column) => column.index !== 'all')),
                        ...filters.columns,
                    ];

                    this.get()
                        .then(response => {
                            for (let [stageId, data] of Object.entries(response.data)) {
                                this.stageLeads[stageId] = data;
                            }
                        });
                },

                /**
                 * Appends the leads to the stage.
                 *
                 * @param {object} params - The parameters to be appended.
                 * @returns {void}
                 */
                append(params) {
                    this.get(params)
                        .then(response => {
                            for (let [stageId, data] of Object.entries(response.data)) {
                                if (! this.stageLeads[stageId]) {
                                    this.stageLeads[stageId] = data;
                                } else {
                                    this.stageLeads[stageId].leads.data = this.stageLeads[stageId].leads.data.concat(data.leads.data);

                                    this.stageLeads[stageId].leads.meta = data.leads.meta;
                                }
                            }
                        });
                },

                /**
                 * Updates the stage with the latest lead data.
                 *
                 * @param {object} stage - The stage object.
                 * @param {object} event - The event object.
                 * @returns {void}
                 */
                updateStage: function (stage, event) {
                    if (event.removed) {
                        stage.lead_value = parseFloat(stage.lead_value) - parseFloat(event.removed.element.lead_value);

                        this.stageLeads[stage.id].leads.meta.total = this.stageLeads[stage.id].leads.meta.total - 1;

                        return;
                    }

                    stage.lead_value = parseFloat(stage.lead_value) + parseFloat(event.added.element.lead_value);

                    this.stageLeads[stage.id].leads.meta.total = this.stageLeads[stage.id].leads.meta.total + 1;

                    this.$axios
                        .put("{{ route('admin.leads.stage.update', 'replace') }}".replace('replace', event.added.element.id), {
                            'lead_pipeline_stage_id': stage.id
                        })
                        .then(response => {
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });

                    // Verifica se o quadro de destino é o de ID 2
                    if (stage.id === 2) {
                        // Abre o modal para atualização do status apenas se o quadro for de ID 2
                        this.selectedLead = event.added.element; // Armazena o lead selecionado
                        if(!this.selectedLead.tracking_link){
                            this.$refs.dialog.openDialog(this.selectedLead); // Abre o diálogo
                        }
                    }

                },

                /**
                 * Handles the scroll event on the stage leads.
                 *
                 * @param {object} stage - The stage object.
                 * @param {object} event - The scroll event.
                 * @returns {void}
                 */
                handleScroll(stage, event) {
                    const bottom = event.target.scrollHeight - event.target.scrollTop === event.target.clientHeight

                    if (! bottom) {
                        return;
                    }

                    if (this.stageLeads[stage.id].leads.meta.current_page == this.stageLeads[stage.id].leads.meta.last_page) {
                        return;
                    }

                    this.append({
                        pipeline_stage_id: stage.id,
                        pipeline_id: stage.lead_pipeline_id,
                        page: this.stageLeads[stage.id].leads.meta.current_page + 1,
                        limit: 10,
                    });
                },

                //=======================================================================================
                // Support for previous applied values in kanbans. All code is based on local storage.
                //=======================================================================================

                /**
                 * Updates the kanbans stored in local storage with the latest data.
                 *
                 * @returns {void}
                 */
                 updateKanbans() {
                    let kanbans = this.getKanbans();

                    if (kanbans?.length) {
                        const currentKanban = kanbans.find(({ src }) => src === this.src);

                        if (currentKanban) {
                            kanbans = kanbans.map(kanban => {
                                if (kanban.src === this.src) {
                                    return {
                                        ...kanban,
                                        requestCount: ++kanban.requestCount,
                                        available: this.available,
                                        applied: this.applied,
                                    };
                                }

                                return kanban;
                            });
                        } else {
                            kanbans.push(this.getKanbanInitialProperties());
                        }
                    } else {
                        kanbans = [this.getKanbanInitialProperties()];
                    }

                    this.setKanbans(kanbans);
                },

                /**
                 * Returns the initial properties for a kanban.
                 *
                 * @returns {object} Initial properties for a kanban.
                 */
                getKanbanInitialProperties() {
                    return {
                        src: this.src,
                        requestCount: 0,
                        available: this.available,
                        applied: this.applied,
                    };
                },

                /**
                 * Returns the storage key for kanbans in local storage.
                 *
                 * @returns {string} Storage key for kanbans.
                 */
                getKanbansStorageKey() {
                    return 'kanbans';
                },

                /**
                 * Retrieves the kanbans stored in local storage.
                 *
                 * @returns {Array} Kanbans stored in local storage.
                 */
                getKanbans() {
                    let kanbans = localStorage.getItem(
                        this.getKanbansStorageKey()
                    );

                    return JSON.parse(kanbans) ?? [];
                },

                /**
                 * Sets the kanbans in local storage.
                 *
                 * @param {Array} kanbans - Kanbans to be stored in local storage.
                 * @returns {void}
                 */
                setKanbans(kanbans) {
                    localStorage.setItem(
                        this.getKanbansStorageKey(),
                        JSON.stringify(kanbans)
                    );
                },
            }
        });

        // Modal (Dialog) Component
        app.component('v-dialog', {
            template: `   
                        <template>
                            <Teleport to="body">
                                <div v-if="isOpen" class="dialog-overlay">
                                    <div class="dialog-content">
                                        

                                        <span class="text-xs font-medium dark:text-white">
                                            Informe o Link de Rastreio
                                        </span>

                                        <!-- Campo de input para o link de rastreamento -->
                                        <input 
                                            v-model="trackingLink" 
                                            type="text" 
                                            placeholder="Insira o link de rastreio"
                                            class="input-field"
                                        />

                                        <!-- Botões de ação -->
                                        <div class="button-group">
                                            <button @click="save" class="primary-button">Salvar</button>
                                            <button @click="closeDialog" class='secondary-button'>Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </Teleport>
                        </template>  
            `,

            data() {
                return {
                    isOpen: false,
                    status: 'open',
                    trackingLink: '' // Variável para armazenar o link de rastreamento
                };
            },

            methods: {
                openDialog(lead) {
                    this.isOpen = true;
                    this.lead = lead;
                },

                closeDialog() {
                    this.isOpen = false;
                    this.lead = null;
                },

                /***
                 * Faz chamada Ajax para salvar o link de rastreamento
                */
                save() {
                    if(!this.trackingLink){
                        this.$emitter.emit('add-flash', { type: 'error', message: 'Link de Rastreamento é obrigatório' });
                        return;
                    }

                    //Faz uma requisição PUT para atualizar o link de rastreamento
                    this.$axios.put(
                            `/admin/leads/${this.lead.id}/saveTrackingLink`,
                        {
                            tracking_link: this.trackingLink,
                            lead_id: this.lead.id
                        }).then(response => {

                            // Atualiza o tracking_link do lead no frontend
                            this.lead.tracking_link = this.trackingLink;
                            
                            this.$emitter.emit('add-flash', {type: 'success', message: response.data.message });

                            this.closeDialog();
                        }).catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });
                }
            }
        });
    </script>
    <style scoped>
        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .dialog-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            width: 300px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .close-button-dialog {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
        
        .input-field {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endPushOnce
