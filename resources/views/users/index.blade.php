@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuários</h2>

        <ol class="breadcrumb mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Usuários</li>
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
            <span class="alert alert-success" id="alert-success" style="display:none;"></span>
            <span class="alert alert-danger" id="alert-danger" style="display:none;"></span>
            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Perfil</th>
                    <th scope="col">Data Nasc.</th>
                    <th class="d-flex flex-row justify-content-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($allUsers) > 0)
                        @foreach ($allUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="cpf">{{ $user->cpf }}</span></td>
                                <td><span class="phone">{{ $user->phone }}</span></td>
                                <td>{{ $user->user_profile_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $user->id }}" 
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-user_profile_id="{{ $user->user_profile_id }}" 
                                        data-company_id="{{ $user->company_id }}" data-phone="{{ $user->phone }}" data-cpf="{{ $user->cpf }}" 
                                        data-birthday="{{ $user->birthday }}" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        
                                        <button class="text-decoration-none btn btn-sm passwordBtn" title="Alterar Senha" data-id="{{ $user->id }}" 
                                        data-name="{{ $user->name }}" data-bs-toggle="modal" data-bs-target="#passwordModal"><i class="fa-solid fa-key"></i></button>

                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" 
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}" ><i class="fa-solid fa-trash"></i></button>

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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="createForm" name="createForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    <span id="name_error" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    <span id="email_error" class="text-danger"></span>
                </div>

                <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="999.999.999-99" value="{{ old('cpf') }}">
                    <span id="cpf_error" class="text-danger"></span>
                </div>
            
                <div class="col-md-6">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="(99) 99999-9999" value="{{ old('phone') }}">
                </div>
            
                <div class="col-md-6">
                    <label for="birthday" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                </div>
                
                
                <div class="col-md-6">
                    <label for="user_profile_id" class="form-label">Perfil do Usuário</label>
                    <select id="user_profile_id" name="user_profile_id" class="form-select">
                        <option disabled>Informe o Perfil do Usuário</option>
                        <option value="1">Estagiário</option>
                        <option value="2">Advogado</option>
                        <option value="3">Financeiro</option>
                        <option value="4">Adminsitrador</option>
                        <option value="5">Escritório Externo</option>
                    </select>
                </div>
                
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

<!-- editModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" name="updateForm" class="row g-3">
                @csrf

                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}">
                </div>
                

                <div class="col-md-4">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="edit_cpf" name="cpf" placeholder="999.999.999-99" value="{{ old('cpf') }}">
                </div>            

                <div class="col-md-4">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="edit_phone" name="phone" placeholder="(99) 99999-9999" value="{{ old('phone') }}">
                </div>
            
                <div class="col-md-4">
                    <label for="birthday" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="edit_birthday" name="birthday" value="{{ old('birthday') }}">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit_email" name="email" value="{{ old('email') }}">
                </div>
                
                
                <div class="col-md-6">
                    <label for="user_profile_id" class="form-label">Perfil do Usuário</label>
                    <select id="edit_user_profile_id" name="user_profile_id" class="form-select">
                        <option disabled>Informe o Perfil do Usuário</option>
                        <option value="1">Estagiário</option>
                        <option value="2">Advogado</option>
                        <option value="3">Financeiro</option>
                        <option value="4">Adminsitrador</option>
                        <option value="5">Escritório Externo</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id">            
                    <input type="hidden" class="form-control" id="edit_id" name="id">            
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
        /** Cadastra registro no banco de dadods */
        $('form[name="createForm"]').submit(function(event){
            event.preventDefault(); //não atualiza a página ao enviar os dados

            $.ajax({
                url: "{{ route('users.store') }}",
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
                            cpf: $(this).attr('data-cpf'), 
                            phone: $(this).attr('data-phone'), 
                            birthday: $(this).attr('data-birthday'), 
                            company_id: $(this).attr('data-company_id'), 
                            user_profile_id: $(this).attr('data-user_profile_id'), 
                        }
                    ];
                    editLabel(dados);
            }else if($(this).hasClass('deleteBtn')){
                var dados = [{ id: $(this).attr('data-id'), }];
                    deleteLabel(dados);
            }
        });

        /**Função que preenche os campos do formulário de atualização */
        function editLabel(dados) {
            let url = "{{ route('users.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                $('#edit_id').val(dados[0].id);
                $('#edit_name').val(dados[0].name);
                $('#edit_email').val(dados[0].email);
                $('#edit_cpf').val(dados[0].cpf);
                $('#edit_phone').val(dados[0].phone);
                $('#edit_birthday').val(dados[0].birthday);
                $('#edit_company_id').val(dados[0].company_id);
                $('#edit_user_profile_id').val(dados[0].user_profile_id);
                $('#updateModal').modal('show');
            });
        }

        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-user/${id}`,
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
        function deleteLabel(dados) {
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
                        url: `/destroy-user/${dados[0].id}`,
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
   
