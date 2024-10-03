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
                      <th>Cliente</th>
                      <th>Responsável</th>
                      <th>Status</th>
                      <th>Entrega</th>
                      <th>Tipo</th>
                      <th>Tribunal</th>
                      <th>Valor</th>
                      <th>Pagto</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($externalPetitions) > 0)
                        @foreach ($externalPetitions as $externalPetition)
                            <tr>
                            <td>{{ $externalPetition->customer_name }}</td>
                            <td>{{ $externalPetition->getResponsible($externalPetition->responsible)->name }}</td>
                            <td>{{ $externalPetition->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($externalPetition->delivery_date)->format('d/m/Y') }}</td>
                            <td>{{ $externalPetition->type }}</td>
                            <td>{{ $externalPetition->court }}</td>
                            <td>{{ 'R$' . number_format($externalPetition->amount, 2, ',', '.') }}</td>
                            <td>{{ $externalPetition->getPaymentStatus($externalPetition->payment_status) }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" 
                                        data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" ><i class="fa-solid fa-trash"></i></button>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Escritório Externo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="createForm" name="createForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                <div class="col-md-6">
                    <label for="name" class="form-label">Nome do Escritório</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    <span id="name_error" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    <span id="email_error" class="text-danger"></span>
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
            
                <div class="col-md-4">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj') }}">
                </div>
            
                <div class="col-md-4">
                    <label for="responsible" class="form-label">Responsável</label>
                    <input type="text" class="form-control" id="responsible" name="responsible" value="{{ old('responsible') }}">
                </div>
            

                <fieldset>
                    <legend>Dados Bancários</legend>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="agency" class="form-label">Agência</label>
                            <input type="text" class="form-control" id="agency" name="agency" value="{{ old('agency') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="current_account" class="form-label">Conta Corrente</label>
                            <input type="text" class="form-control" id="current_account" name="current_account" value="{{ old('current_account') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="bank" class="form-label">Banco</label>
                            <input type="text" class="form-control" id="bank" name="bank" value="{{ old('bank') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="pix" class="form-label">Chave PIX</label>
                            <input type="text" class="form-control" id="pix" name="pix" value="{{ old('pix') }}">
                        </div> 
                    </div>
                </fieldset>
                
                
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
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


</div><!--fim container-fluid-->

<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastra registro no banco de dadods */
        $('form[name="createForm"]').submit(function(event){
            event.preventDefault(); //não atualiza a página ao enviar os dados

            $.ajax({
                url: "{{ route('external-offices.store') }}",
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
                            name: $(this).attr('data-name'), 
                            email: $(this).attr('data-email'), 
                            responsible: $(this).attr('data-responsible'), 
                            phone: $(this).attr('data-phone'), 
                            cnpj: $(this).attr('data-cnpj'), 
                            agency: $(this).attr('data-agency'), 
                            current_account: $(this).attr('data-current_account'), 
                            bank: $(this).attr('data-bank'), 
                            pix: $(this).attr('data-pix'), 
                            company_id: $(this).attr('data-company_id'), 
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
            let url = "{{ route('external-offices.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                $('#edit_id').val(dados[0].id);
                $('#edit_name').val(dados[0].name);
                $('#edit_email').val(dados[0].email);
                $('#edit_responsible').val(dados[0].responsible);
                $('#edit_phone').val(dados[0].phone);
                $('#edit_cnpj').val(dados[0].cnpj);
                $('#edit_agency').val(dados[0].agency);
                $('#edit_current_account').val(dados[0].current_account);
                $('#edit_bank').val(dados[0].bank);
                $('#edit_pix').val(dados[0].pix);
                $('#edit_company_id').val(dados[0].company_id);
                $('#updateModal').modal('show');
            });
        }

        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-external-office/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    //$('#labelsTable').DataTable().ajax.reload();
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
                        url: `/destroy-external-office/${dados[0].id}`,
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
   
