<?php
  class ControllerDb{

    private $host = "ec2-23-21-229-200.compute-1.amazonaws.com";
    private $user = "denibmcnmjikfy";
    private $password  = "18201ee8394165431162a91c26243c1dcf20092899f9d94ad1d8587604e88148";
    private $database = "d4vk0o4kdhima3";
    private $conn;

    function connectDb(){
        $conn = pg_connect("host=$this->host dbname=$this->database user=$this->user password=$this->password")or 
        die("Failed to create connection to database: ". pg_last_error(). "<br/>");
    }   
    
    function construct(){
        $this->conn = $this->connectDb();
    }    
    
    function logar($query){
      try{  $result = pg_query($query);
        if(pg_num_rows($result) > 0){
       
            echo '<script>window.location.replace("../index.php");
            alert("Usuário logado com sucesso!");</script>';
        
        } else{

        echo '<script>window.location.replace("../index.php");
            alert("Email ou senha incorretos!");</script>';
               
        }}catch(Exception $e){
            return die($e);
        }
    }    
    
    function cadastrar($query){
        
      try{
          $result = pg_query($query);
        //   echo '<script>window.location.replace("../index.php");
        //     alert("Usuário cadastrado com sucesso!");</script>';
      }catch(Exception $e){
        echo '<script>window.location.replace("../index.php");
        alert("Fala ao cadastrar!");</script>';         
        return die($e);
      }
    }   
    
    function profissao(){
        try{
            $result = pg_query('select nome from Profissao;');
            if(pg_num_rows($result)>0){
                while($row=pg_fetch_assoc($result)){
                echo "<option value=".$row['nome'].">";
                echo str_replace("_", " ", $row['nome']."</option>");
                }
            }
        }
        catch(Exception $e){
            return die($e);
        }
    }
}

$db = new ControllerDb();
$db->connectDb();

if(isset($_POST['btnCadastrarChaveiro'])){  
    
    if(!empty($_POST['txtDescricao'])){
        $descricao = $_POST['txtDescricao'];
    } else {
        $descricao = "Chaveiro pronto a serviço!";
    }

    // if(!empty($_POST['txtPagamentoD']) && !empty($_POST['txtPagamentoC'])){
    //     $pagamento = $_POST['txtPagamentoD']."".$_POST['txtPagamentoC'];
    // } elseif(!empty($_POST['txtPagamentoD'])){
    //     $pagamento = $_POST['txtPagamentoD'];
    // } elseif(!empty($_POST['txtPagamentoC'])){
    //     $pagamento = $_POST['txtPagamentoC'];
    // } else{

    // }

    //Verificando se os campos estão vazios.

    $name = $_POST['txtName'];
    $email = $_POST['txtEmailCadastro'];
    $senha = $_POST['txtSenhaCadastro'];
    $cpf = $_POST['cpf'];
    $dataN = $_POST['txtDataNascimento'];
    $cep =  $_POST['txtCep'];
    $tel = $_POST['txtTelefone'];
    $descricao;
    $especialidade = $_POST['txtEspecialidade'];
    $pagamento = $_POST['txtPagamento'];;

    $db->cadastrar(
    $query="insert into Chaveiro(nome, email, especialidade, telefone, cpf, cep, descricao, senha, dataDeNascimento, pagamento)
    values('$name','$email','$especialidade',$tel,$cpf,$cep,'$descricao',$senha,'$dataN','$pagamento');");  

} elseif(isset($_POST['btnCadastrarCliente'])){
    
        
    $name = addslashes($_POST['txtName']);
    $email = addslashes($_POST['txtEmailCadastro']);
    $senha = addslashes($_POST['txtSenhaCadastro']);
    $senhaConfirma  = $_POST['txtSenhaConf'];
    $cpf = addslashes($_POST['txtCpf']);
    $dataN = addslashes($_POST['txtDataNascimento']);
    $tel = addslashes($_POST['txtTelefone']);

    if ($senha == $senhaConfirma) {
    $db->cadastrar(
    $query="insert into Cliente(nome, email, telefone, cpf, senha, datadenascimento) 
    values('$name', '$email',$tel,$cpf,$senha,'$dataN');");
    } else {
        echo '<script>window.location.replace("../index.php");
        alert("Senhas não conferem!");</script>';
    };

} elseif(isset($_POST['btnLogin'])){

    $email = addslashes($_POST["txtEmailLogin"]);
    $senha = addslashes($_POST["txtSenhaLogin"]);
    // error_reporting(0);
    // ini_set("display_erros", 0);
    $db->logar($query="select email, senha from Cliente where email='$email' and senha=$senha;");
};

// Esse código foi feito para quando aperter certo button, ele irá corresponder 
// com o valor do button, assim não preciso criar pastas diferentes;

?>