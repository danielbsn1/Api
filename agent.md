# API de RH — Documentação de Aprendizado e Regras do Sistema

## Contexto

API de RH voltada para PMEs brasileiras. O objetivo é cobrir os módulos mais comuns de RH
sem reescrever o que já existe, com foco em regras trabalhistas brasileiras.

---

## Módulos Planejados

### Já existentes (Common/core/Support)

- `Cpf` — validação, formatação, desformatação
- `Cnpj` — mesma lógica do CPF com ajustes de tamanho e máscara
- `Phone` — mesma lógica, máscara `(00) 0000-0000`
- `Money` — armazena em centavos (int) para evitar problemas de precisão com float
- `Inss` — cálculo progressivo por faixas salariais

### A criar

- `Funcionario` — dados pessoais, cargo, departamento, salário, data de admissão
- `Departamento` — agrupamento de funcionários
- `Ferias` — controle de período aquisitivo e gozo
- `FolhaDePagamento` — geração mensal com descontos e adicionais
- `Relatorio` — gerador de documentos (PDF/Excel)

---

## Regras de Negócio

### Funcionário

- Deve ter CPF válido
- Data de admissão obrigatória
- Salário armazenado em centavos via `Money`
- Vinculado a um departamento

### Férias (CLT)

- Período aquisitivo: 12 meses trabalhados
- Período de gozo: até 12 meses após o aquisitivo (período concessivo)
- Pode ser dividido em até 3 períodos, sendo um deles mínimo de 14 dias
- Abono pecuniário: funcionário pode vender até 1/3 das férias
- Férias vencidas geram multa de 50% sobre o valor

### INSS 2024 (tabela progressiva)

| Faixa salarial  | Alíquota |
| --------------- | -------- |
| Até R$ 1.412,00 | 7,5%     |
| Até R$ 2.666,68 | 9%       |
| Até R$ 4.000,03 | 12%      |
| Até R$ 7.786,02 | 14%      |

- Cálculo é progressivo: cada faixa paga só sobre o valor dentro dela
- Acima do teto (R$ 7.786,02) não há desconto adicional

### FGTS

- 8% sobre o salário bruto todo mês
- Depositado na conta vinculada do funcionário
- Não desconta do salário — é custo do empregador

### IR (Imposto de Renda — tabela 2024)

| Base de cálculo      | Alíquota | Dedução   |
| -------------------- | -------- | --------- |
| Até R$ 2.259,20      | Isento   | —         |
| Até R$ 2.826,65      | 7,5%     | R$ 169,44 |
| Até R$ 3.751,05      | 15%      | R$ 381,44 |
| Até R$ 4.664,68      | 22,5%    | R$ 662,77 |
| Acima de R$ 4.664,68 | 27,5%    | R$ 896,00 |

- Base de cálculo = salário bruto - INSS - dependentes (R$ 189,59 cada)
- IR incide sobre a base, depois subtrai a dedução da faixa

### Folha de Pagamento

```
Salário Bruto
- INSS
- IR (sobre base = bruto - INSS)
- Outros descontos (faltas, adiantamento)
+ Adicionais (horas extras, insalubridade, periculosidade)
= Salário Líquido
```

---

## Lógicas Aprendidas

### Por que centavos no Money?

Float tem problema de precisão: `0.1 + 0.2` em float não é exatamente `0.3`.
Com `int` (centavos) isso nunca acontece — crítico pra folha de pagamento.

### Por que construtor privado no Money?

```php
private function __construct(int $cents)
public static function fromFloat(float $value): self
public static function fromString(string $value): self
```

Você controla exatamente como o objeto é criado. Evita estados inválidos.

### Como funciona o cálculo progressivo do INSS?

Salário R$ 3.000,00:

```
1ª faixa: 1.412,00 × 7,5%  = R$ 105,90
2ª faixa: 1.254,68 × 9%    = R$ 112,92  (2.666,68 - 1.412,00)
3ª faixa: 333,32  × 12%    = R$ 39,99   (3.000,00 - 2.666,68)
Total INSS = R$ 258,81
```

