<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Webkul\Admin\Constants\Stages;
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
                // Autenticar o usuário padrão
                $adminUser = \Webkul\User\Models\User::find(config('app.user_admin')); // Substitua 1 pelo `ID` correto
                if ($adminUser) {
                    \Auth::login($adminUser);
                }

                // Busca os leads que precisam ser enviados
                $leads = \Webkul\Lead\Models\Lead::with('person')->where('lead_pipeline_stage_id', Stages::A_CAMINHO)
                    ->where('is_sent_rastreio_to_zarpon', false)
                    ->whereNotNull('tracking_link') // Certifique-se de que há um tracking link
                    ->get();

                // Instancia o serviço
                $zarponService = app(\Webkul\Quote\Services\ZarponService::class);

                foreach ($leads as $lead) {
                    try {

                        // Dados do lead
                        $nome = $lead->person->name;
                        $numero = $lead->person->contact_numbers[0]['value'];
                        $id = $lead->id;
                        $codRastreio = $lead->tracking_link; // Ajuste conforme o campo
                        $link = $lead->tracking_link;
                        $startAt =  Carbon::now()->addMinutes(18)->format('Y-m-d H:i');

                        // Envia para o Zárpon
                        $zarponService->sendRastreio($nome, $numero, $id, $codRastreio, $link, $startAt);

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
