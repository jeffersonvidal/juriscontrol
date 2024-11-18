@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Cliente: {{ $customer->name }}</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Cliente</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <!-- Botões de gestão do cliente -->
            <span class="d-flex float-end">
            <button class="text-decoration-none btn btn-secondary btn-sm me-1 mb-1 mb-sm-0" data-bs-toggle="modal" data-bs-target="#listDocumentModal" title="Novo Documento" ><i class="fa-solid fa-file-signature"></i> Novo Documento</button>
                <a class="btn btn-icon-split btn-secondary btn-sm me-1 mb-1 mb-sm-0" href="{{ route('customers.index') }}" title="Cadastrar Novo Processo"><i class="fa-regular fa-file-lines"></i> Novo Processo</a>
                <a href="" class="btn btn-secondary btn-sm me-1 mb-1 mb-sm-0" title="Cadastrar Novo Consultivo"><i class="fa-solid fa-book"></i> Novo Consultivo</a>
                <button class="btn btn-sm btn-secondary btn-sm me-1 mb-1 mb-sm-0" data-bs-toggle="modal" data-bs-target="#createAddressesModal"><i class="fa-solid fa-earth-americas"></i> Novo Endereço</button>
                <form action="" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Tem certeza que deseja APAGAR este registro?')" class="btn btn-danger btn-sm me-1 mb-1 mb-sm-0" title="Excluir Registro"><i class="fa-solid fa-trash-can"></i> Excluir cliente</button>
                </form>
            </span><!-- fim Botões de gestão do cliente -->

        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            <!-- Estrutura de Abas -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-dadosPessoais-tab" data-bs-toggle="pill" data-bs-target="#pills-dadosPessoais" type="button" role="tab" aria-controls="pills-dadosPessoais" aria-selected="true"><i class="fa-regular fa-user"></i> Dados Pessoais</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-documentos-tab" data-bs-toggle="pill" data-bs-target="#pills-documentos" type="button" role="tab" aria-controls="pills-documentos" aria-selected="false"><i class="fa-solid fa-file-signature"></i> Documentos</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-processos-tab" data-bs-toggle="pill" data-bs-target="#pills-processos" type="button" role="tab" aria-controls="pills-processos" aria-selected="false"><i class="fa-regular fa-file-lines"></i> Processos</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-consultivos-tab" data-bs-toggle="pill" data-bs-target="#pills-consultivos" type="button" role="tab" aria-controls="pills-consultivos" aria-selected="false"><i class="fa-solid fa-book"></i> Casos e Consultivos</button>
                </li>
            </ul><!-- fim Estrutura de Abas -->


            <!-- Conteúdo das Abas -->
            <div class="tab-content" id="pills-tabContent">
                
                <!-- Dados Pessoais -->
                <div class="tab-pane fade show active" id="pills-dadosPessoais" role="tabpanel" aria-labelledby="pills-dadosPessoais-tab" tabindex="0">
                    <fieldset>
                        <legend>Dados Pessoais</legend>
                        <button type="button" class="btn btn-sm btn-dark float-end" data-bs-toggle="modal" data-bs-target="#headerDocument" title="Gerar Cabeçalho para Documentos"><i class="fa-solid fa-file-lines"></i> Gerar Cabeçalho</button>

                        
                        <div class="row">
                            <div class="col-md-4"><strong>Nome:</strong> {{ $customer->name }}</div>
                            <div class="col-md-4"><strong>Email:</strong> {{ $customer->email }}</div>
                            <div class="col-md-4"><strong>Telefone:</strong> {{ $customer->phone }}</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6"><strong>RG:</strong> {{ $customer->rg }} - {{ $customer->rg_expedidor }}</div>
                            <div class="col-md-6"><strong>CPF:</strong> {{ $customer->cpf }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><strong>Pasta Google Drive:</strong> <a href="https://drive.google.com/drive/folders/{{ $customer->gdrive_folder_id }}" target="_blank" ><i class="fa-brands fa-google-drive"></i></a></div>
                        </div>
                    </fieldset>

                    <hr>


                    <fieldset>
                        <legend>Endereço(s)</legend>

                        @forelse($customerAddress as $address)
                     
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Endereço:</strong> {{ $address->street }}, Nº {{ $address->num }}</div> 
                                        <div class="col-md-6"><strong>Bairro:</strong> {{ $address->neighborhood }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"><strong>Cidade:</strong> {{ $address->city }} - UF: {{ $address->state }}.</div> 
                                        <div class="col-md-4"><strong>CEP:</strong> {{ $address->zipcode }}</div>
                                        <div class="col-md-12">
                                        @php
                                            if($address->main == 1){
                                                echo '<span class="badge text-bg-primary">
                                                            Principal
                                                        </span>';
                                            }
                                        @endphp
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <span class="d-flex flex-row justify-content-center ms-auto">
                                    <button class="text-decoration-none btn btn-sm me-1 mb-1 mb-sm-0 editAddressBtn" title="Alterar Endereço" data-id="{{ $address->id }}" 
                                    data-customer_id="{{ $address->customer_id }}" data-company_id="{{ $address->company_id }}" 
                                    data-zipcode="{{ $address->zipcode }}" data-street="{{ $address->street }}" 
                                    data-neighborhood="{{ $address->neighborhood }}" data-num="{{ $address->num }}" 
                                    data-city="{{ $address->city }}" data-state="{{ $address->state }}" 
                                    data-addrmain="{{ $address->main }}" data-complement="{{ $address->complement }}" 
                                    data-bs-toggle="modal" data-bs-target="#updateAddressModal">
                                        <i class="fa-solid fa-pencil"></i></button>
                                    <button class="text-decoration-none btn btn-sm me-1 mb-1 mb-sm-0 text-danger deleteAddressBtn" title="Excluir Endereço" 
                                        data-id="{{ $address->id }}"  ><i class="fa-solid fa-trash"></i></button>
                                </span>
                            </div>
                            
                            @empty
                            {{-- Mostra mensagem de erro --}}
                            <div class="alert alert-danger" role="alert">
                                Nenhum endereço encontrado.
                            </div>
                        @endforelse
                        
                        
                    </fieldset>

                </div><!-- fim Dados Pessoais -->
                
                <!-- Documentos -->
                <div class="tab-pane fade" id="pills-documentos" role="tabpanel" aria-labelledby="pills-documentos-tab" tabindex="0">
                    <fieldset>
                        <legend>Lista de Documentos</legend>
                    </fieldset>

                    <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                              <th>Nome Documento</th>
                              <th>Tipo</th>
                              <th>Área</th>
                              <th class="text-center">Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- puxando registros do banco de dados --}}
                            @if (count($customerDocuments) > 0)
                                @foreach ($customerDocuments as $customerDocument)
                                <tr>
                                    <td>{{ $customerDocument->title }}</td>
                                    <td>{{ $customerDocument->type }}</td>
                                    <td>{{ $customerDocument->area }}</td>
                                    <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $customerDocument->id }}" data-title="{{ $customerDocument->title }}" 
                                            data-content="{{ $customerDocument->content }}" data-type="{{ $customerDocument->type }}" data-area="{{ $customerDocument->area }}" ><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $customerDocument->id }}" ><i class="fa-solid fa-trash"></i></button>

                                    </span>
                                        
                                    </td>
                                </tr>  
                                @endforeach
                        @else
                            <tr colspan="5" style="background-color: orange;">Nenhum registro encontrado</tr>
                        @endif                         
                          </tbody>
                    </table>
                </div><!-- fim Documentos -->
                
                <!-- Processos -->
                <div class="tab-pane fade" id="pills-processos" role="tabpanel" aria-labelledby="pills-processos-tab" tabindex="0">
                    <fieldset>
                        <legend>Lista de Processos</legend>
                    </fieldset>

                    <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
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

