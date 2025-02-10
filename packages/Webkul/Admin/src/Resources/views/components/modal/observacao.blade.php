@props([
    'entity'            => null,
    'entityControlName' => null,
    'leadId'            => null,
])

<div>
    {!! view_render_event('admin.components.modal.observacao.create_btn.before') !!}
    <div
        class="flex h-[74px] w-[84px] flex-col items-center justify-center gap-1 rounded-lg border border-transparent bg-blue-200 font-medium text-blue-800 transition-all hover:border-blue-400"
        role="button"
        @click.stop="$refs.observacaoComponent.openModal('observacao')"
    >        
            <span class="icon-dollar text-2xl dark:!text-blue-800"></span>
            @lang('admin::app.leads.view.billing.billing')
    </div>

    <v-model-observacao
        ref="observacaoComponent"
        :entity="{{ json_encode($entity) }}"
        entity-control-name="{{ $entityControlName }}"
    ></v-model-observacao>
    {!! view_render_event('admin.components.modal.observacao.create_btn.after') !!}

</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-model-observacao-template">
        <Teleport to="body">
            {!! view_render_event('admin.components.modal.observacao.form_controls.before') !!}

            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <form @submit="handleSubmit($event, save)">
                    @csrf
                    {!! view_render_event('admin.components.modal.observacao.form_controls.modal.before') !!}
                    <input type="hidden" v-model="lead_id" id="lead_id" :value="{{ json_encode($leadId) }}">

                    <x-admin::modal 
                        ref="observacaoModal"
                        position="bottom-right"
                    >
                        <x-slot:header>
                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.title.before') !!}

                            <h3 class="text-base font-semibold dark:text-white">
                               Faturamento
                            </h3>

                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.title.after') !!}
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.content.controls.before') !!}
                            
                            <!-- Id -->
                            <x-admin::form.control-group.control
                                type="hidden"
                                ::name="entityControlName"
                                ::value="entity.id"
                            />

                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.leads.view.billing.status')
                                </x-admin::form.control-group.label>
                            
                                <x-admin::form.control-group.control
                                    type="select"
                                    name="status_id"
                                    id="status_id"
                                    rules="required"
                                    :label="trans('admin::app.leads.view.billing.status')"
                                >
                                    <!-- Exibe os status no campo select -->
                                    @foreach($entity as $key => $status)
                                        <option value="{{ $status['id'] }}">{{ $status['status'] }}</option>
                                    @endforeach
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>

                            <!-- Comment -->
                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.leads.view.billing.comment')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    name="comment"
                                    id="comment"
                                    rules="required"
                                    :label="trans('admin::app.leads.view.billing.comment')"
                                />

                                <x-admin::form.control-group.error control-name="comment" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.leads.view.billing.payment_date') <!-- Texto do label do campo -->
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="date"
                                name="payment_date"
                                id="payment_date"
                                rules="required"
                                :label="trans('admin::app.leads.view.billing.payment_date')"
                            />

                            <x-admin::form.control-group.error control-name="payment_date" />
                        </x-admin::form.control-group>
                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.content.controls.after') !!}
                        </x-slot>

                        <x-slot:footer>
                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.footer.save_button.before') !!}

                            <x-admin::button
                                class="primary-button"
                                :title="trans('admin::app.leads.view.billing.save-btn')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />

                            {!! view_render_event('admin.components.modal.observacao.form_controls.modal.header.footer.save_button.after') !!}
                        </x-slot>
                    </x-admin::modal>

                    {!! view_render_event('admin.components.modal.observacao.form_controls.modal.after') !!}
                </form>
            </x-admin::form>

            {!! view_render_event('admin.components.modal.observacao.form_controls.after') !!}
        </Teleport>
    </script>

    <script type="module">
        app.component('v-model-observacao', {
            template: '#v-model-observacao-template',

            props: {
                entity: {
                    type: Object,
                    required: true,
                    default: () => {}
                },
                leadId: {  // Agora leadId é uma prop separada
                    type: Number,
                    required: true
                },
                entityControlName: {
                    type: String,
                    required: true,
                    default: ''
                }
            },

            data: function () {
                return {
                    isStoring: false,
                    status_id: '',
                    comment: '',  // O comentário será preenchido pelo usuário
                    lead_id: null, 
                }
            },

            methods: {
                openModal(type) {
                    this.$refs.observacaoModal.open();
                },

                async save() {
                    this.isStoring = true;
                    try {

                        let formData = new FormData();
                        let statusId = document.getElementById('status_id').value;
                        let comment = document.getElementById('comment').value;
                        let paymentDate = document.getElementById('payment_date').value;  // Captura o valor da data de pagamento

                        formData.append('status_id', statusId);  // Agora o ID correto do status selecionado é usado                        
                        formData.append('comment', comment);      // O campo de comentário
                        formData.append('lead_id', document.getElementById('lead_id').value);      // O campo de comentário //parei no erro para identificar o lead.
                        formData.append('payment_date', paymentDate);  // Data de pagamento

                        // Faz a requisição POST para salvar os dados
                        const response = await axios.post("{{ route('admin.leads.observacao.salvar') }}", formData);
                        
                        if (response.status === 200) {
                            // Fechar modal ou notificar sucesso
                            this.$refs.observacaoModal.close();
                           
                        }
                    } catch (error) {
                        this.$refs.observacaoModal.close();

                        console.error('Erro ao salvar:', error);
                    } finally {
                        this.isStoring = false;
                    }
                }
            },
        });
    </script>
@endPushOnce