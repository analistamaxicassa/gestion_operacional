'use strict'
function cerrar(){
  $("#modal").modal('hide');
  $('body').removeClass('modal-open');
}
function cerrar2(contador){
  $("#modal_detalle_"+contador).modal('hide');
  $('body').removeClass('modal-open');
}

function cerrar_det_sol(conta){
  $("#detalle_hermes_"+conta).modal('hide');
}

function cerrar_mod_segui(conta){
  $("#seguimientos_"+conta).modal('hide');
}


function fileValidacion(contador){
  var fileInput = document.getElementById('file_adjunto_'+contador);
  if (!fileInput) {
    alert('No has seleccionado ningún archivo');
    return false;
  }else{
  var fileSize = $('#file_adjunto_'+contador)[0].files[0].size;

  var nombre = $('#file_adjunto_'+contador)[0].files[0].name;
  if (nombre.length>30) {
    alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
    $('#file_adjunto_'+contador).val('');
    return false;
  }

  var siezekiloByte = parseInt(fileSize / 1024);
  if (siezekiloByte >= 21000) {
        alert('El tamaño del adjunto supera el límite permitido (20 MB)');
        $('#file_adjunto_'+contador).val('');
        return false;
  }
  var filePath = fileInput.value;
  var allowedExtensions = /(.jpg|.png|.jpeg|.xlsx|.xls|.pdf)$/i;
  if (!allowedExtensions.exec(filePath)) {
    alert('Comprueba la extensión de los archivos a subir.\n sólo se pueden subir archivos con extensiones .jpg/.png/.jpeg/.xlsx /.xls /.pdf');
    fileInput. value ='';
    return false;
    }
  }
}


function fileValidacion1(contador){
  var fileInput = document.getElementById('file_adjunto_1_'+contador);
  if (!fileInput) {
    alert('No has seleccionado ningún archivo');
    return false;
  }else{

  var fileSize = $('#file_adjunto_1_'+contador)[0].files[0].size;
  var nombre = $('#file_adjunto_1_'+contador)[0].files[0].name;
  if (nombre.length>30) {
    alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
    $('#file_adjunto_1_'+contador).val('');
    return false;
  }

  var siezekiloByte = parseInt(fileSize / 1024);
  if (siezekiloByte >= 21000) {
        alert('El tamaño del adjunto supera el límite permitido (20 MB)');
        $('#file_adjunto_1_'+contador).val('');
        return false;
  }
  var filePath = fileInput.value;
  var allowedExtensions = /(.jpg|.png|.jpeg|.xlsx|.xls|.pdf)$/i;
  if (!allowedExtensions.exec(filePath)) {
    alert('Comprueba la extensión de los archivos a subir.\n sólo se pueden subir archivos con extensiones .jpg/.png/.jpeg/.xlsx/.xls/.pdf');
    fileInput. value ='';
    return false;
    }
  }
}

function fileValidacion2(contador){
  var fileInput = document.getElementById('file_adjunto_2_'+contador);
  if (!fileInput) {
    alert('No has seleccionado ningún archivo');
    return false;
  }else{

    var nombre = $('#file_adjunto_2_'+contador)[0].files[0].name;
  var fileSize = $('#file_adjunto_2_'+contador)[0].files[0].size;
  if (nombre.length>30) {
    alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
    $('#file_adjunto_2_'+contador).val('');
    return false;
  }

  var siezekiloByte = parseInt(fileSize / 1024);
  if (siezekiloByte >= 21000) {
        alert('El tamaño del adjunto supera el límite permitido (20 MB)');
        $('#file_adjunto_2_'+contador).val('');
        return false;
  }
  var filePath = fileInput.value;
  var allowedExtensions = /(.jpg|.png|.jpeg|.xlsx|.xls|.pdf)$/i;
  if (!allowedExtensions.exec(filePath)) {
    alert('Comprueba la extensión de los archivos a subir.\n sólo se pueden subir archivos con extensiones .jpg/.png/.jpeg/.xlsx/.xls/.pdf');
    fileInput. value ='';
    return false;
    }
  }
}

