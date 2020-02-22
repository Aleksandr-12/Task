<?php
require_once "./functions.php";
require_once "./Pagination.php";
require_once "./Model/model_class.php";
require_once "Controller.php";


class PageController extends Controller{
	
	
	public $db = '';
	public $id = '';
	public $data = '';
	
	public function __construct($pageName = '', $data = '') {
		session_start();
		$this->data = $data;
		$this->db = model_class::getDB();
		if($this->data['id']){
			if($this->data['task']){
					$this->EditTaskOnPage($this->data['id'],$this->data['task']);
				}else{
					$this->EditStatusOnPage($this->data['id']);
			}
		}else{
			$this->createPage($pageName);
		}
		
	}

	public function createPage($pageName=''){
		
		
		switch($pageName){
			
			case 'admin':
				$this->PageAdmin();
				break;
			case  'auth':
				$this->PageAuth();
				break;
			case  'outer':
				$this->PageExit();
				break;
			
			default:
				$this->PageHome();
				break;
		}
	
	}
	
	public function EditTaskOnPage($id, $task){
		$this->db->EditTask($id, $task);
		$result = $this->db->select('tasks',"WHERE id = '$id'",false);
		$_SESSION['editTask'] = 'Задача с почтой '.$result['email'].' и c id '.$result['id'].' успешна отредактирована';
		redirect();
	}
	
	public function EditStatusOnPage($id){
		$this->db->EditStatus($id);
		$result = $this->db->select('tasks',"WHERE id = '$id'",false);
		$_SESSION['editTask'] = 'Задача с почтой '.$result['email'].'  успешна выполнена';
		redirect();
	}
	
	public function PageHome(){
		$this->title = 'Home';
			
		if($_POST['reset']){
			if(isset($_SESSION['sort-name'])){
				unset($_SESSION['sort-name']);
			}
			if(isset($_SESSION['sort-email'])){
				unset($_SESSION['sort-email']);
			}
			if(isset($_SESSION['sort-status'])){
				unset($_SESSION['sort-status']);
			}
			
		}
		
		$sortName = "";
		$sortEmail = "";
		$sortStatus = "";
		$orderBy = '';
		$sortVar = '';
		if(isset($_POST['sortName']) or isset($_POST['sortEmail']) or isset($_POST['sortStatus']) or isset($_SESSION['sort-name']) or isset($_SESSION['sort-email']) or isset($_SESSION['sort-status'])){
			if(isset($_POST['sortName']) AND $_POST['sortName'] != '') {
				$_SESSION['sort-name'] = $_POST['sortName'];
				$sortName = " name ".$_SESSION['sort-name'];
			}elseif(isset($_SESSION['sort-name'])){
				$sortName = " name ".$_SESSION['sort-name'];
			}
			if(isset($_POST['sortEmail']) AND $_POST['sortEmail'] != '') {
				$_SESSION['sort-email'] = $_POST['sortEmail'];
				$sortEmail = "email ".$_SESSION['sort-email'];
			}elseif(isset($_SESSION['sort-email'])){
				$sortEmail = "email ".$_SESSION['sort-email'];
				
			}
			if(isset($_POST['sortStatus']) AND $_POST['sortStatus'] != '') {
				$_SESSION['sort-status'] = $_POST['sortStatus'];
				$sortStatus = "status ".$_SESSION['sort-status'];
			}elseif(isset($_SESSION['sort-status'])){
				$sortStatus = "status ".$_SESSION['sort-status'];
			}
		}
		if($sortName != '' or $sortEmail != '' or $sortStatus != ''){
			$orderBy = 'ORDER BY ';
			if($sortName != ''){
				$orderBy .= $sortName;
			}
			if($sortEmail != ''){
				if($sortName != ''){
					$orderBy .=','.$sortEmail;
				}else{
					$orderBy .= $sortEmail;
				}
			}
			if($sortStatus != ''){
				if($sortName != '' or $sortEmail != ''){
					$orderBy .=','.$sortStatus;
				}else{
					$orderBy .= $sortStatus;
				}
				
			}
		}
		$page = isset($_GET['page']) ? (int)$_GET['page'] :1;
		$perpage = 3;
		$total = $this->db->CountTasks();
		$pagination = new Pagination($page, $perpage,$total);
		$start = $pagination->getStart();
		$data = $this->db->select('tasks', "$orderBy LIMIT $start, $perpage");
		$this->showPage($data, $pagination);
	}
	
	public function PageAdmin(){
		
		if($_SESSION['name']){
			$this->title= 'Admin';
			$this->view = 'admin';
			
			$page = isset($_GET['page']) ? (int)$_GET['page'] :1;
			$perpage = 3;
			$total = $this->db->CountTasks();
			$pagination = new Pagination($page, $perpage,$total);
			$start = $pagination->getStart();
			
			$data = $this->db->select('tasks', "LIMIT $start, $perpage");
			$this->showPage($data,$pagination);
			
		}else{
			redirect('/auth');
		}
	}
	
	public function PageAuth(){
		
		/*if($_SESSION['name']){
			redirect('/');
			
		}elseif($this->data['name'] and $this->data['password']){
			if($this->db->AuthUser($this->data['name'],$this->data['password'])){
				redirect();
			}else{
				redirect('/auth');
			}
		}else{
			$_SESSION['error'] = 'Поля логин\пароль обязательные для заполнения';
			$this->title= 'Авторизоваться';
			$this->view = 'auth';
			$this->showPage();
		}*/
		if($_SESSION['name']){
			redirect('/');
			
		}
		if($_POST['auth']){
			if($this->db->AuthUser($_POST['name'],$_POST['password'])){
				redirect();
			}else{
				redirect('/auth');
			}
		}else{
			$this->title= 'Авторизоваться';
			$this->view = 'auth';
			$this->showPage();
		}
			
	}
	public function PageExit(){
		unset($_SESSION['name']);
		$_SESSION['exit'] = 'Вы успешно вышли!';
		redirect();
	}
}
?>