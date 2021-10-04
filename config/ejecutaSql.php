<?php
require_once("conexion.php");
class EjecutaSql
{

  public function ejecutar($query,$valores) {
    try {
      $consult = Conexion::conectar()->prepare($query);
      $consult->execute($valores);
      return $consult;

    } catch (Exception $e) {
      echo "Error Al ejecutar la consulta: ".$e;
    }
  }

  public static function ConsultarSQL($query,$valores) {
    $consult = self::ejecutar($query,$valores);
    $results=$consult->fetchAll(PDO::FETCH_OBJ);
		return $results;
   }


  public static function InsertSQL($query, $valores) {
    return  self::ejecutar($query,$valores);

  }

  public static function DeleteSQL($query, $valores) {
    $result = self::ejecutar($query,$valores);
    return ($result->rowCount()>=1) ? true : false;
  }
  public static function UpdateSQL($query, $valores) {
    $result = self::ejecutar($query,$valores);
    return ($result->rowCount()>=1) ? true : false;
  }

  public static function cleanString($val){
      $val=trim($val);
      $val=stripslashes($val);
      $val=str_ireplace("<script>", "", $val);
      $val=str_ireplace("</script>", "", $val);
      $val=str_ireplace("<script src", "", $val);
      $val=str_ireplace("<script type=", "", $val);
      $val=str_ireplace("SELECT * FROM", "", $val);
      $val=str_ireplace("DELETE FROM", "", $val);
      $val=str_ireplace("INSERT INTO", "", $val);
      $val=str_ireplace("--", "", $val);
      $val=str_ireplace("^", "", $val);
      $val=str_ireplace("[", "", $val);
      $val=str_ireplace("]", "", $val);
      $val=str_ireplace("==", "", $val);
      $val=str_ireplace(";", "", $val);
      $val=str_ireplace("'", "", $val);
      return $val;
  }
}


 ?>
