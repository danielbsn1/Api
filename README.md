# HR System API

API de RH voltada para PMEs brasileiras. Construída com Laravel, PostgreSQL, Redis e Docker.

---

## Requisitos

- [Docker](https://www.docker.com/) e Docker Compose
- [Git](https://git-scm.com/)

> Não precisa ter PHP, Composer ou PostgreSQL instalados na máquina. Tudo roda via Docker.

---

## Stack

| Tecnologia | Versão |
|------------|--------|
| PHP | 8.4 |
| Laravel | 13.x |
| PostgreSQL | 16 |
| Redis | 7 |
| JWT | php-open-source-saver/jwt-auth ^2.9 |
| Testes | Pest ^4.7 |

---

## Como rodar

### 1. Clonar o repositório

```bash
git clone <url-do-repositorio>
cd API
```

### 2. Copiar o arquivo de ambiente

```bash
cp .env.example .env
```

### 3. Subir os containers

```bash
docker compose up -d --build
```

Isso vai subir 5 serviços:
- `hr_app` — PHP 8.4 / Laravel
- `hr_nginx` — servidor web na porta `8000`
- `hr_postgres` — PostgreSQL na porta `5432`
- `hr_redis` — Redis na porta `6379`
- `hr_queue` — worker de filas

### 4. Instalar dependências

```bash
docker compose exec app composer install
```

### 5. Gerar chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

### 6. Gerar secret do JWT

```bash
docker compose exec app php artisan jwt:secret
```

### 7. Rodar as migrations

```bash
docker compose exec app php artisan migrate
```

A API estará disponível em: **http://localhost:8000**

---

## Comandos úteis

```bash
# Ver logs da aplicação
docker compose logs -f app

# Acessar o container
docker compose exec app sh

# Rodar testes
docker compose exec app ./vendor/bin/pest

# Rodar migrations
docker compose exec app php artisan migrate

# Rollback migrations
docker compose exec app php artisan migrate:rollback

# Limpar cache
docker compose exec app php artisan optimize:clear

# Parar os containers
docker compose down

# Parar e remover volumes (apaga o banco)
docker compose down -v
```

---

## Estrutura de Módulos

```
Modules/
├── Common/
│   ├── core/               ← base reutilizável por todos os módulos
│   │   ├── Actions/        ← BaseAction
│   │   ├── Contracts/      ← HasCompany (multi-tenant)
│   │   ├── Controllers/    ← BaseController
│   │   ├── DTOs/           ← BaseDTO
│   │   ├── Enums/          ← Role
│   │   ├── Exceptions/     ← BusinessException, NotFoundException
│   │   ├── Models/         ← BaseModel (UUID, SoftDelete, tenant scope)
│   │   ├── Policies/       ← BasePolicy
│   │   ├── Requests/       ← BaseRequest (mensagens pt-BR)
│   │   ├── Resources/      ← BaseResource
│   │   └── Support/        ← Cpf, Cnpj, Phone, Money, Inss
│   └── log/                ← auditoria automática
│       ├── Actions/        ← RegisterLog
│       ├── Models/         ← ActivityLog
│       ├── Observers/      ← LogObserver
│       └── Support/        ← Loggable (trait)
├── User/                   ← autenticação e usuários
└── Employee/               ← módulo principal de RH
    ├── Employees
    ├── Departments
    ├── Positions
    ├── Addresses
    ├── Documents
    ├── EmergencyContacts
    ├── Dependents
    ├── BankAccounts
    ├── Salaries
    ├── PositionHistory
    ├── Vacations
    ├── Leaves
    ├── WorkSchedules
    ├── TimeClock
    ├── Payroll
    ├── PerformanceReviews
    ├── Trainings
    ├── Assets
    └── Files
```

---

## Autenticação

A API usa JWT. Após o login, inclua o token no header de todas as requisições:

```
Authorization: Bearer <token>
```

---

## Perfis de acesso

| Role | Descrição |
|------|-----------|
| `admin` | Acesso total |
| `rh_manager` | Gerencia funcionários, folha, férias e relatórios |
| `rh_analyst` | Visualiza e edita, não deleta |
| `manager` | Vê funcionários do seu departamento |
| `employee` | Vê apenas os próprios dados |

---

## Testes

```bash
# Rodar todos os testes
docker compose exec app ./vendor/bin/pest

# Rodar com cobertura
docker compose exec app ./vendor/bin/pest --coverage
```

---

## Variáveis de ambiente importantes

| Variável | Descrição | Padrão |
|----------|-----------|--------|
| `DB_CONNECTION` | Driver do banco | `pgsql` |
| `DB_HOST` | Host do banco | `postgres` (dentro do Docker) |
| `DB_DATABASE` | Nome do banco | `hr_system` |
| `DB_USERNAME` | Usuário do banco | `postgres` |
| `DB_PASSWORD` | Senha do banco | `123456` |
| `REDIS_HOST` | Host do Redis | `redis` (dentro do Docker) |
| `QUEUE_CONNECTION` | Driver de filas | `redis` |
| `CACHE_STORE` | Driver de cache | `redis` |
| `JWT_SECRET` | Secret do JWT | gerado via `jwt:secret` |

> Ao rodar via Docker, `DB_HOST` deve ser `postgres` e `REDIS_HOST` deve ser `redis` (nome dos serviços no compose).

---

## Infra pendente

Veja [infra-checklist.md](infra-checklist.md) para o que ainda falta implementar (Swagger, CI/CD, Seeders).
