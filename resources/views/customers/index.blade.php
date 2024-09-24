@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Clientes</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Clientes</li>
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
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>RG</th>
                        <th>CPF</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($customers) > 0)
                        @foreach ($customers as $customer)
                            <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->rg }}</td>
                            <td>{{ $customer->cpf }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <a href="{{ route('customers.show', ['customer' => $customer->id]) }}" class="btn btn-sm me-1 mb-1 mb-sm-0" title="Ver Registro"><i class="fa-solid fa-eye"></i></a>

                                        <button class="text-decoration-none btn btn-sm " title="Novo Processo" data-id="{{ $customer->id }}" >
                                            <i class="fa-regular fa-file-lines"></i></button>
                                        <button class="text-decoration-none btn btn-sm " title="Novo Caso" data-id="{{ $customer->id }}" >
                                            <i class="fa-solid fa-book"></i></button>
                                        <button class="text-decoration-none btn btn-sm " title="Novo Endereço" data-id="{{ $customer->id }}" >
                                            <i class="fa-solid fa-earth-americas"></i></button>
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $customer->id }}" 
                                            data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $customer->id }}" 
                                            data-name="{{ $customer->name }}" data-hexa_color_bg="{{ $customer->hexa_color_bg }}" 
                                            data-hexa_color_font="{{ $customer->hexa_color_font }}" ><i class="fa-solid fa-trash"></i></button>

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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <legend>Dados Pessoais</legend>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="rg" name="rg" value="{{ old('rg') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="rg_expedidor" class="form-label">Expedidor do RG</label>
                            <input type="text" class="form-control" id="rg_expedidor" name="rg_expedidor" value="{{ old('rg_expedidor') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="marital_status" class="form-label">Estado Civil</label>
                            <select class="form-select" name="marital_status" id="marital_status">
                                <option value="" >Escolha um</option>
                                <option value="solteiro(a)">Solteiro (a)</option>
                                <option value="casado(a)">Casado (a)</option>
                                <option value="divorciado(a)">Divorciado (a)</option>
                                <option value="viúvo(a)">Viúvo (a)</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="nationality" class="form-label">Nacionalidade</label>
                            <select class="form-select" name="nationality" id="nationality">
                                <option value="brasileiro(a)">Brasileiro (a)</option>
                                <option value="estrangeiro(a)">Estrangeiro (a)</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="profession" class="form-label">Profissão</label>
                            <input type="text" class="form-control" id="profession" name="profession" value="{{ old('profession') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="birthday" class="form-label">Nascimento</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="met_us" class="form-label">Como nos conheceu?</label>
                            <select class="form-select" name="met_us" id="met_us">
                                <option value="google">Google</option>
                                <option value="Instagram">Instagram</option>
                                <option value="tiktok">Tiktok</option>
                                <option value="facebook">Facebook</option>
                                <option value="kwai">Kwai</option>
                                <option value="indicação">Indicação</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- ['company_id', 'name','email','phone','rg',
    'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday']; -->
                </fieldset>
                
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="cep" class="form-label">CEP (Apenas nº)</label>
                            <input onblur="pesquisacep(this.value);" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="99999999" value="{{ old('zipcode') }}">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="street" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="num" class="form-label">Número</label>
                            <input type="text" class="form-control" id="num" name="num" value="{{ old('num') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complement" name="complement" value="{{ old('complement') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="neighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="neighborhood" name="neighborhood" placeholder="99999-999" value="{{ old('neighborhood') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="city" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="state" class="form-label">UF</label>
                            <input type="text" class="form-control" id="stateUF" name="state" max="2" value="{{ old('state') }}">
                        </div>
                    </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
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
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <legend>Dados Pessoais</legend>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="edit_rg" name="rg" value="{{ old('rg') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="rg_expedidor" class="form-label">Expedidor do RG</label>
                            <input type="text" class="form-control" id="edit_rg_expedidor" name="rg_expedidor" value="{{ old('rg_expedidor') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="edit_cpf" name="cpf" value="{{ old('cpf') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="marital_status" class="form-label">Estado Civil</label>
                            <select class="form-select" name="marital_status" id="edit_marital_status">
                                <option>Escolha um</option>
                                <option value="solteiro(a)">Solteiro (a)</option>
                                <option value="casado(a)">Casado (a)</option>
                                <option value="divorciado(a)">Divorciado (a)</option>
                                <option value="viúvo(a)">Viúvo (a)</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="nationality" class="form-label">Nacionalidade</label>
                            <select class="form-select" name="nationality" id="edit_nationality">
                                <option value="brasileiro(a)">Brasileiro (a)</option>
                                <option value="estrangeiro(a)">Estrangeiro (a)</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="profession" class="form-label">Profissão</label>
                            <input type="text" class="form-control" id="edit_profession" name="profession" value="{{ old('profession') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="birthday" class="form-label">Nascimento</label>
                            <input type="date" class="form-control" id="edit_birthday" name="birthday" value="{{ old('birthday') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="met_us" class="form-label">Como nos conheceu?</label>
                            <select class="form-select" name="met_us" id="edit_met_us">
                                <option value="google">Google</option>
                                <option value="Instagram">Instagram</option>
                                <option value="tiktok">Tiktok</option>
                                <option value="facebook">Facebook</option>
                                <option value="kwai">Kwai</option>
                                <option value="indicação">Indicação</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- ['company_id', 'name','email','phone','rg',
    'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday']; -->
                </fieldset>
                
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="cep" class="form-label">CEP (Apenas nº)</label>
                            <input onblur="pesquisacep(this.value);" type="text" class="form-control" id="edit_cep" name="zipcode" placeholder="99999999" value="{{ old('cep') }}">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="street" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="edit_street" name="street" value="{{ old('street') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="num" class="form-label">Número</label>
                            <input type="text" class="form-control" id="edit_num" name="num" value="{{ old('num') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="edit_complement" name="complement" value="{{ old('complement') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="neighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="edit_neighborhood" name="neighborhood" placeholder="99999-999" value="{{ old('neighborhood') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="city" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="edit_city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="state" class="form-label">UF</label>
                            <input type="text" class="form-control" id="edit_state" name="state" max="2" value="{{ old('state') }}">
                        </div>
                    </div>

                </fieldset>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="id">                 
                    <input type="hidden" class="form-control" id="edit_address_id" name="id" value="">                 
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
        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('customers.store') }}',
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
                // var dados = [
                //         { 
                //             id: $(this).attr('data-id'), 
                //             name: $(this).attr('data-name'), 
                //             email: $(this).attr('data-email'), 
                //             phone: $(this).attr('data-phone'), 
                //             rg: $(this).attr('data-rg'), 
                //             rg_expedidor: $(this).attr('data-rg_expedidor'), 
                //             cpf: $(this).attr('data-cpf'), 
                //             marital_status: $(this).attr('data-marital_status'), 
                //             nationality: $(this).attr('data-nationality'), 
                //             profession: $(this).attr('data-profession'), 
                //             birthday: $(this).attr('data-birthday'), 
                //             zipcode: $(this).attr('data-zipcode'), 
                //             street: $(this).attr('data-street'), 
                //             num: $(this).attr('data-num'), 
                //             complement: $(this).attr('data-complement'), 
                //             neighborhood: $(this).attr('data-neighborhood'), 
                //             city: $(this).attr('data-city'), 
                //             state: $(this).attr('data-state'), 
                //         }
                //     ];
                    editRegistro($(this).attr('data-id'));
            }else if($(this).hasClass('deleteBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                        }
                    ];
                    deleteRegistro($(this).attr('data-id'));
            }
        });
            

        /**Função que preenche os campos do formulário de atualização */
        function editRegistro(id) {
            let url = "{{ route('customers.show', 'id') }}";
            url = url.replace('id', id);
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
                    $('#edit_id').val(data[0][0]['customer'].id);
                    $('#edit_name').val(data[0][0]['customer'].name);
                    $('#edit_email').val(data[0][0]['customer'].email);
                    $('#edit_phone').val(data[0][0]['customer'].phone);
                    $('#edit_rg').val(data[0][0]['customer'].rg);
                    $('#edit_rg_expedidor').val(data[0][0]['customer'].rg_expedidor);
                    $('#edit_cpf').val(data[0][0]['customer'].cpf);
                    $('#edit_marital_status').val(data[0][0]['customer'].marital_status);
                    $('#edit_nationality').val(data[0][0]['customer'].nationality);
                    $('#edit_profession').val(data[0][0]['customer'].profession);
                    $('#edit_birthday').val(data[0][0]['customer'].birthday);
                    $('#edit_met_us').val(data[0][0]['customer'].met_us);

                    /**Endereço*/
                    $('#edit_cep').val(data[0][0].zipcode);
                    $('#edit_street').val(data[0][0].street);
                    $('#edit_num').val(data[0][0].num);
                    $('#edit_complement').val(data[0][0].complement);
                    $('#edit_neighborhood').val(data[0][0].neighborhood);
                    $('#edit_city').val(data[0][0].city);
                    $('#edit_state').val(data[0][0].state);
                    $('#edit_customer_id').val(data[0][0].customer_id);
                    $('#edit_address_id').val(data[0][0].id);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                
                $('#updateModal').modal('show');
            });
            //console.log(url);
            

        }//Fim aditRegistro()

        /**Formulário de atualização de registro */
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-customer/${id}`,
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


        /**Exibe pergunta se deseja realmente excluir o registro */
        function deleteRegistro(id) {
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
                        url: `/destroy-customer/${id}`,
                        method: 'DELETE',
                        success: function() {
                            //$('#customersTable').DataTable().ajax.reload();
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

    /**ViaCEP - Cadastro*/
    function limpa_formulário_cep() {
        //Limpa valores do formulário de Create.
        document.getElementById('street').value=("");
        document.getElementById('neighborhood').value=("");
        document.getElementById('city').value=("");
        document.getElementById('stateUF').value=("");
        
        //Limpa valores do formulário de Update.
        document.getElementById('edit_street').value=("");
        document.getElementById('edit_neighborhood').value=("");
        document.getElementById('edit_city').value=("");
        document.getElementById('edit_state').value=("");
        //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores no form Create.
            document.getElementById('street').value=(conteudo.logradouro);
            document.getElementById('neighborhood').value=(conteudo.bairro);
            document.getElementById('city').value=(conteudo.localidade);
            document.getElementById('stateUF').value=(conteudo.uf);

            //Atualiza os campos com os valores no form Update.
            document.getElementById('edit_street').value=(conteudo.logradouro);
            document.getElementById('edit_neighborhood').value=(conteudo.bairro);
            document.getElementById('edit_city').value=(conteudo.localidade);
            document.getElementById('edit_state').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice - form Create.
                document.getElementById('street').value="...";
                document.getElementById('neighborhood').value="...";
                document.getElementById('city').value="...";
                document.getElementById('stateUF').value="...";

                //Preenche os campos com "..." enquanto consulta webservice - form Update.
                document.getElementById('edit_street').value="...";
                document.getElementById('edit_neighborhood').value="...";
                document.getElementById('edit_city').value="...";
                document.getElementById('edit_state').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido. Digite apenas números");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };//Fim via cep

    
</script>

@endsection
   
