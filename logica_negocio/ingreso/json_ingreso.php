<?php
@session_start();
require_once("../../Conexion/Modelo_generico.php");
$modelo = new Modelo_generico();
if ((isset($_POST['accion']) && isset($_POST['accion']) !== "")) {
	$accion = $_POST['accion'];
	 
	switch ($accion) {
		case "actualizar_pass" :
		
			$array = array(
				"table"=>"usuario",
				"c_idusuario"=>$_POST['el_id'],
				"c_clave"=>$modelo->encriptarlas_contrasenas($_POST['la_contra'])
			);
			$resultado = $modelo->actualizar_generica($array);
			if($resultado[0]=='1' && $resultado[4]>0){
				print json_encode(array("Exito",));
				exit();
			}else {
				print json_encode(array("Error",$_POST,$resultado));
				exit();
			}
	
	break;
		case "si_validar" :
	
			$resultado = $modelo->get_query("SELECT
			usuario.c_idusuario,
			persona.c_dui 
		FROM
			usuario
			INNER JOIN persona ON usuario.e_idpersona = persona.e_idPersona
		where c_dui='".$_POST['el_dui']."'");
			if($resultado["resultado"] && $resultado["totalFilas"]>0){
				print json_encode(array("Exito",$resultado["filas"]->c_usuario,$_POST,$resultado["filas"]));
				exit();
	
			}else {
				print json_encode(array("Error",$_POST,$resultado));
				exit();
			}
			break;
		case "si_con_contrasena":
			$sql = "SELECT 
				*FROM usuario as tu 
			
			WHERE (tu.c_correo='$_SESSION[usuario]' OR tu.c_usuario = '$_SESSION[usuario]')
			";
			$resultado = $modelo->get_query($sql);
			if ($resultado["resultado"] && $resultado["totalFilas"] == 1) {
				$verificacion = $modelo->desencrilas_contrasena($_POST['contrasena'], $resultado[2][0]['c_clave']);
				if ($verificacion["resultado"]) {
					$array = array("resultado"=>"Exito","mensaje"=>"Bienvenido nuevamente " . $resultado["filas"]->c_nombre);
					$_SESSION['logueado'] = "si";
					$_SESSION['bloquear_pantalla'] = "no";
					print json_encode($array,JSON_FORCE_OBJECT);
					exit;
				} else {
					$array = array("resultado"=>"Error","mensaje"=>"La contraseña no coincide");
					print json_encode($array,JSON_FORCE_OBJECT);
					exit;
				}
			} else {
				$array = array("resultado"=>"Error","mensaje"=>"Datos No Existen");
				print json_encode($array,JSON_FORCE_OBJECT);
				exit;
			}

			break;
		case "si_consultalo":
			$sql = "SELECT 
					*FROM  usuario as tu 
				
				WHERE (tu.c_correo='$_POST[correo]' OR tu.c_usuario = '$_POST[correo]')
				";
	
			$resultado = $modelo->get_query($sql);
			
			if ($resultado["resultado"] && $resultado["totalFilas"] == 1) {
				
				print_r($resultado["filas"]->fetchAll(PDO::FETCH_ASSOC));
				$verificacion = $modelo->desencrilas_contrasena($_POST['contrasena'], $resultado["filas"]->c_clave);
				
				if ($verificacion["resultado"]) {

					$_SESSION['logueado'] = "si";
					$_SESSION['bloquear_pantalla'] = "no";
					$_SESSION['nombre'] = $resultado["filas"]->c_nombre;
					$_SESSION['idusuario'] = $resultado["filas"]->c_idusuario;
					$_SESSION['usuario'] = $resultado["filas"]->usuario;
					$_SESSION['correo'] = $resultado["filas"]->c_correo;

					$array = array("resultado"=>"Exito","mensaje"=>"Bienvenido Al Sistema " . $resultado["filas"]->c_nombre);
					print json_encode($array,JSON_FORCE_OBJECT);
					exit;
				} else {
					$array = array("resultado"=>"Error","mensaje"=>"La contraseña no coincide","datos"=> $resultado);
					print json_encode($array,JSON_FORCE_OBJECT);
					exit;
				}
			} else {
				$array = array("resultado"=>"Error","mensaje"=>"Los Datos No Existen");
				print json_encode($array,JSON_FORCE_OBJECT);
				exit;
			}
			break;
			case "si_registralos":
				$id_insertar = $modelo->retonrar_id_insertar("persona"); 
        $array_insertar = array(
            "table" => "persona",
            "e_idpersona" => $id_insertar,
            "c_nombre" => $_POST['nombre'],
            "t_fechanacimiento" => $modelo->formatear_fecha($_POST['fecha']),
            "c_dui" => $_POST['dui'],
           
        );
        $result = $modelo->insertar_generica($array_insertar);
        if($result["resultado"]){
            /*Si la persona se creo procedo a registrar su usuario*/
            $id_usuario = $modelo->retonrar_id_insertar("usuario"); 
            $array_usuario = array(
                "table" => "usuario",
                "c_idusuario"=>$id_usuario,
                "e_idpersona" => $id_insertar,
                "c_correo" => $_POST['email'],
				"c_usuario" => $_POST['usuario'],
                "c_clave" => $modelo->encriptarlas_contrasenas($_POST['pass']),
				"ruta_fotoperfil" => $_POST['foto'],
            );
            $result_usuario = $modelo->insertar_generica($array_usuario);

            print json_encode(array("resultado"=>"Exito"),JSON_FORCE_OBJECT);
            exit;

        }else {
        	print json_encode(array("resultado"=>"Error"),JSON_FORCE_OBJECT);
			exit;
        }
		
			break;
	}
}
