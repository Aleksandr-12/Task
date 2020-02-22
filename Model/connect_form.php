<?php 
require_once './functions.php';
require_once 'model_class.php';


class connect_form extends model_class{
	
	public $db_connect;
		
	public function __construct($data) {
		session_start();
		$this->db_connect = model_class::getDB();
		if(!$this->db_connect->validate($data,true)){
			$this->db_connect->getErrors();
			
		}else{
			$this->db_connect->save($data,'tasks');
			setFlash('task','задача успешна создана');
		}
		/*$_SESSION['task'] = 'задача успешна создана';*/
	}

}
?>