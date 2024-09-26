@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Escritórios Externos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Escritórios Externos</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar todos os registros</span>

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            
            <table id="datatablesSimple" class="table table-striped table-hover">
            <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Responsável</th>
                      <th>Telefone</th>
                      <th>Email</th>
                      <th>CNPJ</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- puxando registros do banco de dados --}}
                    @if (count($externalOffices) > 0)
                        @foreach ($externalOffices as $externalOffice)
                            <tr>
                            <td>{{ $externalOffice->name }}</td>
                            <td>{{ $externalOffice->responsible }}</td>
                            <td>{{ $externalOffice->phone }}</td>
                            <td>{{ $externalOffice->email }}</td>
                            <td>{{ $externalOffice->cnpj }}</td>
                                <td>
                                    <span class="d-flex flex-row justify-content-center">
                                        <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $externalOffice->id }}"
                                        data-name="{{ $externalOffice->name }}" data-responsible="{{ $externalOffice->responsible }}" data-phone="{{ $externalOffice->phone }}"
                                        data-email="{{ $externalOffice->email }}" data-cnpj="{{ $externalOffice->cnpj }}" 
                                        data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $externalOffice->id }}" ><i class="fa-solid fa-trash"></i></button>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr colspan="5">Nenhum registro encontrado</tr>
                    @endif
                    

                    
                </tbody>
            </table>
        </div><!--fim card-body-->
    </div><!--fim card -->




</div><!--fim container-fluid-->



@endsection
   
