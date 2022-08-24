<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->render('index');
	}

	public function inscreverse() {
		$this->render('inscreverse');
	}

	public function registrar(){
		$usuario = Container::getModel("usuario");
		$usuario->__set("nome", $_POST['nome']);
		$usuario->__set("email", $_POST['email']);
		$usuario->__set("senha", md5($_POST['senha']));

		if($usuario->validarCadastro()){
			if(count($usuario->getUsuarioPorEmail()) == 0){
				$usuario->salvar();
				$this->render('cadastro');
			}else{
				$this->view->usuario_existente = true;
				$this->render('inscreverse');
			}
		}else{
			$this->view->usuarios = array("nome" => $_POST['nome'], "email" => $_POST['email'], "senha" => $_POST['senha']);
			$this->view->erro_cadastro = true; // Atributo erro_cadastro do objeto da view
			$this->render('inscreverse');
		}
	}

}


?>