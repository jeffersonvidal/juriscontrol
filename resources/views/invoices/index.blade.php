@extends('layouts.admin')

@section('content')
<style>
    .btn-check {
        pointer-events: auto; /* Garante que os radio buttons sejam clicáveis */
    }
</style>


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Contas a Pagar e Receber</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Contas a Pagar e Receber</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <div class="card container text-center">
                        <div class="card-header text-bg-primary p-3 row align-items-end">
                            <div class="col">
                                <h5 class="card-title"><i class="fa-solid fa-circle-up"></i> Receita [{{ $mesAtual }}]</h5>
                            </div>
                            <div class="col">
                                <h5 class="card-title ms-auto">{{ 'R$' . number_format($receitaMes, 2, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card container text-center">
                        <div class="card-header text-bg-danger p-3 row align-items-end">
                            <div class="col">
                                <h5 class="card-title"><i class="fa-solid fa-circle-down"></i> Despesa [{{ $mesAtual }}]</h5>
                            </div>
                            <div class="col">
                                <h5 class="card-title ms-auto">{{ 'R$' . number_format($despesaMes, 2, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card container text-center">
                        <div class="card-header text-bg-<?php echo ($saldoCaixa <= 0 ? 'danger' : 'success')?> p-3 row align-items-end">
                            <div class="col">
                                <h5 class="card-title"><i class="fa-solid fa-sack-dollar"></i> Saldo/Caixa</h5>
                            </div>
                            <div class="col">
                                <h5 class="card-title ms-auto">{{ 'R$' . number_format($saldoCaixa, 2, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--fim dirv.row-->
        </div>
    </div>
</div>


<div class="container-fluid px-4">

     <!--buscar entre datas-->
     <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Pesquisar em intervalo de datas</span>
        </div>


        <div class="card-body">
            <form action="{{ route('invoices.index') }}">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input class="form-control" type="text" name="nome" id="nome" value="{{ $nome }}" placeholder="Nome da fatura">
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input class="form-control" type="date" name="data_inicio" id="data_inicio" value="{{ $data_inicio }}" placeholder="Nome da fatura">
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input class="form-control" type="date" name="data_fim" id="data_fim" value="{{ $data_fim }}" placeholder="Nome da fatura">
                    </div>

                    <div class="col-md-2 col-sm-12 mt-3 pt-4">
                        <button type="submit" class="btn btn-info btn-sm">Pesquisar</button>
                        <a href="{{ route('invoices.index') }}" class="btn btn-warning btn-sm">Limpar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
  

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar todos os registros</span>

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            
            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>

                        <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Restante</th>
                        <th>Parcela</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th>Parceiro</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($invoices) > 0)
                        @foreach ($invoices as $invoice)
                            <tr>
                            <td>{{ $invoice->setHearingObject($invoice->description) }}</td>
                            <td>{{ $invoice->getCategory($invoice->invoice_category_id) }}</td>
                            <td>{{ $invoice->getType($invoice->type) }}</td>
                            <td>{{ 'R$' . number_format($invoice->amount, 2, ',', '.') }}</td>
                            <td>{{ 'R$' . number_format($invoice->getAmountRemaining($invoice->id), 2, ',', '.') }}</td>
                            <td class="text-center align-middle">{{ $invoice->enrollment_of }} / {{ $invoice->enrollments }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_at)->format('d/m/Y') }}</td>
                            <td><span class="badge 
                                   @php
                                        $retorno = $invoice->getStatus($invoice->status, $invoice->id);
                                        if($retorno == 'Não Pago'){
                                            echo 'text-bg-light';
                                        }
                                        if($retorno == 'Pago'){
                                            echo 'text-bg-success';
                                        }
                                        if($retorno == 'Atrasado'){
                                            echo 'text-bg-warning';
                                        }
                                        if($retorno == 'Parc. - Atras.'){
                                            echo 'text-bg-warning';
                                        }
                                   @endphp ">
                                {{ $invoice->getStatus($invoice->status, $invoice->id) }}
                                </span>
                            </td>
                                <td>{{ $invoice->getExternalOffice($invoice->external_office_id) }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" class="btn btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>
                                        <button class="text-decoration-none btn btn-sm paymentBtn" title="Dar Baixa / Pagar" 
                                        data-description="{{ $invoice->description }}" data-wallet_id="{{ $invoice->wallet_id }}" data-id="{{ $invoice->id }}"
                                        data-invoice_category_id="{{ $invoice->invoice_category_id }}" data-invoice_of="{{ $invoice->invoice_of }}"
                                        data-amount="{{ $invoice->amount }}" data-due_at="{{ $invoice->due_at }}" data-user_id="{{ auth()->user()->id }}"
                                        data-enrollment_of="{{ $invoice->enrollment_of }}" data-pay_day=""
                                        data-status="paid" data-amount_owed="{{ $invoice->amount }}" data-company_id="{{ $invoice->company_id }}"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="fa-solid fa-money-bill-1-wave"></i></button>
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $invoice->id }}" 
                                            data-description="{{ $invoice->description }}" data-wallet_id="{{ $invoice->wallet_id }}" data-id="{{ $invoice->id }}"
                                            data-invoice_category_id="{{ $invoice->invoice_category_id }}" data-invoice_of="{{ $invoice->invoice_of }}" data-type="{{ $invoice->type }}"
                                            data-amount="{{ $invoice->amount }}" data-due_at="{{ $invoice->due_at }}" 
                                            data-unica="{{ $invoice->repeat_when }}" data-fixa="{{ $invoice->repeat_when }}" data-parcela="{{ $invoice->repeat_when }}"
                                            data-period="{{ $invoice->period }}" data-enrollments="{{ $invoice->enrollments }}" data-enrollment_of="{{ $invoice->enrollment_of }}"
                                            data-status="{{ $invoice->status }}" 
                                            data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $invoice->id }}" 
                                            data-name="{{ $invoice->name }}" data-hexa_color_bg="{{ $invoice->hexa_color_bg }}" 
                                            data-hexa_color_font="{{ $invoice->hexa_color_font }}" ><i class="fa-solid fa-trash"></i></button>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr colspan="5" style="background-color: orange;">Nenhum registro encontrado</tr>
                    @endif
                </tbody>
            </table>
        </div><!--fim card-body-->
    </div><!--fim card -->

<!-- addModal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModa">Lançar Conta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="due_at" class="form-label">Vencimento 1ª Parcela</label>
                            <input type="date" class="form-control" id="due_at" name="due_at" value="{{ old('due_at') }}">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wallet_id" class="form-label">Carteira</label>
                            <select class="form-select" name="wallet_id" id="wallet_id">
                                
                                @foreach ($wallets as $wallet)
                                    @if ($wallet->main = '1')
                                    <option value="{{ $wallet->id }}" >{{ $wallet->name }}</option>
                                    @else
                                        <option value="" >Escolha um</option>
                                    @endif
                                    <option value="" >{{ $wallet->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="invoice_category_id" class="form-label">Categoria</label>
                            <select class="form-select" name="invoice_category_id" id="invoice_category_id">
                                <option value="" >Escolha uma</option>
                                @foreach ($invoiceCategories as $invoiceCategory)
                                    <option value="{{ $invoiceCategory->id }}" > {{ $invoiceCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group col-md-6 mb-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="repeat_when" id="unica" value="unique">
                            <label class="btn btn-sm btn-outline-dark" for="unica">Única</label>

                            <input type="radio" class="btn-check" name="repeat_when" id="fixa" value="fixed">
                            <label class="btn btn-sm btn-outline-dark" for="fixa">Fixa</label>

                            <input type="radio" class="btn-check" name="repeat_when" id="parcela" value="enrollment">
                            <label class="btn btn-sm btn-outline-dark" for="parcela">Parcelas</label>
                        </div>

                        <div id="campoParcela" class=" col-md-6 mb-3">
                            <div class="form-check form-check-inline mb-4">
                                <label for="enrollments" class="form-label">Parcelas</label>
                                <input type="number" disabled min="2" class="form-control" id="enrollments" name="enrollments" placeholder="2" value="{{ old('value') }}">
                            </div>
                        </div>

                        <div id="campoPeriodo" class="col-md-6 mb-3" style="display:none;">
                            <div class="form-check mb-4">
                                <label for="period" class="form-label">Período</label>
                                <select class="form-select" name="period" id="period">
                                    <option value="" >Selecione o período</option>
                                    <option value="month" >Mensal</option>
                                    <option value="year" >Anual</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="type" id="income" value="income" autocomplete="off" >
                            <label class="btn btn-outline-primary" for="income"><i class="fa-solid fa-circle-up"></i> Receita</label>

                            <input type="radio" class="btn-check" name="type" id="expense" value="expense" autocomplete="off">
                            <label class="btn btn-outline-danger" for="expense"><i class="fa-solid fa-circle-down"></i> Despesa</label>
                        </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addButton">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addModal -->

<!-- editModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" class="row g-3">
                @csrf

                <fieldset>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="edit_description" name="description" value="{{ old('description') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="edit_amount" name="amount" value="{{ old('amount') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="due_at" class="form-label">Vencimento</label>
                            <input type="date" class="form-control" id="edit_due_at" name="due_at" value="{{ old('due_at') }}">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wallet_id" class="form-label">Carteira</label>
                            <select class="form-select" name="wallet_id" id="edit_wallet_id">
                                
                                @foreach ($wallets as $wallet)
                                    @if ($wallet->main = '1')
                                    <option value="{{ $wallet->id }}" >{{ $wallet->name }}</option>
                                    @else
                                        <option value="" >Escolha um</option>
                                    @endif
                                    <option value="" >{{ $wallet->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="invoice_category_id" class="form-label">Categoria</label>
                            <select class="form-select" name="invoice_category_id" id="edit_invoice_category_id">
                                <option value="" >Escolha uma</option>
                                @foreach ($invoiceCategories as $invoiceCategory)
                                    <option value="{{ $invoiceCategory->id }}" >{{ $invoiceCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group col-md-6 mb-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="repeat_when" id="edit_unica" value="unique">
                            <label class="btn btn-sm btn-outline-dark" for="unica">Única</label>

                            <input type="radio" class="btn-check" name="repeat_when" id="edit_fixa" value="fixed">
                            <label class="btn btn-sm btn-outline-dark" for="fixa">Fixa</label>

                            <input type="radio" class="btn-check" name="repeat_when" id="edit_parcela" value="enrollment">
                            <label class="btn btn-sm btn-outline-dark" for="parcela">Parcelas</label>
                        </div>

                        <div id="editCampoParcela" class=" col-md-6 mb-3">
                            <div class="form-check form-check-inline mb-4">
                                <label for="enrollments" class="form-label">Parcelas</label>
                                <input type="number" disabled min="2" class="form-control" id="edit_enrollments" name="enrollments" placeholder="2" value="{{ old('value') }}">
                            </div>
                        </div>

                        <div id="editCampoPeriodo" class="col-md-6 mb-3" style="display:none;">
                            <div class="form-check mb-4">
                                <label for="period" class="form-label">Período</label>
                                <select class="form-select" name="period" id="edit_period">
                                    <option value="" >Selecione o período</option>
                                    <option value="month" >Mensal</option>
                                    <option value="year" >Anual</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="type" id="edit_income" value="income" autocomplete="off" >
                            <label class="btn btn-outline-primary" for="income"><i class="fa-solid fa-circle-up"></i> Receita</label>

                            <input type="radio" class="btn-check" name="type" id="edit_expense" value="expense" autocomplete="off">
                            <label class="btn btn-outline-danger" for="expense"><i class="fa-solid fa-circle-down"></i> Despesa</label>
                        </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="id" value="">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary editButton">Salvar Alterações <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim editModal -->

<!-- paymentModal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModal">Pagar ou Amortizar Conta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="paymentForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="pay_description" name="description" value="{{ old('description') }}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount_owed" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="pay_amount_owed" name="amount_owed" value="{{ old('amount_owed') }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="due_at" class="form-label">Vencimento</label>
                            <input type="date" class="form-control" id="pay_due_at" name="due_at" value="{{ old('due_at') }}" disabled>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wallet_id" class="form-label">Carteira</label>
                            <select class="form-select" name="wallet_id" id="pay_wallet_id">
                                
                                @foreach ($wallets as $wallet)
                                    @if ($wallet->main = '1')
                                    <option value="{{ $wallet->id }}" >{{ $wallet->name }}</option>
                                    @else
                                        <option value="" >Escolha um</option>
                                    @endif
                                    <option value="" >{{ $wallet->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pay_day" class="form-label">Data do Pagamento</label>
                            <input type="date" class="form-control" id="pay_pay_day" name="pay_day" value="{{ old('pay_day') }}">
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount_paid" class="form-label">Valor Pago</label>
                            <input type="text" class="form-control" id="pay_amount_paid" name="amount_paid" value="{{ old('amount_paid') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="enrollment_of" class="form-label">Parcela Nº</label>
                            <input type="number" class="form-control" id="pay_enrollment_of" name="enrollment_of" value="{{ old('enrollment_of') }}" readonly>
                        </div>
                    </div>
                    

                    <div class="col-md-12">
                        <label for="pay_day" class="form-label">Forma de Pagamento</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        
                        <div class="btn-group col-md-12 mb-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="method" id="pix" value="pix">
                            <label class="btn btn-sm btn-outline-dark" for="pix">PIX</label>

                            <input type="radio" class="btn-check" name="method" id="card" value="card">
                            <label class="btn btn-sm btn-outline-dark" for="card">Cartão</label>

                            <input type="radio" class="btn-check" name="method" id="money" value="money">
                            <label class="btn btn-sm btn-outline-dark" for="money">Dinheiro</label>

                            <input type="radio" class="btn-check" name="method" id="ted" value="ted">
                            <label class="btn btn-sm btn-outline-dark" for="ted">TED</label>

                            <input type="radio" class="btn-check" name="method" id="bank_slip" value="bank_slip">
                            <label class="btn btn-sm btn-outline-dark" for="bank_slip">Boleto</label>
                        </div>
                    </div>
                    

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="pay_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="pay_user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="pay_invoice_id" name="invoice_id" value="">                 
                    <input type="hidden" class="form-control" id="pay_status" name="status" value="paid">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addButton">Lançar Pagamento <i class="fa-solid fa-sack-dollar"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addModal -->


</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('invoices.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createModal').modal('hide');
                    if(response){
                        Swal.fire('Pronto!', response.success, 'success');
                    }
                    setTimeout(function() {
                        location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                    }, 2000); // 3000 milissegundos = 3 segundos
                },
                error: function(response) {
                    console.log(response.responseJSON);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });

        /**Atualiza registro no banco de dados*/
        /**Passa valores do registro para o formulário na modal de atualização */
        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Adiciona zero à esquerda se necessário
            const day = String(today.getDate()).padStart(2, '0'); // Adiciona zero à esquerda se necessário
            return `${year}-${month}-${day}`;
        }
        let hoje = getCurrentDate();
        //$('#pay_pay_day').val(getCurrentDate());
        $('button').on('click', function() {
            /**Verifica se o botão tem a classe condicional para fazer algo */
            if($(this).hasClass('editBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            description: $(this).attr('data-description'), 
                            wallet_id: $(this).attr('data-wallet_id'), 
                            user_id: $(this).attr('data-user_id'), 
                            company_id: $(this).attr('data-company_id'), 
                            invoice_category_id: $(this).attr('data-invoice_category_id'), 
                            invoice_of: $(this).attr('data-invoice_of'), 
                            type: $(this).attr('data-type'), 
                            amount: $(this).attr('data-amount'), 
                            due_at: $(this).attr('data-due_at'), 
                            //repeat_when: $(this).attr('data-repeat_when'), 
                            period: $(this).attr('data-period'), 
                            enrollments: $(this).attr('data-enrollments'), 
                            enrollment_of: $(this).attr('data-enrollment_of'), 
                            status: $(this).attr('data-status'), 
                        }

                    ];
                    editRegistro($(this).attr('data-id'));
            }else if($(this).hasClass('deleteBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                        }
                    ];
                    deleteRegistro($(this).attr('data-id'));
            }else if($(this).hasClass('paymentBtn')){
                
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            description: $(this).attr('data-description'), 
                            due_at: $(this).attr('data-due_at'), 
                            invoice_category_id: $(this).attr('data-invoice_category_id'), 

                            /**PaymentForm data */
                            wallet_id: $(this).attr('data-wallet_id'), 
                            user_id: $(this).attr('data-user_id'), 
                            company_id: $(this).attr('data-company_id'), 
                            amount_owed: $(this).attr('data-amount_owed'), 
                            enrollment_of: $(this).attr('data-enrollment_of'), 
                            status: $(this).attr('data-status'), 
                            pay_day: $(this).attr('data-pay_day', hoje), 
                            method: $(this).attr('data-method'), 

                        }
                    ];
                    //console.log(dados[0].enrollment_of);
                    pagarRegistro(dados);
            }
        });
            

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(id) {
            let url = "{{ route('invoices.show', 'id') }}";
            url = url.replace('id', id);
            //console.log(url);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                fetch(url)
                .then(response => {
                    if (!response.ok) {
                    throw new Error('Erro na rede: ' + response.statusText);
                    }
                    return response.json();
                    //console.log('Response: ' + response);
                })
                .then(data => {
                    //console.log(data.description);
                    //console.log(data[0]); //lista dados pessoais
                    /**console.log(data[0][0]['invoice']); //lista dados pessoais
                    /** console.log(data[0][0]); //Lista dados do endereço */
                    /**Dados pessoais*/
                    $('#edit_id').val(data.id);
                    $('#edit_description').val(data.description);
                    $('#edit_wallet_id').val(data.wallet_id);
                    $('#edit_user_id').val(data.user_id);
                    $('#edit_company_id').val(data.company_id);
                    $('#edit_invoice_category_id').val(data.invoice_category_id);
                    $('#edit_invoice_of').val(data.invoice_of);
                    $('#edit_amount').val(data.amount);
                    $('#edit_due_at').val(data.due_at);
                    $('#edit_period').val(data.period);
                    $('#edit_enrollments').val(data.enrollments);
                    $('#edit_enrollment_of').val(data.enrollment_of);
                    $('#edit_status').val(data.status);
                    /**Verifica repetição */
                    if(data.repeat_when === 'fixed'){
                        document.querySelector('#edit_fixa').checked = true;
                    }else if(data.repeat_when === 'unique'){
                        document.querySelector('#edit_unica').checked = true;
                    }else{
                        document.querySelector('#edit_parcela').checked = true;
                    }
                    /**Verifica Tipo */
                    if(data.type === 'income'){
                        document.querySelector('#edit_income').checked = true;
                    }else{
                        document.querySelector('#edit_expense').checked = true;
                    }

                    

                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                
                $('#updateModal').modal('show');
            });
            //console.log(url);
            

        }//Fim aditRegistro()

        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-invoice/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    //$('#invoicesTable').DataTable().ajax.reload();
                    //Swal.fire('Success', 'Registro atualizado com sucesso', 'success');
                    console.log(response);
                    if(response){
                        Swal.fire('Pronto!', response.success, 'success');
                    }
                    setTimeout(function() {
                        location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                    }, 2000); // 3000 milissegundos = 3 segundos
                },
                error: function(response) {
                    //Swal.fire('Error', 'ERRO ao atualizar registro', 'error');
                    console.log(response.responseJSON);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });


        /**Exibe pergunta se deseja realmente excluir o registro */
        function deleteRegistro(id) {
            Swal.fire({
                title: 'Deseja realmente excluir esse registro?',
                text: "Não será possível reverter essa operação posteriormente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim! Excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: `/destroy-invoice/${id}`,
                        method: 'DELETE',
                        success: function() {
                            //$('#invoicesTable').DataTable().ajax.reload();
                            Swal.fire('Pronto!', 'Registro excluído.', 'success');
                            setTimeout(function() {
                                location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                            }, 2000); // 3000 milissegundos = 3 segundos
                        },
                        error: function() {
                            Swal.fire('Erro!', 'ERRO ao excluir registro', 'error');
                        }
                    });
                }
            });
        }

        /**Função que preenche os campos do formulário de atualização */
        function pagarRegistro(dados) {
            let url = "{{ route('invoices.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            //console.log(url);
            //console.log(dados);
            /**Preenche os campos do form de atualização*/
            // Função para obter a data atual no formato YYYY-MM-DD
            
            $.get(url, function() {
                fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na rede: ' + response.statusText);
                    }
                    return response.json();
                    //console.log('Response: ' + response);
                })
                .then(data => {
                    //console.log(dados);
                    //console.log(data[0]); //lista dados pessoais
                    /**console.log(data[0][0]['invoice']); //lista dados pessoais
                    /** console.log(data[0][0]); //Lista dados do endereço */
                    /**Dados pessoais*/
                    $('#pay_invoice_id').val(dados[0].id);
                    $('#pay_description').val(dados[0].description);
                    $('#pay_wallet_id').val(dados[0].wallet_id);
                    $('#pay_user_id').val(dados[0].user_id);
                    $('#pay_company_id').val(dados[0].company_id);
                    $('#pay_invoice_category_id').val(dados[0].invoice_category_id);
                    $('#pay_amount_owed').val(dados[0].amount_owed),
                    $('#pay_amount_paid').val(dados[0].amount_owed),
                    $('#pay_due_at').val(dados[0].due_at);
                    //$('#pay_pay_day').val(dados[0].pay_day[0].attributes[11]);
                    $('#pay_pay_day').val(hoje);
                    $('#pay_enrollment_of').val(data.enrollment_of);
                    $('#pay_status').val(dados[0].status);
                    $('#method').val(dados[0].method);
                    //console.log(hoje);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                $('#paymentModal').modal('show');
            });
            //console.log(url);
            

        }//Fim pagarRegistro()

        /**Formulário para pagar fatura */
        $('#paymentForm').on('submit', function(e) {
            const paymentForm =document.querySelector('#paymentForm');
            const formData = new FormData(paymentForm);
            e.preventDefault();
            console.log(formData);
            var id = $('#edit_id').val();
            $.ajax({
                url: `/store-payment`,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    //$('#invoicesTable').DataTable().ajax.reload();
                    //Swal.fire('Success', 'Registro atualizado com sucesso', 'success');
                    console.log(response);
                    if(response){
                        Swal.fire('Pronto!', response.success, 'success');
                    }
                    setTimeout(function() {
                        location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                    }, 2000); // 3000 milissegundos = 3 segundos
                },
                error: function(response) {
                    //Swal.fire('Error', 'ERRO ao atualizar registro', 'error');
                    console.log(response.responseJSON);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });

        
    });

    
</script>

@endsection
   
