<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Nome da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este valor é o nome da sua aplicação. Ele é usado sempre que o framework
    | precisa colocar o nome da aplicação em uma notificação ou em qualquer
    | outro local, conforme necessário pela aplicação ou pacotes.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Ambiente da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este valor determina o "ambiente" em que sua aplicação está executando
    | no momento. Pode ser utilizado para configurar diferentes serviços que
    | a aplicação usa. Defina este valor no arquivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de Depuração da Aplicação
    |--------------------------------------------------------------------------
    |
    | Quando sua aplicação está no modo de depuração, mensagens de erro detalhadas
    | com rastreamentos de pilha serão exibidas em cada erro que ocorre dentro de
    | sua aplicação. Caso contrário, será exibida uma página de erro genérica.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL da Aplicação
    |--------------------------------------------------------------------------
    |
    | Esta URL é utilizada pelo console para gerar URLs corretamente ao usar
    | a ferramenta de linha de comando Artisan. Defina esta URL como sendo
    | o root da sua aplicação para que ela seja utilizada nas tarefas Artisan.
    |
    */

  'url' => env('APP_URL', 'http://localhost'),



    /*
    |--------------------------------------------------------------------------
    | Caminho Admin da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este sufixo de URL é usado para definir o caminho do admin, por exemplo,
    | admin/ ou backend/
    |
    */

    'admin_path' => env('APP_ADMIN_PATH', 'admin'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Fuso Horário da Aplicação
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o fuso horário padrão para sua aplicação, o qual
    | será usado pelas funções de data e hora do PHP. Já configuramos para um
    | padrão sensato para você.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'America/New_York'),

    /*
    |--------------------------------------------------------------------------
    | Configuração de Localização da Aplicação
    |--------------------------------------------------------------------------
    |
    | A localização da aplicação determina a localização padrão que será usada
    | pelo provedor de serviços de tradução. Você está livre para configurar
    | este valor para qualquer uma das localizações suportadas pela aplicação.
    |
    */

    'locale' => env('APP_LOCALE', 'pt'),

    /*
    |--------------------------------------------------------------------------
    | Localizações Disponíveis
    |--------------------------------------------------------------------------
    |
    | A configuração de localizações disponíveis determina quais idiomas são
    | suportados pela aplicação.
    |
    */

    'available_locales' => [
        'ar' => 'Arabic',
        'en' => 'English',
        'es' => 'Español',
        'fa' => 'Persian',
        'pt' => 'Português',
        'tr' => 'Türkçe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Localização de Fallback
    |--------------------------------------------------------------------------
    |
    | A localização de fallback determina a localização que será usada quando a
    | atual não estiver disponível. Você pode alterar o valor para qualquer uma
    | das pastas de idioma fornecidas por sua aplicação.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Localização do Faker
    |--------------------------------------------------------------------------
    |
    | Esta localização será utilizada pela biblioteca Faker PHP ao gerar dados
    | falsos para suas seeds de banco de dados. Por exemplo, ela será usada
    | para obter números de telefone, endereços e outras informações localizadas.
    |
    */

    'faker_locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Código da Moeda Base
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o código da moeda base para sua aplicação.
    |
    */

    'currency' => env('APP_CURRENCY', 'USD'),

    /*
    |--------------------------------------------------------------------------
    | Chave de Criptografia
    |--------------------------------------------------------------------------
    |
    | Esta chave é utilizada pelo serviço de criptografia do Laravel e deve ser
    | definida como uma string aleatória de 32 caracteres, caso contrário, as
    | strings criptografadas não serão seguras. Faça isso antes de implantar!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Provedores de Serviços Carregados Automaticamente
    |--------------------------------------------------------------------------
    |
    | Os provedores de serviços listados aqui serão automaticamente carregados
    | na solicitação à sua aplicação. Sinta-se à vontade para adicionar seus
    | próprios serviços a esta matriz para conceder funcionalidade adicional
    | às suas aplicações.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([

        /*
         * Provedores de Serviços de Pacotes...
         */
        Barryvdh\DomPDF\ServiceProvider::class,
        Konekt\Concord\ConcordServiceProvider::class,
        Prettus\Repository\Providers\RepositoryServiceProvider::class,

        /*
         * Provedores de Serviços da Aplicação...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        /*
         * Provedores de Serviços Webkul...
         */
        Webkul\Activity\Providers\ActivityServiceProvider::class,
        Webkul\Admin\Providers\AdminServiceProvider::class,
        Webkul\Attribute\Providers\AttributeServiceProvider::class,
        Webkul\Automation\Providers\WorkflowServiceProvider::class,
        Webkul\Contact\Providers\ContactServiceProvider::class,
        Webkul\Core\Providers\CoreServiceProvider::class,
        Webkul\DataGrid\Providers\DataGridServiceProvider::class,
        Webkul\EmailTemplate\Providers\EmailTemplateServiceProvider::class,
        Webkul\Email\Providers\EmailServiceProvider::class,
        Webkul\Installer\Providers\InstallerServiceProvider::class,
        Webkul\Lead\Providers\LeadServiceProvider::class,
        Webkul\Product\Providers\ProductServiceProvider::class,
        Webkul\Quote\Providers\QuoteServiceProvider::class,
        Webkul\Tag\Providers\TagServiceProvider::class,
        Webkul\User\Providers\UserServiceProvider::class,
        Webkul\Warehouse\Providers\WarehouseServiceProvider::class,
        Webkul\WebForm\Providers\WebFormServiceProvider::class,
        Webkul\Expenses\Providers\ExpenseServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Aliases de Classes
    |--------------------------------------------------------------------------
    |
    | Esta matriz de aliases de classes será registrada quando esta aplicação
    | for iniciada. No entanto, fique à vontade para registrar quantos quiser
    | pois os aliases são "lazy" carregados, portanto, eles não afetam o desempenho.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([])->toArray(),

];
