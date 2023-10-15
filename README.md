BolsaAnalise
========

Objetivos

    - Capturar as informações sobre as empresas automaticamente.
        - O que queremos capturar:
            OK - Dados básicos como informações da empresa
            OK - Dados fundamentalistas e de balanço da empresa
            OK - Histórico de cotações

Como vamos fazer:
    1 - Executar um webscrap no fundamentus
    2 - Criar banco de dados e infra usando melhores praticas, ddd e tdd
    3 - Criar paineis para comprarar valores das empresas e comparar as empresas entre si


## Análise já realizadas

* Os seguintes valores abaixo são base de calculo:

 - Preço do ativo
 - Quantidade de ações
 - Ativo = Todos os bens e direitos da empresa - Tudo o que a empresa é
 - Divida bruta = vem do balanço
 - Patrimonio Liquido = Todos os ativos - Todos os Passivos - Isso é o que de fato a empresa tem ou o valor que ela é contando com as dividas

* Outros:
 - Disponibilidades = valor em caixa
 - Ativo Circulante = Ativos de rapida disponibilidade

## Calculos

Valor Mercado = Preço Ativo * Qtd Acoes
Divida Liquida = Divida Bruta - Disponibilidades
Valor Firma = Valor Mercado + Divida Liquida

# Conclusões

 * Não confundir ATIVO e Patrimonio Liquido
 * O preço da ação pode ser comparado com o ATIVO e com o Patrimonio Liquido
 * VL_ATIVO / QTD ACOES = preço a ser comparado
 * VPA = Patrimonio Liquido / QTD ACOES = preço a ser comparado
 * Estamos salvando a receita e o lucro liquido dos últimos 3 meses - fazer * 4



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
php composer.phar require vlucas/phpdotenv

```

Criar um arquivo .env na pasta public com a variável para execucao da api
do site https://brapi.dev/dashboard

COTACAO_API_TOKEN=1111_TOKEN_1111

## Comandos

```
na raiz - windows
cd ./public
php -S localhost:8000
php ..\vendor\bin\doctrine orm:validate-schema
php ..\vendor\bin\doctrine orm:schema-tool:drop --force
php ..\vendor\bin\doctrine orm:schema-tool:create
php ..\vendor\bin\doctrine orm:schema-tool:update
