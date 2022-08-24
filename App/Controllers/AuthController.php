<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;  // Responsável por instanciar modelos

class AuthController extends Action {

	public function autenticar(){
        $usuario = Container::getModel("usuario");
        $usuario->__set("email", $_POST['email']);
        $usuario->__set("senha", md5($_POST['senha']));

        if($usuario->Autenticar()){
            // Sucesso ao tentar logar
            session_start();
            $_SESSION['id'] = $usuario->__get("id");
            $_SESSION['nome'] = $usuario->__get("nome");
            $_SESSION['email'] = $usuario->__get("email");

            header("Location: /timeline");  // Redirecionando para timeline
        }else{
            // Falha ao tentar logar
            $this->view->view_folder = "index";
            $this->view->erro_login = true;
            $this->render('index');  // Apenas carregando a index
        }
    }

    public function sair(){
        session_start();
        session_destroy();

        header("Location: /");
    }

}


?>