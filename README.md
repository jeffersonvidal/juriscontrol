# JurisControl - Sistema de Controle Jurídico

<p>Sistema ERP de Gestão e Controle Jurídico para Escritórios Advocatícios.</p>

## Projeto
* Repositório: https://github.com/jeffersonvidal/juriscontrol.git

### Sistemas que inspiram recursos
* EasyJur (dashboard, movimentações, jurisprudencias(wescrapping))
* AdvBox (taskscore, tarefas recorrentes)
* easyvog
* Astrea
* Promad
* MaisJuridico

## Paleta de cores Identidade Visual
* Marrom: #50301E
* Dourado: #C8A472

## Requisitos
* Laravel 11 ou superior
* PHP 8.2 ou superior
* Composer
* NodeJS

## Como rodar o projeto baixado

Duplicar o arquivo ".env.example" e renomear para ".env".<br>

Instalar as dependências do PHP
```
composer install
```
Instalar as dependências do NodeJS
```
npm install
```
Instalar Boostrap com Vite
```
npm i --save bootstrap @popperjs/core
```
Executar Bibliotecas NodeJS
```
npm run dev
```
Instalar Ícones FontAwesome
```
npm i --save @fortawesome/fontawesome-free
```
Gerar chave artisan do projeto
```
php artisan key:generate
```
Inciar o projeto criado com Laravel
```
php artisan serve
```
Acessar conteúdo padrão do Laravel
```
http://localhost:8000
```

## Estrutura e criação de arquivos

Para cada módulo do projeto é necessário criar os mesmos aquivos abaixo, mudando apenas os nomes, colocando o referente a cada módulo.

* Migration
* Controller
* Model
* Request
* Seed
* Adicionar a seed criada no arquivo DatabaseSeeder.php
* Route
* Views (para o CRUD)

## Criando arquivos

Criar Migration
```
php artisan make:migration create_users_table
```

Criar Controller
```
php artisan make:controller UserController
```

Criar Model
```
php artisan make:model User -m
```

Criar Request (para validação de form - em public function authorize() deixe como true)
```
php artisan make:request UserRequest
```

Criar Seed
```
php artisan make:seeder UserSeeder
```

Criar View
```
php artisan make:view users/index
```

Adicionar a seed criada no arquivo DatabaseSeeder.php

Executar as migrations para criar tabelas no banco de dados
```
php artisan migrate
```
Executar as seeds para popular o bando de daods
```
php artisan db:seed
```
## Criar componentes

Criar componente de mensagens (alert = nome do component)
```
php artisan make:component alert --view
```

## Instalar dependências para fazer auditoria do sistema

Instalar dependência para fazer auditoria
```
composer require owen-it/laravel-auditing
```
Publicar a configuração e as migrations para auditoria
```
php artisan vendor:publish --provider "OwenIt\Auditing\AuditingServiceProvider" --tag="config"
```
Criar tabela audits no BD atavés de migration
```
php artisan vendor:publish --provider "OwenIt\Auditing\AuditingServiceProvider" --tag="migrations"
```
Caso não funcione a implementação de auditoria, limpe o cache
```
php artisan config:clear
```
Acrescentar linha em todas as Models que serão auditadas
```
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

Modelo:
class Client extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;
```

## Mensagens de alertas em modal

SweetAlert2
```
npm install sweetalert2
```

## Campo select com busca

Select2
```
npm install select2
```

Tema do Bootstrap 5 para Select2
```
npm install select2-bootstrap-5-theme
```

## Bibliotecas dependentes

JQuery
```
npm install jquery
```

InputMask (para criar máscaras personalizadas em campos de formulários)
```
npm install inputmask
```

Instalar tradução do sistema (mensagens de erro e retorno) para Português Brasil
Fonte: https://github.com/lucascudo/laravel-pt-BR-localization

```
php artisan lang:publish
```
```
composer require lucascudo/laravel-pt-br-localization --dev
```
```
php artisan vendor:publish --tag=laravel-pt-br-localization
```
```
// Versões antigas do Laravel - Altere Linha 85 do arquivo config/app.php para:
'locale' => 'pt_BR'

// Para versões 11.x altere a linha 8 do arquivo .env
APP_LOCALE=pt_BR
```

## Módulos do Sistema

[]-  Gestão Adminsitrativa
    [x]-  Usuários
    [x]-  Escritórios Externos
    []-  Gamificação
[]-  Gestão de Clientes
    []-  Clientes
    []-  Timesheet - registrar tempo gasto em cada atividade/evento executada para o cliente (id, titulo, descricao, dataInicio, HoraInicio, dataFim, HoraFim, tempoTotal, valorDaHora, valorFinal, statusPagto) - Integrar com caixa do escritório (Receitas e Despesas)
    Calcular valores e tempo por atividade/evento e emitir relatório com gráfico do total
[]-  Gestão Jurídica
    [x]-  Tarefas Diárias
    []-  Petições Parceiros
    []-  Audiências/Perícias Parceiros
    []-  Processos
    []-  Casos e Consultivos
    [x]-  Etiquetas
    []-  Eventos/Timesheet
[]-  Gestão Financeira
    []-  Caixa
    []-  Faturas (Pagar e Receber)
    []-  Pagamentos
