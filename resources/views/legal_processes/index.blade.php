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
                <div class="input-group">
                    <input type="text" class="form-control" id="numeroCNJ" name="numeroCNJ" value="{{ old('numeroCNJ') }}" placeholder="Informe o nº CNJ">
                    
                    <div class="input-group-btn">
                        <button type="buton" id="botaoConsulta" class="btn btn-primary" data-acao="consulta"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>

            <div class="row" id="resultadoProcesso" style="margin: 15px"></div>
            
            
        </div><!--fim card-body-->
    </div><!--fim card -->



</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        $("#botaoConsulta").on('click', function(){
            $('#campo_erro').removeClass('bg-warning');
            let data = {acao: $(this).data().acao, numeroCNJ: $('#numeroCNJ').val()};
            $.ajax({
                type: "POST",
                url: `store-legal-process`,
                dataType: "",
                data: data,
            })
            .done(function(result) {
                console.log('resultado: ');
                console.log(result);
                if (result.match('Erro')) {
                    console.log('entrou no if')
                    $('#campo_erro').addClass('bg-warning');
                    $('#campo_erro').html(result);
                } else {
                    $('#resultadoProcesso').html(result);
                }
            });
        });
        
    });

    
</script>

@endsection
   
