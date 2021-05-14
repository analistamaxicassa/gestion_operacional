'use strict'

function cerrar(contador){
  location.reload();
  $("#modal_general_"+contador).modal('hide');
  $('body').removeClass('modal-open');
}

function cerrar2(contador_det,contador){
  $("#modal_detalle_"+contador_det+"_"+contador).modal('hide');
  $('body').removeClass('modal-open');
}
function cerrar_det_sol(contador_det,conta){
  $("#detalle_hermes_"+contador_det+"_"+conta).modal('hide');
  $('body').removeClass('modal-open');
}
function cerrar_mod_segui(contador_det,conta){
  $("#seguimientos_"+contador_det+"_"+conta).modal('hide');
  $('body').removeClass('modal-open');
}

// function cerrar_modal_detalles(contador,contador2){
//   $("#modal_gen_detallado_"+contador+'_'+contador2).modal('hide');
//   $('body').removeClass('modal-open');
// }


function ver_gestiones(contador,contador2){
  document.getElementById("resultados_gestiones_"+contador+"_"+contador2).style.display = "block";
  document.getElementById("ocultar_"+contador+"_"+contador2).style.display = "block";
  document.getElementById("buscar_"+contador+"_"+contador2).style.display = "none";
}
function ocultar_gestiones(contador,contador2){
  document.getElementById("resultados_gestiones_"+contador+"_"+contador2).style.display = "none";
  document.getElementById("buscar_"+contador+"_"+contador2).style.display = "block";
  document.getElementById("ocultar_"+contador+"_"+contador2).style.display = "none";
}

function buscar_gestiones(contador,contador2){

    if ($("#det_fecha_"+contador+"_"+contador2).val()=="") {
      bootbox.alert({
        message: "Por favor verifique dato de fecha inicial",
        title: 'Validación!',
        centerVertical: true
      });
      $("#det_fecha_"+contador+"_"+contador2).focus();
      return false;
    }
    let centro_costo = $("#det_centro_costo_"+contador+"_"+contador2).val();
    let fecha = $("#det_fecha_"+contador+"_"+contador2).val();
    let variable = $("#det_cod_variable_"+contador+"_"+contador2).val();
    let contador1 = contador2;
    // console.log(centro_costo);
    // console.log(fecha);
    // console.log(variable);


    $.ajax({
      url:'clases/ajax_gestiones.php',
      type:'POST',
      data:{
        centro_costo : centro_costo,
        fecha: fecha,
        variable: variable,
        contador1: contador1
      },
      beforeSend: function(){
         $("#resultados_gestiones_"+contador+"_"+contador2).html("Validando, espere por favor...");
         $('#resultados_gestiones_'+contador+"_"+contador2).show();
      },
      success: function(response){
        $("#resultados_gestiones_"+contador+"_"+contador2).show();
        $("#resultados_gestiones_"+contador+"_"+contador2).html(response);

      }
    });

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
