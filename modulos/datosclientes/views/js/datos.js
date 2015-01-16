$(document).ready(function(){


  var cambiarCampana = function(){
    $.post(_root_+"datosclientes/cambiar","id="+id+"&valor="+valor,function(datos){
      alert(datos)
    },'json');

  }

  $("select[name='campana']").change(function(){
    id = $(this).attr("id");
    valor = $(this).val();
    cambiarCampana();
  });

  var graficar = function(id){

    $.post(_root_+"datosclientes/getCampanas","id="+id,function(datos){

      estatus = [];
      cantidad_leads = [];
      contador = 0;

      v_fillColor = "rgba(151,187,205,0.2)";
      v_strokeColor = "rgba(151,187,205,1)";
      v_pointColor = "rgba(151,187,205,1)";
      v_pointStrokeColor = "#fff";
      v_pointHighlightFill = "#fff";
      v_pointHighlightStroke = "rgba(151,187,205,1)";


      /**
        //Verdes
            v_fillColor = "rgba(60,118,61,0.2)";
            v_strokeColor = "rgba(55,106,106,1)";
            v_pointColor = "rgba(60,118,61,1)";
            v_pointStrokeColor = "#fff";
            v_pointHighlightFill = "#fff";
            v_pointHighlightStroke = "rgba(151,187,205,1)";

        //Rojo
            v_fillColor = "rgba(169,68,66,0.2)";
            v_strokeColor = "rgba(155,62,60,1)";
            v_pointColor = "rgba(169,68,66,1)";
            v_pointStrokeColor = "#fff";
            v_pointHighlightFill = "#fff";
            v_pointHighlightStroke = "rgba(151,187,205,1)";
      */

      for(i=0;i<datos.length;i++){
        estatus[i] = datos[i]["nombre_campana"];
        cantidad_leads[i] = datos[i]["cantidad_clientes"];
      }

      var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
      var lineChartData = {
        labels : estatus,
        datasets : [
          {
            label: "My Second dataset",
            fillColor : v_fillColor,
            strokeColor : v_strokeColor,
            pointColor : v_pointColor,
            pointStrokeColor : v_pointStrokeColor,
            pointHighlightFill : v_pointHighlightFill,
            pointHighlightStroke : v_pointHighlightStroke,
            data : cantidad_leads
          }
        ]

      }

      var ctx = document.getElementById(id).getContext("2d");
      window.myLine = new Chart(ctx).Line(lineChartData, {
      });
    },'json');



  }


  graficar("prospecto");
  graficar("lead");
  graficar("contacto");
  graficar("todos_clientes");

});
