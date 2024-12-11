@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Permissões de Acesso do Sistema</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Permissões de Acesso do Sistema</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Gestão de permissão de acesso ao sistema</span>
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            <!-- Estrutura de Abas -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-accessLevels-tab" data-bs-toggle="pill" data-bs-target="#pills-accessLevels" type="button" role="tab" aria-controls="pills-accessLevels" aria-selected="false"><i class="fa-solid fa-file-signature"></i> Níveis de Acesso</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-permissions-tab" data-bs-toggle="pill" data-bs-target="#pills-permissions" type="button" role="tab" aria-controls="pills-permissions" aria-selected="true"><i class="fa-regular fa-user"></i> Permissões</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-processos-tab" data-bs-toggle="pill" data-bs-target="#pills-processos" type="button" role="tab" aria-controls="pills-processos" aria-selected="false"><i class="fa-regular fa-file-lines"></i> Processos</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-consultivos-tab" data-bs-toggle="pill" data-bs-target="#pills-consultivos" type="button" role="tab" aria-controls="pills-consultivos" aria-selected="false"><i class="fa-solid fa-book"></i> Casos e Consultivos</button>
                </li> --}}
            </ul><!-- fim Estrutura de Abas -->


            <!-- Conteúdo das Abas -->
            <div class="tab-content" id="pills-tabContent">

                <!-- accessLevels -->
                <div class="tab-pane fade" id="pills-accessLevels" role="tabpanel" aria-labelledby="pills-accessLevels-tab" tabindex="0">
                    <fieldset>
                        <legend>Níveis de Acesso</legend>
                    </fieldset>
                    <div class="float-end" style="margin-top: -45px;">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
                    </div>

                    <table id="datatablesSimple1" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                              <th>Título</th>
                              <th>URL</th>
                              <th class="text-center">Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <span class="d-flex flex-row justify-content-center">
                                            <a href="" class="btn btn-info btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>
                                        </span>
                                        
                                    </td>
                                </tr>                           
                          </tbody>
                    </table>
                </div><!-- fim accessLevels -->
                
                <!-- Permissões -->
                <div class="tab-pane fade show active" id="pills-permissions" role="tabpanel" aria-labelledby="pills-permissions-tab" tabindex="0">
                    <fieldset>
                        <legend>Permissões</legend>
                    </fieldset>

                    <table id="datatablesSimple" class="table table-striped table-hover">
                        <thead>
                                <tr>
                                <th>Título</th>
                                <th>URL</th>
                                <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            {{-- puxando registros do banco de dados --}}
                            @if (count($permissions) > 0)
                                @foreach ($permissions as $permission)
                                    <tr>
                                    <td>{{ $permission->title }}</td>
                                    <td>{{ $permission->area }}</td>
                                        <td>
                                            <span class="d-flex flex-row justify-content-center">
                                                <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $permission->id }}" ><i class="fa-solid fa-pencil"></i></button>
                                                <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $permission->id }}" ><i class="fa-solid fa-trash"></i></button>

                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr colspan="5" style="background-color: orange;">Nenhum registro encontrado</tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- fim Permissões -->
                
                <!-- Processos -->
                <div class="tab-pane fade" id="pills-processos" role="tabpanel" aria-labelledby="pills-processos-tab" tabindex="0">
                    <fieldset>
                        <legend>Lista de Processos</legend>
                    </fieldset>

                    <table id="datatablesSimple1" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                              <th>Parte contrária</th>
                              <th>Processo</th>
                              <th>Data</th>
                              <th>Resultado</th>
                              <th>Vlr. Causa</th>
                              <th>Vlr. Sentença</th>
                              <th>Honorários</th>
                              <th class="text-center">Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                                <tr>
                                    <td>Nome da parte contrária</td>
                                    <td>5407448-13.2024.8.09.0160</td>
                                    <td>05/2024</td>
                                    <td>Ganhou</td>
                                    <td>R$50.325,42</td>
                                    <td>R$50.325,42</td>
                                    <td>R$15.235,69</td>
                                    <td>
                                        <span class="d-flex flex-row justify-content-center">
                                            <a href="" class="btn btn-info btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>
                                        </span>
                                        
                                    </td>
                                </tr>                           
                          </tbody>
                    </table>
                </div><!-- fim Processos -->
                
                <!-- Consultivos -->
                <div class="tab-pane fade" id="pills-consultivos" role="tabpanel" aria-labelledby="pills-consultivos-tab" tabindex="0">
                    <fieldset>
                        <legend>Lista de Consultivos</legend>
                    </fieldset>

                    <table id="datatablesSimple2" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                              <th>Título</th>
                              <th>Data</th>
                              <th>Status</th>
                              <th>Vlr. Cobrado</th>
                              <th>Cond. Pagto</th>
                              <th>Total Pago</th>
                              <th>Pagto</th>
                              <th class="text-center">Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="badge text-bg-danger">Atrasado</span></td>
                                    <td>
                                        <span class="d-flex flex-row justify-content-center">
                                            <a href="" class="btn btn-info btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>
                                            <a href="" class="btn btn-success btn-sm me-1 mb-1 mb-sm-0" title="Enviar Cobrança de Pagamento"><i class="fa-solid fa-hand-holding-dollar"></i></a>
                                        </span>
                                        
                                    </td>
                                </tr>  
                            
                                                         
                          </tbody>
                    </table>
                </div><!-- fim Consultivos -->

            </div><!-- fim conteúdo das abas -->

            
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
                url: '{{ route('document-templates.store') }}',
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
                            title: $(this).attr('data-title'),
                            content: $(this).attr('data-content'),
                            type: $(this).attr('data-type'),
                            area: $(this).attr('data-area'),
                        }
                    ];
                    editRegistro(dados);

            }else if($(this).hasClass('deleteBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                        }
                    ];
                    deleteRegistro(dados);
            }
        });

        /** Função que preenche os campos do formulário de atualização */
        function editRegistro(dados) {
            let url = "{{ route('document-templates.show', 'id') }}";
            url = url.replace('id', dados[0].id);

            /** Preenche os campos do form de atualização */
            $.get(url, function() {
                $('#edit_id').val(dados[0].id);
                $('#edit_title').val(dados[0].title);
                $('#edit_content').val(dados[0].content);
                $('#edit_type').val(dados[0].type);
                $('#edit_area').val(dados[0].area);

                // Inicializa ou atualiza o conteúdo do Summernote
                $('#edit_content').summernote('destroy'); // Destrói qualquer instância existente
                $('#edit_content').val(dados[0].content); // Preenche o conteúdo
                $('#edit_content').summernote({           // Inicializa o Summernote
                    height: 300,
                    minHeight: null,
                    maxHeight: null,
                    focus: true
                });

                $('#updateModal').modal('show');
            });
        }


        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            if (document.querySelector('#edit_content').ckeditorInstance) {
                document.querySelector('#edit_content').ckeditorInstance.updateSourceElement();
            }
            $.ajax({
                url: `/update-document-templates/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    if(response){
                        Swal.fire('Pronto!', response.success, 'success');
                    }
                    setTimeout(function() {
                        location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                    }, 2000); // 3000 milissegundos = 3 segundos
                },
                error: function(response) {
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });



        /**Exibe pergunta se deseja realmente excluir o registro */
        function deleteRegistro(dados) {
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
                        url: `/destroy-document-templates/${dados[0].id}`,
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

        /**Função para instanciar o summernote */
        if (!window.summernoteInitialized) {
            $('#content, #edit_content').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: true
            });
            window.summernoteInitialized = true;
        }

        $('#createForm').on('submit', function () {
            $('#contentCad').val($('#content').summernote('code'));
        });

        $('#updateform').on('submit', function () {
            $('#contentUpdate').val($('#edit_content').summernote('code'));
        });

        
    });
    
</script>

@endsection
   
