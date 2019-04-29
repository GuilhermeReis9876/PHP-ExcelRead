<!doctype html>
<html lang="pt-br">

<head>
    <title>Senai - Sistema FIEMG</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/icons/favicon.ico" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Bootstrap-Material CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

    <!-- Fontes -->
    <link rel="stylesheet" href="fonts/fontes.css">

    <!-- Index.css -->
    <link rel="stylesheet" href="views/css/index.css">
</head>

<body>

    <div id="loading">
        <div id="loading-main">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            <h1 id="loading-teste">Enviando...</span></h1>
        </div>
    </div>


    <div id="main">
        <img src="assets/img/logo.jpg" alt="Logo Excel">
        <h1>Selecione seu arquivo e clique em enviar:</h1>
        <form id='form-excel' action="models/InserirTabela.php" method='POST' enctype="multipart/form-data">
            <div class="form-group">
                <label for="ipt-arquivo">Escolha um arquivo excel</label>
                <input type="file" accept=".xml" class="form-control-file" id="ipt-arquivo" name="arquivo">            
            </div>
            <div class="form-group">
                <label for="ipt-banco" class="bmd-label-floating">Nome do Banco</label>
                <input type="text" class="form-control" id="ipt-banco" name="nomeBanco">
            </div>
            <div class="form-group">
                <label for="ipt-tabela" class="bmd-label-floating">Nome da Tabela</label>
                <input type="text" class="form-control" id="ipt-tabela" name="nomeTabela">
            </div>
            <button id="btn-enviar" type="submit" type="button" class="btn btn-success">SELECIONE UM ARQUIVO</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
        src="https://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

    <script>
        $(document).ready(function(){
            $('#btn-enviar').click(function(e){
                e.preventDefault()  

                $(this).text('Enviando...')
                $(this).attr('disabled', true)

                $('#loading').css('display', 'flex')

                $('#form-excel').ajaxForm({
                    url: 'models/InserirTabela.php',
                    type: 'POST',
                    success: function(data) {
                        $('#btn-enviar').attr('disabled', false);
                        $('#btn-enviar').text('ENVIAR');
                        $('#ipt-banco').val('');
                        $('#ipt-tabela').val('');
                        $('#loading-teste').text('Enviado com sucesso!')
                        setTimeout(() => {
                            $('#loading').css('display', 'none')
                            $('#loading-teste').text('Enviando...')
                        }, 3000);

                    },
                    error: function(err) {
                        alert('deu ruim')
                        console.log(err)
                    }
                }).submit();
            })
        })
    </script>

    <script>
        arquivo = document.getElementById('ipt-arquivo');
        iptBanco = document.getElementById('ipt-banco');
        iptTabela = document.getElementById('ipt-tabela');

        if(arquivo.files.length === 0 || iptBanco.value == "" || iptTabela.value == "") {
            $('#btn-enviar').attr('disabled', true);
            $('#btn-enviar').text('SELECIONE UM ARQUIVO');
        } else {
            $('#btn-enviar').attr('disabled', false);
            $('#btn-enviar').text('ENVIAR');
        }

        arquivo.addEventListener('change', function(){
            if(arquivo.files.length === 0 || iptBanco.value == "" || iptTabela.value == "") {
                $('#btn-enviar').attr('disabled', true);  
                $('#btn-enviar').text('SELECIONE UM ARQUIVO');
            } else {
                $('#btn-enviar').attr('disabled', false);
                $('#btn-enviar').text('ENVIAR');
            }
        }) 

        iptBanco.addEventListener('keyup', function(){
            if(arquivo.files.length === 0 || iptBanco.value == "" || iptTabela.value == "") {
                $('#btn-enviar').attr('disabled', true);  
                $('#btn-enviar').text('SELECIONE UM ARQUIVO');
            } else {
                $('#btn-enviar').attr('disabled', false);
                $('#btn-enviar').text('ENVIAR');
            }
        }) 

        iptTabela.addEventListener('keyup', function(){
            if(arquivo.files.length === 0 || iptBanco.value == "" || iptTabela.value == "") {
                $('#btn-enviar').attr('disabled', true);  
                $('#btn-enviar').text('SELECIONE UM ARQUIVO');
            } else {
                $('#btn-enviar').attr('disabled', false);
                $('#btn-enviar').text('ENVIAR');
            }
        }) 
        
    </script>

</body>

</html>