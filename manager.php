<?php
require_once "./functions.php";
require_once 'Model/connect_form.php';
require_once 'Model/model_class.php';

if($_POST != null){
	$data = $_POST;
}
/*$model =  model_class::getDB();
if(!$model->validate($data,true)){
	$model->getErrors();
	redirect();
}
$model->save($data,'tasks');
setFlash('task','задача успешна создана');*/

new connect_form($data);
redirect();

?>