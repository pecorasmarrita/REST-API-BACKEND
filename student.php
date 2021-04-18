<?php
$method = $_SERVER["REQUEST_METHOD"];
include('./class/Student.php');
$student = new Student();

switch($method) {
  case 'GET':
    $id = $_GET['id'];
    if (isset($id)){
      $student = $student->find($id);
      $js_encode = json_encode(array('state'=>TRUE, 'student'=>$student),true);
    }else{
      $students = $student->all();
      $js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
    }
    header("Content-Type: application/json");
    echo($js_encode);
    break;

  case 'POST':
    $id = $_POST['id'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$sidi_code = $_POST['sidi_code'];
    $tax_code = $_POST['tax_code'];
	if (isset($id, $name, $surname, $sidi_code, $tax_code)){
      $student = $student->addstudent($id, $name, $surname, $sidi_code, $tax_code);
    }else{
      echo("Dati inseriti non corretti");
    }
	$students = $student->all();
	$js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
	header("Content-Type: application/json");
	echo($js_encode);
	break;

  case 'DELETE':
    $id = $_DELETE['id'];
	if (isset($id)){
      $student->deletestudent($id);
    }else{
      $student->deleteallstudents();
    }
	$students = $student->all();
	$js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
	header("Content-Type: application/json");
	echo($js_encode);
    break;

  case 'PUT':
    // TODO
    break;

  default:
    break;
}


?>
