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
        <div class="col-md-12">

                <!-- visão geral do sistema -->
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
                    
                </div><!-- fim visão geral do sistema -->

        </div>
    
        
    </div>


</div><!-- fim container-->


    
@endsection