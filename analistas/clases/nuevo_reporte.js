'use strict'


// window.addEventListener('load',function(){
    function buscar_concepto(){
      // alert("llego a validar");
      var variable = $("#cod_variable").val();
      $.ajax({
        url:'clases/ajax_concepto.php',
        type:'POST',
        data:{
          variable : variable
        },
        // beforeSend: function(){
        //    $("#centro_costo").html("Validando, espere por favor...");
        //    $('#centro_costo').show();
        // },
        success: function(response){
          $("#concepto_evaluar").show();
          $("#concepto_evaluar").html(response);

        }
      });
    }
    function buscar_tema(){
      var cod_concepto = $("#cod_concepto").val();
      $.ajax({
        url:'clases/ajax_concepto.php',
        type:'POST',
        data:{
          cod_concepto : cod_concepto
        },
        success: function(response){
          $("#tema_revisar").show();
          $("#tema_revisar").html(response);

        }
      });
    }



    function busca_calificacion(){

      // var str = $("#sala_queryx").val();
      // var array= str.split("-");
      var sala_codigo = $("#sala").val();;
      var cod_variable = $("#cod_variable").val();
      var  cod_concepto = $("#cod_concepto").val();

      $.ajax({
        url:'clases/ajax_calificacion.php',
        type:'POST',
        data:{ sala_codigo : sala_codigo,
              cod_variable : cod_variable,
              cod_concepto : cod_concepto
         },
        dataType:'json',
        success: function(data){
            $('#calificacion_ant').val(data[0]);
            $('#codigo_sol_califica').val(data[1]);
        }
      });

    }

    function editarSala(checkboxElem) {
      if (checkboxElem.checked) {
        document.getElementById("sala").disabled = false;
      } else {
        //document.getElementById("telefono").readOnly = true;
      }
    }

    function editcalificacion(checkboxElem) {
      if (checkboxElem.checked) {
        document.getElementById("calificacion_ant").readOnly = false;
      } else {
        //document.getElementById("correo_empresarial").readOnly = true;
      }
    }

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

    //busqueda de nombres para roles ejecutor,responsable e informado
    function filtrar_nombres()
    {
      var min_length = 4;
      var temp1 = $('#ejecutor').val();
      var temp2 = $('#responsable').val();
      var temp3 = $('#informado').val();
      var nombre = "";
      var tipoRol="";

      if((isNaN(temp1) || isEmpty(temp1)) && temp1.length < 16)
      {
        nombre = temp1;
        tipoRol = 'ejecutor';
        if (nombre.length >= min_length)
        {
          $.ajax({
          url: './../validar_nombres.php',
          type: 'POST',
          data: {nombre:nombre, tipoRol:tipoRol},
          success:function(data){
            $('#resultadosEjecutor').show();
            $('#resultadosEjecutor').html(data);
          }
          });
        } else {
            $('#resultadosEjecutor').hide();
        }
      }
      else if ((isNaN(temp2) || isEmpty(temp2)) && temp2.length < 16)
      {
        nombre = temp2;
        tipoRol = 'responsable';
        if (nombre.length >= min_length)
        {
          $.ajax({
          url: './../validar_nombres.php',
          type: 'POST',
          data: {nombre:nombre, tipoRol:tipoRol},
          success:function(data){
            $('#resultadosResponsable').show();
            $('#resultadosResponsable').html(data);
          }
          });
        } else {
            $('#resultadosResponsable').hide();
        }
      }
      else if ((isNaN(temp3) || isEmpty(temp3)) && temp3.length < 16)
      {
        nombre = temp3;
        tipoRol = 'informado';
        if (nombre.length >= min_length)
        {
          $.ajax({
          url: './../validar_nombres.php',
          type: 'POST',
          data: {nombre:nombre, tipoRol:tipoRol},
          success:function(data){
            $('#resultadosInformado').show();
            $('#resultadosInformado').html(data);
          }
          });
        } else {
            $('#resultadosInformado').hide();
        }
      }
    }

  function set_item1(item)
    {
      // console.log(item);
      $('#ejecutor').val(item);
      $('#resultadosEjecutor').hide();

    }
    function set_item2(item)
    {
      $('#responsable').val(item);
      $('#resultadosResponsable').hide();
    }
    function set_item3(item)
    {
      $('#informado').val(item);
      $('#resultadosInformado').hide();
    }

    function pasar_id1(id)
    {
      $('#ejecutorID').val(id);
    }

    function pasar_id2(id)
    {
      $('#responsableID').val(id);
    }
    function pasar_id3(id)
    {
      $('#informadoID').val(id);
      // document.getElementById('btnGuardar').disabled=false;
    }
    // function loader(){
    //   document.getElementById('loader').style.display='block';
    // }

    function buscarResponsable(cod_jefe)
    {
      $('#responsableID').val(cod_jefe);

     }

      function jefeEjecutor(nombre_jefe)
      {
      $('#responsable').val(nombre_jefe);

     }


     function fileValidacion(){
       var fileInput = document.getElementById('file_adjunto');
       if (!fileInput) {
         alert('No has seleccionado ningún archivo');
         return false;
       }else{
       var fileSize = $('#file_adjunto')[0].files[0].size;

       //VALIDACIÓN NOMBRE DEL archivo
       var nombre = $('#file_adjunto')[0].files[0].name;
       if (nombre.length>30) {
         alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
         $('#file_adjunto').val('');
         return false;
       }
       //TERMINA VALIACION

       // alert(fileSize);
       var siezekiloByte = parseInt(fileSize / 1024);
       // alert(siezekiloByte);
       if (siezekiloByte >= 21000) {
             alert('El tamaño del adjunto supera el límite permitido (20 MB)');
             $('#file_adjunto').val('');
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


     function fileValidacion1(){
       var fileInput = document.getElementById('file_adjunto_1');
       if (!fileInput) {
         alert('No has seleccionado ningún archivo');
         return false;
       }else{

       var fileSize = $('#file_adjunto_1')[0].files[0].size;
       // alert(fileSize);

       //VALIDACIÓN NOMBRE DEL archivo
       var nombre = $('#file_adjunto_1')[0].files[0].name;
       if (nombre.length>30) {
         alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
         $('#file_adjunto_1').val('');
         return false;
       }
       //TERMINA VALIDACION

       var siezekiloByte = parseInt(fileSize / 1024);
       // alert(siezekiloByte);
       if (siezekiloByte >= 21000) {
             alert('El tamaño del adjunto supera el límite permitido (20 MB)');
             $('#file_adjunto_1').val('');
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

     function fileValidacion2(){
       var fileInput = document.getElementById('file_adjunto_2');
       if (!fileInput) {
         alert('No has seleccionado ningún archivo');
         return false;
       }else{

       var fileSize = $('#file_adjunto_2')[0].files[0].size;
       // alert(fileSize);

       //VALIDACIÓN NOMBRE DEL archivo
       var nombre = $('#file_adjunto_2')[0].files[0].name;
       if (nombre.length>30) {
         alert('El nombre del adjunto supera máximo permitido (Máximo 30 caracteres)');
         $('#file_adjunto_2').val('');
         return false;
       }
       //TERMINA VALIDACION

       var siezekiloByte = parseInt(fileSize / 1024);
       // alert(siezekiloByte);
       if (siezekiloByte >= 22000) {
             alert('El tamaño del adjunto supera el límite permitido (21 MB)');
             $('#file_adjunto_2').val('');
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

     function guardar_solicitud(){

       if ($("#userID").val() == "") {
               bootbox.alert({
                 message: "No se encuentra identificación del usuario, Ingrese de nuevo a la herramienta",
                 title: 'Validación!',
                 centerVertical: true
               });
               // $("#tipo_persona").focus();
               return false;
            }else if($("#ejecutorID").val() =="" ){

                bootbox.alert({
                  message: "Por favor seleccione un Ejecutor para la solicitud.",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#ejecutor").focus();
                return false;

            }else if($("#responsableID").val() =="" ) {
                bootbox.alert({
                  message: "Por favor seleccione un Responsable para la solicitud.",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#responsable").focus();
                return false;

            }else if ($("#informadoID").val() =="" ) {
                bootbox.alert({
                  message: "Por favor seleccione un Informado para la solicitud.",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#informado").focus();
                return false;
            }else if ($("#descripcion").val() =="" ) {
                bootbox.alert({
                  message: "Por favor ingrese una descripción para la solicitud.",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#descripcion").focus();
                return false;
            }else if ($("#prioridad").val() =="" ) {
                bootbox.alert({
                  message: "Por favor ingrese una prioridad para la solicitud.",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#prioridad").focus();
                return false;
            }else if ($("#estado").val() =="" ) {
                bootbox.alert({
                  message: "No hay un estado para la solicitud, intentelo de nuevo",
                  title: 'Validación!',
                  centerVertical: true
                });
                $("#estado").focus();
                return false;
            }
            if ($("#radioSala").val() != "") {
              var str = $("#sala").val();
              var array = str.split("-")

            }else {
              var str = $("#sala_queryx").val();
              var array= str.split("-");
            }
            var sala_codigo = array[0];
            var codigo_sociedad = array[1];


            var usuario = $("#userID").val();
            var cod_ejecutor = $("#ejecutorID").val();
            var nom_ejecutor = $("#ejecutor").val();
            var cod_responsable = $("#responsableID").val();
            var nom_responsable = $("#responsable").val();
            var cod_informado = $("#informadoID").val();
            var nom_informado = $("#informado").val();
            var descripcion = $("#descripcion").val();
            var prioridad = $("#prioridad").val();
            var estado = $("#estado").val();
            var imagen = $('#file_adjunto')[0].files[0];
            // console.log(usuario cod_ejecutor nom_ejecutor cod_responsable nom_responsable);
            // alert("Listo para transmitir");
            var midata = new FormData();
            midata.append("usuario",usuario);
            midata.append("cod_ejecutor",cod_ejecutor);
            midata.append("nom_ejecutor",nom_ejecutor);
            midata.append("cod_responsable",cod_responsable);
            midata.append("nom_responsable",nom_responsable);
            midata.append("cod_informado",cod_informado);
            midata.append("nom_informado",nom_informado);
            midata.append("descripcion",descripcion);
            midata.append("prioridad",prioridad);
            midata.append("estado",estado);
            midata.append("sala_codigo",sala_codigo);
            midata.append("codigo_sociedad",codigo_sociedad);
            midata.append("file_adjunto",imagen);

            $.ajax({
              url:"guardar_solicitud.php",
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
                    // document.getElementById('guardar_gestion').disabled = false;
                    // document.getElementById('crear_solicitud').disabled = true;
                    cerrar();
                  }
                });

              }
            });

     }

     function guardar_gestion(){

       if ($("#cod_seguimiento").val()=="") {
               bootbox.alert({
                 message: "Por Verifique el código de seguimiento",
                 title: 'Validación!',
                 centerVertical: true
               });
               $("#cod_seguimiento").focus();
               return false;
       }else if ($("#fecha_visita").val()=="") {
               bootbox.alert({
                 message: "Por seleccione fecha de inspección",
                 title: 'Validación!',
                 centerVertical: true
               });
               $("#fecha_visita").focus();
               return false;
       }else if ($("#sala").val() == "") {
               bootbox.alert({
                 message: "No se encuentra centro de costo, ingrese de nuevo a la herramienta",
                 title: 'Validación!',
                 centerVertical: true
               });
               $("#sala").focus();
               return false;

      }else if ($("#cod_variable").val() == "") {
              bootbox.alert({
                message: "Por favor seleccione una variable a gestionar",
                title: 'Validación!',
                centerVertical: true
              });
             $("#cod_variable").focus();
              return false;

      }else if ($("#cod_concepto").val() == "") {
              bootbox.alert({
                message: "Por favor seleccione un concepto a gestionar",
                title: 'Validación!',
                centerVertical: true
              });
             $("#cod_concepto").focus();
              return false;
      }else if ($("#cod_tema").val() == "") {
              bootbox.alert({
                message: "Por favor seleccione un tema a gestionar",
                title: 'Validación!',
                centerVertical: true
              });
             $("#cod_tema").focus();
              return false;

      }else if (($("#calificacion_ant").val() == "") || (($("#calificacion").val() == "") || $("#calificacion").val()==0)) {

            if ($("#calificacion_ant").val() == "") {
              bootbox.alert({
                message: "Por favor Actualiza la calificación",
                title: 'Validación!',
                centerVertical: true
              });
             $("#calificacion_ant").focus();
              return false;

            }else if($("#calificacion").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese una calificación",
                title: 'Validación!',
                centerVertical: true
              });
              $("#calificacion").focus();
              return false;
            }else if($("#calificacion").val()==0 ){
              bootbox.alert({
                message: "Por favor ingrese una calificación válida",
                title: 'Validación!',
                centerVertical: true
              });
              $("#calificacion").focus();
              return false;
            }

      }else if ($("#hallazgo").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese el hallazgo",
                title: 'Validación!',
                centerVertical: true
              });
             $("#hallazgo").focus();
              return false;

      }else if ($("#acciones").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese acciones",
                title: 'Validación!',
                centerVertical: true
              });
             $("#acciones").focus();
              return false;
      }else if ($("#fecha_control").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese fecha de control",
                title: 'Validación!',
                centerVertical: true
              });
             $("#fecha_control").focus();
              return false;

      }else if ($("#evaluador").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese fecha de control",
                title: 'Validación!',
                centerVertical: true
              });
             $("#evaluador").focus();
              return false;

      }else if ($("#evaluador").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese fecha de control",
                title: 'Validación!',
                centerVertical: true
              });
             $("#evaluador").focus();
              return false;

      }else if ($("#observacion").val() == "") {
              bootbox.alert({
                message: "Por favor ingrese alguna observación",
                title: 'Validación!',
                centerVertical: true
              });
             $("#observacion").focus();
              return false;
      }else {

      var cod_seguimiento = $("#cod_seguimiento").val();
      var fecha_visita = $("#fecha_visita").val();
      var str = $("#sala").val();
      var array = str.split("-");
      var sala_codigo = array[0];
      var cod_variable = $("#cod_variable").val();
      var cod_concepto = $("#cod_concepto").val();
      var contador= $("#contador").val();

      var auditoria = $("#auditoria").val();
      // alert(contador);
      // return false;
      var i = 0;
      var temas = [];
      while(i<=contador){
        // var input_i = $("#cod_tema_"+i).val();
        var input_i = $("#cod_tema_"+i).prop('checked');
        if (input_i == true) {
          temas [i]= $("#cod_tema_"+i).val();
      }else {
          temas[i]= 0;
      }
        i++;
      }
      // alert(array_temas.length);
      let j=0;
      let temas_si=0
      while (j<=temas.length) {
        if (temas[j] != 0 && temas[j] != undefined) {
          // alert(temas);
          temas_si=1;
        }
        j++;
      }
      if (temas_si == 0){
      bootbox.alert({
        message: "Por favor seleccione algún tema",
        title: 'Validación!',
        centerVertical: true
      });
       $("#tema_revisar").focus();
        return false;
      }
      var array_temas = JSON.stringify(temas);

      // console.log(array_temas);
      //  return false;
      var cod_hermes = $("#cod_hermes").val();
      var calificacion_ant = $("#calificacion_ant").val();
      var codigo_sol_califica = $('#codigo_sol_califica').val();
      var calificacion = $("#calificacion").val();
      var hallazgo = $("#hallazgo").val();
      var acciones = $("#acciones").val();
      var fecha_control = $("#fecha_control").val();
      var evaluador = $("#evaluador").val();
      var observacion = $("#observacion").val();


      var imagen = $('#file_adjunto')[0].files[0];
      var imagen1 = $('#file_adjunto_1')[0].files[0];
      var imagen2 = $('#file_adjunto_2')[0].files[0];



      var misdatos = new FormData();
      misdatos.append("cod_seguimiento",cod_seguimiento);
      misdatos.append("fecha_visita",fecha_visita);
      misdatos.append("sala",sala_codigo);
      misdatos.append("cod_variable",cod_variable);
      misdatos.append("cod_concepto",cod_concepto);
      misdatos.append("temas",array_temas);
      misdatos.append("calificacion_ant",calificacion_ant);
      misdatos.append("codigo_sol_califica",codigo_sol_califica);
      misdatos.append("calificacion",calificacion);
      misdatos.append("hallazgo",hallazgo);
      misdatos.append("acciones",acciones);
      misdatos.append("fecha_control",fecha_control);
      misdatos.append("evaluador",evaluador);
      misdatos.append("observacion",observacion);
      misdatos.append("auditoria",auditoria);
      misdatos.append("cod_hermes",cod_hermes);

      misdatos.append("file_adjunto",imagen);
      misdatos.append("file_adjunto_1",imagen1);
      misdatos.append("file_adjunto_2",imagen2);

      $.ajax({
        url:"guardar_concepto.php",
        type:"POST",
        data: misdatos,
        processData:false,
        contentType: false,
        success:function(response){
          bootbox.confirm({
            message: response,
            title: 'Respuesta!',
            centerVertical: true,
            callback: function (result) {
              console.log(response);
              location.reload();
            }
          });

        }
      });

    }

 }
 function num_temas_detalle(contador,cod_tema){
   console.log("contador vale:"+contador);
   $("#contador").val(contador);
   let numero=0;
   while(numero<=contador){

     if (cod_tema>=193 && cod_tema<=195) {
       // alert(cod_tema);
       document.getElementById("divauditoria").style.display = "block";
       $("#divauditoria").prop('required',true);
       numero++;
     }
   }
 }

 function num_temas(contador){
   console.log("contador vale:"+contador);
   $("#contador").val(contador);

 };



// });
