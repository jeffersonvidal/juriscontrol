@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Tarefas</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Tarefas</li>
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
            @php
                //dd($tasks->labels->id);
            @endphp
            <table id="datatablesSimple" class="table table-striped table-hover">
            <thead>
                    <tr>
                      <th>Tarefa</th>
                      <th>Responsável(eis)</th>
                      <th>Cliente</th>
                      <th>Prioridade</th>
                      <th>Status</th>
                      <th>Entrega</th>
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
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->delivery_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $task->id }}"  data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $task->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>

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
      <form id="addForm" name="addForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
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
                        <option value="1">Estagiário</option>
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
                        <option value="1">Estagiário</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="label_id" class="form-label">Etiqueta <a href=""><i class="fa-solid fa-plus" title="Adicionar Etiqueta"></i></a></label>
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
                    <label for="status" class="form-label">Status <a href=""><i class="fa-solid fa-plus" title="Adicionar Status"></i></a></label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Informe o Status</option>
                        <option value="1">Estagiário</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label">Origem</label>
                    <select id="source" name="source" class="form-select">
                        <option value="">Informe a Origem</option>
                        <option value="1">Estagiário</option>
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


<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Etiqueta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="editForm" name="editForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}">
                </div>
                <div class="col-md-3">
                    <label for="hexa_color_bg" class="form-label">Cor de Fundo</label>
                    <input type="color" class="form-control" id="edit_hexa_color_bg" name="hexa_color_bg" value="{{ old('hexa_color_bg') }}">
                </div>
                <div class="col-md-3">
                    <label for="hexa_color_font" class="form-label">Cor do Texto</label>
                    <input type="color" class="form-control" id="edit_hexa_color_font" name="hexa_color_font" value="{{ old('hexa_color_font') }}">
                </div>

                <div class="col-md-6">
                    <label for="hexa_color_font" class="form-label">Resultado</label>
                    <br><span id="edit_resultado" class="badge rounded-pill"></span>
                </div>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_label_id" name="id">                 
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
      
        <h3>Você deseja realmente excluir o registro <span class="registro_name"></span>?</h3>
                
            
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

        /**Mostra exemplo em tempo real */
        let inputName = document.querySelector('#name');
        let inputBgColor = document.querySelector('#hexa_color_bg');
        let inputFontColor = document.querySelector('#hexa_color_font');
        let spanResultado = document.querySelector('#resultado');
        let textoDigitado;
        spanResultado.style.backgroundColor = inputBgColor.value;
        spanResultado.style.color = 'white';
        //spanResultado.style.color = inputFontColor.value;

        /**Manda para o span tudo que for digitado no campo name */
        inputName.onkeyup = function(){
            textoDigitado = inputName.value;
            spanResultado.textContent = textoDigitado;
            //console.log(textoDigitado);
        }

        /**Pega a cor de fundo escolhida e aplica no span */
        inputBgColor.onchange = function(){
            spanResultado.style.backgroundColor = inputBgColor.value;
        }

        /**Pega a cor da fonte escolhida e aplica no span */
        inputFontColor.onchange = function(){
            spanResultado.style.color = inputFontColor.value;
        }

        

        /** Create */
        $('form[name="addForm"]').submit(function(event){
            event.preventDefault(); //não atualiza a página ao enviar os dados

            $.ajax({
                url: "{{ route('labels.store') }}",
                type: "get",
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('.addButton').prop('disabled', true);
                },
                complete:function(){
                    $('.addButton').prop('disabled', false);
                },
                // success: function(response){
                //     console.log(response);
                // }
                success: function(response){
                    if(response.success == true){
                        $('#addModal').hide();
                        printSuccessMsg(response.msg);

                        location.reload();
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
        /**Mostra exemplo em tempo real */
        let inputEditName = document.querySelector('#edit_name');
        let inputEditBgColor = document.querySelector('#edit_hexa_color_bg');
        let inputEditFontColor = document.querySelector('#edit_hexa_color_font');
        let spanEditResultado = document.querySelector('#edit_resultado');
        let textoEditDigitado;
        spanEditResultado.style.backgroundColor = inputEditBgColor.value;
        spanEditResultado.style.color = 'white';
        //spanResultado.style.color = inputFontColor.value;

        /**Manda para o span tudo que for digitado no campo name */
        inputEditName.onkeyup = function(){
            textoEditDigitado = inputEditName.value;
            spanEditResultado.textContent = textoEditDigitado;
            //console.log(textoDigitado);
        }

        /**Pega a cor de fundo escolhida e aplica no span */
        inputEditBgColor.onchange = function(){
            spanEditResultado.style.backgroundColor = inputEditBgColor.value;
        }

        /**Pega a cor da fonte escolhida e aplica no span */
        inputEditFontColor.onchange = function(){
            spanEditResultado.style.color = inputEditFontColor.value;
        }
        //Botão editBtn que abre a modal para editar registro
        $('.editBtn').on('click', function(){
            //Pega os valores dos campos vindos do BD para alimentar o formulário
            let id = $(this).attr('data-id');
            let name = $(this).attr('data-name');
            let hexa_color_bg = $(this).attr('data-hexa_color_bg');
            let company_id = $(this).attr('data-company_id');
            let hexa_color_font = $(this).attr('data-hexa_color_font');
            //let data_brasileira = user_birthday.split('-').reverse().join('/');

            //Mostra os valores vindos do BD no form da modal
            $('#edit_label_id').val(id);
            $('#edit_name').val(name);
            $('#edit_hexa_color_bg').val(hexa_color_bg);
            $('#edit_hexa_color_font').val(hexa_color_font);
            $('#edit_company_id').val(company_id);

            let url = "{{ route('labels.update', 'id') }}";
            url = url.replace('id', id);

            //Botão do formulário que envia requisição para salvar alterações do BD
            $('form[name="editForm"]').submit(function(event){
                event.preventDefault(); //não atualiza a página ao enviar os dados

                $.ajax({
                    url: url,
                    type: "get",
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
            let registro_id = $(this).attr('data-id'); //pega id do registro a ser deletado
            let registro_name = $(this).attr('data-name'); //pega name do registro a ser deletado

            //Passa o nome para modal
            $('.registro_name').html('');
            $('.registro_name').html(registro_name);
            
            //Botão de confirmar deletar registro da modal
            $('.deleteModalButton').on('click', function(){
                let url = "{{ route('labels.destroy', 'id') }}";
                url = url.replace('id', registro_id);
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

                            location.reload();
                            
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
   
