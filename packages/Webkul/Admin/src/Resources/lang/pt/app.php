<?php

return [
    'acl' => [
        'leads'           => 'Ordens',
        'lead'            => 'Orden',
        'quotes'          => 'Cotações',
        'mail'            => 'Correio',
        'inbox'           => 'Caixa de entrada',
        'draft'           => 'Rascunho',
        'outbox'          => 'Caixa de saída',
        'sent'            => 'Enviados',
        'trash'           => 'Lixeira',
        'activities'      => 'Atividades',
        'webhook'         => 'Webhook',
        'contacts'        => 'Contatos',
        'persons'         => 'Pessoas',
        'organizations'   => 'Organizações',
        'products'        => 'Produtos',
        'settings'        => 'Configurações',
        'groups'          => 'Grupos',
        'roles'           => 'Papéis',
        'users'           => 'Usuários',
        'user'            => 'Usuário',
        'automation'      => 'Automação',
        'attributes'      => 'Atributos',
        'pipelines'       => 'Pipelines',
        'sources'         => 'Fontes',
        'types'           => 'Tipos',
        'email-templates' => 'Modelos de E-mail',
        'workflows'       => 'Fluxos de Trabalho',
        'other-settings'  => 'Outras Configurações',
        'tags'            => 'Tags',
        'configuration'   => 'Configuração',
        'create'          => 'Criar',
        'edit'            => 'Editar',
        'view'            => 'Ver',
        'print'           => 'Imprimir',
        'delete'          => 'Excluir',
        'export'          => 'Exportar',
        'mass-delete'     => 'Excluir em Massa',
    ],

    'users' => [
        'activate-warning' => 'Sua conta ainda não está ativada. Por favor, entre em contato com o administrador.',
        'login-error'      => 'As credenciais não correspondem aos nossos registros.',

        'login' => [
            'email'                => 'Endereço de E-mail',
            'forget-password-link' => 'Esqueceu a Senha?',
            'password'             => 'Senha',
            'submit-btn'           => 'Entrar',
            'title'                => 'Entrar',
        ],

        'forget-password' => [
            'create' => [
                'email'           => 'E-mail Registrado',
                'email-not-exist' => 'E-mail Não Existe',
                'page-title'      => 'Esqueceu a Senha',
                'reset-link-sent' => 'Link de Redefinição de Senha Enviado',
                'sign-in-link'    => 'Voltar para Entrar?',
                'submit-btn'      => 'Redefinir',
                'title'           => 'Recuperar Senha',
            ],
        ],

        'reset-password' => [
            'back-link-title'  => 'Voltar para Entrar?',
            'confirm-password' => 'Confirmar Senha',
            'email'            => 'E-mail Registrado',
            'password'         => 'Senha',
            'submit-btn'       => 'Redefinir Senha',
            'title'            => 'Redefinir Senha',
        ],
    ],

    'account' => [
        'edit' => [
            'back-btn'          => 'Voltar',
            'change-password'   => 'Alterar Senha',
            'confirm-password'  => 'Confirmar Senha',
            'current-password'  => 'Senha Atual',
            'email'             => 'E-mail',
            'general'           => 'Geral',
            'invalid-password'  => 'A senha atual que você inseriu está incorreta.',
            'name'              => 'Nome',
            'password'          => 'Senha',
            'profile-image'     => 'Imagem de Perfil',
            'save-btn'          => 'Salvar Conta',
            'title'             => 'Minha Conta',
            'update-success'    => 'Conta atualizada com sucesso',
            'upload-image-info' => 'Envie uma Imagem de Perfil (110px X 110px) nos Formatos PNG ou JPG',
        ],
    ],

    'components' => [
        'activities' => [
            'actions' => [
                'mail' => [
                    'btn'          => 'Correio',
                    'title'        => 'Escrever E-mail',
                    'to'           => 'Para',
                    'enter-emails' => 'Pressione Enter para adicionar e-mails',
                    'cc'           => 'CC',
                    'bcc'          => 'BCC',
                    'subject'      => 'Assunto',
                    'send-btn'     => 'Enviar',
                    'message'      => 'Mensagem',
                ],

                'file' => [
                    'btn'           => 'Arquivo',
                    'title'         => 'Adicionar Arquivo',
                    'title-control' => 'Título',
                    'name'          => 'Nome',
                    'description'   => 'Descrição',
                    'file'          => 'Arquivo',
                    'save-btn'      => 'Salvar Arquivo',
                ],

                'note' => [
                    'btn'      => 'Nota',
                    'title'    => 'Adicionar Nota',
                    'comment'  => 'Comentário',
                    'save-btn' => 'Salvar Nota',
                ],

                'activity' => [
                    'btn'           => 'Atividade',
                    'title'         => 'Adicionar Atividade',
                    'title-control' => 'Título',
                    'description'   => 'Descrição',
                    'schedule-from' => 'Agendar de',
                    'schedule-to'   => 'Agendar até',
                    'location'      => 'Local',
                    'call'          => 'Chamada',
                    'meeting'       => 'Reunião',
                    'lunch'         => 'Almoço',
                    'save-btn'      => 'Salvar Atividade',

                    'participants' => [
                        'title'       => 'Participantes',
                        'placeholder' => 'Digite para buscar participantes',
                        'users'       => 'Usuários',
                        'persons'     => 'Pessoas',
                        'no-results'  => 'Nenhum resultado encontrado...',
                    ],
                ],
            ],

            'index' => [
                'from'         => 'De',
                'to'           => 'Para',
                'cc'           => 'Cc',
                'bcc'          => 'Bcc',
                'all'          => 'Tudo',
                'planned'      => 'Planejado',
                'calls'        => 'Chamadas',
                'meetings'     => 'Reuniões',
                'lunches'      => 'Almoços',
                'files'        => 'Arquivos',
                'quotes'       => 'Cotações',
                'notes'        => 'Notas',
                'emails'       => 'E-mails',
                'change-log'   => 'Registros de Alterações',
                'by-user'      => 'Por :user',
                'scheduled-on' => 'Agendado para',
                'location'     => 'Local',
                'participants' => 'Participantes',
                'mark-as-done' => 'Marcar como Concluído',
                'delete'       => 'Excluir',
                'edit'         => 'Editar',
                'view'         => 'Ver',
                'unlink'       => 'Desvincular',
                'empty'        => 'Vazio',

                'empty-placeholders' => [
                    'all' => [
                        'title'       => 'Nenhuma Atividade Encontrada',
                        'description' => 'Nenhuma atividade foi encontrada para este item. Você pode adicionar atividades clicando no botão no painel à esquerda.',
                    ],

                    'planned' => [
                        'title'       => 'Nenhuma Atividade Planejada Encontrada',
                        'description' => 'Nenhuma atividade planejada foi encontrada para este item. Você pode adicionar atividades planejadas clicando no botão no painel à esquerda.',
                    ],

                    'notes' => [
                        'title'       => 'Nenhuma Nota Encontrada',
                        'description' => 'Nenhuma nota foi encontrada para este item. Você pode adicionar notas clicando no botão no painel à esquerda.',
                    ],

                    'calls' => [
                        'title'       => 'Nenhuma Chamada Encontrada',
                        'description' => 'Nenhuma chamada foi encontrada para este item. Você pode adicionar chamadas clicando no botão no painel à esquerda.',
                    ],

                    'meetings' => [
                        'title'       => 'Nenhuma Reunião Encontrada',
                        'description' => 'Nenhuma reunião foi encontrada para este item. Você pode adicionar reuniões clicando no botão no painel à esquerda.',
                    ],

                    'lunches' => [
                        'title'       => 'Nenhum Almoço Encontrado',
                        'description' => 'Nenhum almoço foi encontrado para este item. Você pode adicionar almoços clicando no botão no painel à esquerda.',
                    ],

                    'files' => [
                        'title'       => 'Nenhum Arquivo Encontrado',
                        'description' => 'Nenhum arquivo foi encontrado para este item. Você pode adicionar arquivos clicando no botão no painel à esquerda.',
                    ],

                    'emails' => [
                        'title'       => 'Nenhum E-mail Encontrado',
                        'description' => 'Nenhum e-mail foi encontrado para este item. Você pode adicionar e-mails clicando no botão no painel à esquerda.',
                    ],

                    'system' => [
                        'title'       => 'Nenhum Registro de Alterações Encontrado',
                        'description' => 'Nenhum registro de alterações foi encontrado para este item.',
                    ],
                ],
            ],
        ],


        'media' => [
            'images' => [
                'add-image-btn'     => 'Adicionar Imagem',
                'ai-add-image-btn'  => 'AI Mágica',
                'allowed-types'     => 'png, jpeg, jpg',
                'not-allowed-error' => 'Apenas arquivos de imagem (.jpeg, .jpg, .png, ..) são permitidos.',

                'placeholders' => [
                    'front'     => 'Frente',
                    'next'      => 'Próximo',
                    'size'      => 'Tamanho',
                    'use-cases' => 'Casos de Uso',
                    'zoom'      => 'Zoom',
                ],
            ],

            'videos' => [
                'add-video-btn'     => 'Adicionar Vídeo',
                'allowed-types'     => 'mp4, webm, mkv',
                'not-allowed-error' => 'Apenas arquivos de vídeo (.mp4, .mov, .ogg ..) são permitidos.',
            ],
        ],

        'datagrid' => [
            'index' => [
                'no-records-selected'              => 'Nenhum registro foi selecionado.',
                'must-select-a-mass-action-option' => 'Você deve selecionar uma opção de ação em massa.',
                'must-select-a-mass-action'        => 'Você deve selecionar uma ação em massa.',
            ],

            'toolbar' => [
                'length-of' => ':length de',
                'of'        => 'de',
                'per-page'  => 'Por Página',
                'results'   => ':total Resultados',
                'delete'    => 'Excluir',
                'selected'  => ':total Itens Selecionados',

                'mass-actions' => [
                    'submit'        => 'Enviar',
                    'select-option' => 'Selecionar Opção',
                    'select-action' => 'Selecionar Ação',
                ],

                'filter' => [
                    'apply-filters-btn' => 'Aplicar Filtros',
                    'back-btn'          => 'Voltar',
                    'create-new-filter' => 'Criar Novo Filtro',
                    'custom-filters'    => 'Filtros Personalizados',
                    'delete-error'      => 'Ocorreu um erro ao excluir o filtro, por favor, tente novamente.',
                    'delete-success'    => 'Filtro excluído com sucesso.',
                    'empty-description' => 'Não há filtros selecionados disponíveis para salvar. Selecione filtros para salvar.',
                    'empty-title'       => 'Adicione Filtros para Salvar',
                    'name'              => 'Nome',
                    'quick-filters'     => 'Filtros Rápidos',
                    'save-btn'          => 'Salvar',
                    'save-filter'       => 'Salvar Filtro',
                    'saved-success'     => 'Filtro salvo com sucesso.',
                    'selected-filters'  => 'Filtros Selecionados',
                    'title'             => 'Filtro',
                    'update'            => 'Atualizar',
                    'update-filter'     => 'Atualizar Filtro',
                    'updated-success'   => 'Filtro atualizado com sucesso.',
                ],

                'search' => [
                    'title' => 'Pesquisar',
                ],
            ],

            'filters' => [
                'select' => 'Selecionar',
                'title'  => 'Filtros',

                'dropdown' => [
                    'searchable' => [
                        'at-least-two-chars' => 'Digite pelo menos 2 caracteres...',
                        'no-results'         => 'Nenhum resultado encontrado...',
                    ],
                ],

                'custom-filters' => [
                    'clear-all' => 'Limpar Tudo',
                    'title'     => 'Filtros Personalizados',
                ],

                'boolean-options' => [
                    'false' => 'Falso',
                    'true'  => 'Verdadeiro',
                ],

                'date-options' => [
                    'last-month'        => 'Último Mês',
                    'last-six-months'   => 'Últimos 6 Meses',
                    'last-three-months' => 'Últimos 3 Meses',
                    'this-month'        => 'Este Mês',
                    'this-week'         => 'Esta Semana',
                    'this-year'         => 'Este Ano',
                    'today'             => 'Hoje',
                    'yesterday'         => 'Ontem',
                ],
            ],

            'table' => [
                'actions'              => 'Ações',
                'no-records-available' => 'Nenhum Registro Disponível.',
            ],
        ],

        'modal' => [
            'confirm' => [
                'agree-btn'    => 'Concordar',
                'disagree-btn' => 'Discordar',
                'message'      => 'Você tem certeza de que deseja realizar esta ação?',
                'title'        => 'Você tem certeza?',
            ],
        ],

        'tags' => [
            'index' => [
                'title'          => 'Tags',
                'added-tags'     => 'Tags Adicionadas',
                'save-btn'       => 'Salvar Tag',
                'placeholder'    => 'Digite para buscar tags',
                'add-tag'        => 'Adicionar ":term"...',
                'aquarelle-red'  => 'Vermelho Aquarela',
                'crushed-cashew' => 'Caju Triturado',
                'beeswax'        => 'Cera de Abelha',
                'lemon-chiffon'  => 'Chiffon de Limão',
                'snow-flurry'    => 'Nevasca',
                'honeydew'       => 'Melada',
            ],
        ],

        'layouts' => [
            'header' => [
                'mega-search' => [
                    'title'   => 'Pesquisa',

                    'tabs' => [
                        'leads'    => 'Ordens',
                        'quotes'   => 'Vendas',
                        'persons'  => 'Pessoas',
                        'products' => 'Produtos',
                    ],

                    'explore-all-products'          => 'Explorar todos os Produtos',
                    'explore-all-leads'             => 'Explorar todos os Ordens',
                    'explore-all-contacts'          => 'Explorar todos os Contatos',
                    'explore-all-quotes'            => 'Explorar todas as Cotações',
                    'explore-all-matching-products' => 'Explorar todos os produtos correspondentes ":query" (:count)',
                    'explore-all-matching-leads'    => 'Explorar todos os Ordens correspondentes ":query" (:count)',
                    'explore-all-matching-contacts' => 'Explorar todos os contatos correspondentes ":query" (:count)',
                    'explore-all-matching-quotes'   => 'Explorar todas as cotações correspondentes ":query" (:count)',
                ],
            ],
        ],

        'attributes' => [
            'lookup' => [
                'click-to-add'    => 'Clique para adicionar',
                'search'          => 'Pesquisar',
                'no-result-found' => 'Nenhum resultado encontrado',
            ],
        ],

        'lookup' => [
            'click-to-add' => 'Clique para Adicionar',
            'no-results'   => 'Nenhum Resultado Encontrado',
            'add-as-new'   => 'Adicionar como Novo',
            'search'       => 'Pesquisar...',
        ],

        'flash-group' => [
            'success' => 'Sucesso',
            'error'   => 'Erro',
            'warning' => 'Aviso',
            'info'    => 'Informação',
        ],
    ],



    'quotes' => [
        'index' => [
            'title'          => 'Vendas',
            'create-btn'     => 'Criar Venda',
            'create-success' => 'Venda criada com sucesso.',
            'update-success' => 'Venda atualizada com sucesso.',
            'delete-success' => 'Venda excluída com sucesso.',
            'delete-failed'  => 'A Venda não pode ser excluída.',
            'sendmail-failed'  => 'Houve um erro ao enviar o e-mail de registro da venda.',

            'datagrid' => [
                'subject'        => 'Assunto',
                'product'        => 'Produto',
                'sales-person'   => 'Vendedor',
                'expired-at'     => 'Expirado em',
                'created-at'     => 'Criado em',
                'expired-quotes' => 'Venda Expirada',
                'person'         => 'Cliente',
                'subtotal'       => 'Subtotal',
                'discount'       => 'Disconto',
                'tax'            => 'Imposto',
                'adjustment'     => 'Ajuste',
                'grand-total'    => 'Total Geral',
                'edit'           => 'Editar',
                'delete'         => 'Excluir',
                'print'          => 'Imprimir',
                'status'         => 'Status do Pagamento',
                'payment_method' => 'Forma de Pagamento',
                'email'          => 'Email'
            ],

            'pdf' => [
                'title'            => 'Venda',
                'grand-total'      => 'Total Geral',
                'adjustment'       => 'Ajuste',
                'discount'         => 'Desconto',
                'tax'              => 'Imposto',
                'sub-total'        => 'Subtotal',
                'amount'           => 'Quantia',
                'quantity'         => 'Quantidade',
                'price'            => 'Preço',
                'product-name'     => 'Nome do Produto',
                'status'           => 'Status do Pagamento',
                'sku'              => 'SKU',
                'shipping-address' => 'Endereço de Entrega',
                'billing-address'  => 'Endereço de Cobrança',
                'expired-at'       => 'Expirado em',
                'sales-person'     => 'Vendedor',
                'date'             => 'Data',
                'quote-id'         => 'ID da Venda',
                'coupons-generated' => 'Cupons Gerados',
                'coupon' => 'Cupom',
                'coupons-disclaimer' => [
                    'not-valid-for-1-month' => 'Os cupons não são válidos para tratamento de 1 mês.',
                    'valid-for-60-days' => 'Os cupons são válidos por 60 dias a partir da data de emissão.',
                    'discount-info' => 'Cada cupom concede um desconto de 4%. Se os indicados utilizarem o cupom, o indicador principal recebe um acréscimo de 2% no desconto, totalizando um desconto máximo de 6%.',
                ],
            ],
        ],

        'create' => [
            'title'             => 'Criar Venda',
            'save-btn'          => 'Salvar Venda',
            'quote-info'        => 'Informações da Venda',
            'quote-info-info'   => 'Coloque as informações básicas da Venda.',
            'address-info'      => 'Informações do Endereço',
            'address-info-info' => 'Informações sobre o endereço relacionado à Venda.',
            'quote-items'       => 'Itens da Venda',
            'search-products'   => 'Buscar Produtos',
            'link-to-lead'      => 'Vincular a ordem',
            'person'            => 'Cliente',
            'quote-item-info'   => 'Adicionar Solicitação de Produto para esta Venda.',
            'quote-name'        => 'Nome da Venda',
            'quantity'          => 'Quantidade',
            'price'             => 'Preço',
            'discount'          => 'Desconto',
            'tax'               => 'Imposto',
            'total'             => 'Total',
            'amount'            => 'Quantia',
            'add-item'          => '+ Adicionar Item',
            'sub-total'         => 'Subtotal (:symbol)',
            'total-discount'    => 'Desconto (:symbol)',
            'total-tax'         => 'Imposto (:symbol)',
            'total-adjustment'  => 'Ajuste (:symbol)',
            'grand-total'       => 'Total Geral (:symbol)',
            'discount-amount'   => 'Valor do Desconto',
            'tax-amount'        => 'Valor do Imposto',
            'adjustment-amount' => 'Valor do Ajuste',
            'product-name'      => 'Nome do Produto',
            'action'            => 'Ação',
            'payment-methods'   => 'Forma de Pagamento',
            'payment-methods-info' => 'Selecione...'

        ],

        'edit' => [
            'title'             => 'Editar Venda',
            'save-btn'          => 'Salvar Venda',
            'quote-info'        => 'Informações da Venda',
            'quote-info-info'   => 'Coloque as informações básicas da Venda.',
            'address-info'      => 'Informações do Endereço',
            'address-info-info' => 'Informações sobre o endereço relacionado à Venda.',
            'quote-items'       => 'Itens da Venda',
            'link-to-lead'      => 'Vincular ao Lead',
            'quote-item-info'   => 'Adicionar Solicitação de Produto para esta Venda.',
            'quote-name'        => 'Nome da Venda',
            'quantity'          => 'Quantidade',
            'price'             => 'Preço',
            'search-products'   => 'Buscar Produtos',
            'discount'          => 'Desconto',
            'tax'               => 'Imposto',
            'total'             => 'Total',
            'amount'            => 'Quantia',
            'add-item'          => '+ Adicionar Item',
            'sub-total'         => 'Subtotal (:symbol)',
            'total-discount'    => 'Desconto (:symbol)',
            'total-tax'         => 'Imposto (:symbol)',
            'total-adjustment'  => 'Ajuste (:symbol)',
            'grand-total'       => 'Total Geral (:symbol)',
            'discount-amount'   => 'Valor do Desconto',
            'tax-amount'        => 'Valor do Imposto',
            'adjustment-amount' => 'Valor do Ajuste',
            'product-name'      => 'Nome do Produto',
            'action'            => 'Ação',
        ],
        
        'common' => [
            'contact' => [
                'name'           => 'Nome',
                'email'          => 'Email',
                'contact-number' => 'Número de Contato',
                'organization'   => 'Organização',
            ],
    
            'products' => [
                'product-name' => 'Nome do Produto',
                'quantity'     => 'Quantidade',
                'price'        => 'Preço',
                'amount'       => 'Montante',
                'action'       => 'Ação',
                'add-more'     => 'Adicionar Mais',
                'total'        => 'Total',
            ],
        ],
    ],

    'contacts' => [
        'persons' => [
            'index' => [
                'title'          => 'Pessoa',
                'create-btn'     => 'Criar Pessoa',
                'create-success' => 'Pessoa criada com sucesso.',
                'update-success' => 'Pessoa atualizada com sucesso.',
                'delete-success' => 'Pessoa excluída com sucesso.',
                'delete-failed'  => 'A pessoa não pode ser excluída.',

                'datagrid' => [
                    'contact-numbers'   => 'Números de Contato',
                    'delete'            => 'Excluir',
                    'edit'              => 'Editar',
                    'emails'            => 'E-mails',
                    'id'                => 'ID',
                    'view'              => 'Ver',
                    'name'              => 'Nome',
                    'organization-name' => 'Nome da Organização',
                ],
            ],

            'view' => [
                'title'        => ':name',
                'about-person' => 'Sobre a Pessoa',

                'activities' => [
                    'index' => [
                        'all'          => 'Tudo',
                        'calls'        => 'Chamadas',
                        'meetings'     => 'Reuniões',
                        'lunches'      => 'Almoços',
                        'files'        => 'Arquivos',
                        'quotes'       => 'Cotações',
                        'notes'        => 'Notas',
                        'emails'       => 'E-mails',
                        'by-user'      => 'Por :user',
                        'scheduled-on' => 'Agendado para',
                        'location'     => 'Local',
                        'participants' => 'Participantes',
                        'mark-as-done' => 'Marcar como Concluído',
                        'delete'       => 'Excluir',
                        'edit'         => 'Editar',
                    ],

                    'actions' => [
                        'mail' => [
                            'btn'      => 'Correio',
                            'title'    => 'Escrever E-mail',
                            'to'       => 'Para',
                            'cc'       => 'CC',
                            'bcc'      => 'BCC',
                            'subject'  => 'Assunto',
                            'send-btn' => 'Enviar',
                            'message'  => 'Mensagem',
                        ],

                        'file' => [
                            'btn'           => 'Arquivo',
                            'title'         => 'Adicionar Arquivo',
                            'title-control' => 'Título',
                            'name'          => 'Nome do Arquivo',
                            'description'   => 'Descrição',
                            'file'          => 'Arquivo',
                            'save-btn'      => 'Salvar Arquivo',
                        ],

                        'note' => [
                            'btn'      => 'Nota',
                            'title'    => 'Adicionar Nota',
                            'comment'  => 'Comentário',
                            'save-btn' => 'Salvar Nota',
                        ],

                        'activity' => [
                            'btn'           => 'Atividade',
                            'title'         => 'Adicionar Atividade',
                            'title-control' => 'Título',
                            'description'   => 'Descrição',
                            'schedule-from' => 'Agendar de',
                            'schedule-to'   => 'Agendar até',
                            'location'      => 'Local',
                            'call'          => 'Chamada',
                            'meeting'       => 'Reunião',
                            'lunch'         => 'Almoço',
                            'save-btn'      => 'Salvar Atividade',
                        ],
                    ],
                ],
            ],

            'create' => [
                'title'    => 'Criar Pessoa',
                'save-btn' => 'Salvar Pessoa',
            ],

            'edit' => [
                'title'    => 'Editar Pessoa',
                'save-btn' => 'Salvar Pessoa',
            ],
        ],

        'organizations' => [
            'index' => [
                'title'          => 'Organizações',
                'create-btn'     => 'Criar Organização',
                'create-success' => 'Organização criada com sucesso.',
                'update-success' => 'Organização atualizada com sucesso.',
                'delete-success' => 'Organização excluída com sucesso.',
                'delete-failed'  => 'A organização não pode ser excluída.',

                'datagrid' => [
                    'delete'        => 'Excluir',
                    'edit'          => 'Editar',
                    'id'            => 'ID',
                    'name'          => 'Nome',
                    'persons-count' => 'Quantidade de Pessoas',
                ],
            ],

            'create' => [
                'title'    => 'Criar Organização',
                'save-btn' => 'Salvar Organização',
            ],

            'edit' => [
                'title'    => 'Editar Organização',
                'save-btn' => 'Salvar Organização',
            ],
        ],
    ],


    'products' => [
        'index' => [
            'title'          => 'Produtos',
            'create-btn'     => 'Criar Produto',
            'create-success' => 'Produto criado com sucesso.',
            'update-success' => 'Produto atualizado com sucesso.',
            'delete-success' => 'Produto excluído com sucesso.',
            'delete-failed'  => 'O produto não pode ser excluído.',

            'datagrid' => [
                'allocated' => 'Alocado',
                'delete'    => 'Excluir',
                'edit'      => 'Editar',
                'id'        => 'ID',
                'in-stock'  => 'Em Estoque',
                'name'      => 'Nome',
                'on-hand'   => 'Em Mãos',
                'price'     => 'Preço',
                'sku'       => 'SKU',
                'view'      => 'Visualizar',
            ],
        ],

        'create' => [
            'save-btn'  => 'Salvar Produto',
            'title'     => 'Criar Produto',
            'general'   => 'Geral',
            'price'     => 'Preço',
            'email-template' => 'Template de E-mail',
            'select-email-template' => 'Selecione...',
            'email-template-help' => 'O modelo de email pré-definido que sera enviado no cumprimento de algumas etapas.'
        ],

        'edit' => [
            'title'     => 'Editar Produto',
            'save-btn'  => 'Salvar Produto',
            'general'   => 'Geral',
            'price'     => 'Preço',
        ],

        'view' => [
            'sku'         => 'SKU',
            'all'         => 'Tudo',
            'notes'       => 'Notas',
            'files'       => 'Arquivos',
            'inventories' => 'Inventário',
            'change-logs' => 'Histórico de Alterações',

            'attributes' => [
                'about-product' => 'Sobre o Produto',
            ],

            'inventory' => [
                'source'     => 'Fonte',
                'in-stock'   => 'Em Estoque',
                'allocated'  => 'Alocado',
                'on-hand'    => 'Em Mãos',
                'actions'    => 'Ações',
                'assign'     => 'Atribuir',
                'add-source' => 'Adicionar Fonte',
                'location'   => 'Localização',
                'add-more'   => 'Adicionar Mais',
                'save'       => 'Salvar',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Configurações',

        'groups' => [
            'index' => [
                'create-btn'        => 'Criar Grupo',
                'title'             => 'Grupos',
                'create-success'    => 'Grupo criado com sucesso.',
                'update-success'    => 'Grupo atualizado com sucesso.',
                'destroy-success'   => 'Grupo excluído com sucesso.',
                'delete-failed'     => 'O grupo não pode ser excluído.',

                'datagrid' => [
                    'delete'      => 'Excluir',
                    'description' => 'Descrição',
                    'edit'        => 'Editar',
                    'id'          => 'ID',
                    'name'        => 'Nome',
                ],

                'edit' => [
                    'title' => 'Editar Grupo',
                ],

                'create' => [
                    'name'        => 'Nome',
                    'title'       => 'Criar Grupo',
                    'description' => 'Descrição',
                    'save-btn'    => 'Salvar Grupo',
                ],
            ],
        ],

        'roles' => [
            'index' => [
                'being-used'                => 'A função não pode ser excluída, pois está sendo usada em um usuário administrador.',
                'create-btn'                => 'Criar Funções',
                'create-success'            => 'Função criada com sucesso.',
                'current-role-delete-error' => 'Não é possível excluir a função atribuída ao usuário atual.',
                'delete-failed'             => 'A função não pode ser excluída.',
                'delete-success'            => 'Função excluída com sucesso.',
                'last-delete-error'         => 'Pelo menos uma função é necessária.',
                'settings'                  => 'Configurações',
                'title'                     => 'Funções',
                'update-success'            => 'Função atualizada com sucesso.',
                'user-define-error'         => 'Não é possível excluir a função do sistema.',

                'datagrid' => [
                    'all'             => 'Tudo',
                    'custom'          => 'Personalizado',
                    'delete'          => 'Excluir',
                    'description'     => 'Descrição',
                    'edit'            => 'Editar',
                    'id'              => 'ID',
                    'name'            => 'Nome',
                    'permission-type' => 'Tipo de Permissão',
                ],
            ],

            'create' => [
                'access-control' => 'Controle de Acesso',
                'all'            => 'Tudo',
                'back-btn'       => 'Voltar',
                'custom'         => 'Personalizado',
                'description'    => 'Descrição',
                'general'        => 'Geral',
                'name'           => 'Nome',
                'permissions'    => 'Permissões',
                'save-btn'       => 'Salvar Função',
                'title'          => 'Criar Função',
            ],

            'edit' => [
                'access-control' => 'Controle de Acesso',
                'all'            => 'Tudo',
                'back-btn'       => 'Voltar',
                'custom'         => 'Personalizado',
                'description'    => 'Descrição',
                'general'        => 'Geral',
                'name'           => 'Nome',
                'permissions'    => 'Permissões',
                'save-btn'       => 'Salvar Função',
                'title'          => 'Editar Função',
            ],
        ],


        'types' => [
            'index' => [
                'create-btn'     => 'Criar Tipo',
                'create-success' => 'Tipo criado com sucesso.',
                'delete-failed'  => 'O tipo não pode ser excluído.',
                'delete-success' => 'Tipo excluído com sucesso.',
                'title'          => 'Tipos',
                'update-success' => 'Tipo atualizado com sucesso.',

                'datagrid' => [
                    'delete'      => 'Excluir',
                    'description' => 'Descrição',
                    'edit'        => 'Editar',
                    'id'          => 'ID',
                    'name'        => 'Nome',
                ],

                'create' => [
                    'name'     => 'Nome',
                    'save-btn' => 'Salvar Tipo',
                    'title'    => 'Criar Tipo',
                ],

                'edit' => [
                    'title' => 'Editar Tipo',
                ],
            ],
        ],

        'sources' => [
            'index' => [
                'create-btn'     => 'Criar Fonte',
                'create-success' => 'Fonte criada com sucesso.',
                'delete-failed'  => 'A fonte não pode ser excluída.',
                'delete-success' => 'Fonte excluída com sucesso.',
                'title'          => 'Fontes',
                'update-success' => 'Fonte atualizada com sucesso.',

                'datagrid' => [
                    'delete' => 'Excluir',
                    'edit'   => 'Editar',
                    'id'     => 'ID',
                    'name'   => 'Nome',
                ],

                'create' => [
                    'name'     => 'Nome',
                    'save-btn' => 'Salvar Tipo',
                    'title'    => 'Criar Fonte',
                ],

                'edit' => [
                    'title' => 'Editar Fonte',
                ],
            ],
        ],

        'workflows' => [
            'index' => [
                'title'          => 'Fluxos de Trabalho',
                'create-btn'     => 'Criar Fluxo de Trabalho',
                'create-success' => 'Fluxo de trabalho criado com sucesso.',
                'update-success' => 'Fluxo de trabalho atualizado com sucesso.',
                'delete-success' => 'Fluxo de trabalho excluído com sucesso.',
                'delete-failed'  => 'O fluxo de trabalho não pode ser excluído.',
                'datagrid'       => [
                    'delete'      => 'Excluir',
                    'description' => 'Descrição',
                    'edit'        => 'Editar',
                    'id'          => 'ID',
                    'name'        => 'Nome',
                ],
            ],

            'helpers' => [
                'update-related-leads'       => 'Atualizar ordens relacionados',
                'send-email-to-sales-owner'  => 'Enviar e-mail ao responsável por vendas',
                'send-email-to-participants' => 'Enviar e-mail aos participantes',
                'add-webhook'                => 'Adicionar Webhook',
                'update-lead'                => 'Atualizar Orden',
                'update-person'              => 'Atualizar Pessoa',
                'send-email-to-person'       => 'Enviar e-mail para a pessoa',
                'add-tag'                    => 'Adicionar Tag',
                'add-note-as-activity'       => 'Adicionar Nota como Atividade',
            ],

            'create' => [
                'title'                  => 'Criar Fluxo de Trabalho',
                'event'                  => 'Evento',
                'back-btn'               => 'Voltar',
                'save-btn'               => 'Salvar Fluxo de Trabalho',
                'name'                   => 'Nome',
                'basic-details'          => 'Detalhes Básicos',
                'description'            => 'Descrição',
                'actions'                => 'Ações',
                'basic-details-info'     => 'Coloque as informações básicas do fluxo de trabalho.',
                'event-info'             => 'Um evento dispara verificações e condições, e realiza ações predefinidas.',
                'conditions'             => 'Condições',
                'conditions-info'        => 'Condições são regras que verificam cenários e são acionadas em ocasiões específicas.',
                'actions-info'           => 'Uma ação não só reduz a carga de trabalho, como também facilita bastante a automação do CRM.',
                'value'                  => 'Valor',
                'condition-type'         => 'Tipo de Condição',
                'all-condition-are-true' => 'Todas as condições são verdadeiras',
                'any-condition-are-true' => 'Qualquer condição é verdadeira',
                'add-condition'          => 'Adicionar Condição',
                'add-action'             => 'Adicionar Ação',
                'yes'                    => 'Sim',
                'no'                     => 'Não',
                'email'                  => 'E-mail',
                'is-equal-to'            => 'É igual a',
                'is-not-equal-to'        => 'Não é igual a',
                'equals-or-greater-than' => 'Igual ou maior que',
                'equals-or-less-than'    => 'Igual ou menor que',
                'greater-than'           => 'Maior que',
                'less-than'              => 'Menor que',
                'type'                   => 'Tipo',
                'contain'                => 'Contém',
                'contains'               => 'Contém',
                'does-not-contain'       => 'Não contém',
            ],

            'edit' => [
                'title'                  => 'Editar Fluxo de Trabalho',
                'event'                  => 'Evento',
                'back-btn'               => 'Voltar',
                'save-btn'               => 'Salvar Fluxo de Trabalho',
                'name'                   => 'Nome',
                'basic-details'          => 'Detalhes Básicos',
                'description'            => 'Descrição',
                'actions'                => 'Ações',
                'type'                   => 'Tipo',
                'basic-details-info'     => 'Coloque as informações básicas do fluxo de trabalho.',
                'event-info'             => 'Um evento dispara verificações e condições, e realiza ações predefinidas.',
                'conditions'             => 'Condições',
                'conditions-info'        => 'Condições são regras que verificam cenários e são acionadas em ocasiões específicas.',
                'actions-info'           => 'Uma ação não só reduz a carga de trabalho, como também facilita bastante a automação do CRM.',
                'value'                  => 'Valor',
                'condition-type'         => 'Tipo de Condição',
                'all-condition-are-true' => 'Todas as condições são verdadeiras',
                'any-condition-are-true' => 'Qualquer condição é verdadeira',
                'add-condition'          => 'Adicionar Condição',
                'add-action'             => 'Adicionar Ação',
                'yes'                    => 'Sim',
                'no'                     => 'Não',
                'email'                  => 'E-mail',
                'is-equal-to'            => 'É igual a',
                'is-not-equal-to'        => 'Não é igual a',
                'equals-or-greater-than' => 'Igual ou maior que',
                'equals-or-less-than'    => 'Igual ou menor que',
                'greater-than'           => 'Maior que',
                'less-than'              => 'Menor que',
                'contain'                => 'Contém',
                'contains'               => 'Contém',
                'does-not-contain'       => 'Não contém',
            ],
        ],

        'webforms' => [
            'index' => [
                'title'          => 'Formulários da Web',
                'create-btn'     => 'Criar Formulário da Web',
                'create-success' => 'Formulário da Web criado com sucesso.',
                'update-success' => 'Formulário da Web atualizado com sucesso.',
                'delete-success' => 'Formulário da Web excluído com sucesso.',
                'delete-failed'  => 'O Formulário da Web não pode ser excluído.',

                'datagrid' => [
                    'id'     => 'ID',
                    'title'  => 'Título',
                    'edit'   => 'Editar',
                    'delete' => 'Excluir',
                ],
            ],

            'create' => [
                'add-attribute-btn'        => 'Adicionar Atributo',
                'attribute-label-color'    => 'Cor do Rótulo do Atributo',
                'attributes'               => 'Atributos',
                'attributes-info'          => 'Adicione atributos personalizados ao formulário.',
                'background-color'         => 'Cor de Fundo',
                'create-lead'              => 'Criar Ordem',
                'customize-webform'        => 'Personalizar Formulário da Web',
                'customize-webform-info'   => 'Personalize seu formulário web com cores dos elementos à sua escolha.',
                'description'              => 'Descrição',
                'display-custom-message'   => 'Exibir mensagem personalizada',
                'form-background-color'    => 'Cor de Fundo do Formulário',
                'form-submit-btn-color'    => 'Cor do Botão de Enviar Formulário',
                'form-submit-button-color' => 'Cor do Botão de Enviar Formulário',
                'form-title-color'         => 'Cor do Título do Formulário',
                'general'                  => 'Geral',
                'leads'                    => 'Ordem',
                'person'                   => 'Pessoa',
                'save-btn'                 => 'Salvar Formulário da Web',
                'submit-button-label'      => 'Rótulo do Botão de Enviar',
                'submit-success-action'    => 'Ação após Sucesso no Envio',
                'title'                    => 'Criar Formulário da Web',
            ],

            'edit' => [
                'add-attribute-btn'         => 'Adicionar Atributo',
                'attribute-label-color'     => 'Cor do Rótulo do Atributo',
                'attributes'                => 'Atributos',
                'attributes-info'           => 'Adicione atributos personalizados ao formulário.',
                'background-color'          => 'Cor de Fundo',
                'code-snippet'              => 'Trecho de Código',
                'copied'                    => 'Copiado',
                'copy'                      => 'Copiar',
                'create-lead'               => 'Criar Ordem',
                'customize-webform'         => 'Personalizar Formulário da Web',
                'customize-webform-info'    => 'Personalize seu formulário web com cores dos elementos à sua escolha.',
                'description'               => 'Descrição',
                'display-custom-message'    => 'Exibir mensagem personalizada',
                'embed'                     => 'Incorporar',
                'form-background-color'     => 'Cor de Fundo do Formulário',
                'form-submit-btn-color'     => 'Cor do Botão de Enviar Formulário',
                'form-submit-button-color'  => 'Cor do Botão de Enviar Formulário',
                'form-title-color'          => 'Cor do Título do Formulário',
                'general'                   => 'Geral',
                'preview'                   => 'Pré-visualização',
                'person'                    => 'Pessoa',
                'public-url'                => 'URL Pública',
                'redirect-to-url'           => 'Redirecionar para URL',
                'save-btn'                  => 'Salvar Formulário da Web',
                'submit-button-label'       => 'Rótulo do Botão de Enviar',
                'submit-success-action'     => 'Ação após Sucesso no Envio',
                'title'                     => 'Editar Formulário da Web',
            ],
        ],


        'email-template' => [
            'index' => [
                'create-btn'     => 'Criar Modelo de Email',
                'title'          => 'Modelos de Email',
                'create-success' => 'Modelo de email criado com sucesso.',
                'update-success' => 'Modelo de email atualizado com sucesso.',
                'delete-success' => 'Modelo de email excluído com sucesso.',
                'delete-failed'  => 'O modelo de email não pode ser excluído.',

                'datagrid' => [
                    'delete'  => 'Excluir',
                    'edit'    => 'Editar',
                    'id'      => 'ID',
                    'name'    => 'Nome',
                    'subject' => 'Assunto',
                ],
            ],

            'create' => [
                'title'                => 'Criar Modelo de Email',
                'save-btn'             => 'Salvar Modelo de Email',
                'email-template'       => 'Modelo de Email',
                'subject'              => 'Assunto',
                'content'              => 'Conteúdo',
                'subject-placeholders' => 'Marcadores de Assunto',
                'general'              => 'Geral',
                'name'                 => 'Nome',
            ],

            'edit' => [
                'title'                => 'Editar Modelo de Email',
                'save-btn'             => 'Salvar Modelo de Email',
                'email-template'       => 'Modelo de Email',
                'subject'              => 'Assunto',
                'content'              => 'Conteúdo',
                'subject-placeholders' => 'Marcadores de Assunto',
                'general'              => 'Geral',
                'name'                 => 'Nome',
            ],
        ],

        'tags' => [
            'index' => [
                'create-btn'     => 'Criar Tag',
                'title'          => 'Tags',
                'create-success' => 'Tag criada com sucesso.',
                'update-success' => 'Tag atualizada com sucesso.',
                'delete-success' => 'Tag excluída com sucesso.',
                'delete-failed'  => 'A Tag não pode ser excluída.',

                'datagrid' => [
                    'delete'      => 'Excluir',
                    'edit'        => 'Editar',
                    'id'          => 'ID',
                    'name'        => 'Nome',
                    'users'       => 'Usuários',
                    'created-at'  => 'Criado Em',
                ],

                'create' => [
                    'name'     => 'Nome',
                    'save-btn' => 'Salvar Tag',
                    'title'    => 'Criar Tag',
                    'color'    => 'Cor',
                ],

                'edit' => [
                    'title' => 'Editar Tag',
                ],
            ],
        ],

        'users' => [
            'index' => [
                'create-btn'          => 'Criar Usuário',
                'create-success'      => 'Usuário criado com sucesso.',
                'delete-failed'       => 'O usuário não pode ser excluído.',
                'delete-success'      => 'Usuário excluído com sucesso.',
                'last-delete-error'   => 'Pelo menos um usuário é necessário.',
                'mass-delete-failed'  => 'Usuários não podem ser excluídos.',
                'mass-delete-success' => 'Usuários excluídos com sucesso.',
                'mass-update-failed'  => 'Usuários não podem ser atualizados.',
                'mass-update-success' => 'Usuários atualizados com sucesso.',
                'title'               => 'Usuários',
                'update-success'      => 'Usuário atualizado com sucesso.',
                'user-define-error'   => 'Não é possível excluir o usuário do sistema.',
                'active'              => 'Ativo',
                'inactive'            => 'Inativo',

                'datagrid' => [
                    'active'        => 'Ativo',
                    'created-at'    => 'Criado Em',
                    'delete'        => 'Excluir',
                    'edit'          => 'Editar',
                    'email'         => 'Email',
                    'id'            => 'ID',
                    'inactive'      => 'Inativo',
                    'name'          => 'Nome',
                    'status'        => 'Status',
                    'update-status' => 'Atualizar Status',
                    'users'         => 'Usuários',
                ],

                'create' => [
                    'confirm-password' => 'Confirmar Senha',
                    'email'            => 'Email',
                    'general'          => 'Geral',
                    'global'           => 'Global',
                    'group'            => 'Grupo',
                    'individual'       => 'Individual',
                    'name'             => 'Nome',
                    'password'         => 'Senha',
                    'permission'       => 'Permissão',
                    'role'             => 'Função',
                    'save-btn'         => 'Salvar Usuário',
                    'status'           => 'Status',
                    'title'            => 'Criar Usuário',
                    'view-permission'  => 'Permissão de Visualização',
                ],

                'edit' => [
                    'title' => 'Editar Usuário',
                ],
            ],
        ],

        'pipelines' => [
            'index' => [
                'title'                => 'Pipelines',
                'create-btn'           => 'Criar Pipeline',
                'create-success'       => 'Pipeline criado com sucesso.',
                'update-success'       => 'Pipeline atualizado com sucesso.',
                'delete-success'       => 'Pipeline excluído com sucesso.',
                'delete-failed'        => 'O Pipeline não pode ser excluído.',
                'default-delete-error' => 'O pipeline padrão não pode ser excluído.',

                'datagrid' => [
                    'delete'      => 'Excluir',
                    'edit'        => 'Editar',
                    'id'          => 'ID',
                    'is-default'  => 'É Padrão',
                    'name'        => 'Nome',
                    'no'          => 'Não',
                    'rotten-days' => 'Dias Apodrecido',
                    'yes'         => 'Sim',
                ],
            ],

            'create' => [
                'title'                => 'Criar Pipeline',
                'save-btn'             => 'Salvar Pipeline',
                'name'                 => 'Nome',
                'rotten-days'          => 'Dias Apodrecido',
                'mark-as-default'      => 'Marcar como Padrão',
                'general'              => 'Geral',
                'probability'          => 'Probabilidade(%)',
                'new-stage'            => 'Novo',
                'won-stage'            => 'Ganho',
                'lost-stage'           => 'Perdido',
                'stage-btn'            => 'Adicionar Estágio',
                'stages'               => 'Estágios',
                'duplicate-name'       => 'O campo "Nome" não pode ser duplicado',
                'delete-stage'         => 'Excluir Estágio',
                'add-new-stages'       => 'Adicionar Novos Estágios',
                'add-stage-info'       => 'Adicionar novo estágio para seu Pipeline',
                'newly-added'          => 'Adicionado Recentemente',
                'stage-delete-success' => 'Estágio excluído com sucesso.',
            ],

            'edit' => [
                'title'                => 'Editar Pipeline',
                'save-btn'             => 'Salvar Pipeline',
                'name'                 => 'Nome',
                'rotten-days'          => 'Dias Apodrecido',
                'mark-as-default'      => 'Marcar como Padrão',
                'general'              => 'Geral',
                'probability'          => 'Probabilidade(%)',
                'new-stage'            => 'Novo',
                'won-stage'            => 'Ganho',
                'lost-stage'           => 'Perdido',
                'stage-btn'            => 'Adicionar Estágio',
                'stages'               => 'Estágios',
                'duplicate-name'       => 'O campo "Nome" não pode ser duplicado',
                'delete-stage'         => 'Excluir Estágio',
                'add-new-stages'       => 'Adicionar Novos Estágios',
                'add-stage-info'       => 'Adicionar novo estágio para seu Pipeline',
                'stage-delete-success' => 'Estágio excluído com sucesso.',
            ],
        ],


        'webhooks' => [
            'index' => [
                'title'          => 'Webhooks',
                'create-btn'     => 'Criar Webhook',
                'create-success' => 'Webhook criado com sucesso.',
                'update-success' => 'Webhook atualizado com sucesso.',
                'delete-success' => 'Webhook excluído com sucesso.',
                'delete-failed'  => 'O Webhook não pode ser excluído.',

                'datagrid' => [
                    'id'          => 'ID',
                    'delete'      => 'Excluir',
                    'edit'        => 'Editar',
                    'name'        => 'Nome',
                    'entity-type' => 'Tipo de Entidade',
                    'end-point'   => 'End Point',
                ],
            ],

            'create' => [
                'title'                 => 'Criar Webhook',
                'save-btn'              => 'Salvar Webhook',
                'info'                  => 'Insira os detalhes do webhook',
                'url-and-parameters'    => 'URL e Parâmetros',
                'method'                => 'Método',
                'post'                  => 'Post',
                'put'                   => 'Put',
                'url-endpoint'          => 'Url Endpoint',
                'parameters'            => 'Parâmetros',
                'add-new-parameter'     => 'Adicionar Novo Parâmetro',
                'url-preview'           => 'Pré-visualização da URL:',
                'headers'               => 'Cabeçalhos',
                'add-new-header'        => 'Adicionar Novo Cabeçalho',
                'body'                  => 'Corpo',
                'default'               => 'Padrão',
                'x-www-form-urlencoded' => 'x-www-form-urlencoded',
                'raw'                   => 'Raw',
                'general'               => 'Geral',
                'name'                  => 'Nome',
                'entity-type'           => 'Tipo de Entidade',
                'insert-placeholder'    => 'Inserir Placeholder',
                'description'           => 'Descrição',
                'json'                  => 'Json',
                'text'                  => 'Texto',
            ],

            'edit' => [
                'title'                 => 'Editar Webhook',
                'edit-btn'              => 'Salvar Webhook',
                'save-btn'              => 'Salvar Webhook',
                'info'                  => 'Insira os detalhes do webhook',
                'url-and-parameters'    => 'URL e Parâmetros',
                'method'                => 'Método',
                'post'                  => 'Post',
                'put'                   => 'Put',
                'url-endpoint'          => 'Url Endpoint',
                'parameters'            => 'Parâmetros',
                'add-new-parameter'     => 'Adicionar Novo Parâmetro',
                'url-preview'           => 'Pré-visualização da URL:',
                'headers'               => 'Cabeçalhos',
                'add-new-header'        => 'Adicionar Novo Cabeçalho',
                'body'                  => 'Corpo',
                'default'               => 'Padrão',
                'x-www-form-urlencoded' => 'x-www-form-urlencoded',
                'raw'                   => 'Raw',
                'general'               => 'Geral',
                'name'                  => 'Nome',
                'entity-type'           => 'Tipo de Entidade',
                'insert-placeholder'    => 'Inserir Placeholder',
                'description'           => 'Descrição',
                'json'                  => 'Json',
                'text'                  => 'Texto',
            ],
        ],

        'warehouses' => [
            'index' => [
                'title'          => 'Armazéns',
                'create-btn'     => 'Criar Armazém',
                'create-success' => 'Armazém criado com sucesso.',
                'name-exists'    => 'O nome do armazém já existe.',
                'update-success' => 'Armazém atualizado com sucesso.',
                'delete-success' => 'Armazém excluído com sucesso.',
                'delete-failed'  => 'O Armazém não pode ser excluído.',

                'datagrid' => [
                    'id'              => 'ID',
                    'name'            => 'Nome',
                    'contact-name'    => 'Nome do Contato',
                    'delete'          => 'Excluir',
                    'edit'            => 'Editar',
                    'view'            => 'Visualizar',
                    'created-at'      => 'Criado em',
                    'products'        => 'Produtos',
                    'contact-emails'  => 'Emails de Contato',
                    'contact-numbers' => 'Números de Contato',
                ],
            ],

            'create' => [
                'title'         => 'Criar Armazém',
                'save-btn'      => 'Salvar Armazém',
                'contact-info'  => 'Informações de Contato',
            ],

            'edit' => [
                'title'         => 'Editar Armazém',
                'save-btn'      => 'Salvar Armazém',
                'contact-info'  => 'Informações de Contato',
            ],

            'view' => [
                'all'         => 'Tudo',
                'notes'       => 'Notas',
                'files'       => 'Arquivos',
                'location'    => 'Localização',
                'change-logs' => 'Logs de Alterações',

                'locations' => [
                    'action'         => 'Ação',
                    'add-location'   => 'Adicionar Localização',
                    'create-success' => 'Localização criada com sucesso.',
                    'delete'         => 'Excluir',
                    'delete-failed'  => 'A Localização não pode ser excluída.',
                    'delete-success' => 'Localização excluída com sucesso.',
                    'name'           => 'Nome',
                    'save-btn'       => 'Salvar',
                ],

                'general-information' => [
                    'title' => 'Informações Gerais',
                ],

                'contact-information' => [
                    'title' => 'Informações de Contato',
                ],
            ],
        ],

        'attributes' => [
            'index' => [
                'title'              => 'Atributos',
                'create-btn'         => 'Criar Atributo',
                'create-success'     => 'Atributo criado com sucesso.',
                'update-success'     => 'Atributo atualizado com sucesso.',
                'delete-success'     => 'Atributo excluído com sucesso.',
                'delete-failed'      => 'O Atributo não pode ser excluído.',
                'user-define-error'  => 'Não é possível excluir o atributo do sistema.',
                'mass-delete-failed' => 'Os atributos do sistema não podem ser excluídos.',

                'datagrid' => [
                    'yes'         => 'Sim',
                    'no'          => 'Não',
                    'id'          => 'ID',
                    'code'        => 'Código',
                    'name'        => 'Nome',
                    'entity-type' => 'Tipo de Entidade',
                    'type'        => 'Tipo',
                    'is-default'  => 'É Padrão',
                    'edit'        => 'Editar',
                    'delete'      => 'Excluir',
                ],
            ],

            'create' => [
                'title'                 => 'Criar Atributo',
                'save-btn'              => 'Salvar Atributo',
                'code'                  => 'Código',
                'name'                  => 'Nome',
                'entity-type'           => 'Tipo de Entidade',
                'type'                  => 'Tipo',
                'validations'           => 'Validações',
                'is-required'           => 'É Obrigatório',
                'input-validation'      => 'Validação de Entrada',
                'is-unique'             => 'É Único',
                'labels'                => 'Rótulos',
                'general'               => 'Geral',
                'numeric'               => 'Numérico',
                'decimal'               => 'Decimal',
                'url'                   => 'Url',
                'options'               => 'Opções',
                'option-type'           => 'Tipo de Opção',
                'lookup-type'           => 'Tipo de Pesquisa',
                'add-option'            => 'Adicionar Opção',
                'save-option'           => 'Salvar Opção',
                'option-name'           => 'Nome da Opção',
                'add-attribute-options' => 'Adicionar Opções de Atributo',
                'text'                  => 'Texto',
                'textarea'              => 'Área de Texto',
                'price'                 => 'Preço',
                'boolean'               => 'Booleano',
                'select'                => 'Selecionar',
                'multiselect'           => 'Multiseleção',
                'email'                 => 'Email',
                'address'               => 'Endereço',
                'phone'                 => 'Telefone',
                'datetime'              => 'Data e Hora',
                'date'                  => 'Data',
                'image'                 => 'Imagem',
                'file'                  => 'Arquivo',
                'lookup'                => 'Pesquisa',
                'entity_type'           => 'Tipo de Entidade',
                'checkbox'              => 'Caixa de Seleção',
                'is_required'           => 'É Obrigatório',
                'is_unique'             => 'É Único',
            ],

            'edit' => [
                'title'                 => 'Editar Atributo',
                'save-btn'              => 'Salvar Atributo',
                'code'                  => 'Código',
                'name'                  => 'Nome',
                'labels'                => 'Rótulos',
                'entity-type'           => 'Tipo de Entidade',
                'type'                  => 'Tipo',
                'validations'           => 'Validações',
                'is-required'           => 'É Obrigatório',
                'input-validation'      => 'Validação de Entrada',
                'is-unique'             => 'É Único',
                'general'               => 'Geral',
                'numeric'               => 'Numérico',
                'decimal'               => 'Decimal',
                'url'                   => 'Url',
                'options'               => 'Opções',
                'option-type'           => 'Tipo de Opção',
                'lookup-type'           => 'Tipo de Pesquisa',
                'add-option'            => 'Adicionar Opção',
                'save-option'           => 'Salvar Opção',
                'option-name'           => 'Nome da Opção',
                'add-attribute-options' => 'Adicionar Opções de Atributo',
                'text'                  => 'Texto',
                'textarea'              => 'Área de Texto',
                'price'                 => 'Preço',
                'boolean'               => 'Booleano',
                'select'                => 'Selecionar',
                'multiselect'           => 'Multiseleção',
                'email'                 => 'Email',
                'address'               => 'Endereço',
                'phone'                 => 'Telefone',
                'datetime'              => 'Data e Hora',
                'date'                  => 'Data',
                'image'                 => 'Imagem',
                'file'                  => 'Arquivo',
                'lookup'                => 'Pesquisa',
                'entity_type'           => 'Tipo de Entidade',
                'checkbox'              => 'Caixa de Seleção',
                'is_required'           => 'É Obrigatório',
                'is_unique'             => 'É Único',
            ],
        ],
    ],



    'activities' => [
        'index' => [
            'title' => 'Atividades',

            'datagrid' => [
                'comment'       => 'Comentário',
                'created_at'    => 'Criado Em',
                'created_by'    => 'Criado Por',
                'edit'          => 'Editar',
                'id'            => 'ID',
                'done'          => 'Concluído',
                'not-done'      => 'Não Concluído',
                'lead'          => 'Ordem',
                'mass-delete'   => 'Excluir em Massa',
                'mass-update'   => 'Atualizar em Massa',
                'schedule-from' => 'Agendado de',
                'schedule-to'   => 'Agendado para',
                'title'         => 'Título',
                'is_done'       => 'Está Concluído',
                'type'          => 'Tipo',
                'update'        => 'Atualizar',
                'call'          => 'Chamada',
                'meeting'       => 'Reunião',
                'lunch'         => 'Almoço',
            ],
        ],

        'edit' => [
            'title'           => 'Editar Atividade',
            'back-btn'        => 'Voltar',
            'save-btn'        => 'Salvar Atividade',
            'type'            => 'Tipo de Atividade',
            'call'            => 'Chamada',
            'meeting'         => 'Reunião',
            'lunch'           => 'Almoço',
            'schedule_to'     => 'Agendado para',
            'schedule_from'   => 'Agendado de',
            'location'        => 'Localização',
            'comment'         => 'Comentário',
            'lead'            => 'Ordem',
            'participants'    => 'Participantes',
            'general'         => 'Geral',
            'persons'         => 'Pessoas',
            'no-result-found' => 'Nenhum registro encontrado.',
            'users'           => 'Usuários',
        ],

        'updated'              => 'Atualizado :attribute',
        'created'              => 'Criado',
        'duration-overlapping' => 'Os participantes têm outra reunião nesse horário. Deseja continuar?',
        'create-success'       => 'Atividade criada com sucesso.',
        'update-success'       => 'Atividade atualizada com sucesso.',
        'overlapping-error'    => 'Os participantes têm outra reunião nesse horário.',
        'mass-update-success'  => 'Atividades atualizadas com sucesso.',
        'destroy-success'      => 'Atividade excluída com sucesso.',
        'delete-failed'        => 'A atividade não pode ser excluída.',
    ],

    'mail' => [
        'index' => [
            'compose'           => 'Compor',
            'draft'             => 'Rascunho',
            'inbox'             => 'Caixa de Entrada',
            'outbox'            => 'Caixa de Saída',
            'sent'              => 'Enviado',
            'trash'             => 'Lixeira',
            'compose-mail-btn'  => 'Enviar Email',
            'btn'               => 'Email',
            'mail'              => [
                'title'         => 'Enviar Email',
                'to'            => 'Para',
                'enter-emails'  => 'Pressione enter para adicionar emails',
                'cc'            => 'CC',
                'bcc'           => 'BCC',
                'subject'       => 'Assunto',
                'send-btn'      => 'Enviar',
                'message'       => 'Mensagem',
                'draft'         => 'Rascunho',
            ],

            'datagrid' => [
                'id'            => 'ID',
                'from'          => 'De',
                'to'            => 'Para',
                'subject'       => 'Assunto',
                'tag-name'      => 'Nome da Tag',
                'created-at'    => 'Criado Em',
                'move-to-inbox' => 'Movido para Caixa de Entrada',
                'edit'          => 'Editar',
                'view'          => 'Visualizar',
                'delete'        => 'Excluir',
            ],
        ],

        'create-success'      => 'Email enviado com sucesso.',
        'update-success'      => 'Email atualizado com sucesso.',
        'mass-update-success' => 'Emails atualizados com sucesso.',
        'delete-success'      => 'Email excluído com sucesso.',
        'delete-failed'       => 'O email não pode ser excluído.',

        'view' => [
            'title'                      => 'Emails',
            'subject'                    => ':subject',
            'link-mail'                  => 'Vincular Email',
            'to'                         => 'Para',
            'cc'                         => 'CC',
            'bcc'                        => 'BCC',
            'reply'                      => 'Responder',
            'reply-all'                  => 'Responder a Todos',
            'forward'                    => 'Encaminhar',
            'delete'                     => 'Excluir',
            'enter-mails'                => 'Insira o email',
            'rotten-days'                => 'Ordem apodrecido há :days dias',
            'search-an-existing-lead'    => 'Pesquisar um ordem existente',
            'search-an-existing-contact' => 'Pesquisar um contato existente',
            'message'                    => 'Mensagem',
            'add-attachments'            => 'Adicionar Anexos',
            'discard'                    => 'Descartar',
            'send'                       => 'Enviar',
            'no-result-found'            => 'Nenhum resultado encontrado',
            'add-new-contact'            => 'Adicionar Novo Contato',
            'description'                => 'Descrição',
            'search'                     => 'Pesquisar...',
            'add-new-lead'               => 'Adicionar Novo Ordem',
            'create-new-contact'         => 'Criar Novo Contato',
            'save-contact'               => 'Salvar Contato',
            'create-lead'                => 'Criar Ordem',
            'linked-contact'             => 'Contato Vinculado',
            'link-to-contact'            => 'Vincular ao Contato',
            'link-to-lead'               => 'Vincular a Ordem',
            'linked-lead'                => 'Ordem Vinculado',
            'lead-details'               => 'Detalhes da Ordem',
            'contact-person'             => 'Pessoa de Contato',
            'product'                    => 'Produto',

            'tags' => [
                'create-success'  => 'Tag criada com sucesso.',
                'destroy-success' => 'Tag excluída com sucesso.',
            ],
        ],
    ],

    'common' => [
        'custom-attributes' => [
            'select-country' => 'Selecionar País',
            'select-state'   => 'Selecionar Estado',
            'state'          => 'Estado',
            'city'           => 'Cidade',
            'postcode'       => 'Código Postal',
            'work'           => 'Trabalho',
            'home'           => 'Casa',
            'add-more'       => 'Adicionar Mais',
            'select'         => 'Selecionar',
            'country'        => 'País',
            'address'        => 'Endereço',
        ],
    ],


    'expenses' => [
        'index' => [
            'title'       => 'Despesas',
            'create-btn'  => 'Criar Nova Despesa',
            'datagrid'    => [
                'id'          => 'ID',
                'type'        => 'Tipo',
                'description' => 'Descrição',
                'date'        => 'Data',
                'value'       => 'Valor',
                'sales-person'=> 'Responsável',
                'created-at'  => 'Criado em',
                'edit'        => 'Editar',
                'delete'      => 'Excluir',
                'mass-delete' => 'Excluir em Massa',
                'grand-total' => 'Total Geral',
            ],
            'create-success' => 'Despesa criada com sucesso.',
            'update-success' => 'Despesa atualizada com sucesso.',
            'delete-success' => 'Despesa excluída com sucesso.',
            'delete-failed'  => 'Despesas excluídas com sucesso.',
        ],

        'create' => [
            'title'        => 'Criar Nova Despesa',
            'save-btn'     => 'Salvar Despesa',
            'general-info' => 'Informações Gerais',
            'type'         => 'Tipo de Despesa',
            'description'  => 'Descrição',
            'date'         => 'Data da Despesa',
            'value'        => 'Valor',
            'observation'  => 'Observações',
            'user'         => 'Responsável',
            'cancel'       => 'Cancelar',
        ],

        'edit' => [
            'title'          => 'Editar Despesa',
            'save-btn'       => 'Salvar',
            'details'        => 'Detalhes da Despesa',
            'details-info'   => 'Insira as informações básicas da despesa',
            'type'           => 'Tipo de Despesa',
            'user'           => 'Responsável',
            'value'          => 'Valor da Despesa',
            'date'           => 'Data da Despesa',
            'description'    => 'Descrição da Despesa',
            'observation'    => 'Observação (Opcional)',
        ],
    ],
    
    'leads' => [
        'create-success'    => 'Ordem criado com sucesso.',
        'update-success'    => 'Ordem atualizado com sucesso.',
        'destroy-success'   => 'Ordem excluído com sucesso.',
        'destroy-failed'    => 'O Ordem não pode ser excluído.',

        'index' => [
            'title'      => 'Ordens',
            'create-btn' => 'Criar Ordem',

            'datagrid' => [
                'id'                  => 'ID',
                'sales-person'        => 'Vendedor',
                'subject'             => 'Assunto',
                'source'              => 'Fonte',
                'lead-value'          => 'Valor do Ordem',
                'lead-type'           => 'Tipo de Ordem',
                'tag-name'            => 'Nome da Tag',
                'contact-person'      => 'Pessoa de Contato',
                'stage'               => 'Estágio',
                'rotten-lead'         => 'Ordem Apodrecido',
                'expected-close-date' => 'Data Prevista para Fechamento',
                'created-at'          => 'Criado Em',
                'no'                  => 'Não',
                'yes'                 => 'Sim',
                'delete'              => 'Excluir',
                'mass-delete'         => 'Excluir em Massa',
                'mass-update'         => 'Atualizar em Massa',
            ],

            'kanban' => [
                'rotten-days'            => 'Ordem apodrecido há :days dias',
                'empty-list'             => 'Sua lista de Ordens está vazia',
                'empty-list-description' => 'Crie um ordem para organizar seus objetivos.',
                'create-lead-btn'        => 'Criar Ordem',
                'track-shipment'         => 'Rastrear Envio',
                'columns' => [
                    'contact-person'      => 'Pessoa de Contato',
                    'id'                  => 'ID',
                    'lead-type'           => 'Tipo de ordem',
                    'lead-value'          => 'Valor do ordem',
                    'sales-person'        => 'Vendedor',
                    'source'              => 'Fonte',
                    'title'               => 'Título',
                    'tags'                => 'Tags',
                    'expected-close-date' => 'Data Prevista para Fechamento',
                    'created-at'          => 'Criado Em',
                ],

                'toolbar' => [
                    'search' => [
                        'title' => 'Pesquisar',
                    ],

                    'filters' => [
                        'apply-filters' => 'Aplicar Filtros',
                        'clear-all'     => 'Limpar Tudo',
                        'filter'        => 'Filtrar',
                        'filters'       => 'Filtros',
                        'select'        => 'Selecionar',
                    ],
                ],
            ],

            'view-switcher' => [
                'all-pipelines'       => 'Todos os Pipelines',
                'create-new-pipeline' => 'Criar Novo Pipeline',
            ],
        ],

        'create' => [
            'title'          => 'Criar Ordem',
            'save-btn'       => 'Salvar',
            'details'        => 'Detalhes',
            'details-info'   => 'Insira as informações básicas da ordem',
            'contact-person' => 'Pessoa de Contato',
            'contact-info'   => 'Informações sobre a Pessoa de Contato',
            'products'       => 'Produtos',
            'products-info'  => 'Informações sobre os Produtos',
        ],

        'edit' => [
            'title'          => 'Editar Ordem',
            'save-btn'       => 'Salvar',
            'details'        => 'Detalhes',
            'details-info'   => 'Insira as informações básicas do Ordem',
            'contact-person' => 'Pessoa de Contato',
            'contact-info'   => 'Informações sobre a Pessoa de Contato',
            'products'       => 'Produtos',
            'products-info'  => 'Informações sobre os Produtos',
        ],

        'common' => [
            'contact' => [
                'name'           => 'Nome',
                'email'          => 'Email',
                'contact-number' => 'Número de Contato',
                'organization'   => 'Organização',
            ],

            'products' => [
                'product-name' => 'Nome do Produto',
                'quantity'     => 'Quantidade',
                'price'        => 'Preço',
                'amount'       => 'Montante',
                'action'       => 'Ação',
                'add-more'     => 'Adicionar Mais',
                'total'        => 'Total',
            ],
        ],

        'view' => [
            'title'       => 'Ordem: :title',
            'rotten-days' => ':days dias',

            'tabs'        => [
                'description' => 'Descrição',
                'products'    => 'Produtos',
                'quotes'      => 'Cotações',
            ],

            'attributes' => [
                'title' => 'Sobre o Ordem',
            ],

            'quotes'=> [
                'subject'         => 'Assunto',
                'expired-at'      => 'Expirado Em',
                'sub-total'       => 'Sub Total',
                'discount'        => 'Desconto',
                'tax'             => 'Imposto',
                'adjustment'      => 'Ajuste',
                'grand-total'     => 'Total Geral',
                'delete'          => 'Excluir',
                'edit'            => 'Editar',
                'download'        => 'Baixar',
                'destroy-success' => 'Venda excluída com sucesso.',
                'empty-title'     => 'Nenhuma Venda Encontrada',
                'empty-info'      => 'Nenhuma Venda foi encontrada para este Ordem',
                'add-btn'         => 'Adicionar Venda',
            ],

            'products' => [
                'product-name' => 'Nome do Produto',
                'quantity'     => 'Quantidade',
                'price'        => 'Preço',
                'amount'       => 'Montante',
                'action'       => 'Ação',
                'add-more'     => 'Adicionar Mais',
                'total'        => 'Total',
                'empty-title'  => 'Nenhum Produto Encontrado',
                'empty-info'   => 'Nenhum produto foi encontrado para este Ordem',
                'add-product'  => 'Adicionar Produto',
            ],

            'persons' => [
                'title'     => 'Sobre as Pessoas',
                'job-title' => ':job_title na :organization',
            ],

            'stages' => [
                'won-lost'       => 'Ganho/Perdido',
                'won'            => 'Ganho',
                'lost'           => 'Perdido',
                'need-more-info' => 'Precisa de Mais Informações',
                'closed-at'      => 'Fechado Em',
                'won-value'      => 'Valor Ganhado',
                'lost-reason'    => 'Motivo da Perda',
                'save-btn'       => 'Salvar',
            ],

            'tags' => [
                'create-success'  => 'Tag criada com sucesso.',
                'destroy-success' => 'Tag excluída com sucesso.',
            ],
            'billing' => [
                'billing'   => 'Faturamento',
                'comment'   => 'Observação',
                'save-btn'  => 'Salvar',
                'status'    => 'Status do Pagamento',
                'payment_date' => 'Data do Pagamento',
            ]
            
        ],
    ],

    'configuration' => [
        'index' => [
            'back'         => 'Voltar',
            'save-btn'     => 'Salvar Configuração',
            'save-success' => 'Configuração Salva com Sucesso.',
            'search'       => 'Pesquisar',
            'title'        => 'Configuração',

            'general'  => [
                'title'   => 'Geral',
                'info'    => 'Configuração Geral',

                'general' => [
                    'title'           => 'Geral',
                    'info'            => 'Atualize suas configurações gerais aqui.',
                    'locale-settings' => [
                        'title'       => 'Configurações de Localidade',
                        'title-info'  => 'Define a linguagem utilizada na interface do usuário, como Inglês (en), Francês (fr), ou Japonês (ja).',
                    ],
                ],
            ],
        ],
    ],


    'dashboard' => [
        'index' => [
            'title' => 'Painel',

            'pdf' => [
                'sales' => [
                    'title' => 'Relatório de Vendas',
                    'summary' => 'Resumo das Vendas',
                    'total-sales' => 'Total de Vendas',
                    'total-paid' => 'Total Pago',
                    'total-pending' => 'Total Pendente',
                    'total-unpaid' => 'Total Não Pago',
                    'total-value' => 'Valor Total',
                    'total-value-paid' => 'Valor Total Pago',
                    'total-value-unpaid' => 'Valor Total Não Pago',
                    'weekly-avg-sales' => 'Média de Vendas por Semana',
                    'details' => 'Detalhamento das Vendas',
                    'date' => 'Data',
                    'sale' => 'Venda',
                    'client' => 'Cliente',
                    'payment-method' => 'Forma de Pagamento',
                    'product' => 'Produto',
                    'seller' => 'Vendedor',
                    'value' => 'Valor',
                    'status' => 'Status',
                    'product-specific' => 'Relatório de vendas para o produto: :product',
                ],
            ],
            'revenue-by-report-filters' => [
                'title' => 'Relatório de Vendas por Período',
                'start-date' => 'De',
                'end-date' => 'Até',
                'seller' => 'Vendedor',
                'select-seller' => 'Selecione o Vendedor',
                'product' => 'Produto',
                'select-product' => 'Selecione o Produto',
                'all-sellers' => 'Todos Vendedores',
                'all-products' => 'Todos Produtos',
                'clear-fields' => 'Limpar Campos',
                'print' => 'Imprimir',
                'sales-report' => 'Relatório de Vendas',
                'no-data' => 'Nenhum dado disponível',
            ],

            'revenue' => [
                'lost-revenue' => 'Despesa',
                'won-revenue'  => 'Receita',
            ],

            'over-all' => [
                'average-lead-value'    => 'Valor Médio do Ordem',
                'total-leads'           => 'Total de Ordens',
                'average-leads-per-day' => 'Média de Ordens por Dia',
                'total-quotations'      => 'Total de Vendas',
                'total-persons'         => 'Total de Pessoas',
                'total-organizations'   => 'Total de Organizações',
            ],

            'total-leads' => [
                'title' => 'Ordens',
                'total' => 'Total de Ordens',
                'won'   => 'Ordens Ganhos',
                'lost'  => 'Ordens Perdidos',
            ],

            'revenue-by-sources' => [
                'title'       => 'Receita por Fontes',
                'empty-title' => 'Nenhum Dado Disponível',
                'empty-info'  => 'Nenhum dado disponível para o intervalo selecionado',
            ],

            'revenue-by-payment-days' => [
                'title'       => 'Receita por Dias de Pagamento',
                'empty-title' => 'Nenhum Dado Disponível',
                'empty-info'  => 'Nenhum dado disponível para os dias de pagamento no intervalo selecionado',
            ],

            'revenue-by-types' => [
                'title'       => 'Receita por Forma de Pagamento',
                'empty-title' => 'Nenhum Dado Disponível',
                'empty-info'  => 'Nenhum dado disponível para o intervalo selecionado',
            ],

            'top-selling-products' => [
                'title'       => 'Produtos Mais Vendidos',
                'empty-title' => 'Nenhum Produto Encontrado',
                'empty-info'  => 'Nenhum produto disponível para o intervalo selecionado',
            ],

            'top-persons' => [
                'title'       => 'Principais Pessoas',
                'empty-title' => 'Nenhuma Pessoa Encontrada',
                'empty-info'  => 'Nenhuma pessoa disponível para o intervalo selecionado',
            ],

            'open-leads-by-states' => [
                'title'       => 'Ordens Abertos por Estados',
                'empty-title' => 'Nenhum Dado Disponível',
                'empty-info'  => 'Nenhum dado disponível para o intervalo selecionado',
            ],
        ],
    ],

    'layouts' => [
        'app-version'          => 'Versão : :version',
        'dashboard'            => 'Painel',
        'leads'                => 'Ordens',
        'quotes'               => 'Vendas',
        'quote'                => 'Venda',
        'expenses'             => 'Despesas',  
        'mail'                 => [
            'title'   => 'Email',
            'compose' => 'Compor',
            'inbox'   => 'Caixa de Entrada',
            'draft'   => 'Rascunho',
            'outbox'  => 'Caixa de Saída',
            'sent'    => 'Enviado',
            'trash'   => 'Lixeira',
            'setting' => 'Configuração',
        ],
        'activities'           => 'Atividades',
        'contacts'             => 'Contatos',
        'persons'              => 'Pessoas',
        'person'               => 'Pessoa',
        'organizations'        => 'Organizações',
        'organization'         => 'Organização',
        'products'             => 'Produtos',
        'product'              => 'Produto',
        'settings'             => 'Configurações',
        'user'                 => 'Usuário',
        'user-info'            => 'Gerencie todos os seus usuários e suas permissões no CRM, o que eles podem fazer.',
        'groups'               => 'Grupos',
        'groups-info'          => 'Adicionar, editar ou excluir grupos do CRM',
        'roles'                => 'Funções',
        'role'                 => 'Função',
        'roles-info'           => 'Adicionar, editar ou excluir funções no CRM',
        'users'                => 'Usuários',
        'users-info'           => 'Adicionar, editar ou excluir usuários no CRM',
        'lead'                 => 'Ordem',
        'lead-info'            => 'Gerenciar todas as configurações relacionadas a ordens no CRM',
        'pipelines'            => 'Pipelines',
        'pipelines-info'       => 'Adicionar, editar ou excluir pipelines do CRM',
        'sources'              => 'Fontes',
        'sources-info'         => 'Adicionar, editar ou excluir fontes no CRM',
        'types'                => 'Tipos',
        'types-info'           => 'Adicionar, editar ou excluir tipos no CRM',
        'automation'           => 'Automação',
        'automation-info'      => 'Gerenciar todas as configurações de automação no CRM',
        'attributes'           => 'Atributos',
        'attribute'            => 'Atributo',
        'attributes-info'      => 'Adicionar, editar ou excluir atributos no CRM',
        'email-templates'      => 'Modelos de Email',
        'email'                => 'Email',
        'email-templates-info' => 'Adicionar, editar ou excluir modelos de email no CRM',
        'workflows'            => 'Workflows',
        'workflows-info'       => 'Adicionar, editar ou excluir workflows no CRM',
        'other-settings'       => 'Outras Configurações',
        'other-settings-info'  => 'Gerencie todas as suas configurações extras no CRM',
        'tags'                 => 'Tags',
        'tags-info'            => 'Adicionar, editar ou excluir tags no CRM',
        'my-account'           => 'Minha Conta',
        'sign-out'             => 'Sair',
        'back'                 => 'Voltar',
        'name'                 => 'Nome',
        'configuration'        => 'Configuração',
        'activities'           => 'Atividades',
        'howdy'                => 'Olá!',
        'warehouses'           => 'Armazéns',
        'warehouse'            => 'Armazém',
        'warehouses-info'      => 'Adicionar, editar ou excluir armazéns no CRM',
    ],

    'user' => [
        'account' => [
            'name'                  => 'Nome',
            'email'                 => 'Email',
            'password'              => 'Senha',
            'my_account'            => 'Minha Conta',
            'update_details'        => 'Atualizar Detalhes',
            'current_password'      => 'Senha Atual',
            'confirm_password'      => 'Confirmar Senha',
            'password-match'        => 'A senha atual não coincide.',
            'account-save'          => 'Alterações na conta salvas com sucesso.',
            'permission-denied'     => 'Permissão Negada',
            'remove-image'          => 'Remover Imagem',
            'upload_image_pix'      => 'Carregar uma Imagem de Perfil (100px x 100px)',
            'upload_image_format'   => 'em Formato PNG ou JPG',
            'image_upload_message'  => 'Apenas imagens (.jpeg, .jpg, .png, ...) são permitidas.',
        ],
    ],

    'emails' => [
        'common' => [
            'dear'   => 'Caro(a) :name',
            'cheers' => 'Saudações,</br>Equipe :app_name',
        ],
    ],

    'errors' => [
        '401' => 'Você não está autorizado a acessar esta página',
    ],
];
