@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Perfil do usuário</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Perfil do usuário</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Alterar dados do usuário</span>
        </div><!--fim card-header-->

        <div class="card-body">

            <!-- Estrutura de Abas -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-dadosPessoais-tab" data-bs-toggle="pill" data-bs-target="#pills-dadosPessoais" type="button" role="tab" aria-controls="pills-dadosPessoais" aria-selected="true"><i class="fa-regular fa-user"></i> Dados Pessoais</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-password-tab" data-bs-toggle="pill" data-bs-target="#pills-password" type="button" role="tab" aria-controls="pills-password" aria-selected="false"><i class="fa-solid fa-key"></i> Senha</button>
                </li>
            </ul><!-- fim Estrutura de Abas -->

            <!-- Conteúdo das Abas -->
            <div class="tab-content" id="pills-tabContent">
                
                <!-- Dados Pessoais -->
                <div class="tab-pane fade show active" id="pills-dadosPessoais" role="tabpanel" aria-labelledby="pills-dadosPessoais-tab" tabindex="0">
                    <form id="updateProfileForm" name="updateProfileForm" class="row g-3">
                        @csrf
                        
                        <div class="col-md-12">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $theUser->name }}">
                            <span id="name_error" class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $theUser->email }}">
                            <span id="email_error" class="text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="999.999.999-99" value="{{ $theUser->cpf }}">
                            <span id="cpf_error" class="text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="(99) 99999-9999" value="{{ $theUser->phone }}">
                        </div>
                    
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $theUser->birthday }}">
                        </div>
                        
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                            <input type="hidden" class="form-control" id="edit_id" name="edit_id" value="{{ auth()->user()->id }}">                 
                            <input type="hidden" class="form-control" id="user_profile_id" name="user_profile_id" value="{{ $theUser->user_profile_id }}">                 
                        </div>

                        <button type="submit" class="btn btn-primary addBtn">Salvar Alterações <i class="fa-solid fa-paper-plane"></i></button>
                    </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
                </div><!-- fim Dados Pessoais -->
                
                <!-- Password -->
                <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab" tabindex="0">
                    <form id="passwordForm" name="passwordForm" class="row g-3">
                        @csrf
                        
                        <div class="col-md-6">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                        </div>
                        
                        <div class="col-md-6 mt-5">
                            <button type="submit" class="btn btn-primary addBtn">Alterar Senha</button>
                        </div>

                        
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                        </div>

                        
                    </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
                </div><!-- fim Documentos -->
                
            </div><!-- fim conteúdo das abas -->

        </div><!--fim card-body-->
    </div><!--fim card -->


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
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
                    //editProfile(dados);
            }
        });


        /**Formulário de atualização de registro */
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-profile`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
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



</div><!--fim container-fluid-->


@endsection
   
