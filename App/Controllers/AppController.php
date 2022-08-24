<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;  // Responsável por instanciar modelos

class AppController extends Action {

	public function timeline(){
        // Recuperando dados do usário logado por meio da sessão
        session_start();
        
        if(isset($_SESSION['id']) && isset($_SESSION['nome'])){
            // Recuperar os tweets
            $tweet = Container::getModel('Tweet');
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweets = $tweet->recuperar_tweet();

            $this->view->tweets = $tweets;
            $this->render('timeline');
        }else{
            $this->view->view_folder = "index";
            $this->render('index');
        }
    }

    public function tweet(){
        // Recuperando dados do usário logado por meio da sessão
        session_start();
        
        if(isset($_SESSION['id']) && isset($_SESSION['nome'])){
            $tweet = Container::getModel('Tweet');

            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);

            $tweet->salvar();

            header("Location: /timeline");
        }else{
            $this->view->view_folder = "index";
            $this->render('index');
        }
    }
}


?>