<!-- TRATAMENTO DE ENDEREÇO -->
<!-- addressModal -->
<div class="modal fade" id="createAddressesModal" tabindex="-1" aria-labelledby="createAddressesModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Endereço</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createAddressForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="cep" class="form-label">CEP (Apenas nº)</label>
                            <input onblur="pesquisacep(this.value);" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="99999999" value="{{ old('zipcode') }}">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="street" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="num" class="form-label">Número</label>
                            <input type="text" class="form-control" id="num" name="num" value="{{ old('num') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complement" name="complement" value="{{ old('complement') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="neighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="{{ old('neighborhood') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="state" class="form-label">UF</label>
                            <input type="text" class="form-control" id="stateUF" name="state" max="2" value="{{ old('state') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="main" class="form-label">Principal?</label>
                            <select id="edit_main" name="main" class="form-select">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addButton">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addressModal -->

<!-- editModal -->
<div class="modal fade" id="updateAddressModal" tabindex="-1" aria-labelledby="updateAddressModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateAddressForm" class="row g-3">
                @csrf
                
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="cep" class="form-label">CEP (Apenas nº)</label>
                            <input onblur="pesquisacep(this.value);" type="text" class="form-control" id="edit_zipcode" name="zipcode" placeholder="99999999" value="{{ old('zipcode') }}">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="street" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="edit_street" name="street" value="{{ old('street') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="num" class="form-label">Número</label>
                            <input type="text" class="form-control" id="edit_num" name="num" value="{{ old('num') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="edit_complement" name="complement" value="{{ old('complement') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="neighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="edit_neighborhood" name="neighborhood" value="{{ old('neighborhood') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="edit_city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="state" class="form-label">UF</label>
                            <input type="text" class="form-control" id="edit_stateUF" name="state" max="2" value="{{ old('state') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="main" class="form-label">Principal?</label>
                            <select id="edit_principal" name="main" class="form-select">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                </fieldset>
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="id">                 
                    <input type="hidden" class="form-control" id="edit_customer_id" name="customer_id" value="">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary editButton">Salvar Alterações <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim editAddressModal -->

<!-- TRATAMENTO DE DOCUMENTOS -->
 <!-- listDocumentModal -->
<div class="modal fade" id="listDocumentModal" tabindex="-1" aria-labelledby="listDocumentModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModal">Listar Modelos de Documentos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

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
                    @if (count($documentTemplates) > 0)
                        @foreach ($documentTemplates as $document)
                        
                            <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->type }}</td>
                            <td>{{ $document->area }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm viewDocumentTemplate" title="Ver Modelo de Documento" data-id="{{ $document->id }}" data-title="{{ $document->title }}" 
                                            data-content="{{ $clientHeaderDocs . $document->content }}" data-type="{{ $document->type }}" data-area="{{ $document->area }}" data-customer_id="{{ $customer->id }}" ><i class="fa-solid fa-eye"></i></button>

                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr colspan="3" style="background-color: orange;">Nenhum registro encontrado</tr>
                    @endif
                </tbody>
            </table>

      
    </div>
  </div>
</div><!-- fim listDocumentModal -->





<!-- addDocumentModal -->
<div class="modal fade" id="createDocumentModal" tabindex="-1" aria-labelledby="createDocumentModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModal">Cadastrar Documento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createDocumentForm" class="row g-3">
                @csrf

                
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
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">                 
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
</div><!-- fim addDocumentModal -->

</div><!--fim container-fluid-->

<!-- headerDocument -->
<div class="modal fade" id="headerDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cabeçalho para Documentos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ $clientHeaderDocs }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- headerDocument -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.tiny.cloud/1/f0hn7yp6hoepuf9q4glhvc0ta67w6ereck2x2gaki1oh5zbr/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastrar novo endereço do cliente */
        $('#createAddressForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('customer-addresses.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createAddressModal').modal('hide');
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

        /** Cadastrar Documento em CustomerContracts */
        $('#createDocumentForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('customer-contracts.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createDocumentModal').modal('hide');
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
            if($(this).hasClass('editAddressBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            zipcode: $(this).attr('data-zipcode'), 
                            street: $(this).attr('data-street'), 
                            num: $(this).attr('data-num'), 
                            complement: $(this).attr('data-complement'), 
                            neighborhood: $(this).attr('data-neighborhood'), 
                            city: $(this).attr('data-city'), 
                            state: $(this).attr('data-state'), 
                            company_id: $(this).attr('data-company_id'), 
                            customer_id: $(this).attr('data-customer_id'), 
                            main: $(this).attr('data-addrmain'), 
                        }
                    ];
                    //console.log(dados[0]);
                    editAddress(dados);
            }else if($(this).hasClass('deleteAddressBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                        }
                    ];
                    deleteAddress($(this).attr('data-id'));
            }else if($(this).hasClass('viewDocumentTemplate')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'),
                            title: $(this).attr('data-title'),
                            content: $(this).attr('data-content'),
                            type: $(this).attr('data-type'),
                            area: $(this).attr('data-area'),
                            company_id: $(this).attr('data-company_id'),
                            customer_id: $(this).attr('data-customer_id'),
                        }
                    ];
                    //console.log(dados[0]);
                    showDocumentTemplate(dados);
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
        function showDocumentTemplate(dados) {
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
                $('#edit_company_id').val(dados[0].company_id);
                //$('#edit_customer_id').val(dados[0].customer_id);
                $('#createDocumentModal').modal('show');
            });
        }
            

        /**Função que preenche os campos do formulário de atualização */
        function editAddress(dados) {
            let id = dados[0].id;
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
                     //console.log(data[0][0]['customer'].name);

                    /**Endereço*/
                    $('#edit_zipcode').val(dados[0].zipcode);
                    $('#edit_street').val(dados[0].street);
                    $('#edit_num').val(dados[0].num);
                    $('#edit_complement').val(dados[0].complement);
                    $('#edit_neighborhood').val(dados[0].neighborhood);
                    $('#edit_city').val(dados[0].city);
                    $('#edit_stateUF').val(dados[0].state);
                    $('#edit_company_id').val(dados[0].company_id);
                    $('#edit_customer_id').val(dados[0].customer_id);
                    $('#edit_id').val(dados[0].id);
                    $('#edit_principal').val(dados[0].main);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
                
                
                $('#updateAddressModal').modal('show');
            });
            //console.log(url);
            

        }//Fim aditRegistro()

        /**Formulário de atualização de registro */
        $('#updateAddressForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: `/update-customer-address/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateAddressModal').modal('hide');
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
        function deleteAddress(id) {
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
                        url: `/destroy-customer-address/${id}`,
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
        document.getElementById('edit_stateUF').value=("");
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
            document.getElementById('edit_stateUF').value=(conteudo.uf);
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
                document.getElementById('edit_stateUF').value="...";
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
   
