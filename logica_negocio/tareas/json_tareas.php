<?php 

	require_once("../../Conexion/Modelo_generico.php");
	$modelo = new Modelo_generico();
    if (isset($_POST['consultar_datos']) && $_POST['consultar_datos']=="si_consultalos") {
		$sql = "SELECT
        *, 
        proyecto.c_nombre as nombreproyecto
    
    FROM
        tarea
        INNER JOIN
        proyecto
        ON 
            tarea.c_codigoproyecto = proyecto.c_codigo";
		$resultado = $modelo->get_query($sql);

		$html=$html_tr="";
		$cuanto=0;
		if ($resultado[0]=="1") {
			foreach ($resultado[2] as $row) {
			
				
				$html_tr.='<tr>
                            <td>'.$row['c_nombre'].'</td>
                            <td>'.$modelo->formatear_fecha($row['td_fechacreacion']).'</td>
                            <td>'.$modelo->formatear_fecha($row['dt_fechafinal']).'</td>
                            <td>'.($row['estado']==1)? 'Pendiente':'Finalizada'.'</td>
                            <td>'.$row['nombreproyecto'].'</td>
                            <td>'.$tipo_persona.'</td> 
                            <td>
                            	<div class="dropdown m-b-10">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Seleccione
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item btn_eliminar" data-id="'.$row['id'].'"  href="javascript:void(0)">Eliminar</a>
                                        <a class="dropdown-item btn_editar" data-id="'.$row['id'].'"  href="javascript:void(0)" >Actualizar</a>
                                        <a class="dropdown-item btn_recupearcontra" data-id="'.$row['id'].'" data-email="'.$email.'" href="javascript:void(0)">Recuperar contraseña</a>
                                    </div>
                                </div>
                            </td> 
                        </tr>';
				
			}

			$html.='<table id="tabla_personas" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Creacion</th>
                            <th>Fecha Finalizacion</th>
                            <th>Estado</th>
                            <th>Proyecto</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        ';
            $html.=$html_tr;
            $html.='</tbody>
            		</table>';

           	print json_encode(array("Exito",$html,$resultado[4]));

		}else{
			print json_decode(array("Error"));
		}
		
	}

        

?>