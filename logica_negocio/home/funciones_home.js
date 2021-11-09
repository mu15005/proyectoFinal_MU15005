$(function(){
//   $('#fecha').datepicker({
//     format: "dd/mm/yyyy",
//     language: "es",
//     autoclose: true,
//     endDate:fecha

// });
    // $('form_registro_P').parsley();
   $(document).on("submit","#formulario_registro",function(event){
		event.preventDefault();
   
      getProyectos();
      
      var datos = {"accion":"si_carga_proyecto","codigo":codigo}
          getAjax("json_home.php",datos).then(json=>{
             console.log(json)
          });
      });
    $(document).on("click",".link_proyecto",function(e){
		e.preventDefault(); 
 

		var codigo = $(this).attr("data-codigo");
		console.log(codigo);
		var datos = {"accion":"si_carga_proyecto","codigo":codigo}
        getAjax("json_home.php",datos).then(json=>{
           console.log(json)
        });
    });
    $(document).on("submit","#form_registro_P",function(e){
      e.preventDefault();
       
      var datos = $("#form_registro_P").serialize();
      
    
       getAjax("json_home.php",datos).then((json) =>{
         console.log(json);
         let dato=JSON.parse(json);
        
           if (dato.resultado=="Exito") {
            mostrarMensaje('Proyecto Registrado Con Exito', 'success',1500);
             $("#myModal").modal("hide");
               cargar_datos();
            }else{
             
            }
  
       });
    });
	$(document).on("submit","#form_registro_Proyectos",function(event){
       
		event.preventDefault();
		var datos = $("#form_registro_Proyectos").serialize();
		
	
		getAjax("json_home.php",datos).then((json) =>{
			console.log(json);
      let dato=JSON.parse(json);
      
	    	if (dato.resultado=="Exito") {
         mostrarMensaje('Proyecto Registrado Con Exito', 'success',1500);
          $("#myModal").modal("hide");
            cargar_datos();
	    	 }else{
	    	 	
	    	 }

		});
	});
  cargar_datos();
});
function cargar_datos(){
 
	var datos = {"accion":"si_consultalos"};
	getAjax("json_home.php",datos).then(json=>{
    console.log('hola'+json);
    let dato=JSON.parse(json);
    console.log(dato);
       $("#proyectos_del_usuario").empty().html(dato.fila);
       $("#cantidad_proyectos").empty().html(dato.totalProyectos);
       $("#tareas_hoy").empty().html(dato.tareas);
       $("#select_productos").empty().html(dato.select);
      
    });

}
function getProyectos(){
 
	var datos = {"accion":"buscar_proyectos"};
	getAjax("json_home.php",datos).then(json=>{
    console.log(json);
    dato=JSON.parse(json);
    console.log(dato);
       $("#proyectos_del_usuario").empty().html(dato.fila);
       $("#cantidad_proyectos").empty().html(dato.totalProyectos);
       $("#tareas_hoy").empty().html(dato.tareas);
      
    });

}
