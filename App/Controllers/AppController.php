<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;  // Responsável por instanciar modelos

class AppController extends Action {

	public function timeline(){
        $this->validarAutenticacao();

        // Recuperar os tweets
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
        $tweets = $tweet->recuperar_tweet();

        $this->view->tweets = $tweets;
        $this->render('timeline');
    }

    public function tweet(){
        $this->validarAutenticacao();
        
        $tweet = Container::getModel('Tweet');

        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweet->salvar();

        header("Location: /timeline");
    }

    public function validarAutenticacao(){
        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            $this->view->view_folder = "index";
            $this->render('index');
        }
    }
}
