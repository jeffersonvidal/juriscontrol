@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuários</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Usuários</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar todos os registros</span>

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
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
                                <td>{{ $user->cpf }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-user_profile_id="{{ $user->user_profile_id }}" data-company_id="{{ $user->company_id }}" data-phone="{{ $user->phone }}" data-cpf="{{ $user->cpf }}" data-birthday="{{ $user->birthday }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm passwordBtn" title="Alterar Senha" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-bs-toggle="modal" data-bs-target="#passwordModal"><i class="fa-solid fa-key"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>

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
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="addUserForm" name="addUserForm" class="row g-3">
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
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="999.999.999-99" value="{{ old('phone') }}">
                </div>
            
                <div class="col-md-6">
                    <label for="birthday" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                </div>
                
                
                <div class="col-md-6">
                    <label for="user_profile_id" class="form-label">Perfil do Usuário</label>
                    <select id="user_profile_id" name="user_profile_id" class="form-select">
                        <option>Informe o Perfil do Usuário</option>
                        <option value="1">Estagiário</option>
                        <option value="2">Advogado</option>
                        <option value="3">Financeiro</option>
                        <option value="4">Adminsitrador</option>
                        <option value="5">Escritório Externo</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="1">                 
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="editUserForm" name="editUserForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}">
                    <span id="name_error" class="text-danger"></span>
                </div>
                

                <div class="col-md-4">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="edit_cpf" name="cpf" placeholder="999.999.999-99" value="{{ old('cpf') }}">
                    <span id="cpf_error" class="text-danger"></span>
                </div>            

                <div class="col-md-4">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="edit_phone" name="phone" placeholder="(99) 99999-9999" value="{{ old('phone') }}">
                    <span id="phone_error" class="text-danger"></span>
                </div>
            
                <div class="col-md-4">
                    <label for="birthday" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="edit_birthday" name="birthday" value="{{ old('birthday') }}">
                    <span id="birthday_error" class="text-danger"></span>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit_email" name="email" value="{{ old('email') }}">
                    <span id="email_error" class="text-danger"></span>
                </div>
                
                
                <div class="col-md-6">
                    <label for="user_profile_id" class="form-label">Perfil do Usuário</label>
                    <select id="edit_user_profile_id" name="user_profile_id" class="form-select">
                        <option>Informe o Perfil do Usuário</option>
                        <option value="1">Estagiário</option>
                        <option value="2">Advogado</option>
                        <option value="3">Financeiro</option>
                        <option value="4">Adminsitrador</option>
                        <option value="5">Escritório Externo</option>
                    </select>
                    <span id="user_profile_id_error" class="text-danger"></span>
                </div>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id">            
                    <input type="hidden" class="form-control" id="edit_user_id" name="id">            
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

<!-- deleteModal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Deletar Usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        <h3>Você deseja realmente excluir o registro <span class="user_name"></span>?</h3>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-danger deleteModalButton">Excluir <i class="fa-solid fa-trash"></i></button>
      </div><!--fim modal-footer-->
      
    </div>
  </div>
</div><!-- fim deleteModal -->


</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Create */
        $('form[name="addUserForm"]').submit(function(event){
            event.preventDefault(); //não atualiza a página ao enviar os dados

            $.ajax({
                url: "{{ route('users.store') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('.addBtn').prop('disabled', true);
                },
                complete:function(){
                    $('.addBtn').prop('disabled', false);
                },
                // success: function(response){
                //     console.log(response);
                // }
                success: function(response){
                    if(response.success == true){
                        $('#addModal').hide();
                        printSuccessMsg(response.msg);

                        let reloadInterval = 200; //page reload delay
                        //Function reload page
                        function reloadPage(){
                            location.reload(true); //passa tru para forçar o recarregamento da página
                        }

                        //Especifica o tempo para recarregar página
                        let intervalId =setInterval(reloadPage, reloadInterval);
                    }else if(response.success == false){
                        printErrorMsg(response.msg);
                    }else{
                        printValidationErrorMsg(response.msg);
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

        /** Update */
        //Botão editBtn que abre a modal para editar registro
        $('.editBtn').on('click', function(){
            //Pega os valores dos campos vindos do BD para alimentar o formulário
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');
            let email = $(this).attr('data-email');
            let company_id = $(this).attr('data-company_id');
            let user_profile_id = $(this).attr('data-user_profile_id');
            let phone = $(this).attr('data-phone');
            let cpf = $(this).attr('data-cpf');
            let birthday = $(this).attr('data-birthday');
            //let data_brasileira = user_birthday.split('-').reverse().join('/');

            //Mostra os valores vindos do BD no form da modal
            $('#edit_user_id').val(id);
            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_company_id').val(company_id);
            $('#edit_user_profile_id').val(user_profile_id);
            $('#edit_phone').val(phone);
            $('#edit_cpf').val(cpf);
            $('#edit_birthday').val(birthday);

            let url = "{{ route('users.update', 'user_id') }}";
            url = url.replace('user_id', id);

            //Botão do formulário que envia requisição para salvar alterações do BD
            $('form[name="editUserForm"]').submit(function(event){
                event.preventDefault(); //não atualiza a página ao enviar os dados

                $.ajax({
                    url: url,
                    //type: "get",
                    data: $(this).serialize(),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('.editButton').prop('disabled', true);
                    },
                    complete:function(){
                        $('.editButton').prop('disabled', false);
                    },
                    success: function(response){   
                        console.log(response.msg);
                        if(response.success == true){
                            $('#editModal').hide();
                            printSuccessMsg(response.msg);
                            location.reload();

                            // let reloadInterval = 200; //page reload delay
                            // //Function reload page
                            // function reloadPage(){
                            //     location.reload(true); //passa tru para forçar o recarregamento da página
                            // }

                            //Especifica o tempo para recarregar página
                            //let intervalId =setInterval(reloadPage, reloadInterval);
                        }else if(response.success == false){
                            printErrorMsg(response.msg);
                        }else{
                            printValidationErrorMsg(response.msg);
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

            
        });

        /** Delete */
        //Botão de deletar que chama modal
        $('.deleteBtn').on('click', function(){
            let user_id = $(this).attr('data-id'); //pega id do registro a ser deletado
            let user_name = $(this).attr('data-name'); //pega name do registro a ser deletado

            //Passa o nome para modal
            $('.user_name').html('');
            $('.user_name').html(user_name);
            
            //Botão de confirmar deletar registro da modal
            $('.deleteModalButton').on('click', function(){
                let url = "{{ route('users.destroy', 'user_id') }}";
                url = url.replace('user_id', user_id);
                //console.log(url);
                $.ajax({
                    url: url,
                    type: "get",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend:function(){
                        $('.deleteModalButton').prop('disabled', true);
                    },
                    complete:function(){
                        $('.deleteModalButton').prop('disabled', false);
                    },
                    // success: function(response){
                    //     console.log(response);
                    // }
                    success: function(response){
                        if(response.success == true){
                            console.log(response.msg);
                            $('#deleteModal').hide();
                            printSuccessMsg(response.msg);

                            //window.location.reload();

                            let reloadInterval = 200; //page reload delay
                            //Function reload page
                            function reloadPage(){
                                location.reload(true); //passa tru para forçar o recarregamento da página
                            }

                            let intervalId = setInterval(reloadPage, reloadInterval);
                            
                        }else{
                            printErrorMsg(respsonse.msg);
                        }
                        
                    }
                });

                /**Mensagens do sistema */
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
        });
        
    });
    
</script>

@endsection
   
