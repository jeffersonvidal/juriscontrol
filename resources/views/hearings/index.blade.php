@extends('layouts.admin')

@section('content')
<style>
    .btn-check {
        pointer-events: auto; /* Garante que os radio buttons sejam clicáveis */
    }
</style>


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Audiências, Reuniões e Diligências</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Audiências, Reuniões e Diligências</li>
        </ol>
    </div>    
</div>


<div class="container-fluid px-4">

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
                        <th>Objeto</th>
                        <th>Responsável</th>
                        <th>Status</th>
                        <th>Data/Hora</th>
                        <th>Origem</th>
                        <th>Cliente</th>
                        <th>Local</th>
                        <th>Tipo</th>
                        <th>Pago</th>
                        <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($hearings) > 0)
                        @foreach ($hearings as $hearing)
                            <tr>
                             <td>{{ $hearing->getObject($hearing->id) }}</td> 
                             <td>{{ $hearing->getResponsible($hearing->responsible)->name }}</td> 
                            <td>{{ $hearing->getStatus($hearing->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($hearing->date_happen)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($hearing->time_happen)->format('H:i') }}</td>
                            <td>{{ $hearing->getExternalOffices($hearing->external_office_id) }}</td>
                            <td>{{ $hearing->client }}</td>
                            <td>{{ $hearing->local }}</td>
                            <td>{{ $hearing->getType($hearing->type) }}</td>
                            <td>{{ $hearing->getPaymentStatus($hearing->id) }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm paymentBtn" title="Ver Detalhes" 
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="fa-solid fa-eye"></i></button>
                                        
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro"  
                                        data-id="{{ $hearing->id }}" data-object="{{ $hearing->object }}" data-company_id="{{ $hearing->company_id }}"
                                        data-user_id="{{ $hearing->user_id }}" data-date_happen="{{ $hearing->date_happen }}" data-responsible="{{ $hearing->responsible }}"
                                        data-status="{{ $hearing->status }}" data-time_happen="{{ $hearing->time_happen }}" data-external_office_id="{{ $hearing->external_office_id }}"
                                        data-client="{{ $hearing->client }}" data-local="{{ $hearing->local }}" data-type="{{ $hearing->type }}"
                                        data-process_num="{{ $hearing->process_num }}" data-modality="{{ $hearing->modality }}" data-informed_client="{{ $hearing->informed_client }}"
                                        data-informed_witnesses="{{ $hearing->informed_witnesses }}" data-link="{{ $hearing->link }}" data-notes="{{ $hearing->notes }}"
                                        data-amount="{{ $hearing->amount }}" data-payment_status="{{ $hearing->payment_status }}" 
                                        data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro"  
                                        data-id="{{ $hearing->id }}">
                                        <i class="fa-solid fa-trash"></i></button>
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
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Audiência, Reunião ou Diligência</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="createForm" name="createForm" class="row g-3">
                @csrf
                
                <div class="col-md-4">
                    <label for="object" class="form-label">Objeto *</label>
                    <select id="object" name="object" class="form-select">
                        <option value="">Informe o objeto</option>
                        <option value="hearing">Audiência</option>
                        <option value="expertise">Perícia</option>
                        <option value="meeting">Reunião</option>
                        <option value="petition">Petição</option>
                        <option value="diligence">Diligência</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="responsible" class="form-label">Responsável *</label>
                    <select id="responsible" name="responsible" class="form-select">
                        <option value="">Informe o responsável</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Informe o status</option>
                        <option value="open">Aberto</option>
                        <option value="canceled">Cancelado</option>
                        <option value="completed">Concluído</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="date_happen" class="form-label">Data *</label>
                    <input type="date" class="form-control" id="date_happen" name="date_happen" value="{{ old('date_happen') }}">
                </div>

                <div class="col-md-2">
                    <label for="time_happen" class="form-label">Horário *</label>
                    <input type="time" class="form-control" id="time_happen" name="time_happen" value="{{ old('time_happen') }}">
                </div>
                <div class="col-md-3">
                    <label for="external_office_id" class="form-label">Escritório *</label>
                    <select id="external_office_id" name="external_office_id" class="form-select">
                        <option value="">Informe o Escritório</option>
                        <option value="{{ auth()->user()->company_id }}">Próprio</option>
                        @foreach ($externalOffices as $externalOffice)
                            <option value="{{$externalOffice->id }}">{{$externalOffice->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-md-4">
                    <label for="client" class="form-label">Cliente *</label>
                    <input type="text" class="form-control" id="client" name="client" value="{{ old('client') }}">
                </div>
            
                <div class="col-md-4">
                    <label for="local" class="form-label">Local *</label>
                    <input type="text" class="form-control" id="local" name="local" value="{{ old('local') }}">
                </div>

                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo *</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">Informe o Tipo</option>
                        <option value="initial">Inicial</option>
                        <option value="conciliation">Conciliação</option>
                        <option value="expert_due_dilivence">Diligência Pericial</option>
                        <option value="instruction">Instrução</option>
                        <option value="una">Una</option>
                        <option value="visit">Visita</option>
                        <option value="instruction_closure">Encerramento de Instrução</option>
                    </select>
                </div>
                <!-- 'object','company_id','user_id','responsible','status',
    'date_happen','time_happen','external_office_id','client','local','type',
    'process_num','modality','informed_client','informed_witnesses','link',
    'notes','amount','payment_status' -->
                <div class="col-md-4">
                    <label for="process_num" class="form-label">Processo Nº</label>
                    <input type="text" class="form-control" id="process_num" name="process_num" value="{{ old('process_num') }}">
                </div>

                <div class="col-md-2">
                    <label for="modality" class="form-label">Modalidade *</label>
                    <select id="modality" name="modality" class="form-select">
                        <option value="">Informe a Modalidade</option>
                        <option value="online">Online</option>
                        <option value="in_person">Presencial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="link" class="form-label">Link</label>
                    <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                </div>
                <div class="col-md-4">
                    <label for="wallet_id" class="form-label">Carteira *</label>
                    <select id="wallet_id" name="wallet_id" class="form-select">
                        <option value="">Informe a Carteira</option>
                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="amount" class="form-label">Valor *</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                </div>
                

                <div class="col-md-8 mt-5">
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" role="switch" id="informed_client" name="informed_client">
                        <label class="form-check-label" for="informed_client">Cliente Informado</label>
                    </div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" role="switch" id="informed_witnesses" name="informed_witnesses">
                        <label class="form-check-label" for="informed_witnesses">Testemunhas Informadas</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Pago</label>
                    <select id="payment_status" name="payment_status" class="form-select">
                        <option value="">Informe</option>
                        <option value="paid">Pago</option>
                        <option value="unpaid">Não Pago</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="notes" class="form-label">Observações</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                
                
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addBtn">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addModal -->

<!-- updateModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar Audiência, Reunião ou Diligência</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="updateForm" name="updateForm" class="row g-3">
                @csrf
                
                <div class="col-md-4">
                    <label for="object" class="form-label">Objeto *</label>
                    <select id="edit_object" name="object" class="form-select">
                        <option value="">Informe o objeto</option>
                        <option value="hearing">Audiência</option>
                        <option value="expertise">Perícia</option>
                        <option value="meeting">Reunião</option>
                        <option value="petition">Petição</option>
                        <option value="diligence">Diligência</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="responsible" class="form-label">Responsável *</label>
                    <select id="edit_responsible" name="responsible" class="form-select">
                        <option value="">Informe o responsável</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status *</label>
                    <select id="edit_status" name="status" class="form-select">
                        <option value="">Informe o status</option>
                        <option value="open">Aberto</option>
                        <option value="canceled">Cancelado</option>
                        <option value="completed">Concluído</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="date_happen" class="form-label">Data *</label>
                    <input type="date" class="form-control" id="edit_date_happen" name="date_happen" value="{{ old('date_happen') }}">
                </div>

                <div class="col-md-2">
                    <label for="time_happen" class="form-label">Horário *</label>
                    <input type="time" class="form-control" id="edit_time_happen" name="time_happen" value="{{ old('time_happen') }}">
                </div>
                <div class="col-md-3">
                    <label for="external_office_id" class="form-label">Escritório *</label>
                    <select id="edit_external_office_id" name="external_office_id" class="form-select">
                        <option value="">Informe o Escritório</option>
                        <option value="{{ auth()->user()->company_id }}">Próprio</option>
                        @foreach ($externalOffices as $externalOffice)
                            <option value="{{$externalOffice->id }}">{{$externalOffice->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-md-4">
                    <label for="client" class="form-label">Cliente *</label>
                    <input type="text" class="form-control" id="edit_client" name="client" value="{{ old('client') }}">
                </div>
            
                <div class="col-md-4">
                    <label for="local" class="form-label">Local *</label>
                    <input type="text" class="form-control" id="edit_local" name="local" value="{{ old('local') }}">
                </div>

                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo *</label>
                    <select id="edit_type" name="type" class="form-select">
                        <option value="">Informe o Tipo</option>
                        <option value="initial">Inicial</option>
                        <option value="conciliation">Conciliação</option>
                        <option value="expert_due_dilivence">Diligência Pericial</option>
                        <option value="instruction">Instrução</option>
                        <option value="una">Una</option>
                        <option value="visit">Visita</option>
                        <option value="instruction_closure">Encerramento de Instrução</option>
                    </select>
                </div>
                <!-- 'object','company_id','user_id','responsible','status',
    'date_happen','time_happen','external_office_id','client','local','type',
    'process_num','modality','informed_client','informed_witnesses','link',
    'notes','amount','payment_status' -->
                <div class="col-md-4">
                    <label for="process_num" class="form-label">Processo Nº</label>
                    <input type="text" class="form-control" id="edit_process_num" name="process_num" value="{{ old('process_num') }}">
                </div>

                <div class="col-md-4">
                    <label for="modality" class="form-label">Modalidade *</label>
                    <select id="edit_modality" name="modality" class="form-select">
                        <option value="">Informe a Modalidade</option>
                        <option value="online">Online</option>
                        <option value="in_person">Presencial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="link" class="form-label">Link</label>
                    <input type="text" class="form-control" id="edit_link" name="link" value="{{ old('link') }}">
                </div>
                <div class="col-md-4">
                    <label for="amount" class="form-label">Valor *</label>
                    <input type="text" class="form-control" id="edit_amount" name="amount" value="{{ old('amount') }}">
                </div>

                <div class="col-md-8 mt-5">
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" role="switch" id="edit_informed_client" name="informed_client" value="s">
                        <label class="form-check-label" for="informed_client">Cliente Informado</label>
                    </div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" role="switch" id="edit_informed_witnesses" name="informed_witnesses" value="s">
                        <label class="form-check-label" for="informed_witnesses">Testemunhas Informadas</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Pago</label>
                    <select id="edit_payment_status" name="payment_status" class="form-select">
                        <option value="">Informe</option>
                        <option value="paid">Pago</option>
                        <option value="unpaid">Não Pago</option>
                    </select>
                </div>

                <div class="paymentMethod" style="display:none;">
                    <div class="col-md-12">
                        <label for="pay_day" class="form-label">Forma de Pagamento</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        
                        <div class="btn-group col-md-12 mb-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="method" id="pix" value="pix">
                            <label class="btn btn-sm btn-outline-dark" for="pix">PIX</label>

                            <input type="radio" class="btn-check" name="method" id="card" value="card">
                            <label class="btn btn-sm btn-outline-dark" for="card">Cartão</label>

                            <input type="radio" class="btn-check" name="method" id="money" value="money">
                            <label class="btn btn-sm btn-outline-dark" for="money">Dinheiro</label>

                            <input type="radio" class="btn-check" name="method" id="ted" value="ted">
                            <label class="btn btn-sm btn-outline-dark" for="ted">TED</label>

                            <input type="radio" class="btn-check" name="method" id="bank_slip" value="bank_slip">
                            <label class="btn btn-sm btn-outline-dark" for="bank_slip">Boleto</label>
                        </div>
                    </div>
                </div><!--end paymentMethod-->

                <div class="col-md-12">
                    <label for="notes" class="form-label">Observações</label>
                    <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                </div>
                
                
                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="edit_user_id" name="user_id" value="{{ auth()->user()->id }}">                 
                    <input type="hidden" class="form-control" id="edit_id" name="id" value="{{ $hearing->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addBtn">Salvar Alterações <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim updateModal -->

</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('hearings.store') }}',
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
                            object: $(this).attr('data-object'), 
                            company_id: $(this).attr('data-company_id'), 
                            user_id: $(this).attr('data-user_id'), 
                            responsible: $(this).attr('data-responsible'), 
                            status: $(this).attr('data-status'), 
                            date_happen: $(this).attr('data-date_happen'), 
                            time_happen: $(this).attr('data-time_happen'), 
                            external_office_id: $(this).attr('data-external_office_id'), 
                            client: $(this).attr('data-client'), 
                            local: $(this).attr('data-local'), 
                            type: $(this).attr('data-type'), 
                            process_num: $(this).attr('data-process_num'), 
                            modality: $(this).attr('data-modality'), 
                            informed_client: $(this).attr('data-informed_client'), 
                            informed_witnesses: $(this).attr('data-informed_witnesses'), 
                            link: $(this).attr('data-link'), 
                            notes: $(this).attr('data-notes'), 
                            type: $(this).attr('data-type'), 
                            amount: $(this).attr('data-amount'), 
                            payment_status: $(this).attr('data-payment_status'), 
                        }
                        
                    ];
                    editRegistro(dados);
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
        function editRegistro(dados) {
            let url = "{{ route('hearings.show', 'id') }}";
            url = url.replace('id', dados[0].id);
            //console.log(url);
            /**Preenche os campos do form de atualização*/
            $.get(url, function() {
                fetch(url)
                .then(response => {
                    if (!response.ok) {
                    throw new Error('Erro na rede: ' + response.statusText);
                    }
                    return response.json();
                    //console.log('Response: ' + response);
                })
                .then(data => {
                    //console.log(data.description);
                    //console.log(data[0]); //lista dados pessoais
                    /**console.log(data[0][0]['invoice']); //lista dados pessoais
                    /** console.log(data[0][0]); //Lista dados do endereço */
                    /**Dados pessoais*/
                    $('#edit_id').val(data.id);
                    $('#edit_object').val(data.object);
                    $('#edit_company_id').val(data.company_id);
                    $('#edit_user_id').val(data.user_id);
                    $('#edit_responsible').val(data.responsible);
                    $('#edit_status').val(data.status);
                    $('#edit_date_happen').val(data.date_happen);
                    $('#edit_time_happen').val(data.time_happen);
                    $('#edit_external_office_id').val(data.external_office_id);
                    $('#edit_client').val(data.client);
                    $('#edit_local').val(data.local);
                    $('#edit_type').val(data.type);
                    $('#edit_process_num').val(data.process_num);
                    $('#edit_modality').val(data.modality);
                    $('#edit_informed_client').val(data.informed_client);
                    $('#edit_informed_witnesses').val(data.informed_witnesses);
                    $('#edit_link').val(data.link);
                    $('#edit_notes').val(data.notes);
                    $('#edit_payment_status').val(data.payment_status);
                    $('#edit_amount').val(data.amount);
                    /**Verifica Se cliente e testemunhas foram informados */
                    if(data.informed_client === 's'){
                        document.querySelector('#edit_informed_client').checked = true;
                    }else{
                        document.querySelector('#edit_informed_client').checked = false;
                    }
                    if(data.informed_witnesses === 's'){
                        document.querySelector('#edit_informed_witnesses').checked = true;
                    }else{
                        document.querySelector('#edit_informed_witnesses').checked = false;
                    }
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
                url: `/update-hearing/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
                    //$('#invoicesTable').DataTable().ajax.reload();
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
                        url: `/destroy-hearing/${id}`,
                        method: 'DELETE',
                        success: function() {
                            //$('#invoicesTable').DataTable().ajax.reload();
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
   