function guardar_seguimiento(contador){

  if ($("#estado_segui_"+contador).val() == "") {
          bootbox.alert({
            message: "Por favor seleccione un estado",
            title: 'Validación!',
            centerVertical: true
          });
          $("#estado_segui_"+contador).focus();
          return false;
  }else if ($("#nuevo_seguimiento_"+contador).val() == "") {
        bootbox.alert({
          message: "Por favor ingrese una descripción del seguimiento",
          title: 'Validación!',
          centerVertical: true
        });
        $("#nuevo_seguimiento_"+contador).focus();
        return false;
  }
  // alert($("#nuevo_seguimiento_"+contador).val())
  // return false;

  var estado = $("#estado_segui_"+contador).val();
  var seguimiento = $("#nuevo_seguimiento_"+contador).val();
  var codigo_gestion = $("#codigo_gestion_"+contador).val();

  console.log(estado ,seguimiento, codigo_gestion);

    $.ajax({
    url: 'guardar_seguimiento.php',
    type: 'POST',
    data: {
      codigo_gestion : codigo_gestion,
      estado :estado,
      seguimiento:seguimiento
    },
      success:function(response){
        bootbox.confirm({

        message: response,
        title: 'Respuesta!',
        centerVertical: true,
        callback: function (result) {
          cerrar_mod_segui(contador);
          location.reload();
        }

      });
      }
  });
}

function buscar_gestiones(){
    if ($("#finicial").val()=="") {
      bootbox.alert({
        message: "Por favor seleccione fecha inicial",
        title: 'Validación!',
        centerVertical: true
      });
      $("#finicial").focus();
      return false;
    }else if( $("#ffinal").val()==""){
      bootbox.alert({
        message: "Por favor seleccione fecha final",
        title: 'Validación!',
        centerVertical: true
      });
      $("#ffinal").focus();
      return false;
    }
    let sala = $("#codigo_sala").val();
    let fecha_inicial = $("#finicial").val();
    let fecha_final = $("#ffinal").val();
    let estado = $("#estado").val();
    let variable = $("#variable").val();

    $.ajax({
      url:'clases/ajax_gestiones.php',
      type:'POST',
      data:{
        sala : sala,
        fecha_inicial: fecha_inicial,
        fecha_final: fecha_final,
        estado:estado,
        variable: variable
      },
      beforeSend: function(){
         $("#resultados_gestiones").html("Validando, espere por favor...");
         $('#resultados_gestiones').show();
      },
      success: function(response){
        $("#resultados_gestiones").show();
        $("#resultados_gestiones").html(response);

      }
    });

}

