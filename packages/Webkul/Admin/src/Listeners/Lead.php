<?php

namespace Webkul\Admin\Listeners;

use Webkul\Email\Repositories\EmailRepository;
use Webkul\EmailTemplate\Repositories\EmailTemplateRepository;
use Webkul\Lead\Models\LeadProxy;
use Webkul\Lead\Repositories\LeadRepository;
use Webkul\Email\Mails\Email;
use Webkul\Quote\Models\QuoteProxy;
use Webkul\Email\Helpers\MailTranslation;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Lead
{
    protected $mailTranslation;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected EmailRepository $emailRepository,
    protected LeadRepository $leadRepository,
    protected EmailTemplateRepository $emailTemplateRepository,
    ) {
        $this->mailTranslation = new MailTranslation();
    }

    /**
     * Lida com o evento `quote.create.after`.
     *
     * @param  array  $eventData
     * @return void
     */
    public function handleQuoteCreated($lead, $email_id)
    {   
        // Envia o e-mail
        $this->sendEmail($email_id, $lead);
       
        // Vincula o e-mail ao lead
        $this->linkToEmail($lead, $email_id);
    }

    /**
     * @param  \Webkul\Lead\Models\Lead  $lead
     * @return void
     */
    public function linkToEmail($lead, $email_id)
    {
        try {
            if (! request('email_id') && ! $email_id) {
                return;
            }

            $this->emailRepository->update([
                'lead_id' => $lead->id,
            ], $email_id);
        } catch (\Exception $e) {
            Log::error('Erro ao vincular lead ao e-mail: ' . $e->getMessage());
        }        

    }

    /**
     * Envia o e-mail.
     *
     * @param  int  $email_template_id
     * @param  \Webkul\Lead\Models\Lead $lead
     * @return void
     * @throws \Exception
     */
    public function sendEmail($email_template_id, $lead)
    {
        try {
            // Busca o template de e-mail pelo ID
            $emailTemplate = $this->emailTemplateRepository->find($email_template_id);

            if (!$emailTemplate) {
                throw new \Exception("Template de e-mail não encontrado para envio, ID: $email_template_id");
            }

            // Obtém as informações necessárias para o e-mail, por exemplo, o lead e a pessoa
            $person = $lead ? $lead->person : null;

            $leadQuotes = QuoteProxy::with('items.product', 'paymentMethod', 'person')->whereHas('leads', function ($query) use ($lead) {
                $query->where('lead_id', $lead->id);
            })->get();

            $product = $leadQuotes[0]->items[0] ?? null;

            if (!$person) {
                throw new \Exception("Cliente associada ao venda não encontrada.");
            }

            $_lead = LeadProxy::where('id', $lead->id)->first();
            // Prepara os dados do e-mail com base no template
            $toEmail = $person->emails[0]['value'] ?? null; // Certifique-se de que o e-mail está disponível
            if (!$toEmail) {
                throw new \Exception("Destinatário não encontrado para o envio de e-mail.");
            }

            // Pessoa é espanhola?
            if ($leadQuotes[0]->raca != true) {
                $emailReplyContent = $this->mailTranslation->translateHtmlContent($this->processTemplate($emailTemplate->content, [
                    'person' => $person,
                    'lead'   => $_lead,
                    'product' => $product
                ]));
            } else {
                $emailReplyContent = $this->processTemplate($emailTemplate->content, [
                    'person' => $person,
                    'lead'   => $_lead,
                    'product' => $product
                ]);
            }

            $emailData = [
                'subject'       => $emailTemplate->subject,
                'source'        => 'web',
                'name'          => $person->name ?? 'No Name',
                'user_type'     => 'person',
                'from'          => $emailTemplate->from ?? config('mail.from.address'),
                'to'            => $toEmail, // Definindo o destinatário
                'reply_to'      => [$toEmail],
                'folders'       => ['outbox'], // Pasta inicial para o envio
                'unique_id'     => time().'@'.config('mail.domain'),
                'message_id'    => time().'@'.config('mail.domain'),
                'reference_ids' => [],
                'reply'         => $emailReplyContent,
                'person_id'     => $person->id,
                'lead_id'       => $lead->id,
            ];

            // Cria o e-mail usando o repositório
            $email = $this->emailRepository->create($emailData);
            // Envia e-mail
            Mail::send(new Email($email));

            // Atualiza a pasta do e-mail para 'sent' após envio bem-sucedido
            $this->emailRepository->update(['folders' => ['sent']], $email->id);

            Log::info("E-mail enviado com sucesso usando o template, ID: $email_template_id");
        } catch (\Exception $exception) {
            // Tratamento de exceção
            return response()->json([
                'message' => 'Erro ao enviar e-mail.',
                'error' => $exception->getMessage(),
            ], 400);
        }
    }
    protected function processTemplate($content, $context)
    {
        $placeholders = [];
    
        // Defina os campos para as tabelas
        $fields = [
            'lead' => [
                'billing_observation', 'billing_status_id', 'closed_at', 'created_at', 
                'description', 'expected_close_date', 'id', 'lead_pipeline_id',
                'lead_pipeline_stage_id', 'lead_source_id', 'lead_type_id', 'lead_value',
                'lost_reason', 'payment_date', 'person_id', 'status', 'title',
                'tracking_link', 'updated_at', 'user_id',
            ],
            'person' => [
                'contact_numbers', 'created_at', 'emails', 'id', 'job_title', 
                'name', 'organization_id', 'updated_at', 'user_id',
            ],
            'product' => [
                'created_at', 'description', 'email_template_id', 'id', 'image', 
                'name', 'price', 'quantity', 'sku', 'updated_at',
            ],
            'quote' => [
                'adjustment_amount', 'billing_address', 'created_at', 'description',
                'discount_amount', 'discount_percent', 'expired_at', 'grand_total',
                'id', 'payment_method_id', 'person_id', 'raca', 'shipping_address',
                'subject', 'sub_total', 'tax_amount', 'updated_at', 'user_id',
            ],
        ];
    
        // Percorre os campos e cria os placeholders dinamicamente
        foreach ($fields as $entity => $entityFields) {
            if (isset($context[$entity])) {
                foreach ($entityFields as $field) {
                    // Gera o placeholder com o formato {% entity.field %}
                    $placeholder = "{% {$entity}.{$field} %}";
                    // Log::info($placeholder);
                    // Log::info( $context[$entity]);
                    // Log::info( $field);

                    // Busca o valor do campo no contexto
                    $value = $context[$entity]->$field ?? '';
                    // Verifica se o valor é um array com a estrutura [{"value": "data"}]
                    if (is_array($value) && isset($value[0]['value'])) {
                        $value = implode(', ', array_column($value, 'value')); // Extrai todos os "value" e concatena
                    } elseif (is_array($value)) {
                        // Converte arrays aninhados para strings
                        array_walk_recursive($value, function (&$item) {
                            $item = is_scalar($item) ? (string) $item : json_encode($item);
                        });
                        $value = implode(', ', $value); // Converte arrays para uma string
                    } elseif ($value instanceof \DateTime) {
                        $value = $value->format('Y-m-d'); // Formato padrão para datas
                    } elseif (!is_scalar($value)) {
                        $value = ''; // Converte valores não escalares para string vazia
                    }
    
                    // Adiciona ao array de placeholders
                    $placeholders[$placeholder] = (string) $value; // Garante que o valor seja uma string
                }
            }
        }

        // Substitui os placeholders no conteúdo
        foreach ($placeholders as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }
        
        return $content;
    }
    
    
    
    
}

