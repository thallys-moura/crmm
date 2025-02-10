<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Webkul\Admin\Constants\Stages;
use Webkul\Quote\Models\QuoteProxy;

use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        $schedule->call(function () {
            
            try {
                $adminUser = \Webkul\User\Models\User::find(config('app.user_admin')); 
                if ($adminUser) {
                    \Auth::login($adminUser);
                }

                $leads = \Webkul\Lead\Models\Lead::with('person')->where('lead_pipeline_stage_id', Stages::A_CAMINHO)
                    ->where('is_sent_rastreio_to_zarpon', false)
                    ->whereNotNull('tracking_link')
                    ->get();

                // Instancia o serviço
                $zarponService = app(\Webkul\Quote\Services\ZarponService::class);

                foreach ($leads as $lead) {

                    try {
                        // Carrega os quotes com os produtos associados aos quote_items
                        $leadQuotes = QuoteProxy::with('items.product')->whereHas('leads', function ($query) use ($lead) {
                            $query->where('lead_id', $lead->id);
                        })->get();

                        $lead->quotes = $leadQuotes; 
                        
                        // Dados do lead
                        $nome = $lead->person->name;
                        $numero = $lead->person->contact_numbers[0]['value'];
                        $id = $lead->id;
                        $codRastreio = $lead->tracking_link; 
                        $link = $lead->tracking_link;
                        $startAt =  Carbon::now()->addMinutes(18)->format('Y-m-d H:i');
                        $isEspano = ($lead->quotes[0]->raca == true) ? true : false;

                        // Envia para o Zárpon
                        $zarponService->sendRastreio($nome, $numero, $id, $codRastreio, $link, $startAt, $isEspano);

                        // Marca como enviado para evitar reenvios
                        $lead->update(['is_sent_rastreio_to_zarpon' => true]);
                    } catch (\Exception $e) {
                        \Log::info($e);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar lead para o Zárpon: ' . $e->getMessage());
            }
        })->cron('*/30 * * * *');

        // Novo schedule para verificar e-mails via IMAP
        $schedule->job(new \App\Jobs\FetchEmailsJobs())->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        $this->load(__DIR__.'/../../packages/Webkul/Core/src/Console/Commands');

        require base_path('routes/console.php');
    }
}
