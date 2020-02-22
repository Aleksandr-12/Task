<?php


 class Controller{
	
	public $header = "./View/header.php";
	public $footer = "./View/footer.php";
	public $DirTmp = "./View/";
	public  $view = "index";
	public $data="";
	public $pagination = '';
	public $title;
	
	public function showPage($data= '', $pagination = '') {
		$this->data = $data;
		$this->pagination = $pagination;
		
		ob_start();
		include ($this->header);
		include ($this->DirTmp.$this->view.'.php');
		include ($this->footer);
	
		echo ob_get_clean();
	}
}

?>