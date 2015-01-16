$(document).ready(function(){


  var graficar = function(id){
    $.post(_root_+"leads/getEstatus",function(datos){
      estatus = [];
      cantidad_leads = [];
      contador = 0;

      for(i=0;i<datos.length;i++){
        v_fillColor = "rgba(151,187,205,0.2)";
        v_strokeColor = "rgba(151,187,205,1)";
        v_pointColor = "rgba(151,187,205,1)";
        v_pointStrokeColor = "#fff";
        v_pointHighlightFill = "#fff";
        v_pointHighlightStroke = "rgba(151,187,205,1)";

        switch (id) {
        case "en_operacion":
            if(datos[i]["acumulado"]==1){
              estatus[contador] = datos[i]["estatus"];
              cantidad_leads[contador] = datos[i]["cantidad_leads"];
              contador++;
            }
          break;
        case "sin_operacion":
            if(datos[i]["acumulado"]==0){
              estatus[contador] = datos[i]["estatus"];
              cantidad_leads[contador] = datos[i]["cantidad_leads"];
              contador++;
            }
            v_fillColor = "rgba(60,118,61,0.2)";
            v_strokeColor = "rgba(55,106,106,1)";
            v_pointColor = "rgba(60,118,61,1)";
            v_pointStrokeColor = "#fff";
            v_pointHighlightFill = "#fff";
            v_pointHighlightStroke = "rgba(151,187,205,1)";
          break;
        case "total_leads":
              estatus[i] = datos[i]["estatus"];
              cantidad_leads[i] = datos[i]["cantidad_leads"];

            v_fillColor = "rgba(169,68,66,0.2)";
            v_strokeColor = "rgba(155,62,60,1)";
            v_pointColor = "rgba(169,68,66,1)";
            v_pointStrokeColor = "#fff";
            v_pointHighlightFill = "#fff";
            v_pointHighlightStroke = "rgba(151,187,205,1)";
          break;
        default:
        }
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

  graficar("en_operacion");
  graficar("sin_operacion");
  graficar("total_leads");

});
