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
            <span>Listar</span>

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
                                <td>{{ $user->birthday }}</td>
                                <td>
                                <span class="d-flex flex-row justify-content-center">
                                    <a href="" class="text-decoration-none btn btn-sm" title="Alterar Registro"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="" class="text-decoration-none btn btn-sm text-danger" title="Excluir Registro"><i class="fa-solid fa-trash"></i></a>
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
                    <label for="company_id" class="form-label">Escritório</label>
                    <input disabled type="text" class="form-control" value="">
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
</div>


</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
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
                    $('#addModal').hide();
                    location.reload();
                    if(response.success == true){
                        console.log(response);
                    }
                }
            });
        });
    });
    
</script>

@endsection
   
