<?php 
require_once "./Config.php";
require_once "./vendor/vlucas/valitron/src/Valitron/Validator.php";
use Valitron\Validator;

class model_class{
	
	private $config;
	private $mysqli;
	private static $db = null;
	public $errors = [];
	public $rules = [];
	
	
	public $rulesTasks = [
        'required' => [
            ['name'],
            ['text'],
            ['email']
        ],
		'email' => [
			['email'],
		],
				
    ];
	
	public function __construct() {
		$this->config = new Config();
		$this->mysqli = new mysqli($this->config->db_host, $this->config->db_user, $this->config->db_password, $this->config->db_name);
		$this->mysqli->query("SET NAMES 'utf8'");
	}
	
	public static function getDB() {
		if (self::$db == null) self::$db = new model_class();
		return self::$db;
	}
	
	public function select($table_name, $param = '', $array = true){
		$query = "SELECT * FROM `".$table_name."`$param ";
		$result = $this->mysqli->query($query);
		if (!$result) return 'error';
		
		if($array){
				$data = array();
				while (($row = $result->fetch_assoc()) != false) {
				$data[] = $row;
			}
		}else{
			$data = $result->fetch_assoc();
		}
		
		return $data;
	}
	
	public function save($data, $table_name){
		$fields = array('name','email','text');
		$query = "INSERT INTO ".$table_name." (";
	
		foreach ($fields as $field => $value){
			$query .= "`$value`,";
		}
		$query = substr($query, 0, -1);
		$query .= ") VALUES (";
		foreach ($data as $field => $value){
			$val = $this->secureAcces($value);
			$query .= "'$val',";
		} 
		
		$query = substr($query, 0, -1);
		
		$query .= ")";
		$this->mysqli->query($query);
		
	}
	
	public function EditTask($id,$task){
		$query = "UPDATE tasks SET updated_at = '1', text = '$task'  WHERE  id = '$id'";
		$this->mysqli->query($query);
	}
	
	public function EditStatus($id){
		$query = "UPDATE tasks SET status = '1'  WHERE  id = '$id'";
		$this->mysqli->query($query);
	}	
	
	public function CountTasks(){
		$query = "SELECT COUNT(*) FROM tasks";
		$result = $this->mysqli->query($query);
		$result = $result->fetch_assoc();
		return $result['COUNT(*)'];
		
	}
	
	public function AuthUser($name,$pass){
		$name = $this->secureAcces($name);
		$pass = $this->secureAcces($pass);
		if($pass == '' or $name == ''){
			if($pass == '' AND $name != ''){
				$_SESSION['error'] = 'Поле пароль обязательно для заполнения';
				return false;
			}
			if($pass == '' AND $name == ''){
				$_SESSION['error'] = 'Поле имя\логин обязательные для заполнения';
				return false;
			}
			if($name == '' AND $pass != ''){
				$_SESSION['error'] = 'Поле имя обязательно для заполнения';
				return false;
			}
		}
		$pass = md5($pass);
		$result = $this->select('user',"WHERE name='$name' AND password='$pass'");
		if($result){
			$_SESSION['name'] = 'admin';
			$_SESSION['success'] = 'Вы успешно авторизированы';
			return true;
			
		}else{
			$_SESSION['error'] = 'Не верно введен логин\пароль';
			return false;
		}
	}
	
	public function secureAcces($var){
		$var = htmlspecialchars($var,ENT_QUOTES);
		$var = trim($var);
		$var = addslashes($var); 
		return $var;
	}
	public function getErrors(){
		$errors = '<ul>';
			foreach($this->errors as $error){
				foreach($error as $item){
					$errors .= "<li>$item</li>";
				}
			}
		$errors .= '</ul>';
		$_SESSION['error'] = $errors;
	}
	
	 public function validate($data,$tasks = false){
        Validator::lang('ru');
        $v = new Validator($data);
		if($tasks){
			 $v->rules($this->rulesTasks);
		}else{
			 $v->rules($this->rules);
		}
        if($v->validate()){
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }
	
}


?>