$(document).ready(function(){

  var volumen = function(){

    //var cargaSuelta = ["Menos de una mensual","Más de una mensual"];

    var cargaSuelta = [];
    cargaSuelta[0] = "Menos de una mensual";
    cargaSuelta[1] = "Más de una mensual";

    var containers = [];
    containers[0] = "De uno a tres containers anuales";
    containers[1] = "4 containers anuales";
    valores = "";

    if(valor==1){
      valores = cargaSuelta;
    }else{
      valores = containers;
    }

    $("#volumen_select").attr("disabled",false);
    $("#volumen_select").html("");
    $("#volumen_select").append("<option>Seleccione</option>");
    for(i=0;i<valores.length;i++){
      $("#volumen_select").append("<option value="+[i+1]+">"+valores[i]+"</option>");
      //alert(valores[i]);
    }

  }

  $("#carga_suelta").click(function(){
    valor = 1;
    volumen();
  });

  $("#container").click(function(){
    valor = 2;
    volumen();
  });

  var contador = 0;
  $("#btn-forzado").click(function(){

    clase = $(this).attr("class");

    if(clase=="btn btn-default"){
      $("input[name='input_forzado']").val("1");
      $("textarea[name='textarea_forzado']").attr("readOnly",false);
    }else{
      $("input[name='input_forzado']").val("");
      $("textarea[name='textarea_forzado']").attr("readOnly",true);
    }

  });

});
