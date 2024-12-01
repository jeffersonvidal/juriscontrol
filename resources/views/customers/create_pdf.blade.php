@extends('layouts.admin')

@section('content')


<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Clientes - Gerar PDF</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header hstack gap-2">
            <span>Listar todos os registros</span>

            <span class="ms-auto">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Cadastrar</button>
            </span>
        </div><!--fim card-header-->

        <div class="card-body">
            <x-alerts />

            {!! $documentPDF->content !!}
            
        </div><!--fim card-body-->
    </div><!--fim card -->



</div><!--fim container-fluid-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /**Add in database - store */
    $(document).ready(function(){
        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('customers.store') }}',
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
            // ['company_id', 'name','email','phone','rg',
            // 'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday'];
            if($(this).hasClass('editBtn')){
                var dados = [
                        { 
                            id: $(this).attr('data-id'), 
                            name: $(this).attr('data-name'), 
                            email: $(this).attr('data-email'), 
                            phone: $(this).attr('data-phone'), 
                            rg: $(this).attr('data-rg'), 
                            rg_expedidor: $(this).attr('data-rg_expedidor'), 
                            cpf: $(this).attr('data-cpf'), 
                            marital_status: $(this).attr('data-marital_status'), 
                            nationality: $(this).attr('data-nationality'), 
                            profession: $(this).attr('data-profession'), 
                            birthday: $(this).attr('data-birthday'), 
                            /** Endereço*/
                            zipcode: $(this).attr('data-zipcode'), 
                            street: $(this).attr('data-street'), 
                            num: $(this).attr('data-num'), 
                            complement: $(this).attr('data-complement'), 
                            neighborhood: $(this).attr('data-neighborhood'), 
                            city: $(this).attr('data-city'), 
                            state: $(this).attr('data-state'), 
                        }
                    ];
                    //console.log(dados[0].id);
                    //editRegistro($(this).attr('data-id'));
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
            let url = "{{ route('customers.show', 'id') }}";
            url = url.replace('id', dados[0].id);
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
                    /**Dados pessoais*/
                    //console.log(data['address'][0].city);
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_email').val(data.email);
                    $('#edit_phone').val(data.phone);
                    $('#edit_rg').val(data.rg);
                    $('#edit_rg_expedidor').val(data.rg_expedidor);
                    $('#edit_cpf').val(data.cpf);
                    $('#edit_marital_status').val(data.marital_status);
                    $('#edit_nationality').val(data.nationality);
                    $('#edit_profession').val(data.profession);
                    $('#edit_birthday').val(data.birthday);
                    $('#edit_met_us').val(data.met_us);

                    /**Endereço*/
                    $('#edit_cep').val(data['address'][0].zipcode);
                    $('#edit_street').val(data['address'][0].street);
                    $('#edit_num').val(data['address'][0].num);
                    $('#edit_complement').val(data['address'][0].complement);
                    $('#edit_neighborhood').val(data['address'][0].neighborhood);
                    $('#edit_city').val(data['address'][0].city);
                    $('#edit_state').val(data['address'][0].state);
                    $('#edit_customer_id').val(data['address'][0].customer_id);
                    //$('#edit_address_id').val(data['address'][0].id);
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
            let url = "{{ route('customers.update', 'id') }}";
            var id = $('#edit_id').val();
            url = url.replace('id', id);
            
            console.log(url);
            $.ajax({
                //url: `/update-customer/${id}`,
                url: url,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#updateModal').modal('hide');
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
                        url: `/destroy-customer/${id}`,
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
        document.getElementById('edit_state').value=("");
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
            document.getElementById('edit_state').value=(conteudo.uf);
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
                document.getElementById('edit_state').value="...";
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
   
