@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Modelos de Documentos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Modelos de Documentos</li>
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
            <x-alerts />

            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>
                        <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Área</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($documents) > 0)
                        @foreach ($documents as $document)
                            <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->type }}</td>
                            <td>{{ $document->area }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $document->id }}" data-title="{{ $document->title }}" 
                                            data-content="{{ $document->content }}" data-type="{{ $document->type }}" data-area="{{ $document->area }}" ><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $document->id }}" ><i class="fa-solid fa-trash"></i></button>

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
    
<!-- addModal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModal">Cadastrar Modelo de Documento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createForm" class="row g-3">
                @csrf

                
                <div class="col-md-12 mb-2">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="content" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="content" name="content" rows="50">{{ old('content') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Tipo</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">Informe o tipo de documento</option>
                        <option value="contract">Contrato</option>
                        <option value="hypossufficiency_declaration">Declaração Hipossuficiência</option>
                        <option value="power_of_attorney">Procuração</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area" class="form-label">Área</label>
                    <select id="area" name="area" class="form-select">
                        <option value="">Informe a área do direito</option>
                        <option value="geral">Geral</option>
                        <option value="ambiental">Ambiental</option>
                        <option value="civil">Civil</option>
                        <option value="complience">Complience</option>
                        <option value="condominio">Condomínio</option>
                        <option value="digital">Digital</option>
                        <option value="penal">Penal</option>
                        <option value="previdenciario">Previdenciário</option>
                        <option value="trabalhista">Trabalhista</option>
                        <option value="tributario">Tributário</option>
                    </select>
                </div>
                
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
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Modelo de Documento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12 mb-2">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="edit_title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="content" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="edit_content" name="content" rows="50">{{ old('content') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Tipo</label>
                    <select id="edit_type" name="type" class="form-select">
                        <option value="">Informe o tipo de documento</option>
                        <option value="contract">Contrato</option>
                        <option value="hypossufficiency_declaration">Declaração Hipossuficiência</option>
                        <option value="power_of_attorney">Procuração</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area" class="form-label">Área</label>
                    <select id="edit_area" name="area" class="form-select">
                    <option value="">Informe a área do direito</option>
                        <option value="geral">Geral</option>
                        <option value="ambiental">Ambiental</option>
                        <option value="civil">Civil</option>
                        <option value="complience">Complience</option>
                        <option value="condominio">Condomínio</option>
                        <option value="digital">Digital</option>
                        <option value="penal">Penal</option>
                        <option value="previdenciario">Previdenciário</option>
                        <option value="trabalhista">Trabalhista</option>
                        <option value="tributario">Tributário</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_author_id" name="author_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="author_id" value="">                 
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
<script src="https://cdn.tiny.cloud/1/f0hn7yp6hoepuf9q4glhvc0ta67w6ereck2x2gaki1oh5zbr/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<!-- <script src="https://cdn.tiny.cloud/1/f0hn7yp6hoepuf9q4glhvc0ta67w6ereck2x2gaki1oh5zbr/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
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

        // Função para inicializar o CKEditor apenas uma vez
        function initTinyMCEOnce(content) {
            if (!tinymce.get('edit_content')) {
                tinymce.init({
                    selector: '#edit_content',
                    language: 'pt_BR',
                    plugins: ['anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                        'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'mentions', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
                        ],
                    toolbar_mode: 'floating',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    height: 300,
                    setup: function (editor) {
                        editor.on('init', function () {
                            editor.setContent(content);
                        });
                    }
                });
            } else {
                tinymce.get('edit_content').setContent(content);
            }
        }

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(dados) {
            let url = "{{ route('document-templates.show', 'id') }}";
            url = url.replace('id', dados[0].id);

            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                // Verificar se dados[0].content existe
                if (dados[0] && dados[0].content) {
                    initTinyMCEOnce(dados[0].content);
                } else {
                    console.error('O conteúdo não está definido.');
                }
                $('#edit_id').val(dados[0].id);
                $('#edit_title').val(dados[0].title);
                $('#edit_type').val(dados[0].type);
                $('#edit_area').val(dados[0].area);
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
                    //$('#labelsTable').DataTable().ajax.reload();
                    //Swal.fire('Success', 'Registro atualizado com sucesso', 'success');
                    // console.log(data);
                    // console.log(response);
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

        
    });
    
</script>

@endsection
   
