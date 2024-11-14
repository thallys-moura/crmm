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

    public function sendRastreio($nome, $numero, $id, $codRastreio, $link, $startAt)
    {
        $this->webhookUrl = env('ZARPON_WEBHOOK_URL_RASTREIO');
        \Log::info('entrando aqui, atravez do comando agendado');

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

    public function sendSaudacoes($nome, $numero, $id)
    {
        $this->webhookUrl = config('app.zarpon.saudacoes_webhook_url');

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
}
