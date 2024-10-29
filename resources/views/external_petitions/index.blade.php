@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Petições de Parceiros</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Petições de Parceiros</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar todos os registros</span>

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover">
            <thead>
                    <tr>
                      <th>Escritório</th>
                      <th>Cliente</th>
                      <th>Responsável</th>
                      <th>Status</th>
                      <th>Entrega</th>
                      <th>Tipo</th>
                      <th>Tribunal</th>
                      <th>Valor</th>
                      <th>Pagto</th>
                      <th>Situação</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($externalPetitions) > 0)
                        @foreach ($externalPetitions as $externalPetition)
                            <tr>
                            <td>{{ $externalPetition->getExternalOffice($externalPetition->external_office_id)->name }}</td>
                            <td>{{ $externalPetition->customer_name }}</td>
                            <td>{{ $externalPetition->getResponsible($externalPetition->responsible)->name }}</td>
                            <td>{{ $externalPetition->getStatusPetition($externalPetition->id) }}</td>
                            <td>{{ \Carbon\Carbon::parse($externalPetition->delivery_date)->format('d/m/Y') }}</td>
                            <td>{{ $externalPetition->getTypePetition($externalPetition->type)->name }}</td>
                            <td>{{ $externalPetition->court }}</td>
                            <td>{{ 'R$' . number_format($externalPetition->amount, 2, ',', '.') }}</td>
                            <td>{{ $externalPetition->getPaymentStatus($externalPetition->payment_status) }}</td>
                            <td>
                                @php
                                    $isToday = \Carbon\Carbon::now()->format('Y-m-d');
                                    if($externalPetition->status <> 'completed' AND $externalPetition->delivery_date < $isToday){
                                        echo "<span class='badge text-bg-warning'>Atrasada</span>";
                                    }else{
                                        echo 'No Prazo';
                                    }
                                @endphp
                            </td>
                            <td>
                                <span class="d-flex flex-row justify-content-center">
                                    <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $externalPetition->id }}"
                                    data-wallet_id="{{ $externalPetition->wallet_id }}" data-user_id="{{ $externalPetition->user_id }}" data-company_id="{{ $externalPetition->company_id }}" 
                                    data-external_office_id="{{ $externalPetition->external_office_id }}" data-responsible="{{ $externalPetition->responsible }}" data-delivery_date="{{ $externalPetition->delivery_date }}" 
                                    data-type="{{ $externalPetition->type }}" data-customer_name="{{ $externalPetition->customer_name }}" data-process_number="{{ $externalPetition->process_number }}" 
                                    data-court="{{ $externalPetition->court }}" data-notes="{{ $externalPetition->notes }}" data-amount="{{ $externalPetition->amount }}" 
                                    data-status="{{ $externalPetition->status }}" data-payment_status="{{ $externalPetition->payment_status }}" data-delivery_date="{{ $externalPetition->delivery_date }}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                    <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $externalPetition->id }}"><i class="fa-solid fa-trash"></i></button>
                                </span>
                            </td>
                            </tr>
                        @endforeach
                    @else
                        <tr colspan="5">Nenhum registro encontrado</tr>
                    @endif
                    

                    
                </tbody>
            </table>
        </div><!--fim card-body-->
    </div><!--fim card -->

