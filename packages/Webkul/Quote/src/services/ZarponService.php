<?php

namespace Webkul\Quote\Services;

use Illuminate\Support\Facades\Http;

class ZarponService
{
    protected $webhookUrl;

    public function __construct()
    {
        $this->webhookUrl = config('app.zarpon.saudacoes_webhook_url');
    }

    public function sendRastreio($nome, $numero, $id, $codRastreio, $link, $startAt, $isEspano)
    {   
        if($isEspano == true){
            $this->webhookUrl = env('ZARPON_WEBHOOK_URL_RASTREIO_SPANO');
        }else{
            $this->webhookUrl = env('ZARPON_WEBHOOK_URL_RASTREIO');
        }

        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Cookie' => 'clzh8biq0003yyq7bgx15ds3h=e%3AkjPq2GKxNHGIHnE8zM8Jyiu753nqxdTA3m8Atbw7VUNOC6UNIsJ8Mebc8fJxd4aW6e5Oi8mFowqYGk22-bXhKg.RS1JTXcydjlKbVBxN3NNWQ.CNXjEKtnsvnamDfB9f3sfwZwOAKRVo7UCfNtKeJBF48; zarpon-session=s%3AeyJtZXNzYWdlIjoiY2x6aDhiaXEwMDAzeXlxN2JneDE1ZHMzaCIsInB1cnBvc2UiOiJ6YXJwb24tc2Vzc2lvbiJ9.h8wRpN_gTENh1dhNdAkGUy8vUsWB2DGbM36tRna_Pgs'
            ])->post($this->webhookUrl, [
                'lead' => [
                    'name' => $nome,
                    'phone' => $numero,
                    'email' => '',
                    'variables' => [
                        [
                            'name' => 'id',
                            'content' => (string)$id,
                        ],
                        [
                            'name' => 'CodigoDeRastreio',
                            'content' => (string)$codRastreio,
                        ],
                        [
                            'name' => 'LinkRastreio',
                            'content' => (string)$link,
                        ],
                    ],
                ],
                'start_at' => $startAt,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            \Log::info($e);
            \Log::error('Erro ao enviar lead para o Zárpon: ' . $e->getMessage());
        }
       
    }

    public function sendSaudacoes($nome, $numero, $id, $isEspano)
    {
        if($isEspano == true){
            $this->webhookUrl = env('ZARPON_WEBHOOK_URL_SAUDACOES_SPANO');
        }else{
            $this->webhookUrl = env('ZARPON_WEBHOOK_URL_SAUDACOES');
        }
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Cookie' => 'clzh8biq0003yyq7bgx15ds3h=e%3AkjPq2GKxNHGIHnE8zM8Jyiu753nqxdTA3m8Atbw7VUNOC6UNIsJ8Mebc8fJxd4aW6e5Oi8mFowqYGk22-bXhKg.RS1JTXcydjlKbVBxN3NNWQ.CNXjEKtnsvnamDfB9f3sfwZwOAKRVo7UCfNtKeJBF48; zarpon-session=s%3AeyJtZXNzYWdlIjoiY2x6aDhiaXEwMDAzeXlxN2JneDE1ZHMzaCIsInB1cnBvc2UiOiJ6YXJwb24tc2Vzc2lvbiJ9.h8wRpN_gTENh1dhNdAkGUy8vUsWB2DGbM36tRna_Pgs'
        ])->post($this->webhookUrl, [
            'lead' => [
                'name' => $nome,
                'phone' => $numero,
                'email' => '',
                'variables' => [
                    [
                        'name' => 'id',
                        'content' => (string)$id,
                    ]
                ],
            ],
        ]);
        return $response->successful();
    }

    /**
     * Para o funnel de um lead no Zárpon.
     *
     * @param string $telefone Número de telefone do lead.
     * @return bool Retorna true em caso de sucesso ou false em caso de erro.
     */
    public function stopFunnelForLead($telefone)
    {
        $token = $this->getToken();

        if (!$token) {
            \Log::error('Unable to stop funnel: Token not available.');
            return false;
        }

        $url = env('ZARPON_WEBHOOK_URL_STOP_FUNNEL', 'https://beta.zarpon.com.br/funnel-executings/stop-for-lead');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post($url, [
                'phone' => $telefone,
            ]);

            if ($response->successful()) {
                \Log::info('Funnel stopped successfully for lead: ' . $telefone);
                return true;
            }

            \Log::warning('Failed to stop funnel for lead: ' . $telefone . '. Response: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            \Log::error('Error stopping funnel for lead: ' . $telefone . '. Error: ' . $e->getMessage());
            return false;
        }
    }

        /**
     * Obtém o token de autenticação.
     *
     * @return string|null Retorna o token em caso de sucesso ou null em caso de erro.
     */
    private function getToken()
    {
        $url = env('ZARPON_AUTH_URL', 'https://beta.zarpon.com.br/auth/login');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'email' => env('ZARPON_AUTH_EMAIL', 'landingadsagency@gmail.com'),
                'password' => env('ZARPON_AUTH_PASSWORD', 'Herbs2024'),
            ]);

            if ($response->successful() && isset($response->json()['token']['token'])) {
                return $response->json()['token']['token'];
            }

            \Log::warning('Failed to obtain token. Response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            \Log::error('Error obtaining token: ' . $e->getMessage());
            return null;
        }
    }

}
