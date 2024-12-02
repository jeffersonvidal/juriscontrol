<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerar PDF de {{ $documentPDF->title }}</title>
    <style>
        @page {
            margin: 120px 25px;
        }
        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            height: 70px;
            text-align: center;
        }
        footer {
            position: fixed;
            bottom: -90px;
            left: 0px;
            right: 0px;
            height: 70px;
            text-align: center;
            border-top: 2px solid #50301E;
            margin: 0 50px;
        }
        body {
            margin-top: 20px;
            margin-bottom: 5px;
        }

        a {
            text-decoration: none;
            color: #50301E;
        }

        section.content{
            padding: 0 50px;
        }

        .nomeEscritorio {
            text-align: left;
            color: #50301E;
            width: 70%;
        }

        .dadosEscritorio {
            text-align: right;
        }

        table {
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
  </head>
  <body>
    @if ($documentPDF->type != 'power_of_attorney')
        <header>
            <img src="{{ public_path('imgs/headerDocsBV.png') }}" alt="Header Docs BV" width="100%">
        </header>
    @endif

    <section class="content">
        {!! $documentPDF->content !!}
    </section>

    @if ($documentPDF->type != 'power_of_attorney')
        <footer>
            <div class="footerContainer">
                <table>
                    <tr>
                        <td>
                            <div class="nomeEscritorio">
                                <h2>Brandão Vidal Advogados</h2>
                            </div>
                        </td>

                        <td>
                            <div class="dadosEscritorio">
                                <dd><a href="https://brandaovidaladvogados.com.br" target="_blank">brandaovidaladvogados.com.br</a></dd>
                                <dd><a href="mailto:contato@brandaovidaladvogados.com.br" target="_blank">contato@brandaovidaladvogados.com.br</a></dd>
                                <dd><a href="https://wa.me/5561981261073?utm_source=Documento+Jur%C3%ADdico&utm_medium=Rodap%C3%A9+de+documento+feito+pelo+escrit%C3%B3rio" target="_blank">(61) 98126-1073</a></dd>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
        </footer>
    @endif

    
  </body>
</html>
