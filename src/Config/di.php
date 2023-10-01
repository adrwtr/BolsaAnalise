<?php
use Akuma\BolsaAnalise\Domain\Repository\UsuarioSQLiteRepository;
use Akuma\BolsaAnalise\Domain\Repository\IUsuarioRepository;

use Akuma\BolsaAnalise\Controller\LeitorFundamentus;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder, bool $sn_test) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        // lista de repositories

        // memory
        IUsuarioRepository::class => $sn_test
            ? \DI\autowire(UsuarioSQLiteRepository::class)
            : \DI\autowire(UsuarioSQLiteRepository::class),

        // LeitorFundamentus::class => \DI\autowire(LeitorFundamentus::class)
        // sqlite
        // IUsuarioRepository::class => \DI\autowire(UsuarioSQLiteRepository::class),

        // lista de services
        // UsuarioService::class => \DI\autowire(UsuarioService::class),

    ]);
};

// $container->set('LeitorFundamentus', function (ContainerInterface $container) {
//     // retrieve the 'view' from the container
//     // $view = $container->get('IUsuarioRepository');

//     return new LeitorFundamentus($container);
// });