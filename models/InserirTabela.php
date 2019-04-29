<?php

    set_time_limit(0);

    # Informa qual o conjunto de caracteres será usado.
    header('Content-Type: text/html; charset=utf-8');

    $nomeBanco = $_POST['nomeBanco'];
    $nomeTabela = $_POST['nomeTabela'];

    // Checando se foi passado o arquivo corretamente
    if(!empty($_FILES['arquivo']['tmp_name'])) {
        $arquivo = new DomDocument();

        // Transformando a variavel $arquivo em um documento légivel XML
        $arquivo->load($_FILES['arquivo']['tmp_name']);

        // Buscando somente as Rows do documento
        $linhas = $arquivo->getElementsByTagName('Row');

        $link = mysqli_connect("localhost", "root", "root");


        // Criando Banco
        $teste = mysqli_query($link, "CREATE DATABASE `$nomeBanco` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;");

        require_once('../class/ConexaoClass.php');
        $objConexao = new ConexaoClass("localhost", "root", "root", "$nomeBanco");

        # MySQL UTF-8
        $objConexao->executarComandoSQL("SET NAMES 'utf8'");
        $objConexao->executarComandoSQL('SET character_set_connection=utf8');
        $objConexao->executarComandoSQL('SET character_set_client=utf8');
        $objConexao->executarComandoSQL('SET character_set_results=utf8');

        // Vetor que recebe nome dos campos
        $campos = [];

        // Preenchendo vetor com os nomes
        for($i = 0; $i < 10; $i++) {
            if(isset($linhas[0]->getElementsByTagName('Data')->item($i)->nodeValue)) {
                $item = $linhas[0]->getElementsByTagName('Data')->item($i)->nodeValue;
                array_push($campos, $item);
            }
        }

        $numCampos = sizeof($campos);
        $ultimoCampo = sizeof($campos) - 1;

        // Criando query que cria a tabela
        $query = "CREATE TABLE `$nomeTabela` ( ";

        for($i = 0; $i < $numCampos; $i++) {
            if ($i != $ultimoCampo) {
                $query = $query . " $campos[$i] varchar(100), ";
            }
            else {
                $query = $query . " $campos[$i] varchar(100) ) CHARACTER SET utf8 COLLATE utf8_general_ci; ";
            }
        }

        $objConexao->executarComandoSQL($query);


        // Criando query que insere itens
        for($i = 1; $i < sizeof($linhas); $i++) {

                $queryInsert = "INSERT INTO $nomeTabela VALUES ( ";

                for($x = 0; $x < $numCampos; $x++) {
                    if ($x != $ultimoCampo) {
                        $valor = $linhas[$i]->getElementsByTagName('Data')->item($x)->nodeValue;
                        $queryInsert = $queryInsert . " ' $valor ' , ";
                    }
                    else {
                        $valor = $linhas[$i]->getElementsByTagName('Data')->item($x)->nodeValue;
                        $queryInsert = $queryInsert . " ' $valor ' ) ";
                    }
                }        
                $objConexao->executarComandoSQL($queryInsert);
        }
    }
   
?>