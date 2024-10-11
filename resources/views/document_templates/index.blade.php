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
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createLabelModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
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
                                            data-type="{{ $document->type }}" data-area="{{ $document->area }}" ><i class="fa-solid fa-pencil"></i></button>
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
<div class="modal fade" id="createLabelModal" tabindex="-1" aria-labelledby="createLabelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Modelo de Documento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createLabelForm" class="row g-3">
                @csrf

                
                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="col-md-12">
                    <label for="content" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Tipo</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">Informe o tipo de documento</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area" class="form-label">Área</label>
                    <select id="area" name="area" class="form-select">
                        <option value="">Informe a área do direito</option>
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
<div class="modal fade" id="updateLabelModal" tabindex="-1" aria-labelledby="updateLabelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Etiqueta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateLabelForm" class="row g-3">
                @csrf
                <!-- @method('POST') -->

                
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="hexa_color_bg" class="form-label">Cor de Fundo</label>
                    <input type="color" class="form-control" id="edit_hexa_color_bg" name="hexa_color_bg" value="{{ old('hexa_color_bg') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="hexa_color_font" class="form-label">Cor do Texto</label>
                    <input type="color" class="form-control" id="edit_hexa_color_font" name="hexa_color_font" value="{{ old('hexa_color_font') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hexa_color_font" class="form-label">Resultado</label>
                    <br><span id="edit_resultado" class="badge rounded-pill"></span>
                </div>
                
                <div class="col-md-12 mb-3">
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


</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- CKEditor CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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

        /** Cadastrar registro funcionando com sucesso */
        $('#createLabelForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('labels.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createLabelModal').modal('hide');
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
        /**Mostra exemplo em tempo real no formulário*/
        let inputEditName = document.querySelector('#edit_name');
        let inputEditBgColor = document.querySelector('#edit_hexa_color_bg');
        let inputEditFontColor = document.querySelector('#edit_hexa_color_font');
        let spanEditResultado = document.querySelector('#edit_resultado');
        let textoEditDigitado;
        spanEditResultado.style.backgroundColor = inputEditBgColor.value;
        spanEditResultado.style.color = inputEditFontColor.value;
        spanEditResultado.textContent = inputEditName.val;

        /**Manda para o span tudo que for digitado no campo name */
        inputEditName.onkeyup = function(){
            textoEditDigitado = inputEditName.value;
            spanEditResultado.textContent = textoEditDigitado;
        }

        /**Pega a cor de fundo escolhida e aplica no span */
        inputEditBgColor.onchange = function(){
            spanEditResultado.style.backgroundColor = inputEditBgColor.value;
        }

        /**Pega a cor da fonte escolhida e aplica no span */
        inputEditFontColor.onchange = function(){
            spanEditResultado.style.color = inputEditFontColor.value;
        }

        /**Passa valores do registro para o formulário na modal de atualização */
        $('button').on('click', function() {
            /**Verifica se o botão tem a classe condicional para fazer algo */
            if($(this).hasClass('editBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            name: $(this).attr('data-name'), 
                            hexa_color_bg: $(this).attr('data-hexa_color_bg'), 
                            hexa_color_font: $(this).attr('data-hexa_color_font'), 
                        }
                    ];
                    editLabel(dados);
            }else if($(this).hasClass('deleteBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            name: $(this).attr('data-name'), 
                            hexa_color_bg: $(this).attr('data-hexa_color_bg'), 
                            hexa_color_font: $(this).attr('data-hexa_color_font'), 
                        }
                    ];
                    deleteLabel(dados);
            }
        });
            

        /**Função que preenche os campos do formulário de atualização */
        function editLabel(dados) {
            let url = "{{ route('labels.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                $('#edit_label_id').val(dados[0].id);
                $('#edit_name').val(dados[0].name);
                $('#edit_hexa_color_bg').val(dados[0].hexa_color_bg);
                $('#edit_hexa_color_font').val(dados[0].hexa_color_font);
                $('#updateLabelModal').modal('show');
            });
        }

        /**Formulário de atualização de registro */
        $('#updateLabelForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_label_id').val();
            $.ajax({
                url: `/update-label/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateLabelModal').modal('hide');
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


        /**Exibe pergunta se deseja realmente excluir o registro */
        function deleteLabel(dados) {
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
                        url: `/destroy-label/${dados[0].id}`,
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
   
