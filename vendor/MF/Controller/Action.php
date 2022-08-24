<?php

namespace MF\Controller;

abstract class Action {

	protected $view;

	public function __construct() {
		$this->view = new \stdClass();
	}

	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;  // Atributo page do objeto da view

		if(file_exists("../App/Views/".$layout.".phtml")) {
			require_once "../App/Views/".$layout.".phtml";
		} else {
			$this->content();
		}
	}

	protected function content() {
		$folder = "";
		if(isset($this->view->view_folder)){
			$folder = $this->view->view_folder;
		}else{
			$folder = get_class($this);  // Retorna o nome da classe do objeto instanciado

			$folder = str_replace('App\\Controllers\\', '', $folder);

			$folder = strtolower(str_replace('Controller', '', $folder));
		}
		require_once "../App/Views/".$folder."/".$this->view->page.".phtml";
	}
}

?>