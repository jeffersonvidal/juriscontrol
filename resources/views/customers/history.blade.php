@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Cliente</h2>

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
                <a class="btn btn-icon-split btn-secondary btn-sm me-1 mb-1 mb-sm-0" href="{{ route('customers.index') }}" title="Cadastrar Novo Processo"><i class="fa-regular fa-file-lines"></i> Novo Processo</a>
                <a href="" class="btn btn-secondary btn-sm me-1 mb-1 mb-sm-0" title="Cadastrar Novo Consultivo"><i class="fa-solid fa-book"></i> Novo Consultivo</a>
                <a class="btn btn-secondary btn-sm me-1 mb-1 mb-sm-0" href="{{ route('customers.index') }}" title="Cadastrar Novo Endereço"><i class="fa-solid fa-earth-americas"></i> Novo Endereço</a>
                <form action="" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Tem certeza que deseja APAGAR este registro?')" class="btn btn-danger btn-sm me-1 mb-1 mb-sm-0" title="Excluir Registro"><i class="fa-solid fa-trash-can"></i> Excluir cliente</button>
                </form>
            </span><!-- fim Botões de gestão do cliente -->

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            <!-- Estrutura de Abas -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-dadosPessoais-tab" data-bs-toggle="pill" data-bs-target="#pills-dadosPessoais" type="button" role="tab" aria-controls="pills-dadosPessoais" aria-selected="true"><i class="fa-regular fa-user"></i> Dados Pessoais</button>
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
                                        <div class="col-md-4"><strong>Cidade:</strong> {{ $address->city }} - UF: {{ $address->uf }}.</div> 
                                        <div class="col-md-4"><strong>CEP:</strong> {{ $address->zipcode }}</div>
                                    </div>
                                </div>
                                <form action="" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-secondary btn-sm me-1 mb-1 mb-sm-0 float-end" onclick="return confirm('Tem certeza que deseja APAGAR este registro?')" title="Excluir Endereço"><i class="fa-solid fa-trash-can"></i> Excluir Endereço</button>
                                </form>
                            </div>
                            
                            @empty
                            {{-- Mostra mensagem de erro --}}
                            <div class="alert alert-danger" role="alert">
                                Nenhum endereço encontrado.
                            </div>
                        @endforelse
                        
                        
                    </fieldset>

                </div><!-- fim Dados Pessoais -->
                
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




</div><!--fim container-fluid-->



@endsection
   
