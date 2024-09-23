# JurisControl - Sistema de Controle Jurídico

<p>Sistema ERP de Gestão e Controle Jurídico para Escritórios Advocatícios.</p>

## Projeto
* Repositório: https://github.com/jeffersonvidal/juriscontrol.git

### Sistemas que inspiram recursos
* EasyJur
* AdvBox
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
    []-  Usuários
    []-  Etiquetas
    []-  Tarefas
    []-  Empresas
    []-  Gamificação
[]-  Gestão de Clientes
    []-  Clientes
    []-  Processos e Casos
    []-  Consultivos
[]-  Gestão Financeira
    []-  Caixa
    []-  Contas a Pagar
    []-  Contas a Receber
[]-  Gestão de RH
    []-  Funcionários
    []-  Cargas Horárias
    []-  Treinamentos
[]-  CRM
    []-  Aniversariantes
    []-  Campanhas
    []-  Email Mkt

## APIs Externas

-[] - IBGE (Localidades)
    -[] - https://servicodados.ibge.gov.br/api/docs/localidades#api-_
    -[] - https://servicodados.ibge.gov.br/api/v1/localidades/estados/{UF}/mesorregioes
-[] - CORREIOS (CPF)
    -[] -  https://cws.correios.com.br/dashboard/pesquisa
    -[] -  https://api.correios.com.br/token/v3/api-docs
    -[] -  
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