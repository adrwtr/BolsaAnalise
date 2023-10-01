BolsaAnalise
========

Objetivos

    - Capturar as informações sobre as empresas automaticamente.
        - O que queremos capturar:
            - Dados básicos como informações da empresa
            - Dados fundamentalistas e de balanço da empresa
            - Histórico de cotações

Como vamos fazer:
    1 - Executar um webscrap no fundamentus
    2 - Criar banco de dados e infra usando melhores praticas, ddd e tdd
    3 - Criar paineis para comprarar valores das empresas e comparar as empresas entre si


## Set de instalação

```
php composer.phar require slim/slim
php composer.phar require slim/psr7
php composer.phar require php-di/php-di --with-all-dependencies
php composer.phar require phpunit/phpunit
php composer.phar require symfony/var-dumper
php composer.phar require symfony/yaml
php composer.phar require symfony/cache
php composer.phar require guzzlehttp/guzzle
php composer.phar require gdoctrine/orm
php composer.phar require doctrine/dbal
php composer.phar require doctrine/annotations

```

## Comandos

```
na raiz - windows
cd ./public
php ..\vendor\bin\doctrine orm:validate-schema
php ..\vendor\bin\doctrine orm:schema-tool:drop --force
php ..\vendor\bin\doctrine orm:schema-tool:create
