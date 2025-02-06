<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class TestIMAPConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imap:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the IMAP connection and list unseen emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            $messages = $folder->messages()->unseen()->get();

            if ($messages->count() > 0) {
                foreach ($messages as $message) {
                        
                        \Log::info($messages);
                }
            } else {
                $this->info("Nenhuma mensagem não lida encontrada.");
            }

            $client->disconnect();
        } catch (\Exception $e) {
            \Log::info($e);
            $this->error("Erro ao conectar ao servidor IMAP: " . $e->getMessage());
        }
    }
}
