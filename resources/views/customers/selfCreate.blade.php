@extends('layouts.login')

@section('content')

<div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Formulário de cadastro de cliente</h3></div>
                                    <div class="card-body">
                                        <!-- componente de mensagens de alerta --> 
                                        <x-alerts />   
                                        

                                        <form id="createForm" class="row g-3">
                                            @csrf

                                            
                                            <fieldset>
                                                <legend>Dados Pessoais</legend>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="name" class="form-label">Nome</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="phone" class="form-label">Telefone</label>
                                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="rg" class="form-label">RG</label>
                                                        <input type="text" class="form-control" id="rg" name="rg" value="{{ old('rg') }}">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="rg_expedidor" class="form-label">Expedidor do RG</label>
                                                        <input type="text" class="form-control" id="rg_expedidor" name="rg_expedidor" value="{{ old('rg_expedidor') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="cpf" class="form-label">CPF</label>
                                                        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}">
                                                    </div>
                                                
                                                    <div class="col-md-4 mb-3">
                                                        <label for="marital_status" class="form-label">Estado Civil</label>
                                                        <select class="form-select" name="marital_status" id="marital_status">
                                                            <option value="" >Escolha um</option>
                                                            <option value="solteiro(a)">Solteiro (a)</option>
                                                            <option value="casado(a)">Casado (a)</option>
                                                            <option value="divorciado(a)">Divorciado (a)</option>
                                                            <option value="viúvo(a)">Viúvo (a)</option>
                                                        </select>
                                                    </div>
                                                
                                                    <div class="col-md-4 mb-3">
                                                        <label for="nationality" class="form-label">Nacionalidade</label>
                                                        <select class="form-select" name="nationality" id="nationality">
                                                            <option value="brasileiro(a)">Brasileiro (a)</option>
                                                            <option value="estrangeiro(a)">Estrangeiro (a)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="profession" class="form-label">Profissão</label>
                                                        <input type="text" class="form-control" id="profession" name="profession" value="{{ old('profession') }}">
                                                    </div>
                                                
                                                    <div class="col-md-4 mb-3">
                                                        <label for="birthday" class="form-label">Nascimento</label>
                                                        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="met_us" class="form-label">Como nos conheceu?</label>
                                                        <select class="form-select" name="met_us" id="met_us">
                                                            <option value="google">Google</option>
                                                            <option value="Instagram">Instagram</option>
                                                            <option value="tiktok">Tiktok</option>
                                                            <option value="facebook">Facebook</option>
                                                            <option value="kwai">Kwai</option>
                                                            <option value="indicação">Indicação</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <!-- ['company_id', 'name','email','phone','rg',
                                'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday']; -->
                                            </fieldset>
                                            
                                            <fieldset>
                                                <legend>Endereço</legend>
                                                <div class="row">
                                                    <div class="col-md-2 mb-3">
                                                        <label for="cep" class="form-label">CEP (Só nº)</label>
                                                        <input onblur="pesquisacep(this.value);" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="99999999" value="{{ old('zipcode') }}">
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="street" class="form-label">Rua</label>
                                                        <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}">
                                                    </div>
                                                
                                                    <div class="col-md-2 mb-3">
                                                        <label for="num" class="form-label">Número</label>
                                                        <input type="text" class="form-control" id="num" name="num" value="{{ old('num') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="complement" class="form-label">Complemento</label>
                                                        <input type="text" class="form-control" id="complement" name="complement" value="{{ old('complement') }}">
                                                    </div>
                                                
                                                    <div class="col-md-4 mb-3">
                                                        <label for="neighborhood" class="form-label">Bairro</label>
                                                        <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="{{ old('neighborhood') }}">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="city" class="form-label">Cidade</label>
                                                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="state" class="form-label">UF</label>
                                                        <input type="text" class="form-control" id="stateUF" name="state" max="2" value="{{ old('state') }}">
                                                    </div>
                                                </div>

                                            </fieldset>

                                            
                                            <div class="col-md-12">
                                                @php
                                                    $url = $_SERVER['REQUEST_URI'];
                                                    $pathSegments = explode('/', trim($url, '/'));
                                                    $id = end($pathSegments);
                                                @endphp
                                                <input type="hidden" class="form-control" id="company_id" name="company_id" value="<?php echo $id; ?>">                 
                                            </div>

                                            <button type="submit" class="btn btn-primary addButton">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                    <div class="small">Precisa de uma conta? <a class="text-decoration-none" href="">Criar conta!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Brandão Vidal Advogados 2024-{{ date('Y') }}</div>
                            <div>
                                <a class="text-decoration-none" href="#">Política de Privacidade</a>
                                &middot;
                                <a class="text-decoration-none" href="#">Termos &amp; Condições</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        
<script>
    /**Add in database - store */
    $(document).ready(function(){
        const url = window.location.href;
        const urlObj = new URL(url);
        const pathSegments = urlObj.pathname.split('/');
        const id = pathSegments[pathSegments.length - 1];
        //console.log(id); // Deve imprimir "5"



        /** Cadastrar registro funcionando com sucesso */
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            let url = "{{ route('customers.store-self', 'id') }}";
            //let id = '1';
            url = url.replace('id', id);
            $.ajax({
                url: url,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
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
        
    });

    /**ViaCEP - Cadastro*/
    function limpa_formulário_cep() {
        //Limpa valores do formulário de Create.
        document.getElementById('street').value=("");
        document.getElementById('neighborhood').value=("");
        document.getElementById('city').value=("");
        document.getElementById('stateUF').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores no form Create.
            document.getElementById('street').value=(conteudo.logradouro);
            document.getElementById('neighborhood').value=(conteudo.bairro);
            document.getElementById('city').value=(conteudo.localidade);
            document.getElementById('stateUF').value=(conteudo.uf);
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