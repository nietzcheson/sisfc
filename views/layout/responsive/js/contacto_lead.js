$(document).ready(function(){

  $(".contacto_lead").click(function(){

    value = $(this).find("input").val();

    $(this).attr("class","btn btn-default active");
    $(this).find("input").val(0);

    if(value==0){
      $(this).attr("class","btn btn-primary");
      $(this).find("input").val(1);
    }

  });

});
