jQuery.fn.extend({
  searchTable: function(options){
  defaults = {
      fadeIn: 500,
      fadeOut: 500
    }

    var options = $.extend({}, defaults, options);

    elementoID = $(this);
    elemento = "";
    if(elementoID.attr("id")!=undefined){
      elemento = "#"+elementoID.attr("id");
    }else{
      elemento = "."+elementoID.attr("class");
    }

    elemento = elemento+" th input";



    var getTr = function(){

      /*
        i: index
        e: elemento
      */

      $("tbody tr").each(function(i1,e1){

        c1 = 0;
        c2 = 0;
        $(elemento).each(function(i2,e2){

          if($(e2).val()!=""){
            c1+=1;

            eSearch = $("tbody tr:nth-child("+(i1+1)+") td:nth-child("+(i2+1)+")");
            if(eSearch.text().toUpperCase().search($(e2).val().toUpperCase())>-1){
              c2+=1
            }
          }
        });

        if(c1!=c2){
          $("tbody tr:nth-child("+(i1+1)+")").fadeOut(options.fadeOut);
        }else{
          $("tbody tr:nth-child("+(i1+1)+")").fadeIn(options.fadeIn);
        }

      });
    }

    $(elemento).keyup(function(){
      getTr();
    });

  }

});
