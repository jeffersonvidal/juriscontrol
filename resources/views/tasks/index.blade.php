@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Tarefas Diárias</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Tarefas Diárias</li>
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
            
            <table id="datatablesSimple" class="table table-striped table-hover">
            <thead>
                    <tr>
                      <th>Tarefa</th>
                      <th>Responsável(eis)</th>
                      <th>Cliente</th>
                      <th>Etiqueta</th>
                      <th>Status</th>
                      <th>Entrega</th>
                      <th>Situação</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($tasks) > 0)
                        @foreach ($tasks as $task)
                            <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->getUser($task->responsible_id)->name }}</td>
                            <td>{{ $task->client }}</td>
                            <td>{!! $helper->getLabel($task->label_id) !!}</td>
                            <td>{{ $task->getStatus($task->status)->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->delivery_date)->format('d/m/Y') }}</td>
                            <td>{{ $helper->getSituation($task->delivery_date, $task->status) }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $task->id }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-delivery_date="{{ $task->delivery_date }}"
                                        data-end_date="{{ $task->end_date }}" data-responsible_id="{{ $task->responsible_id }}" data-author_id="{{ $task->author_id }}"
                                        data-client="{{ $task->client }}" data-process_number="{{ $task->process_number }}" data-court="{{ $task->court }}"
                                        data-priority="{{ $task->priority }}" data-label_id="{{ $task->label_id }}" data-status="{{ $task->status }}"
                                        data-source="{{ $task->source }}" data-id="{{ $task->id }}" data-id="{{ $task->id }}"
                                        data-id="{{ $task->id }}" data-company_id="{{ $task->company_id }}"  data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $task->id }}" ><i class="fa-solid fa-trash"></i></button>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Tarefa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="createForm" name="createForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Data Fatal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="delivery_date" class="form-label">Entrega</label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="responsible_id" class="form-label">Responsável</label>
                    <select id="responsible_id" name="responsible_id" class="form-select">
                        <option value="">Para quem é essa tarefa?</option>
                        @if (count($users) > 0)
                            @foreach($users as $user)
                                echo '<option value="{{ $user->id }}">{{ $user->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="client" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="client" name="client" value="{{ old('client') }}">
                </div>
                <div class="col-md-6">
                    <label for="process_number" class="form-label">Processo</label>
                    <input type="text" class="form-control" id="process_number" name="process_number" value="{{ old('process_number') }}">
                </div>
                <div class="col-md-2">
                    <label for="court" class="form-label">Tribunal</label>
                    <input type="text" class="form-control" id="court" name="court" value="{{ old('court') }}">
                </div>
                <div class="col-md-2">
                    <label for="priority" class="form-label">Prioridade</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="">Defina a Prioridade</option>
                        @if (count($priorities) > 0)
                            @foreach($priorities as $priority)
                                echo '<option value="{{ $priority->id }}">{{ $priority->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="label_id" class="form-label">Etiqueta <!--<a href=""><i class="fa-solid fa-plus" title="Adicionar Etiqueta"></i></a>--></label>
                    <select id="label_id" name="label_id" class="form-select">
                        <option value="">Defina uma Etiqueta</option>
                        @if (count($labels) > 0)
                            @foreach($labels as $label)
                                echo '<option value="{{ $label->id }}">{{ $label->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status <!--<a href=""><i class="fa-solid fa-plus" title="Adicionar Status"></i></a>--></label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Informe o Status</option>
                        @if (count($systemStatus) > 0)
                            @foreach($systemStatus as $status)
                                echo '<option value="{{ $status->id }}">{{ $status->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label">Origem</label>
                    <select id="source" name="source" class="form-select select2">
                        <option value="">Informe a Origem</option>
                        @if (count($externalOffices) > 0)
                            @foreach($externalOffices as $externalOffice)
                                echo '<option value="{{ $externalOffice->id }}">{{ $externalOffice->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <!-- Campos ocultos -->
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="author_id" name="author_id" value="{{ auth()->user()->id }}">                 
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