function guardar_hermes(contador_ges){

      let codigo_gestion = $("#codigo_gestion_"+contador_ges).val();
      if ($("#cod_hermes_"+contador_ges).val() == '' ) {
        bootbox.alert({
          message: "Por favor ingrese Código solicitud Hermes",
          title: 'Validación!',
          centerVertical: true
        });
        $("#cod_hermes_"+contador_ges).focus();
        return false;

      }
      let cod_hermes = $("#cod_hermes_"+contador_ges).val();

      $.ajax({
        url:'guardar_concepto.php',
        type:'POST',
        data:{
          codigo_gestion : codigo_gestion,
          cod_hermes: cod_hermes,
        },
        beforeSend: function(){
           $("#resultados_gestiones").html("Validando, espere por favor...");
           $('#resultados_gestiones').show();
        },
        success: function(response){
            bootbox.confirm({
            message: response,
            title: 'Respuesta!',
            centerVertical: true,
            callback: function (result) {
              cerrar2(contador_ges);
              location.reload();
            }

          });

        }
      });

}

 function crear_seguimiento(){

   let usuario_radica = $("#usuario_radica").val();
   let centro_costo = $("#codigo_sala").val();
   // alert(centro_costo);
   let fecha_inspeccion = $("#fecha_inspeccion").val();
   let estado = 1;

   $.ajax({
     url:'gestion_seguimientos.php',
     type:'POST',
     data:{
       usuario_radica: usuario_radica,
       centro_costo : centro_costo,
       fecha_inspeccion: fecha_inspeccion,
       estado: estado
     },
         success: function(response){
         bootbox.confirm({
         message: response,
         title: 'Respuesta!',
         centerVertical: true,
         callback: function (result) {
           // cerrar2(contador_ges);
           location.reload();
         }

       });

     }
   });

 }

 function cerrar_seguimiento(){

       var opcion = confirm("¿Seguro que quiere cerrar el seguimiento?");
       if (opcion == true) {


         let num_conceptos = parseInt($("#num_conceptos").val());
         if (num_conceptos <=0) {

           bootbox.alert({
             message: "El seguimiento debe tener al menos una gestión para lograrla cerrar.",
             title: 'Validación!',
             centerVertical: true
           });
           $("#num_conceptos").focus();
           return false;

        }

       let cod_seguimiento = $("#cod_seguimiento").val();
       // alert(cod_seguimiento);
       let centro_costo = $("#codigo_sala").val();
       let estado_cerrado = 2;

       $.ajax({
         url:'gestion_seguimientos.php',
         type:'POST',
         data:{
           cod_seguimiento : cod_seguimiento,
           centro_costo : centro_costo,
           estado_cerrado: estado_cerrado
         },
             success: function(response){
             bootbox.confirm({
             message: response,
             title: 'Respuesta!',
             centerVertical: true,
             callback: function (result) {
               // cerrar2(contador_ges);
               location.reload();
             }

           });

         }
       });
     }else {
       return false;
     }

 }

 function guardar_adjuntos(contador_ges){

       let codigo_gestion = $("#codigo_gestion_"+contador_ges).val();
       let centro_costo = $("#centro_costo_"+contador_ges).val();

       var fileInput = document.getElementById('file_adjunto_'+contador_ges);
       if (!fileInput) {

             bootbox.alert({
               message: "Por favor selecciones al menos un adjunto para cargarlo",
               title: 'Validación!',
               centerVertical: true
             });
             $("#file_adjunto").focus();
             return false;

      }

      var imagen = $('#file_adjunto_'+contador_ges)[0].files[0];
      var imagen1 = $('#file_adjunto_1_'+contador_ges)[0].files[0];
       var midata = new FormData();

       midata.append("codigo_gestion",codigo_gestion);
       midata.append("centro_costo",centro_costo);
       midata.append("file_adjunto",imagen);
       midata.append("file_adjunto_1",imagen1);


       $.ajax({
         url:"guardar_concepto.php",
         type:"POST",
         data: midata,
         processData:false,
         contentType: false,
         success:function(response){
           bootbox.confirm({
             message: response,
             title: 'Respuesta!',
             centerVertical: true,
             callback: function (result) {
               location.reload();
             }
           });

         }
       });
  }


  function guardar_otro_adjunto(contador_ges){

        let codigo_gestion = $("#codigo_gestion_"+contador_ges).val();
        let centro_costo = $("#centro_costo_"+contador_ges).val();


          var fileInput2 = document.getElementById('file_adjunto_2_'+contador_ges);
          if (!fileInput2) {

              bootbox.alert({
                message: "Por favor selecciones al menos un adjunto para cargarlo",
                title: 'Validación!',
                centerVertical: true
              });
              $("#file_adjunto_2_"+contador_ges).focus();
              return false;

            }


        var imagen = $('#file_adjunto_2_'+contador_ges)[0].files[0];
        var midata = new FormData();

        midata.append("codigo_gestion",codigo_gestion);
        midata.append("centro_costo",centro_costo);
        midata.append("file_adjunto",imagen);
        // midata.append("file_adjunto_1",imagen1);


        $.ajax({
          url:"guardar_concepto.php",
          type:"POST",
          data: midata,
          processData:false,
          contentType: false,
          success:function(response){
            bootbox.confirm({
              message: response,
              title: 'Respuesta!',
              centerVertical: true,
              callback: function (result) {
                location.reload();
              }
            });

          }
        });
   }
