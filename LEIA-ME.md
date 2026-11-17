# Laravel Tabelas · ordenação e relações

Sistema de estudo (tema **Biblioteca**) que demonstra, com código comentado, os itens do quadro:

| Quadro | Onde ver | Arquivo principal |
|---|---|---|
| `::oldest(coluna)`, `::latest(coluna)`, `::orderBy(coluna)` | `/tabelas/ordenacao` | `app/Http/Controllers/OrdenacaoController.php` |
| E + R `::with('relacionamento')` (eager loading) | `/tabelas/relacoes` | `app/Http/Controllers/RelacoesController.php` |
| N:1 `belongsTo(Model)` | `/tabelas/relacoes` | `app/Models/Book.php`, `app/Models/AuthorProfile.php` |
| 1:N `hasMany(Model)` | `/tabelas/relacoes` | `app/Models/Author.php`, `app/Models/Category.php` |
| 1:1 `hasOne(Model)` | `/tabelas/relacoes` | `app/Models/Author.php` |

Cada exemplo na tela mostra: a consulta PHP (lida do próprio controller), o laço que usa o resultado,
**o SQL gerado com a contagem de consultas** (o N+1 aparece em vermelho) e a tabela de resultado.

## Banco (normalizado, padrão Laravel, tabelas em inglês)

```
categories (id PK, name UNIQUE)
authors    (id PK, name, country)
author_profiles (id PK, author_id FK UNIQUE -> authors.id ON DELETE CASCADE, bio, birth_date, birth_city)
books      (id PK, author_id FK -> authors.id, category_id FK -> categories.id, title, pages, published_at)
```
Todas com `created_at` e `updated_at`. Casos de estudo nos seeders:
- **Cecília Meireles** não tem perfil → `hasOne` devolve `null` (use `?->`).
- **Ariano Suassuna** não tem livros e **Teatro** não tem livros → `hasMany` devolve Collection vazia.
- `created_at` foi embaralhado de propósito → `latest()` (sem coluna) ≠ `latest('published_at')`.

Arquivos para estudar, nesta ordem:
1. `database/migrations/` (as 4 tabelas, PK e FK comentadas)
2. `app/Models/` (os métodos de relação)
3. `database/seeders/` (dados, criação pela relação `$autor->profile()->create(...)`)
4. `app/Http/Controllers/OrdenacaoController.php` e `RelacoesController.php`
5. `resources/views/` (Blade)

`app/Support/ExemploConsulta.php` é só a "ferramenta didática" que mostra código e SQL na tela; não é algo de prova.

---

## Publicar em http://192.168.5.101/tabelas

Requisitos: **PHP 8.2 ou mais novo**, Apache com **mod_rewrite** e **AllowOverride All**, MySQL/MariaDB
(ou SQLite). A pasta `vendor/` já vem no zip, então **não precisa de Composer nem de internet**.

### 1. Copiar a pasta
Copie a pasta `tabelas` inteira para a raiz web do servidor:
- XAMPP (Windows): `C:\xampp\htdocs\tabelas`
- Linux: `/var/www/html/tabelas` (por WinSCP/FileZilla ou `scp`)

A raiz do projeto já tem um `index.php` e um `.htaccess` que mandam tudo para o `public/` e
**bloqueiam** o acesso direto a `.env`, `vendor/`, `storage/`, `app/` etc.

### 2. Criar o banco
No phpMyAdmin ou no MySQL Workbench:
```sql
CREATE DATABASE tabelas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Conferir o `.env`
O zip já traz um `.env` pronto (APP_KEY gerada). Ajuste usuário e senha do banco se forem outros:
```
APP_URL=http://192.168.5.101/tabelas
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tabelas
DB_USERNAME=root
DB_PASSWORD=
```
`APP_URL` precisa ter o `/tabelas` no fim. Sessão e cache estão em arquivo (`SESSION_DRIVER=file`,
`CACHE_STORE=file`), então não há tabelas extras de sessão.

Se for publicar num servidor visível por outras pessoas, deixe `APP_DEBUG=false` (já vem assim).
Ligado, ele mostra `.env`, caminhos e senhas na tela de erro: é ponto perdido em prova.

### 4. Criar as tabelas e os dados
Abra o terminal **dentro da pasta** `tabelas`:
```bash
php artisan migrate --seed
```
Para apagar tudo e recriar do zero (útil depois de mexer em migration ou seeder):
```bash
php artisan migrate:fresh --seed
```
Se o servidor estiver com `APP_ENV=production`, o Laravel pede confirmação; use `--force`.

### 5. Permissões (só Linux)
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 6. Testar
- http://192.168.5.101/tabelas
- http://192.168.5.101/tabelas/ordenacao
- http://192.168.5.101/tabelas/relacoes

---

## Alternativa: SQLite (sem MySQL)
No `.env`:
```
DB_CONNECTION=sqlite
# apague ou comente as linhas DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```
Crie o arquivo vazio `database/database.sqlite` e rode `php artisan migrate --seed`.
Precisa da extensão `pdo_sqlite` ligada no PHP.

## Rodar no próprio PC, sem Apache
```bash
php artisan serve
```
Abra http://127.0.0.1:8000 (para isso, troque o `APP_URL` para `http://127.0.0.1:8000`).

## Se der erro
| Sintoma | Causa provável |
|---|---|
| 404 do Apache em `/tabelas/ordenacao` | mod_rewrite desligado ou `AllowOverride None` no Apache |
| "500 Server Error" do Laravel | veja `storage/logs/laravel.log` (com APP_DEBUG=false o detalhe fica só lá) |
| "SQLSTATE[HY000] [1049] Unknown database" | banco `tabelas` não foi criado (passo 2) |
| "SQLSTATE[42S02] Table ... doesn't exist" | faltou `php artisan migrate --seed` |
| Links apontando para a raiz do servidor | `APP_URL` sem o `/tabelas` |
| Página em branco / erro de permissão (Linux) | passo 5 |
| Erro de versão do PHP | precisa de PHP 8.2 ou mais novo (`php -v`) |

Se você instalar sem a pasta `vendor/` (clonando do GitHub), rode antes `composer install --no-dev`
e `php artisan key:generate`, copiando `.env.example` para `.env`.

---
Material de estudo · SP Skills 2026 · #17 Tecnologias Web · Raul Porto Lopes (Avaliador)