### Regex usadas

- `\D` — qualquer coisa que não seja dígito (usado no unformat)
- `^(\d)\1+$` — todos os dígitos iguais (rejeita CPFs como 111.111.111-11)
- `^\d{3}\.\d{3}\.\d{3}-\d{2}$` — valida formato CPF
- `^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$` — valida formato CNPJ

---

## Estrutura de Módulos

```
Modules/
├── Common/
│   ├── core/
│   │   ├── Actions/
│   │   │   └── BaseAction.php          ← contrato handle()
│   │   ├── Contracts/
│   │   │   ├── HasCompany.php          ← interface para models multi-tenant
│   │   │   ├── TokenServiceInterface.php    ← contrato para geração/validação de JWT
│   │   │   └── PasswordServiceInterface.php ← contrato para hash/reset de senha
│   │   ├── Controllers/
│   │   │   └── BaseController.php      ← success, created, paginated, noContent, error, execute
│   │   ├── DTOs/
│   │   │   └── BaseDTO.php             ← fromRequest, fromArray, toArray
│   │   ├── Enums/
│   │   │   ├── DefaultRole.php         ← roles do sistema com level, label, permissions
│   │   │   ├── Permissions.php         ← todas as permissões do sistema (enum)
│   │   │   └── PermissionGroups.php    ← agrupamento de permissões por módulo
│   │   ├── Exceptions/
│   │   │   ├── BusinessException.php   ← regra de negócio violada (422)
│   │   │   └── NotFoundException.php   ← recurso não encontrado (404)
│   │   ├── Models/
│   │   │   └── BaseModel.php           ← UUID, soft delete, tenant scope via HasCompany
│   │   ├── Policies/
│   │   │   └── BasePolicy.php          ← viewAny, view, create, update, delete, helpers
│   │   ├── Requests/
│   │   │   └── BaseRequest.php         ← authorize true, mensagens pt-BR
│   │   ├── Resources/
│   │   │   └── BaseResource.php        ← timestamps formatados d/m/Y H:i
│   │   └── Support/
│   │       ├── Cpf.php
│   │       ├── Cnpj.php
│   │       ├── Phone.php
│   │       ├── Money.php
│   │       └── Inss.php
│   └── log/
│       ├── Actions/
│       │   └── RegisterLog.php         ← grava company_id, user_id, before, after, ip
│       ├── Models/
│       │   └── ActivityLog.php         ← herda Model direto (não BaseModel) evita loop
│       ├── Observers/
│       │   └── LogObserver.php         ← ignora ActivityLog para evitar loop infinito
│       └── Support/
│           └── Loggable.php            ← trait: use Loggable no model = auditoria automática
├── User/
└── Employee/                           ← a criar
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

## Decisões de Arquitetura (boilerplate)

### Multi-tenant via interface HasCompany
Models que implementam `HasCompany` recebem automaticamente um global scope
que filtra por `company_id` do usuário logado. Mais seguro que checar `getFillable()`.
```php
class Employee extends BaseModel implements HasCompany { ... }
```

### execute() no BaseController
Evita try/catch repetido em todo controller. Captura `NotFoundException`,
`BusinessException` e erros genéricos automaticamente:
```php
public function store(Request $request): JsonResponse
{
    return $this->execute(fn() =>
        $this->created(new EmployeeResource(
            (new CreateEmployee(EmployeeDTO::fromRequest($request)))->handle()
        ))
    );
}
```

### ActivityLog herda Model direto
Se herdasse BaseModel, o global scope de company tentaria filtrar os próprios
logs causando loop. Por isso herda direto de `Model`.

### LogObserver ignora ActivityLog
Guard explícito para evitar que o observer tente logar o próprio log.

---

## Sistema de Roles e Permissões

### Como funciona

O sistema usa 3 enums que trabalham juntos:
- `DefaultRole` — define os perfis de acesso
- `Permissions` — define todas as ações possíveis no sistema
- `PermissionGroups` — agrupa as permissões por módulo (usado em telas de configuração)

### DefaultRole — como usar

```php
use Modules\Common\Core\Enums\DefaultRole;

