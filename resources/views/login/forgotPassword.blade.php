@extends('layouts.login')

@section('content')

<div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><img title="Área Restrita" alt="Área Restrita" src="http://localhost:8000\imgs\logoLogin.png" width="250" /></h3></div>

                                    <h3 class="text-center mt-3">Recuperar Senha</h3>
                                    <div class="card-body">
                                        <!-- componente de mensagens de alerta -->
                                        <x-alerts />
                                        

                                        <form action="{{ route('forgot-password.submit') }}" method="POST">
                                            @csrf
                                            @method('POST')

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" name="email" type="email" placeholder="Digite seu email" value="{{ old('email') }}" />
                                                <label for="email">Digite seu Email</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Recuperar Senha <i class="fa-solid fa-paper-plane"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                    <!-- <div class="small">Precisa de uma conta? <a class="text-decoration-none" href="">Criar conta!</a></div> -->
                                    <div class="small">Clique aqui para <a class="text-decoration-none" href="{{ route('login.index') }}">Acessar</a></div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        
    
@endsection