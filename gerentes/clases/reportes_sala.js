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
