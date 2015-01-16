$(document).on("ready", function(){


  p1 = 0;
    v_input1 = $("input[name='importa_exporta']:checked").val();
  p2 = 0;
    v_input2 = $("input[name='padron']:checked").val();
  p3 = 0;
    v_input3 = $("input[name='departamento']:checked").val();
  p4 = 0;
    v_input4 = $("input[name='volumen']:checked").val();
  p5 = 0;
    v_input5 = $("input[name='listado']:checked").val();


  if(v_input1==1){
    p1 = 30;
  }else if(v_input1==0){
    p1 = 0;
  }

  if(v_input2==1){
    p2 = 10;
  }else if(v_input2==0){
    p2 = 25;
  }

  if(v_input3==1){
    p3 = 10;
  }else if(v_input3==0){
    p3 = 25;
  }

  if(v_input4==1){
    if($("select[name='volumen_carga']").val()==1){
      p4 = 0;
    }else if($("select[name='volumen_carga']").val()==2){
      p4 = 10;
    }
  }else if(v_input4==0){
    if($("select[name='volumen_carga']").val()==1){
      p4 = 5;
    }else if($("select[name='volumen_carga']").val()==2){
      p4 = 10;
    }
  }

  if(v_input5==1){
    p5 = 10;
  }else if(v_input3==0){
    p5 = 0;
  }

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
      $("input[name='forzada']").val("1");
      $("textarea[name='explicacion_forzada']").attr("readOnly",false);

    }else{
      $("input[name='forzada']").val("");
      $("textarea[name='explicacion_forzada']").attr("readOnly",true);
      $("textarea[name='explicacion_forzada']").val("");
    }
  });

  carga_suelta = $("#carga_suelta");
  container = $("#container");

  if(carga_suelta.attr("class")=="btn btn-primary active"){

  }else if(container.attr("class")=="btn btn-primary active"){

  }


  //Barra de progreso



  barra_progreso = parseInt($("#progress-bar").attr("anchura"));



  var barra = function(){
    $("#progress-bar").animate({width: barra_progreso+'%'});
    $("#porcentaje_barra").html("");
    $("#porcentaje_barra").fadeOut(100);
    $("#porcentaje_barra").html(barra_progreso);
    $("#porcentaje_barra").fadeIn(300);

    if(barra_progreso<60){
      $("#progress-bar").removeClass();
      $("#progress-bar").addClass("progress-bar progress-bar-danger");
      $("#caja_forzada").fadeIn(300)
    }else{
      $("#progress-bar").removeClass();
      $("#progress-bar").addClass("progress-bar progress-bar-success");
      $("#caja_forzada").fadeOut(300)
    }
  }

  $("select[name='volumen_carga']").change(function(){

    registro_valor_barra = barra_progreso;
    valor = $(this).val();
    carga_suelta = $("#carga_suelta").attr("class");
    container = $("#container").attr("class");

    valor_select = 0;

    if(carga_suelta=="btn btn-primary active"){
      if(valor==1){
        p4 = 0;
      }else if(valor==2){
        p4 = 10;
      }
    }

    if(container=="btn btn-primary active"){
      if(valor==1){
        p4 = 5;
      }else if(valor==2){
        p4 = 10;
      }
    }

    barra_progreso = p1 + p2 + p3 + p4 + p5;
    barra();

  });

  $("label.btn").click(function(){
    inputRadio = $(this).find("input[type=radio]").attr("name");
    valorInput = $(this).find("input[type=radio]").val();
    primeraClase = $(this).attr("class");

    $("input[name='"+inputRadio+"']").closest('label').removeClass();
    $("input[name='"+inputRadio+"']").closest('label').addClass("btn btn-default");
    $(this).removeClass();
    $(this).addClass("btn btn-primary active");
    segundaClase = $(this).attr("class");

    existe_calificacion = $("#existe_calificacion").attr("value");


    switch (inputRadio) {
        case 'importa_exporta':
          if(primeraClase!=segundaClase){
            if(valorInput==1){
              p1 = 30;
            }else if(valorInput==0){
              p1 = 0;
            }
          }
            break;
        case 'padron':
            if(primeraClase!=segundaClase){
              if(valorInput==1){
                p2 = 10;
              }else if(valorInput==0){
                p2 = 25;
              }
            }
            break;
        case 'departamento':
            if(primeraClase!=segundaClase){
              if(valorInput==1){
                p3 = 10;
              }else if(valorInput==0){
                p3 = 25;
              }
            }
            break;
        case 'volumen':
          p4=0;
            if(primeraClase!=segundaClase){
              if(valorInput==1){
                if($("select[name='volumen_carga']").val()==1){
                  p4 = 0;
                }else if($("select[name='volumen_carga']").val()==2){
                  p4 = 10;
                }
              }else if(valorInput==0){
                if($("select[name='volumen_carga']").val()==1){
                  p4 = 5;
                }else if($("select[name='volumen_carga']").val()==2){
                  p4 = 10;
                }
              }
            }

            barra_progreso = p1 + p2 + p3 + p4 + p5;
            barra();
            break;
        case 'listado':
            if(primeraClase!=segundaClase){
              if(valorInput==1){
                p5 = 10;
              }else if(valorInput==0){
                p5 = 0;
              }
            }
            break;
        default:

    }

    //alert(p1 +" "+ p2 +" "+ p3 +" "+ p4 +" "+ p5);
    barra_progreso = p1 + p2 + p3 + p4 + p5;
    barra();

  });








});