[]-  Gestão de RH
    []-  Funcionários
    []-  Cargas Horárias
    []-  Treinamentos
[]-  CRM
    []-  Aniversariantes
    []-  Campanhas
    []-  Email Mkt
[]-  SUPORTE
    []-  Tutoriais
    []-  Abrir Chamado

## APIs Externas

-[] - IBGE (Localidades)
    -[] - https://servicodados.ibge.gov.br/api/docs/localidades#api-_
    -[] - https://servicodados.ibge.gov.br/api/v1/localidades/estados/{UF}/mesorregioes
-[] - CORREIOS (CPF)
    -[] -  https://cws.correios.com.br/dashboard/pesquisa
    -[] -  https://api.correios.com.br/token/v3/api-docs
    -[] -  Consulta endereço e cep com viacep - https://viacep.com.br/exemplo/javascript/
    -[] -  
    -[] -  
-[] - 

## Modelagem do BD

[]- customers (clientes)
    id, company_id, name, email, phone, created_at, updated_at, birthday

[]- customer_addresses (enderços de clientes)
    id, customer_id, address, zipcode, neighborhood, city, uf, rg, rg_expedidor, cpf, created_at, updated_at

[]- companies (empresas)
    id, userId(responsavel), name, email, cnpj, created_at, updated_at 

[]- users_profiles (perfis de usuários)
    id, name, created_at, updated_at

[]- compamnies_addresses (endereços de empresas)
    id, company_id, address, zipcode, neighborhood, city, phone, created_at, updated_at 

[]-  users (usuários)
    id, name, email, company_id, cpf, user_profile_id, password, created_at, updated_at

[]-  customer_law_suits (processos do cliente)
    id, law_suit_id, customer_id, customer_situacao(reclamante, requerente), opposite_party_name, opposite_situacao(reclamado, requerido), company_id

[]-  law_suits (processos)
    id, customer_folder_id, process_number, companie_id, title, label_id, instancia, numero_instancia, juizo, vara, foro, acao, link do tribunal, objeto, valor_causa, data_valor_distribuido, valor_condenacao, observacoes, user_employee_id (responsaveis), acesso(publico, privado, equipe) created_at, updated_at

[]- cases
    id, title, status, amount_charged, amount_paid, form_of_payment, label_id, description, author_user_id, company_id, responsible_employee_id

[]-  tasks (tarefas)
    id, description, priority, label_id, end_date, law_suit_case_id, owner_user_id, company_id, employees_id, created_at, updated_at

[]-  labels (etiquetas)
    id, name, hexa_color, company_id, created_at, updated_at
    
[]- Events
    id, title, start_date, start_time, end_date, end_time, all_day, alert_number, alert_unit (min, hr, dia), responsible_user_id, company_id, 
    
[]-  
[]-  
[]-  


## Ferramentas

[]-  Calculadora Horas Extras
[]-  


Teste para fazer contratos dinamicamente fazendo replace de variáveis por valores vindos do BD

```
@php
    $texto = "Estou apenasmente testando isso aqui com o nome [[nome]], email [[email]] e telefone [[telefone]]";
    $variaveis = array('[[nome]]','[[email]]','[[telefone]]');
    $valoresDoBD = array('Jeff', 'dabaea@gmail.com','(61) 98765-4321');
    $teste = str_replace($variaveis, $valoresDoBD, $texto);
    echo $teste;
@endphp
```

Tabela de faturas (receita(income) e despesa(expense))

Lançar tudo que entra e sai de pagamentos, informar valor, data de pagamento, se é fixo,
mensal ou pagamento único, se é receita ou despesa.

Quando for mensal/parcelado, informar qtde de parcelas. O sistema já fará o cálculo de todas
as parcelas. Primeira parcela será considerada a data informada no sistema. Se for data retroativa
o sistema considera que já foi paga

**Carteira - Wallet

id, name, agency, current_account, balance (saldo), company_id, type (personal/business), holder(titular), main(principal)

**Faturas/Transações (invoices/transactions)

id, description, wallet_id, user_id, company_id, customer_id, invoice_category_id, invoice_of,
type, amount, due_at, repeat_when, preiod, enrollments, enrollment_of, status

**Pagamentos (payments)
method = card, cash, pix, ted

id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
amount_owed, amount_paid, amount_remaining

**Petições
customer_name, wallet_id, user_id, company_id, status(iniciada, em andamento, concluído),
origem (escritórios), data recebimento, responsável, data entrega,
tipo (RT, Contestação, Manifestação, RO, RR, ED, Análise de Sentença, Análise Processual, Análise de Caso),
cliente, processo, tribunal, observações, valor, payment_status (pago, pendente, atrasado)

**Audiências, Perícias, Reuniões
status(aberto, concluído, cancelado, a receber), objeto (audiência, perícia, reunião, petição, diligência),
data acontecer, origem(escritórios), cliente, local, horario, tipo(inicial, conciliação, diligencia pericial, instrução, una, visita, encerramento instrução), responsável, processo, modalidade(online, presencial), cliente informado(sim, não), testemunhas informadas(sim, não), link, observações, valor, status(pago, pendente, atrasado)

Tasks (tarefas para recurso taskscore)
id, grupo, fase, pontuação, recorrente, agenda geral