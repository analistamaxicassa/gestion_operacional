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
