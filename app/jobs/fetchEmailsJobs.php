<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Webklex\IMAP\Facades\Client;

class FetchEmailsJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
       
    }

    
    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            
            $client = Client::account('default');
            $client->connect();

           
            $folder = $client->getFolder('INBOX');
            $messages = $folder->messages()->unseen()->get();

            //Obter os ultimos 5 emails lidos/não lidos da caixa de entrada via IMAP
            // $limit = 5;
            // $messages = $folder->messages()->all()->limit($limit)->get();

            foreach ($messages as $message) {
                DB::table('emails')->insert([
                    'subject' => $message->getSubject() ?? 'Sem Assunto', 
                    'source' => 'imap', 
                    'user_type' => 'admin', 
                    'name' => $message->getFrom()[0]->personal ?? 'Desconhecido', 
                    'reply' => $message->getTextBody() ?? 'Sem conteúdo', 
                    'is_read' => 0, 
                    'folders' => json_encode(['inbox']), 
                    'from' => json_encode($message->getFrom()[0]->mail ?? 'unknown@email.com'), 
                    'sender' => json_encode($message->getFrom()[0]->mail ?? 'unknown@email.com'), 
                    'reply_to' => json_encode($message->getReplyTo() ?: []), 
                    'cc' => json_encode($message->getCc() ?: []), 
                    'bcc' => json_encode($message->getBcc() ?: []), 
                    'unique_id' => $message->getUid() ?? uniqid(), 
                    'message_id' => $message->getMessageId() ?? uniqid(), 
                    'reference_ids' => json_encode($message->getReferences() ?: []), 
                    'created_at' => now(),
                    'updated_at' => now(),
                    'parent_id' => null, 
                ]);
            }

            $client->disconnect(); 
        } catch (\Webklex\PHPIMAP\Exceptions\ConnectionFailedException $e) {
            \Log::error('Erro na conexão: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Erro genérico: ' . $e->getMessage());
        }
    }
}