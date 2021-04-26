<?php
$method = $_SERVER["REQUEST_METHOD"];
include('./class/Student.php');
$student = new Student();

switch($method) {
  case 'GET':
    if (isset($_GET['id'])){
	  $id = $_GET['id'];
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
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$sidi_code = $_POST['sidi_code'];
    $tax_code = $_POST['tax_code'];
	if (isset($name, $surname, $sidi_code, $tax_code)){
      $result = $student->addstudent($name, $surname, $sidi_code, $tax_code);
    }else{
      echo("Dati inseriti non corretti");
    }
    	if ($result>0)
    	{
    		echo("Sono stati aggiunti".$result."studenti");
    	}
    	else 
    	{
    		echo("Non sono stati aggiunti studenti");
    	}
	$students = $student->all();
	$js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
	header("Content-Type: application/json");
	echo($js_encode);
	break;

  case 'DELETE':
	parse_str(file_get_contents("php://input"),$post_vars);
    $id = $post_vars['id'];
	if (isset($id)){
      $result = $student->deletestudent($id);
    }else{
      $result = $student->deleteallstudents();
    }
    	if ($result>0)
    	{
    		echo("Sono state cancellate".$result."righe");
    	}
    	else 
    	{
    		echo("Non sono stati trovati studenti con tale ID");
    	}
	$students = $student->all();
	$js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
	header("Content-Type: application/json");
	echo($js_encode);
    break;

  case 'PUT':
	parse_str(file_get_contents("php://input"),$post_vars);
	$id = $post_vars['id'];
	$name = $post_vars['name'];
	$surname = $post_vars['surname'];
	$sidi_code = $post_vars['sidi_code'];
    	$tax_code = $post_vars['tax_code'];
	if (isset($id, $name, $surname, $sidi_code, $tax_code)){
      $result = $student->updatestudent($id, $name, $surname, $sidi_code, $tax_code);
    }else{
      echo("Dati inseriti non corretti");
    }
    	if ($result>0)
    	{
    		echo("Sono state modificate".$result."righe");
    	}
    	else 
    	{
    		echo("Non sono stati trovati studenti con tale ID");
    	}
	$students = $student->all();
	$js_encode = json_encode(array('state'=>TRUE, 'students'=>$students),true);
	header("Content-Type: application/json");
	echo($js_encode);
    break;

  default:
    break;
}


?>
