@extends('layouts.admin')

@section('content')

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
                        <div class="card-header text-bg-success p-3 row align-items-end">
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
                        <div class="card-header p-3 row align-items-end">
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
                        <th>Parcela</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($invoices) > 0)
                        @foreach ($invoices as $invoice)
                            <tr>
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $invoice->getCategory($invoice->invoice_category_id) }}</td>
                            <td>{{ $invoice->getType($invoice->type) }}</td>
                            <td>{{ 'R$' . number_format($invoice->amount, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">{{ $invoice->enrollment_of }} / {{ $invoice->getEnrollments($invoice->description, $invoice->type) }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_at)->format('d/m/Y') }}</td>
                            <td>{{ $invoice->getStatus($invoice->status) }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" class="btn btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>

                                        <button class="text-decoration-none btn btn-sm " title="Novo Processo" data-id="{{ $invoice->id }}" >
                                            <i class="fa-regular fa-file-lines"></i></button>
                                        <button class="text-decoration-none btn btn-sm " title="Novo Caso" data-id="{{ $invoice->id }}" >
                                            <i class="fa-solid fa-book"></i></button>
                                        <button class="text-decoration-none btn btn-sm " title="Novo Endereço" data-id="{{ $invoice->id }}" >
                                            <i class="fa-solid fa-earth-americas"></i></button>
                                        <button class="text-decoration-none btn btn-sm " title="Timesheet - Atividades" data-id="" >
                                        <i class="fa-regular fa-clock"></i></button>
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $invoice->id }}" 
                                            data-description="{{ $invoice->description }}" data-wallet_id="{{ $invoice->wallet_id }}" data-id="{{ $invoice->id }}"
                                            data-invoice_category_id="{{ $invoice->invoice_category_id }}" data-invoice_of="{{ $invoice->invoice_of }}" data-type="{{ $invoice->type }}"
                                            data-amount="{{ $invoice->amount }}" data-due_at="{{ $invoice->due_at }}" data-repeat_when="{{ $invoice->repeat_when }}"
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
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModa" aria-hidden="true">
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
                            <label for="due_at" class="form-label">Vencimento</label>
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
                                    <option value="{{ $invoiceCategory->id }}" >{{ $invoiceCategory->name }}</option>
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
                            <label class="btn btn-outline-success" for="income"><i class="fa-solid fa-circle-up"></i> Receita</label>

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
  <div class="modal-dialog modal-xl">
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
                                <option value="" >Escolha um</option>
                                <option value="" >Teste</option>
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

                        <div id="campoParcela" class=" col-md-6 mb-3">
                            <div class="form-check form-check-inline mb-4">
                                <label for="enrollments" class="form-label">Parcelas</label>
                                <input type="number" disabled min="2" class="form-control" id="edit_enrollments" name="enrollments" placeholder="2" value="{{ old('value') }}">
                            </div>
                        </div>

                        <div id="campoPeriodo" class="col-md-6 mb-3" style="display:none;">
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
                            <label class="btn btn-outline-success" for="income"><i class="fa-solid fa-circle-up"></i> Receita</label>

                            <input type="radio" class="btn-check" name="type" id="edit_expense" value="expense" autocomplete="off">
                            <label class="btn btn-outline-danger" for="expense"><i class="fa-solid fa-circle-down"></i> Despesa</label>
                        </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="edit_invoice_id" name="id" value="">                 
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
        $('button').on('click', function() {
            /**Verifica se o botão tem a classe condicional para fazer algo */
            // ['company_id', 'name','email','phone','rg',
            // 'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday'];
            if($(this).hasClass('editBtn')){
                // var dados = [
                //         { 
                //             id: $(this).attr('data-id'), 
                //             name: $(this).attr('data-name'), 
                //             email: $(this).attr('data-email'), 
                //             phone: $(this).attr('data-phone'), 
                //             rg: $(this).attr('data-rg'), 
                //             rg_expedidor: $(this).attr('data-rg_expedidor'), 
                //             cpf: $(this).attr('data-cpf'), 
                //             marital_status: $(this).attr('data-marital_status'), 
                //             nationality: $(this).attr('data-nationality'), 
                //             profession: $(this).attr('data-profession'), 
                //             birthday: $(this).attr('data-birthday'), 
                //             zipcode: $(this).attr('data-zipcode'), 
                //             street: $(this).attr('data-street'), 
                //             num: $(this).attr('data-num'), 
                //             complement: $(this).attr('data-complement'), 
                //             neighborhood: $(this).attr('data-neighborhood'), 
                //             city: $(this).attr('data-city'), 
                //             state: $(this).attr('data-state'), 
                //         }
                //     ];
                    editRegistro($(this).attr('data-id'));
            }else if($(this).hasClass('deleteBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                        }
                    ];
                    deleteRegistro($(this).attr('data-id'));
            }
        });
            

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(id) {
            let url = "{{ route('invoices.show', 'id') }}";
            url = url.replace('id', id);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                fetch(url)
                .then(response => {
                    if (!response.ok) {
                    throw new Error('Erro na rede: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    /**console.log(data[0][0]['invoice']); //lista dados pessoais
                     ** console.log(data[0][0]); //Lista dados do endereço */
                    /**Dados pessoais*/
                    $('#edit_id').val(data[0][0]['invoice'].id);
                    $('#edit_name').val(data[0][0]['invoice'].name);
                    $('#edit_email').val(data[0][0]['invoice'].email);
                    $('#edit_phone').val(data[0][0]['invoice'].phone);
                    $('#edit_rg').val(data[0][0]['invoice'].rg);
                    $('#edit_rg_expedidor').val(data[0][0]['invoice'].rg_expedidor);
                    $('#edit_cpf').val(data[0][0]['invoice'].cpf);
                    $('#edit_marital_status').val(data[0][0]['invoice'].marital_status);
                    $('#edit_nationality').val(data[0][0]['invoice'].nationality);
                    $('#edit_profession').val(data[0][0]['invoice'].profession);
                    $('#edit_birthday').val(data[0][0]['invoice'].birthday);
                    $('#edit_met_us').val(data[0][0]['invoice'].met_us);

                    /**Endereço*/
                    $('#edit_cep').val(data[0][0].zipcode);
                    $('#edit_street').val(data[0][0].street);
                    $('#edit_num').val(data[0][0].num);
                    $('#edit_complement').val(data[0][0].complement);
                    $('#edit_neighborhood').val(data[0][0].neighborhood);
                    $('#edit_city').val(data[0][0].city);
                    $('#edit_state').val(data[0][0].state);
                    $('#edit_invoice_id').val(data[0][0].invoice_id);
                    $('#edit_address_id').val(data[0][0].id);
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
                    //console.log(response);
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

        
    });

    /**ViaCEP - Cadastro*/
    function limpa_formulário_cep() {
        //Limpa valores do formulário de Create.
        document.getElementById('street').value=("");
        document.getElementById('neighborhood').value=("");
        document.getElementById('city').value=("");
        document.getElementById('stateUF').value=("");
        
        //Limpa valores do formulário de Update.
        document.getElementById('edit_street').value=("");
        document.getElementById('edit_neighborhood').value=("");
        document.getElementById('edit_city').value=("");
        document.getElementById('edit_state').value=("");
        //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores no form Create.
            document.getElementById('street').value=(conteudo.logradouro);
            document.getElementById('neighborhood').value=(conteudo.bairro);
            document.getElementById('city').value=(conteudo.localidade);
            document.getElementById('stateUF').value=(conteudo.uf);

            //Atualiza os campos com os valores no form Update.
            document.getElementById('edit_street').value=(conteudo.logradouro);
            document.getElementById('edit_neighborhood').value=(conteudo.bairro);
            document.getElementById('edit_city').value=(conteudo.localidade);
            document.getElementById('edit_state').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice - form Create.
                document.getElementById('street').value="...";
                document.getElementById('neighborhood').value="...";
                document.getElementById('city').value="...";
                document.getElementById('stateUF').value="...";

                //Preenche os campos com "..." enquanto consulta webservice - form Update.
                document.getElementById('edit_street').value="...";
                document.getElementById('edit_neighborhood').value="...";
                document.getElementById('edit_city').value="...";
                document.getElementById('edit_state').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido. Digite apenas números");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };//Fim via cep

    
</script>

@endsection
   
