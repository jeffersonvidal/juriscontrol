@extends('layouts.admin')

@section('content')
<style>
    .btn-check {
        pointer-events: auto; /* Garante que os radio buttons sejam clicáveis */
    }
</style>


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Processos Jurídicos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Processos Jurídicos</li>
        </ol>
    </div>    
</div>


<div class="container-fluid px-4">

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Consultar Processos</span>
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            <div class="row">
                5407448-13.2024.8.09.0160 - Eduarda GO <br>
                0000230-47.2024.5.10.0018 - Felipe DF
                <form id="consultaCNJForm" class="row g-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" id="numeroCNJ" name="numeroCNJ" value="{{ old('numeroCNJ') }}" placeholder="Informe o nº CNJ">
                        
                        <div class="input-group-btn">
                            <button type="buton" id="botaoConsulta" class="btn btn-primary" data-acao="consulta"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row" id="tramitacoes-list" style="margin: 15px"></div>

            <div id="tramitacoes-accordion" class="accordion mt-4"></div>
            
            
        </div><!--fim card-body-->
    </div><!--fim card -->



</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        $('#consultaCNJForm').on('submit', function(e) {
            e.preventDefault();
            var numeroCnj = $('#numeroCNJ').val();
            $.ajax({
                url: '{{ route('legal-processes.search') }}',
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    var tramitacoesAccordion = $('#tramitacoes-accordion');
                        tramitacoesAccordion.empty();

                        response[0].hits.hits.forEach(function(tramitacao, index) {
                            let grau = '';
                            if(tramitacao._source.grau == 'GI'){
                                grau = '1ª Instância';
                            }
                        var accordionItem = `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading${index}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="true" aria-controls="collapse${index}">
                                        Tramitação ${index + 1}: ${tramitacao._source.classe.nome}
                                    </button>
                                </h2>
                                <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#tramitacoes-accordion">
                                    <div class="accordion-body">
                                        ${tramitacao.observacao}
                                    </div>
                                </div>
                            </div>
                        `;
                        tramitacoesAccordion.append(accordionItem);
                    });

                    /**--------------------------------------------- */
                    //console.log(response[0].hits.hits);
                    // var tramitacoesList = $('#tramitacoes-list');
                    // tramitacoesList.empty();
                    // response[0].hits.hits.forEach(function(tramitacao) {
                    //     console.log(tramitacao.data);
                    //     var listItem = $('<div>').text(
                    //             'Tipo de processo: - ' + tramitacao._source.classe.nome + ' - Movimentação'
                    //     );
                    //     tramitacoesList.append(listItem);
                    // });
                },
                error: function(response) {
                    //console.log(response.responseJSON);
                    console.error('Erro:', error);
                    if(response.responseJSON){
                        Swal.fire('Erro!', response.responseJSON.message, 'error');
                    }
                }
            });
        });
        
    });

    /**Mostrar resultados vindos via json */
    // document.addEventListener('DOMContentLoaded', function() {
    //     fetch('') /** url ex: /clientes*/
    //         .then(response => response.json())
    //         .then(data => {
    //             let clientesList = document.getElementById('clientes-list');
    //             data.forEach(cliente => {
    //                 let listItem = document.createElement('li');
    //                 listItem.textContent = `Nome: ${cliente.nome}, Email: ${cliente.email}`;
    //                 clientesList.appendChild(listItem);
    //             });
    //         })
    //         .catch(error => console.error('Erro:', error));
    // });

    
</script>

@endsection
   
