@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuários</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Usuários</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar</span>

            <span class="ms-auto">
                <a  class="btn btn-sm btn-primary text-decoration-none" href=""><i class="fa-solid fa-plus"></i> Cadastrar</a>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data Nasc.</th>
                    <th class="d-flex flex-row justify-content-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Fulano</td>
                        <td>email@email.com</td>
                        <td>123.654.789-21</td>
                        <td>01/09/1980</td>
                        <td>
                        <span class="d-flex flex-row justify-content-center">
                            <a href="" class="text-decoration-none btn btn-sm" title="Alterar Registro"><i class="fa-solid fa-pencil"></i></a>
                            <a href="" class="text-decoration-none btn btn-sm text-danger" title="Excluir Registro"><i class="fa-solid fa-trash"></i></a>
                        </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!--fim card-body-->
    </div>
</div>


@endsection
    