<!-- updateModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Tarefa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" name="editForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="edit_title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Data Fatal</label>
                    <input type="date" class="form-control" id="edit_end_date" name="end_date" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="delivery_date" class="form-label">Entrega</label>
                    <input type="date" class="form-control" id="edit_delivery_date" name="delivery_date" value="{{ old('delivery_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="responsible_id" class="form-label">Responsável</label>
                    <select id="edit_responsible_id" name="responsible_id" class="form-select">
                        <option value="">Para quem é essa tarefa?</option>
                        @if (count($users) > 0)
                            @foreach($users as $user)
                                echo '<option value="{{ $user->id }}">{{ $user->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="client" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="edit_client" name="client" value="{{ old('client') }}">
                </div>
                <div class="col-md-6">
                    <label for="process_number" class="form-label">Processo</label>
                    <input type="text" class="form-control" id="edit_process_number" name="process_number" value="{{ old('process_number') }}">
                </div>
                <div class="col-md-2">
                    <label for="court" class="form-label">Tribunal</label>
                    <input type="text" class="form-control" id="edit_court" name="court" value="{{ old('court') }}">
                </div>
                <div class="col-md-2">
                    <label for="priority" class="form-label">Prioridade</label>
                    <select id="edit_priority" name="priority" class="form-select">
                        <option value="">Defina a Prioridade</option>
                        @if (count($priorities) > 0)
                            @foreach($priorities as $priority)
                                echo '<option value="{{ $priority->id }}">{{ $priority->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="label_id" class="form-label">Etiqueta <!--<a href=""><i class="fa-solid fa-plus" title="Adicionar Etiqueta"></i></a>--></label>
                    <select id="edit_label_id" name="label_id" class="form-select">
                        <option value="">Defina uma Etiqueta</option>
                        @if (count($labels) > 0)
                            @foreach($labels as $label)
                                echo '<option value="{{ $label->id }}">{{ $label->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status <!--<a href=""><i class="fa-solid fa-plus" title="Adicionar Status"></i></a>--></label>
                    <select id="edit_status" name="status" class="form-select">
                        <option value="">Informe o Status</option>
                        @if (count($systemStatus) > 0)
                            @foreach($systemStatus as $status)
                                echo '<option value="{{ $status->id }}">{{ $status->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label">Origem</label>
                    <select id="edit_source" name="source" class="form-select select2">
                        <option value="">Informe a Origem</option>
                        @if (count($externalOffices) > 0)
                            @foreach($externalOffices as $externalOffice)
                                echo '<option value="{{ $externalOffice->id }}">{{ $externalOffice->name }}</option>';
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <!-- Campos ocultos -->
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="">                 
                    <input type="hidden" class="form-control" id="edit_author_id" name="author_id" value="">                 
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




</div><!--fim container-fluid-->

<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('tasks.store') }}',
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
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            title: $(this).attr('data-title'), 
                            description: $(this).attr('data-description'), 
                            delivery_date: $(this).attr('data-delivery_date'), 
                            end_date: $(this).attr('data-end_date'), 
                            responsible_id: $(this).attr('data-responsible_id'), 
                            author_id: $(this).attr('data-author_id'), 
                            client: $(this).attr('data-client'), 
                            process_number: $(this).attr('data-process_number'), 
                            court: $(this).attr('data-court'), 
                            priority: $(this).attr('data-priority'), 
                            label_id: $(this).attr('data-label_id'), 
                            status: $(this).attr('data-status'), 
                            source: $(this).attr('data-source'), 
                            company_id: $(this).attr('data-company_id'), 
                        }
                    ];
                    //console.log(dados);
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
            

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(dados) {
            let url = "{{ route('tasks.show', 'id') }}";
            url = url.replace('id', dados[0].id);
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
                    /**console.log(data[0][0]['customer']); //lista dados pessoais
                     ** console.log(data[0][0]); //Lista dados do endereço */
                    /**Dados pessoais*/
                    $('#edit_id').val(dados[0].id);
                    $('#edit_title').val(dados[0].title);
                    $('#edit_description').val(dados[0].description);
                    $('#edit_delivery_date').val(dados[0].delivery_date);
                    $('#edit_end_date').val(dados[0].end_date);
                    $('#edit_responsible_id').val(dados[0].responsible_id);
                    $('#edit_author_id').val(dados[0].author_id);
                    $('#edit_client').val(dados[0].client);
                    $('#edit_process_number').val(dados[0].process_number);
                    $('#edit_court').val(dados[0].court);
                    $('#edit_priority').val(dados[0].priority);
                    $('#edit_label_id').val(dados[0].label_id);
                    $('#edit_status').val(dados[0].status);
                    $('#edit_source').val(dados[0].source);
                    $('#edit_company_id').val(dados[0].company_id);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                
                $('#updateModal').modal('show');
            });
            //console.log(data);
            

        }//Fim aditRegistro()

        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-task/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    //$('#customersTable').DataTable().ajax.reload();
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
                        url: `/destroy-task/${dados[0].id}`,
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

    /**Seletc2 */
    // $('.select2').select2({
    //     theme: 'bootstrap-5'
    // });

    
</script>

@endsection
   
