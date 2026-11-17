<?php

/*
|--------------------------------------------------------------------------
| Entrada para publicar o projeto INTEIRO dentro de uma subpasta do Apache
| (ex.: htdocs/tabelas  ->  http://192.168.5.101/tabelas)
|--------------------------------------------------------------------------
| O normal no Laravel é o Apache apontar direto para a pasta public/.
| Quando não dá para mexer na configuração do Apache, este arquivo e o
| .htaccess da raiz mandam toda requisição para o public/index.php.
|
| Como o Apache executa ESTE arquivo (/tabelas/index.php), o Laravel entende
| que a base da URL é "/tabelas" e as rotas funcionam: /tabelas/ordenacao etc.
*/

require __DIR__.'/public/index.php';
