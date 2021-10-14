const getAjax = (rutaControlador, datos) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        datatype: "JSON",
        method: "POST",
        url: rutaControlador,
        data: datos,
      }).done(function (json) {
  
        resolve(json);
      }).fail(function (json) {
  
        mostrarMensaje("Ocurrio un Error Inesperado", "error", 1500);
        resolve("error");
      });
    })
  }