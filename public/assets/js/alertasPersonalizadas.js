function mostrarMensaje(text, tipo, tiempo) {
  swal.fire({
    position: 'top-end',
    icon: tipo,
    
	  html: text,
    showConfirmButton: false,
    timer: tiempo
  })
}

function getConfirmacion(titulo, mensaje) {

  return new Promise((resolve, reject) => {
    Swal.fire({
      title: titulo,
      text: mensaje,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Continuar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      resolve(result);
    })
  })

}
function mostrar_cargando(titulo,mensaje=""){
	Swal.fire({
	  title: titulo,
	  html: mensaje,
	  timer: 2000,
	  timerProgressBar: true,
	  didOpen: () => {
	    Swal.showLoading()
	     
	  },
	  willClose: () => {
	     
	  }
	}).then((result) => {
	  /* Read more about handling dismissals below */
	  if (result.dismiss === Swal.DismissReason.timer) {
	    console.log('I was closed by the timer')
	  }
	})
}