<!-- addModal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Petição de Parceiros</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="createForm" name="createForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                <div class="col-md-4 mb-3">
                    <label for="external_office_id" class="form-label">Escritório</label>
                    <select class="form-select" name="external_office_id" id="external_office_id">
                        <option value="" >Escolha um</option>
                        @foreach ($externalOffices as $externalOffice)
                            <option value="{{ $externalOffice->id }}" >{{ $externalOffice->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="wallet_id" class="form-label">Carteira</label>
                    <select class="form-select" name="wallet_id" id="wallet_id">
                        <option value="" >Escolha uma</option>
                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}" >{{ $wallet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="responsible" class="form-label">Responsável</label>
                    <select class="form-select" name="responsible" id="responsible">
                        <option value="" >Escolha um</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" >{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <div class="col-md-5">
                    <label for="customer_name" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                </div>
            
                <div class="col-md-3 mb-3">
                    <label for="delivery_date" class="form-label">Data de Entrega</label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select class="form-select" name="type" id="type">
                        <option value="" >Escolha um</option>
                        @foreach ($typePetitions as $typePetition)
                            <option value="{{ $typePetition->id }}" >{{ $typePetition->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-md-6">
                    <label for="process_number" class="form-label">Processo</label>
                    <input type="text" class="form-control" id="process_number" name="process_number" value="{{ old('process_number') }}">
                </div>
            
                <div class="col-md-3">
                    <label for="court" class="form-label">Tribunal</label>
                    <input type="text" class="form-control" id="court" name="court" value="{{ old('court') }}">
                </div>
            
                <div class="col-md-3">
                    <label for="amount" class="form-label">Valor Cobrado</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                </div>
                <div class="col-md-12">
                    <label for="notes" class="form-label">Observações</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                
                
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addBtn">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addModal -->

<!-- updateModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Petição de Parceiros</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" name="updateForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                <div class="col-md-4 mb-3">
                    <label for="external_office_id" class="form-label">Escritório</label>
                    <select class="form-select" name="external_office_id" id="edit_external_office_id">
                        <option value="" >Escolha um</option>
                        @foreach ($externalOffices as $externalOffice)
                            <option value="{{ $externalOffice->id }}" >{{ $externalOffice->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="wallet_id" class="form-label">Carteira</label>
                    <select class="form-select" name="wallet_id" id="edit_wallet_id">
                        <option value="" >Escolha uma</option>
                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}" >{{ $wallet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="responsible" class="form-label">Responsável</label>
                    <select class="form-select" name="responsible" id="edit_responsible">
                        <option value="" >Escolha um</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" >{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <div class="col-md-5">
                    <label for="customer_name" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="edit_customer_name" name="customer_name" value="{{ old('customer_name') }}">
                </div>
            
                <div class="col-md-3 mb-3">
                    <label for="delivery_date" class="form-label">Data de Entrega</label>
                    <input type="date" class="form-control" id="edit_delivery_date" name="delivery_date" value="{{ old('delivery_date') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select class="form-select" name="type" id="edit_type">
                        <option value="" >Escolha um</option>
                        @foreach ($typePetitions as $typePetition)
                            <option value="{{ $typePetition->id }}" >{{ $typePetition->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-md-3">
                    <label for="process_number" class="form-label">Processo</label>
                    <input type="text" class="form-control" id="edit_process_number" name="process_number" value="{{ old('process_number') }}">
                </div>
            
                <div class="col-md-2">
                    <label for="court" class="form-label">Tribunal</label>
                    <input type="text" class="form-control" id="edit_court" name="court" value="{{ old('court') }}">
                </div>
            
                <div class="col-md-2">
                    <label for="amount" class="form-label">Valor Cobrado</label>
                    <input type="text" class="form-control" id="edit_amount" name="amount" value="{{ old('amount') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="payment_status" class="form-label">Pagamento</label>
                    <select class="form-select" name="payment_status" id="edit_payment_status">
                        <option value="" >Escolha um</option>
                        <option value="paid" >Pagou</option>
                        <option value="unpaid" >Não Pagou</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="edit_status">
                        <option value="" >Escolha um</option>
                        <option value="started" >Iniciada</option>
                        <option value="in_progress" >Em Andamento</option>
                        <option value="completed" >Concluído</option>
                    </select>
                </div>

                <div class="paymentMethod" style="display:none;">
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
                </div><!--end paymentMethod-->

                <div class="col-md-12">
                    <label for="notes" class="form-label">Observações</label>
                    <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                </div>
                
                
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="id" value="">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addBtn">Salvar alterações <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim updateModal -->


</div><!--fim container-fluid-->

<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastra registro no banco de dadods */
        $('form[name="createForm"]').submit(function(event){
            event.preventDefault(); //não atualiza a página ao enviar os dados

            $.ajax({
                url: "{{ route('external-petitions.store') }}",
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
                    //console.log(response.responseJSON);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });

            /**Mensagens do sistema */
            //Exibe mensagens abaixo dos campos obrigatórios, validação de campos
            function printValidationErrorMsg(msg){
                $.each(msg, function(field_name, error){
                    $(document).find('#'+field_name+'_error').text(error);
                });
            }
            //Exibe mensagem de erro do sistema
            function printErrorMsg(msg){
                $('#alert-danger').html('');
                $('#alert-danger').css('display','block');
                $('#alert-danger').append(''+msg+'');
            }
            //Mostra mensagem de sucesso
            function printSuccessMsg(msg){
                $('#alert-success').html('');
                $('#alert-success').css('display','block');
                $('#alert-success').append(''+msg+'');
            }
        });

        /**Atualiza registro no banco de dados*/
        /**Passa valores do registro para o formulário na modal de atualização */
        $('button').on('click', function() {
            /**Verifica se o botão tem a classe condicional para fazer algo */
            if($(this).hasClass('editBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            customer_name: $(this).attr('data-customer_name'), 
                            wallet_id: $(this).attr('data-wallet_id'), 
                            user_id: $(this).attr('data-user_id'), 
                            company_id: $(this).attr('data-company_id'), 
                            status: $(this).attr('data-status'), 
                            external_office_id: $(this).attr('data-external_office_id'), 
                            responsible: $(this).attr('data-responsible'), 
                            type: $(this).attr('data-type'), 
                            delivery_date: $(this).attr('data-delivery_date'), 
                            process_number: $(this).attr('data-process_number'), 
                            court: $(this).attr('data-court'), 
                            notes: $(this).attr('data-notes'), 
                            amount: $(this).attr('data-amount'), 
                            payment_status: $(this).attr('data-payment_status'), 
                        }
                    ];
                    editRegistro(dados);
            }else if($(this).hasClass('deleteBtn')){
                var dados = [{ id: $(this).attr('data-id'), }];
                    deleteRegistro(dados);
            }
        });

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(dados) {
            let url = "{{ route('external-petitions.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            //console.log(url);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                $('#edit_id').val(dados[0].id);
                $('#edit_customer_name').val(dados[0].customer_name);
                $('#edit_wallet_id').val(dados[0].wallet_id);
                $('#edit_user_id').val(dados[0].user_id);
                $('#edit_company_id').val(dados[0].company_id);
                $('#edit_status').val(dados[0].status);
                $('#edit_external_office_id').val(dados[0].external_office_id);
                $('#edit_responsible').val(dados[0].responsible);
                $('#edit_type').val(dados[0].type);
                $('#edit_delivery_date').val(dados[0].delivery_date);
                $('#edit_process_number').val(dados[0].process_number);
                $('#edit_court').val(dados[0].court);
                $('#edit_notes').val(dados[0].notes);
                $('#edit_amount').val(dados[0].amount);
                $('#edit_payment_status').val(dados[0].payment_status);
                $('#updateModal').modal('show');
            });
            //console.log(dados);
        }

        
        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-external-petition/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    //$('#labelsTable').DataTable().ajax.reload();
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
                    //console.log(response.responseJSON);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });

        /** Delete */
        /**Exibe pergunta se deseja realmente excluir o registro */
        function deleteRegistro(dados) {
            Swal.fire({
                title: 'Você tem certeza que deseja excluir esse registro?',
                text: "Você não poderá reverter essa operação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: `/destroy-external-petition/${dados[0].id}`,
                        method: 'DELETE',
                        success: function() {
                            //$('#labelsTable').DataTable().ajax.reload();
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
    
</script>

@endsection
   
