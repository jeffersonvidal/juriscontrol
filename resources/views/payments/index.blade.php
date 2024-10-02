@extends('layouts.admin')

@section('content')
<style>
    .btn-check {
        pointer-events: auto; /* Garante que os radio buttons sejam clicáveis */
    }
</style>


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Pagamentos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pagamentos</li>
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
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            
            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>
                <!-- //     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
                // amount_owed, amount_paid, pay_day, amount_remaining, status -->
                        <tr>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Valor Pago</th>
                        <th>Valor Restante</th>
                        <th>Pago Via</th>
                        <th>Parcela</th>
                        <th>Vencimento</th>
                        <th>Data Pagto</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($payments) > 0)
                        @foreach ($payments as $payment)
                            <tr>
                            <td>{{ $payment->getInvoice($payment->invoice_id)->description }}</td>
                            <td>{{ $payment->getInvoiceType($payment->invoice_id) }}</td>
                            <td>{{ 'R$' . number_format($payment->amount_owed, 2, ',', '.') }}</td>
                            <td>{{ 'R$' . number_format($payment->amount_paid, 2, ',', '.') }}</td>
                            <td>{{ 'R$' . number_format($payment->amount_remaining, 2, ',', '.') }}</td>
                            <td>{{ $payment->getMethodPayment($payment->id) }}</td>
                            <td>{{ $payment->enrollment_of }} / {{ $payment->getInvoice($payment->invoice_id)->enrollments }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->getInvoice($payment->invoice_id)->due_at)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pay_day)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        
                                        <button class="text-decoration-none btn btn-sm paymentBtn" title="Dar Baixa / Pagar" 
                                        
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="fa-solid fa-money-bill-1-wave"></i></button>
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro"  
                                            
                                            data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro"  
                                             ><i class="fa-solid fa-trash"></i></button>
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
                    pagarRegistro($(this).attr('data-id'));
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
        function pagarRegistro(id) {
            let url = "{{ route('invoices.show', 'id') }}";
            url = url.replace('id', id);
            console.log(url);
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
                    $('#invoice_id').val(data.id);
                    $('#pay_description').val(data.description);
                    $('#pay_wallet_id').val(data.wallet_id);
                    $('#pay_user_id').val(data.user_id);
                    $('#pay_company_id').val(data.company_id);
                    $('#pay_invoice_category_id').val(data.invoice_category_id);
                    $('#pay_invoice_of').val(data.invoice_of);
                    $('#pay_amount').val(data.amount);
                    $('#pay_amount_owed').val(data.amount);
                    $('#pay_due_at').val(data.due_at);
                    $('#pay_period').val(data.period);
                    $('#pay_enrollments').val(data.enrollments);
                    $('#pay_enrollment_of').val(data.enrollment_of);
                    $('#pay_status').val(data.status);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                
                $('#paymentModal').modal('show');
            });
            //console.log(url);
            

        }//Fim pagarRegistro()

        
    });

    
</script>

@endsection
   