// Checar o role do usuário
$user->role === DefaultRole::ADMIN;

// Checar nível de acesso (quanto maior, mais acesso)
$user->role->level(); // SUPER_ADMIN=100, ADMIN=90, MANAGER=70...

// Checar se o role é protegido (não pode ser deletado)
$user->role->isProtected(); // true para SUPER_ADMIN e ADMIN

// Checar se o role é oculto (não aparece na listagem)
$user->role->isHidden(); // true para SUPER_ADMIN

// Pegar as permissões do role
$user->role->permissions(); // retorna array de Permissions

// No User model
$user->hasRole(DefaultRole::ADMIN, DefaultRole::MANAGER);
$user->isAdmin();
$user->canManage(); // true se level >= MANAGER
```

| Role | Level | Descrição |
|------|-------|-----------|
| `super-admin` | 100 | Acesso total à plataforma |
| `admin` | 90 | Acesso administrativo |
| `manager` | 70 | Gerencia departamentos e times |
| `supervisor` | 60 | Supervisiona processos |
| `employee` | 40 | Usuário interno padrão |
| `customer` | 20 | Acesso externo limitado |
| `guest` | 10 | Somente leitura |

### Permissions — como usar

```php
use Modules\Common\Core\Enums\Permissions;

// Checar se usuário tem permissão (via gate do Laravel)
Gate::allows(Permissions::EMPLOYEE_VIEW->value);

// Pegar todas as permissões
Permissions::cases();

// No middleware ou policy
$user->hasPermission(Permissions::EMPLOYEE_CREATE);
```

Permissões seguem o padrão `modulo.acao`:
```
auth.login, auth.logout, auth.manage-sessions
user.view, user.create, user.update, user.delete
role.view, role.create, role.update, role.delete
employee.view, employee.create, employee.update, employee.delete
company.view, company.create, company.update, company.delete
```

### PermissionGroups — como usar

```php
use Modules\Common\Core\Enums\PermissionGroups;

// Pegar o módulo de um grupo
PermissionGroups::EMPLOYEES->module(); // 'Employee'

// Pegar label para exibição
PermissionGroups::EMPLOYEES->label(); // 'Employees'

// Pegar ícone (Heroicons)
PermissionGroups::EMPLOYEES->icon(); // 'identification'

// Listar todos os grupos organizados por módulo
PermissionGroups::modules();
// retorna: ['IAM' => [...], 'Employee' => [...], ...]
```

### Contracts — como usar

**TokenServiceInterface** — qualquer implementação de token (JWT, Sanctum, etc) deve seguir esse contrato:
```php
// Implementar o contrato
class JwtService implements TokenServiceInterface
{
    public function generate(array $payload): string { ... }
    public function validate(string $token): bool { ... }
    public function decode(string $token): array { ... }
    public function refresh(string $token): string { ... }
    public function invalidate(string $token): void { ... }
}

// Registrar no ServiceProvider
$this->app->bind(TokenServiceInterface::class, JwtService::class);

// Usar via injeção de dependência
public function __construct(private TokenServiceInterface $tokenService) {}
```

**PasswordServiceInterface** — abstrai hash, verificação e reset de senha:
```php
class PasswordService implements PasswordServiceInterface
{
    public function hash(string $password): string { ... }
    public function verify(string $password, string $hash): bool { ... }
    public function isStrong(string $password): bool { ... }
    public function generateReset(string $email): string { ... }
    public function validateReset(string $token): bool { ... }
}
```

### Por que usar Contracts (interfaces)?

Se hoje você usa JWT e amanhã quiser trocar para Sanctum, você só troca a implementação no `ServiceProvider`. O resto do código não muda nada — ele depende da interface, não da implementação concreta.
