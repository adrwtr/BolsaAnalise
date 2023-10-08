<?php
use Akuma\BolsaAnalise\Domain\Repository\UsuarioSQLiteRepository;
use Akuma\BolsaAnalise\Domain\Repository\IUsuarioRepository;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoRepository;
use Akuma\BolsaAnalise\Domain\Repository\Acao\AcaoSQLiteRepository;
use Akuma\BolsaAnalise\Service\AcaoService;

use Akuma\BolsaAnalise\Controller\LeitorFundamentus;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder, bool $sn_test) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        // lista de repositories
        IUsuarioRepository::class => $sn_test
            ? \DI\autowire(UsuarioSQLiteRepository::class)
            : \DI\autowire(UsuarioSQLiteRepository::class),

        IAcaoRepository::class => $sn_test
            ? \DI\autowire(AcaoSQLiteRepository::class)
            : \DI\autowire(AcaoSQLiteRepository::class),

        // lista de services
        AcaoService::class => \DI\autowire(AcaoService::class),

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