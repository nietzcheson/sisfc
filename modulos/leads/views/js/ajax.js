$(document).ready(function() {
    server = "http://"+window.location.hostname;

    var getInternas = function(){
        $.post(_root_+'/leads/getInternas','interna=1',function(datos){
            for(var i = 0; i < datos.length; i++){
                $("#referencia_prospecto").append('<option value="' + datos[i].id_u_usuario + '">' + datos[i].nombre_usuario + ' ' +datos[i].p_apellido_usuario+'</option>');
            }
            $('#referencia_prospecto').removeAttr('disabled');
        }, 'json');
    }

    var getExternas = function(){
      $("#referencia_prospecto").append('<option value="x">No referenciado</option>');
            $('#referencia_prospecto').removeAttr('disabled');
    }

    var getEmpresas = function(){
      $.post(server+'/leads/getEmpresas','empresa=1',function(datos){
          for(var i = 0; i < datos.length; i++){
              $("#referencia_prospecto").append('<option value="' + datos[i].id_u_marca + '">' + datos[i].nombre_marca + '</option>');
          }
          $('#referencia_prospecto').removeAttr('disabled');
      }, 'json');
    }



  $("#s_referencias").change(function(){

    $("#referencia_prospecto").html('');
        $("#referencia_prospecto").append('<option>Seleccione</option>');
        //$('#referencia_prospecto').attr('disabled','-1')
        if ($("#s_referencias").val()=="1"){
            getInternas();
        };
        if ($("#s_referencias").val()=="2"){
            getExternas();
        };
        if ($("#s_referencias").val()=="3") {
            getEmpresas();
        };

    });

    var removeForm = function(){
      parent = $(elemento).parent();
      abuelo = $(parent).parent();
      biz_abuelo = $(abuelo).parent();
      $(biz_abuelo).remove();
    }

    $(".btn-remove").click(function(){
      elemento = $(this);
      removeForm();
    });

    function htmlData(){
      wrap_dataPlus = $("<div />",{
        "class" : "form-group col-md-12"
      });

        wrap_data_select = $("<div />",{
          "class" : "col-md-6"
        });

        input_group = $("<div />", {
          "class" : "input-group"
        });

          select = $('<select />', {
            "class": "form-control",
            "name" : "id_tipodato[]"
          });

          input = $("<input />",{
            "class": "form-control",
            "name" : "dato[]"
          });

          span = $("<span />", {
            "class" : "input-group-btn"
          });

          btn = $("<button />", {
            "class" : "btn btn-default",
            "type"  : "button",
            click : (function(){
              elemento = $(this);
              removeForm();

            })
          });

          glyphicon = $("<span />",{
            "class" : "glyphicon glyphicon-remove"
          });

          btn = $(btn).append(glyphicon);
          span = $(span).append(btn);

          input_group = $(input_group).append(input,span);

        select = $(select).append(options);
        w_select = $(wrap_data_select).append(select);



      formHTML = $(wrap_dataPlus).append(w_select,input_group);
      $("#data-plus").append(formHTML);
    }

    $("#agregar-dato").click(function(){

      $.post(_root_+"prospectos/getDatosAdicionales",function(datos){

        options = "<option value='x'>Seleccione</option>"
        for(i=0;i<datos.length;i++){
          options+= "<option value='"+datos[i]["id"]+"'>"+datos[i]["dato_adicional"]+"</option>"
        }

        htmlData();

      },'json');

    });


});
