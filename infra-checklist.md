# Infraestrutura — O que falta implementar

Baseado no canvas `Infraestrtura.canvas`. Tudo que está aqui **ainda não existe** no projeto.

---

## Stack

| Item | Status | Observação |
|------|--------|------------|
| PHP 8.4 | ❌ | `composer.json` exige `^8.3`, precisa atualizar |
| Laravel 12 | ❌ | Instalado Laravel 13 (`^13.8`), verificar compatibilidade com o canvas |
| Redis | ❌ | Não instalado (`predis/predis` ou `phpredis`) |
| Docker | ❌ | Nenhum `Dockerfile` ou `docker-compose.yml` na raiz |

---

## Docker / Docker Compose

Nada criado ainda. Precisa de:

- [ ] `Dockerfile` — imagem PHP 8.4 + extensões necessárias
- [ ] `docker-compose.yml` com os serviços:
  - `app` — PHP/Laravel
  - `postgres` — PostgreSQL
  - `redis` — cache e filas
  - `nginx` — servidor web
- [ ] `.dockerignore`

---

## Banco de Dados

| Item | Status | Observação |
|------|--------|------------|
| PostgreSQL | ❌ | Projeto usa SQLite por padrão (`database.sqlite`) |
| Migrations | ✅ | Existem em `database/migrations/auth/` e `database/migrations/employee/` |
| Seeders | ❌ | `DatabaseSeeder.php` existe mas está vazio |

O que falta:
- [ ] Trocar driver de `sqlite` para `pgsql` no `.env` e `config/database.php`
- [ ] Migration do `activity_logs` (log de auditoria)
- [ ] Migration do `companies` (multi-tenant)
- [ ] Seeders de dados iniciais (empresa, admin, roles)

---

## Autenticação

| Item | Status | Observação |
|------|--------|------------|
| JWT | ❌ | Não instalado (`tymon/jwt-auth` ou `php-open-source-saver/jwt-auth`) |
| Migrations de auth | ✅ | Existem em `database/migrations/auth/` |

O que falta:
- [ ] Instalar pacote JWT: `composer require php-open-source-saver/jwt-auth`
- [ ] Publicar config: `php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"`
- [ ] Gerar secret: `php artisan jwt:secret`
- [ ] Implementar `AuthController` com login, logout, refresh
- [ ] Middleware de autenticação nas rotas

---

## Filas

| Item | Status | Observação |
|------|--------|------------|
| Laravel Queue | ⚠️ | Script `dev` já roda `queue:listen`, mas driver é `sync` |
| Redis como driver | ❌ | Precisa Redis instalado e configurado |

O que falta:
- [ ] Instalar Redis: `composer require predis/predis`
- [ ] Trocar `QUEUE_CONNECTION=sync` para `redis` no `.env`
- [ ] Criar jobs para operações pesadas (geração de relatórios, folha de pagamento)

---

## Documentação da API

| Item | Status | Observação |
|------|--------|------------|
| Swagger / OpenAPI | ❌ | Não instalado |

O que falta:
- [ ] Instalar: `composer require darkaonline/l5-swagger`
- [ ] Publicar config: `php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`
- [ ] Anotar controllers com anotações OpenAPI
- [ ] Rota `/api/documentation`

---

## Testes

| Item | Status | Observação |
|------|--------|------------|
| Pest | ❌ | Instalado PHPUnit (`^12.5`), canvas pede Pest |
| Testes existentes | ⚠️ | Só os exemplos padrão do Laravel |

O que falta:
- [ ] Instalar Pest: `composer require pestphp/pest pestphp/pest-plugin-laravel --dev`
- [ ] Migrar `tests/` para sintaxe Pest
- [ ] Criar testes para `Cpf`, `Cnpj`, `Money`, `Inss`
- [ ] Criar testes de feature para os módulos

---

## CI/CD

| Item | Status | Observação |
|------|--------|------------|
| GitHub Actions / GitLab CI | ❌ | Nenhum arquivo de pipeline |
| Git | ✅ | `.gitignore` existe |

O que falta:
- [ ] Criar `.github/workflows/ci.yml` com:
  - Instalar dependências
  - Rodar Pest
  - Verificar code style com Pint
- [ ] Ou `.gitlab-ci.yml` se usar GitLab

---

## Serviços Externos

Canvas menciona serviços externos mas não especifica quais. Para um sistema de RH brasileiro os mais comuns são:

- [ ] Serviço de e-mail (Mailgun, SES) — notificações de férias, holerite
- [ ] Storage de arquivos (S3 ou similar) — documentos, atestados, arquivos do funcionário
- [ ] Serviço de CEP (ViaCEP) — preenchimento automático de endereço

---

## Repositórios (módulos)

Canvas lista os repositórios `Auth` e `Employees`. O que falta:

- [ ] Implementar camada de repositório em `Auth` (login, logout, refresh, registro)
- [ ] Implementar camada de repositório em `Employee` (todos os sub-módulos)

---

## Ordem sugerida de implementação

```
1. Docker + PostgreSQL + Redis     ← base de tudo
2. JWT                             ← autenticação
3. Migration companies             ← multi-tenant
4. Seeders                         ← dados iniciais
5. Pest                            ← testes
6. Swagger                         ← documentação
7. CI/CD                           ← pipeline
8. Serviços externos               ← conforme necessidade
```
