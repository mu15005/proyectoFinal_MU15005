<?php
@session_start();
require_once("../../Conexion/Modelo_generico.php");
$modelo = new Modelo_generico();
if (isset($_POST['registro']) && $_POST['registro'] == "si_registralos") {
	$id_insertar = $modelo->retonrar_id_insertar("persona"); 
	$array_insertar = array(
		"table" => "persona",
		"e_idpersona" => $id_insertar,
		"c_nombre" => $_POST['nombre'],
		"t_fechanacimiento" => $modelo->formatear_fecha($_POST['fecha'])
		
	   
	);
	$result = $modelo->insertar_generica($array_insertar);
	if($result[0]=='1'){
		/*Si la persona se creo procedo a registrar su usuario*/
		subirImagenAlServer( $_FILES["foto_perfil"]);
		$id_usuario = $modelo->retonrar_id_insertar("usuario"); 
		$array_usuario = array(
			"table" => "usuario",
			"c_idusuario"=>$id_usuario,
			"e_idpersona" => $id_insertar,
			"c_correo" => $_POST['email'],
			"c_usuario" => $_POST['usuario'],
			"c_clave" => $modelo->encriptarlas_contrasenas($_POST['pass']),
			"ruta_fotoperfil" => "",
		);
		$result_usuario = $modelo->insertar_generica($array_usuario);

		print json_encode(array("Exito",$_POST,$result,$result_usuario));
		
		exit;

	}else {
		print json_encode(array("Error",$_POST,$result));
			exit;
	}
}
else if (isset($_POST['validar_correo']) && $_POST['validar_correo'] == "actualizar_pass") {
	
	$array = array(
		"table" => "usuario",
		"c_idusuario" => $_POST['el_idusuario'],
		"c_clave" => $modelo->encriptarlas_contrasenas($_POST['la_contra'])
	);
	$resultado = $modelo->actualizar_generica($array);
	if ($resultado[0] == '1' && $resultado[4] > 0) {
		print json_encode(array("Exito",));
		exit();
	} else {
		print json_encode(array("Error", $_POST, $resultado));
		exit();
	}
	
} else if (isset($_POST['verificar_token']) && $_POST['verificar_token'] == "si_verificar") {


			$resultado = $modelo->get_query("SELECT
												usuario.*
											FROM
												usuario
											WHERE c_idusuario='" . $_POST['el_idusuario'] . "'");

		if ($resultado[0] == '1' && $resultado[4] > 0) {
			
			 
			
		if ($_POST['token']==$resultado[2][0]['c_token']) {
			$array = array("resultado"=>"Exito","filas"=> $resultado);
		
			print json_encode($array);
			exit;
		} else {
			$array = array("resultado"=>"Error","mensaje"=> "Codigo Invalido", "filas"=>$resultado);
			print json_encode($array);
			exit;
		}
			

		} else {
		print json_encode(array("resultado"=>"Error", "post"=>$_POST, "filas"=>$resultado));
		exit;
		}

}else if (isset($_POST['validar_correo']) && $_POST['validar_correo'] == "si_validar") {
	
	 $resultado = $modelo->get_query("SELECT
	 				usuario.c_idusuario, 
	 				usuario.c_correo, 
	 				usuario.c_usuario
	 				FROM
	 				usuario
	 				where c_correo='" . $_POST['el_correo'] . "'");
	
	 if ($resultado[0] == '1' && $resultado[4] > 0) {


		$token = $modelo->generartoken()."-". $modelo->generartoken();
        $array_update = array(
            "table" => "usuario",
            "c_idusuario" =>  $resultado[2][0]['c_idusuario'],
            "c_token" => $token
        );
        $resultadoUsuario = $modelo->actualizar_generica($array_update);

        if($resultadoUsuario[0]=='1' && $resultadoUsuario[4]>0){

            $mensaje = $modelo->plantilla($token);
            $titulo="Recuperación de contraseña";
            $para = $_POST['el_correo'];
            $resultadoCorreo = $modelo->envio_correo($para,$titulo,$mensaje);
            if ($resultadoCorreo[0]==1) {
				$datos=array("resultado"=>"Exito", 
				"idusuario"=>$resultado[2][0]['c_idusuario'],
				 "post"=>$_POST,
				 "filas"=> $resultado[2][0]);
				print json_encode($datos,JSON_FORCE_OBJECT);
				exit;
            }else{
                print json_encode(array("Error",$_POST,$resultado));
                exit;
            }
            

        }else {
            print json_encode(array("Error",$_POST,$resultado));
            exit();
        }

	 } else {
	 	print json_encode(array("Error", $_POST, $resultado));
	 	exit();
	 }
} else if (isset($_POST['desbloquear']) && $_POST['desbloquear'] == "si_con_contrasena") {
	$sql = "SELECT 
					*FROM usuario AS tp
				
				
				WHERE (tp.c_correo='$_SESSION[usuario]' OR tp.c_usuario = '$_SESSION[usuario]')
				";
	$resultado = $modelo->get_query($sql);
	if ($resultado[0] == 1 && $resultado[4] == 1) {
		$verificacion = $modelo->desencrilas_contrasena($_POST['contrasena'], $resultado[2][0]['c_clave']);
		if ($verificacion[0] === 1) {
			$array = array("Exito", "Bienvenido nuevamente " . $resultado[2][0]['c_usuario'], $resultado);
			$_SESSION['logueado'] = "si";
			$_SESSION['bloquear_pantalla'] = "no";
			print json_encode($array);
		} else {
			$array = array("Error", "La contraseña no coincide", $resultado);
			print json_encode($array);
		}
	} else {
		$array = array("Error", "Datos no existen", $resultado);
		print json_encode($array);
	}
} else if (isset($_POST['consultar_login']) && $_POST['consultar_login'] == "si_consultalo") {

	$sql = "SELECT

				persona.c_nombre,
				tp.c_idusuario,
				tp.c_correo,
				tp.c_usuario,
				tp.c_clave,
				tp.ruta_fotoperfil 
			FROM
				usuario AS tp
				INNER JOIN persona ON tp.e_idpersona = persona.e_idPersona 
			WHERE
				(
					tp.c_correo = '$_POST[correo]' 
				OR tp.c_usuario = '$_POST[correo]' 
				)";

	$resultado = $modelo->get_query($sql);
	if ($resultado[0] == 1 && $resultado[4] == 1) {
		$verificacion = $modelo->desencrilas_contrasena($_POST['contrasena'], $resultado[2][0]['c_clave']);
		if ($verificacion[0] === 1) {

			$_SESSION['logueado'] = "si";
			$_SESSION['bloquear_pantalla'] = "no";
			$_SESSION['nombre'] = $resultado[2][0]['c_nombre'];
			$_SESSION['usuario'] = $resultado[2][0]['c_usuario'];
			$_SESSION['idusuario'] = $resultado[2][0]['c_idusuario'];
			$_SESSION['correo'] = $resultado[2][0]['c_correo'];

			$array = array("Exito", "Bienvenido al sistema " . $resultado[2][0]['c_usuario'], $resultado, $_SESSION);
			print json_encode($array);
			exit();
		} else {
			$array = array("Error", "La contraseña no coincide", $resultado, $_SESSION);
			print json_encode($array);
			exit();
		}
	} else {
		$array = array("Error", "Datos no existen", $resultado);
		print json_encode($array);
		exit();
	}
}

function subirImagenAlServer($file){
	
		
		$archivo = $file['archivo']['name'];
		
		if (isset($archivo) && $archivo != "") {
		  
		   $tipo = $_FILES['archivo']['type'];
		   $tamano = $_FILES['archivo']['size'];
		   $temp = $_FILES['archivo']['tmp_name'];
		   
		   if(($tamano < 2000000)){
			if (strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) {
				if(move_uploaded_file($temp, 'images/'.$archivo)){
					return true;
				  }
				}
			}
		   }
		   return false;
		}
	 
