<?php
include("DBConnection.php");
class Student 
{
  private $db;
  public $_id;
  public $_name;
  public $_surname;
  public $_sidiCode;
  public $_taxCode;

  public function __construct() {
    $this->db = new DBConnection();
    $this->db = $this->db->returnConnection();
  }

  public function find($id){
    $sql = "SELECT * FROM student WHERE id=:id";
    $stmt = $this->db->prepare($sql);
    $data = [
      'id' => $id
    ];
    $stmt->execute($data);
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }
  public function all(){
    $sql = "SELECT * FROM student LIMIT 0,3000"; // LIMIT 0,3000 è per vedere tutte le tabelle in caso di default a 1000, aggiunto al codice originale dato ma probabilmente non essenziale
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
  
  public function deletestudent ($id){
    $sql = "DELETE FROM student WHERE id='"+$id+"'"; // È possibile cancellare solo dal 1700 in poi, prima foreign key non lo permettono
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  }
  
  public function deleteallstudents (){
    $sql = "DELETE FROM student";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  }
  
  public function addstudent ($id, $name, $surname, $sidi_code, $tax_code){
    $sql = "INSERTO INTO student VALUES ('"+$id+"','"+$name+"','"+$surname+"','"+$sidi_code+"','"+$tax_code+"')"; // Inserire dal 1700 in poi
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  }
  
  public function updatestudent ($id, $name, $surname, $sidi_code, $tax_code){
    $sql = "UPDATE student SET name='"+$name+"', surname='"+$surname+"', sidi_code='"+$sidi_code+"', tax_code='"+$tax_code+"' WHERE id='"+$id+"'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  }
  

}
?>
