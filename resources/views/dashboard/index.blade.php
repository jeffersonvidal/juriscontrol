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

    <div class="row">
        <!-- gráfico receita vs despesas -->
        <div class="col-md-12">

            <!-- visão geral do sistema -->
            <div class="card mb-4 shadow-sm border-light">
                <div class="card-header hstack gap-2">
                    <i class="fa-solid fa-gavel"></i> <span>VISÃO GERAL - FINANCEIRO</span>
                </div>


                <div class="card-body">
                    <!-- componente de mensagens e alertas -->    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4 border-light shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="card container text-center">
                                                <div class="card-header text-bg-primary p-3 row align-items-end">
                                                    <div class="col">
                                                        <h5 class="card-title"><i class="fa-solid fa-circle-up"></i> Rec. Semana</h5>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="card-title ms-auto">{{ 'R$' . number_format($incomeWeek, 2, ',', '.') }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card container text-center">
                                                <div class="card-header text-bg-danger p-3 row align-items-end">
                                                    <div class="col">
                                                        <h5 class="card-title"><i class="fa-solid fa-circle-down"></i> Des. Semana</h5>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="card-title ms-auto">{{ 'R$' . number_format($expenseWeek, 2, ',', '.') }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card container text-center">
                                                <div class="card-header text-bg-<?php echo ($cashBalance <= 0 ? 'danger' : 'success')?> p-3 row align-items-end">
                                                    <div class="col">
                                                        <h5 class="card-title"><i class="fa-solid fa-sack-dollar"></i> Saldo/Caixa</h5>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="card-title ms-auto">{{ 'R$' . number_format($cashBalance, 2, ',', '.') }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--fim row align-items-center -->
                                    
                                    <!--Gráfico Receita vs Despesas -->
                                    <div id="chart_div" style="width: 100%; height: 500px;"></div>

                                </div><!--fim card-body-->
                            </div><!--fim card mb-4 border-light shadow-sm-->

                        </div><!--col-md-8 -->


                        <!-- Resumo jurídico do dia -->
                        <div class="col-md-4">
                            <div class="row">
                                <h4>Responsabilidades Para Hoje</h4>

                                <div class="col mb-4">
                                    <div class="card border border-4 border-dark border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2 text-lg-center">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Audiências</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $hearingsToday }}</h3></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card border border-4 border-dark border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2 text-lg-center">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Tarefas</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $tasksToday }}</h3></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card border border-4 <?php echo ($lateTasks > 0 ? 'border-danger' : 'border-dark')?> <?php echo ($lateTasks > 0 ? 'text-bg-danger' : '')?> border-top-0 border-end-0 border-bottom-0 shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2 text-lg-center">
                                                    <div class="text-xs font-weight-bold <?php echo ($lateTasks > 0 ? 'text-light' : 'text-primary')?> text-uppercase mb-1">
                                                        Tarefas Atrasadas</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{ $lateTasks }}</h3></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-4">
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

    
        
    </div>


</div><!-- fim container-->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Mês', 'Receitas', 'Despesas'],
                @foreach($invoices as $row)
                    ['{{ $row['month'] }}', {{ $row['income'] }}, {{ $row['expense'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Receita vs Despesas',
                hAxis: {title: 'Meses', titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
      }
    </script>


    
@endsection