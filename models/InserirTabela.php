<?php

    set_time_limit(0);

    # Informa qual o conjunto de caracteres será usado.
    header('Content-Type: text/html; charset=utf-8');

    $nomeBanco = $_POST['nomeBanco'];
    $nomeTabela = $_POST['nomeTabela'];
    $csvTable = $_POST['csv'];

    $filename = "../csv/".time().".csv";
    $myfile = fopen($filename, "w");
    fwrite($myfile, $csvTable);
    fclose($myfile);

if($csvTable!=''){
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


        $fn = fopen($filename,"r");
        $header = fgets($fn);
        fclose($fn);
        $campos = explode (",",$header);

        $numCampos = sizeof($campos);
        $ultimoCampo = sizeof($campos) - 1;

        // Criando query que cria a tabela
        $query = "CREATE TABLE `$nomeTabela` ( ";

        for($i = 0; $i < $numCampos; $i++) {
            if($campos[$i]!=''&&$campos[$i]!=null&&$campos[$i]!=" "&&$campos[$i]!="/n"){
                if ($i == 0){
                    $query = $query . " $campos[$i] varchar(100) ";
                }
                else if ($i != $ultimoCampo) {
                    $query = $query . ", $campos[$i] varchar(100) ";
                }
                else {
                    $query = $query . ", $campos[$i] varchar(100) ) CHARACTER SET utf8 COLLATE utf8_general_ci; ";
                }
            }
            else{
                $query = $query . ") CHARACTER SET utf8 COLLATE utf8_general_ci; ";
                break;
            }
        }

        $objConexao->executarComandoSQL($query);
    }


    $query2 = "LOAD DATA LOCAL INFILE '".__DIR__."/".$filename."' INTO TABLE `$nomeTabela` FIELDS TERMINATED BY ',' IGNORE 1 LINES";

    $objConexao->executarComandoSQL($query2);   
?>