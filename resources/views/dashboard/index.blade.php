@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3"><i class="fas fa-tachometer-alt"></i> Painel</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
        </ol>
    </div>

    <!-- Conteúdo -->
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sua Agenda Hoje</h5>
                    <!--quadros contadores -->
                    <div class="row">
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Audiências</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $hearingsToday }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $hearingsToday }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas Atrasadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 <?php echo ($getUserLateTasks > 0 ? 'text-danger' : '')?>"><h3>{{ $getUserLateTasks }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Petições
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getUserExternalPetition }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fim quadros contadores -->
                    <h5 class="card-title">Sua Agenda Amanhã</h5>
                    <!--quadros contadores -->
                    <div class="row">
                    <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Audiências</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getUserTomorowHearing }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getUserTomorowTask }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas Atrasadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 <?php echo ($getUserLateTasks > 0 ? 'text-danger' : '')?>"><h3>{{ $getUserLateTasks }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Petições</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getUserTomorowExternalPetition }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fim quadros contadores -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agenda Escritório Hoje</h5>
                    <!--quadros contadores -->
                    <div class="row">
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Audiências</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $hearingsToday }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $tasksToday }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas Atrasadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 <?php echo ($lateTasks > 0 ? 'text-danger' : '')?>"><h3>{{ $lateTasks }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Petições
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $hearingsToday }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fim quadros contadores -->
                    <h5 class="card-title">Agenda Escritório Amanhã</h5>
                    <!--quadros contadores -->
                    <div class="row">
                    <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Audiências</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getTomorowHearing }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getTomorowTask }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Tarefas Atrasadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 <?php echo ($lateTasks > 0 ? 'text-danger' : '')?>"><h3>{{ $lateTasks }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="card border shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 text-lg-center">
                                            <div style="font-size:12px; font-weight:bold;" class="text-uppercase mb-1">
                                                Petições</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $getTomorowExternalPetition }}</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fim quadros contadores -->
                </div>
            </div>
        </div>
    </div>

    <!--Financeiro -->
    <div class="row mt-4">
        <!-- gráfico receita vs despesas -->
        <div class="col-md-12">

            <!-- visão geral do sistema -->
            <div class="card mb-4 shadow-sm border">
                <!-- <div class="card-header hstack gap-2">
                    <i class="fa-solid fa-sack-dollar"></i> <span>VISÃO GERAL - FINANCEIRO</span>
                </div> -->


                <div class="card-body">
                    <!-- componente de mensagens e alertas -->    
                    <div class="row">
                        <div class="col-md-7"><!-- financeiro + gráfico -->
                        <h4>Histórico Financeiro Mensal</h4>
                            <!--Gráfico Receita vs Despesas -->
                            <div id="chart_div" style="width: 100%; height: 500px;"></div>
                        </div><!--col-md-7 -->


                        <!-- Resumo jurídico do dia -->
                        <div class="col-md-5">
                            <div class="row">
                                <h4>Financeiro</h4>
                                <!--Saldo em caixa -->
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="p-2"><span>Saldo em caixa</span></div>
                                        <div class="p-2"><span class="ms-auto">{{ 'R$' . number_format($cashBalance, 2, ',', '.') }}</span></div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-<?php echo ($cashBalance <= 0 ? 'warning' : 'success')?>" style="width: 100%"></div>
                                    </div>
                                </div><!--Fim Saldo em caixa -->

                                <!--Pagar e receber hoje -->
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="col">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2"><i class="fa-solid fa-circle-down"></i> Essa Semana</div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-danger" style="width: 100%">{{ 'R$ ' . number_format($expenseWeek, 2, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2"><i class="fa-solid fa-circle-up"></i> Essa Semana</div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 100%">{{ 'R$ ' . number_format($incomeWeek, 2, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div><!--Fim Pagar e receber hoje -->

                                <!--Pagar e receber atrasado -->
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="col">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2"><i class="fa-solid fa-circle-down"></i> Atrasado</div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-danger" style="width: 100%">{{ 'R$ ' . number_format($expenseWeek, 2, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2"><i class="fa-solid fa-circle-up"></i> Atrasado</div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 100%">{{ 'R$ ' . number_format($incomeWeek, 2, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div><!--Fim Pagar e receber atrasado -->
                                
                                
                            </div><!--fim compromissos para hoje -->

                            

                            
                        </div><!-- fim col-md-4 - Resumo jurídico do dia -->


                    </div><!--fim row -->
            </div><!-- fim card mb-4 shadow-sm border-light -->
                    
            </div><!-- fim visão geral do sistema -->

                

        </div><!-- fim gráfico receita vs despesas -->

        


        <!-- visão jurídico -->
        <div class="card mb-4 shadow-sm border-light">
                    <div class="card-header hstack gap-2">
                        <i class="fa-solid fa-gavel"></i> <span>VISÃO GERAL - JURÍDICO</span>
                    </div>
    
    
                    <div class="card-body">
                        <!-- componente de mensagens e alertas -->    
                        
    
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border border-4 border-primary border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2 text-lg-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Audiências Hoje</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>3</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border border-4 border-warning border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2 text-lg-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Tarefas Hoje</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>17</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border border-4 border-danger border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2 text-lg-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Tarefas Atrasadas</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>8</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border border-4 border-dark border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2 text-lg-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Consultivos</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>32</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                        </div>
                    </div>
                    
                </div><!-- fim visão jurídico -->

    
        
    </div><!--Fim financeiro -->

    <!--Contratos e Aniversariantes -->
    <div class="row">
        <!--Contract Chart -->
        <div class="col-sm-4 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contratos</h5>
                    <!--quadros contadores -->
                    <div class="row">
                        <div class="newContractChart" id="newContractChart"></div>
                    </div>
                </div><!--Fim quadros contadores -->
        </div>
        </div>
        <!--Customers Chart -->
        <div class="col-sm-4 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Novos Clientes</h5>
                    <!--quadros contadores -->
                    <div class="row">
                        <div class="newCustomersChart" id="newCustomersChart"></div>
                    </div>
                    <!--Fim quadros contadores -->
                </div>
            </div>
        </div>
        <!--Aniversariantes -->
        <div class="col-sm-4 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <h5 clc="card-title"><i class="fa-solid fa-cake-candles"></i> Clientes Aniversariantes</h5>
                    <!--quadros contadores -->
                    <div class="row">
                        <table id="" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- puxando registros do banco de dados --}}
                                @if (count($getBirthdays) > 0)
                                    @foreach ($getBirthdays as $birthday)
                                        <tr>
                                        <td>{{ $birthday->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($birthday->birthday)->format('d/m') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr colspan="2" style="background-color: orange; text-align:center; margin:0 auto;">Nenhum aniversariante encontrado</tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!--Fim quadros contadores -->
                </div>
            </div>
        </div>
    </div>


</div><!-- fim container-->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        /**Receitas e Despesas */
            var data = google.visualization.arrayToDataTable([
                ['Mês', 'Receitas', 'Despesas'],
                @foreach($invoices as $row)
                    ['{{ $row['month'] }}', {{ $row['income'] }}, {{ $row['expense'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Receita vs Despesas',
                legend: 'bottom',
                hAxis: {title: 'Meses', titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);

        /**Novos Contratos */
        var dataNewContracts = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var optionsNewContracts = {
          pieHole: 0.3,
          legend: 'bottom',
          height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('newContractChart'));
        chart.draw(dataNewContracts, optionsNewContracts);

        /**Novos Clientes */
        var dataNewCustomers = google.visualization.arrayToDataTable([
          ['Mês', 'Novos Clientes'],
          @foreach($customersPerMonth as $customer) 
            ['{{ $customer->month }}', {{ $customer->count }}], 
          @endforeach
        ]);

        var optionsNewCustomers = {
          pieHole: 0.3,
          legend: 'bottom',
          height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('newCustomersChart'));
        chart.draw(dataNewCustomers, optionsNewCustomers);

      }
    </script>


    
@endsection