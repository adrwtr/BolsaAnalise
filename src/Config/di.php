<?php
use Akuma\BolsaAnalise\Domain\Repository\UsuarioSQLiteRepository;
use Akuma\BolsaAnalise\Domain\Repository\IUsuarioRepository;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoRepository;
use Akuma\BolsaAnalise\Domain\Repository\Acao\AcaoSQLiteRepository;
use Akuma\BolsaAnalise\Service\AcaoService;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoDadosFundamentalistaRepository;
use Akuma\BolsaAnalise\Domain\Repository\Acao\AcaoDadosFundamentalistaSQLiteRepository;
use Akuma\BolsaAnalise\Service\AcaoDadosFundamentalistaService;

use Akuma\BolsaAnalise\Service\Http\IHttpClient;
use Akuma\BolsaAnalise\Service\Http\GuzzleClient;
use Akuma\BolsaAnalise\Service\LeitorUrl;

use Akuma\BolsaAnalise\Controller\LeitorFundamentus;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder, bool $sn_test) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([

        // upper services
        IHttpClient::class => \DI\autowire(GuzzleClient::class),
        LeitorUrl::class => \DI\autowire(LeitorUrl::class),

        // lista de repositories
        IUsuarioRepository::class => $sn_test
            ? \DI\autowire(UsuarioSQLiteRepository::class)
            : \DI\autowire(UsuarioSQLiteRepository::class),

        IAcaoRepository::class => $sn_test
            ? \DI\autowire(AcaoSQLiteRepository::class)
            : \DI\autowire(AcaoSQLiteRepository::class),

        IAcaoDadosFundamentalistaRepository::class => $sn_test
            ? \DI\autowire(AcaoDadosFundamentalistaSQLiteRepository::class)
            : \DI\autowire(AcaoDadosFundamentalistaSQLiteRepository::class),

        // lista de services
        AcaoService::class => \DI\autowire(AcaoService::class),
        AcaoDadosFundamentalistaService::class => \DI\autowire(AcaoDadosFundamentalistaService::class),

        // LeitorFundamentus::class => \DI\autowire(LeitorFundamentus::class)
        // sqlite
        // IUsuarioRepository::class => \DI\autowire(UsuarioSQLiteRepository::class),



    ]);
};

// $container->set('LeitorFundamentus', function (ContainerInterface $container) {
//     // retrieve the 'view' from the container
//     // $view = $container->get('IUsuarioRepository');

//     return new LeitorFundamentus($container);
// });