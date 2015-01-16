$(document).ready(function(){




    //$('#justificar').fadeOut(500);


    var width           = 0;


    var importa         = 0;


    var padron          = 0;


    var departamento    = 0;


    var tipo_volumen    = 0;


    var que_productos   = 0;


    var valor6          = 0;


    var valor7          = 0;


    var valor8          = 0;


    var objetoJson      = {


            "carga" : [


                 { id: "1", valor: 0, nombre: 'Menos de una mensual' },


                 { id: "2", valor: 10, nombre: 'Mas de una mensual' },


            ],


            "container" : [


                 { id: "1", valor: 5, nombre: 'De 1 a 3 containers anuales' },


                 { id: "2", valor: 10, nombre: 'De 4 containers anuales' },


            ]


        };


    var objetoJson2      = {


            "si" : [


                 { id: "1", valor: 10, nombre: 'si1' },


                 { id: "2", valor: 10, nombre: 'si2' },


                 { id: "3", valor: 10, nombre: 'si3' },


                 { id: "4", valor: 10, nombre: 'si4' },


            ],


            "no" : [


                 { id: "1", valor: 0, nombre: 'no1' },


                 { id: "2", valor: 0, nombre: 'no2' },


                 { id: "3", valor: 0, nombre: 'no3' },


                 { id: "4", valor: 0, nombre: 'no4' },


            ]


        };


    var obj1          = null;


    var obj2          = null;





    if ($('#importa_si').attr("class")=="btn btn-primary active") {


        importa=30;


    };


    if ($('#patron_si').attr("class")=="btn btn-primary active") {


        padron=10;


    };


    if ($('#patron_no').attr("class")=="btn btn-primary active") {


        padron=25;


    };


    if ($('#depart_si').attr("class")=="btn btn-primary active") {


        departamento=10;


    };


    if ($('#depart_no').attr("class")=="btn btn-primary active") {


        departamento=25;


    };


    if ($('#calif1_1').attr("class")=="btn btn-primary active") {


        obj1 = objetoJson.carga;


        for(var i=0;i<obj1.length;i++){


            if (obj1[i].id==parseInt($("#calif1_box").val())) {


                tipo_volumen= parseInt(obj1[i].valor);


            }


        }


    };


    if ($('#calif1_2').attr("class")=="btn btn-primary active") {


        obj1 = objetoJson.container;


        for(var i=0;i<obj1.length;i++){


            if (obj1[i].id==parseInt($("#calif1_box").val())) {


                tipo_volumen= parseInt(obj1[i].valor);


            }


        }


    };


    if ($('#calif2_1').attr("class")=="btn btn-primary active") {


        obj2 = objetoJson2.si;


        for(var i=0;i<obj2.length;i++){


            if (obj2[i].id==parseInt($("#calif2_box").val())) {


                que_productos= parseInt(obj2[i].valor);


            }


        }


    };


    if ($('#calif2_2').attr("class")=="btn btn-primary active") {


        obj2 = objetoJson2.no;


        for(var i=0;i<obj2.length;i++){


            if (obj2[i].id==parseInt($("#calif2_box").val())) {


                que_productos= parseInt(obj2[i].valor);


            }


        }


    };





    var Calificar = function(){


        width = importa+padron+departamento+tipo_volumen+que_productos+valor6+valor7+valor8;


        $('#barrita_calificar').animate({width: width+'%'},500);


        $('#puntaje').val(width);





        if(width>70){


            $('#barrita_calificar').animate({backgroundColor: "#5cb85c"});


            $('#justificar').fadeOut(500);


            $('#calificar_forzado').fadeOut(500);





        }else{


            $('#barrita_calificar').animate({backgroundColor: "#da4b39"});


            $('#calificar_forzado').fadeIn(500);


            if ($('#calificar_forzadoX').val()==1) {


                $('#justificar').fadeIn(500);


            };


        }


    }


    Calificar();


    $("label[id^='importa_']").click(function(){


        id = $(this).attr("id");


        id = id.slice(8,id.length);


        if (id=="si") {


            importa = 30;


            $("#importa_si").attr('class', 'btn btn-primary active');


            $("#importa_no").attr('class', 'btn btn-default');


        }else  if (id=="no"){


            importa = 0;


            $("#importa_no").attr('class', 'btn btn-primary active');


            $("#importa_si").attr('class', 'btn btn-default');


        };


        Calificar();


    });


    $("label[id^='patron_']").click(function(){


        id = $(this).attr("id");


        id = id.slice(7,id.length);


        if (id=="si") {


            padron = 10;


            $("#patron_si").attr('class', 'btn btn-primary active');


            $("#patron_no").attr('class', 'btn btn-default');


        }else  if (id=="no"){


            padron = 25;


            $("#patron_no").attr('class', 'btn btn-primary active');


            $("#patron_si").attr('class', 'btn btn-default');


        };


        Calificar();


    });


    $("label[id^='depart_']").click(function(){


        id = $(this).attr("id");


        id = id.slice(7,id.length);


        if (id=="si") {


            departamento = 10;


            $("#depart_si").attr('class', 'btn btn-primary active');


            $("#depart_no").attr('class', 'btn btn-default');


        }else  if (id=="no"){


            departamento = 25;


            $("#depart_no").attr('class', 'btn btn-primary active');


            $("#depart_si").attr('class', 'btn btn-default');


        };


        Calificar();


    });





    $("label[id^='calif1_']").click(function(){


        id = $(this).attr("id");


        id = id.slice(7,id.length);


        if (id=="1") {


            $("#calif1_1").attr('class', 'btn btn-primary active');


            $("#calif1_2").attr('class', 'btn btn-default');


            obj1 = objetoJson.carga;


        }else  if (id=="2"){


            $("#calif1_2").attr('class', 'btn btn-primary active');


            $("#calif1_1").attr('class', 'btn btn-default');


            obj1 = objetoJson.container;


        };


        $('#calif1_box').removeAttr('disabled');


        $('#calif1_box').html('');


        $("#calif1_box").append('<option value="0">Seleccione</option>');


        for(var i=0;i<obj1.length;i++){


            $("#calif1_box").append('<option value="' + obj1[i].id + '">' + obj1[i].nombre + '</option>');


        }


        tipo_volumen=0;


        Calificar();


    });


    $("#calif1_box").change(function(){


        for(var i=0;i<obj1.length;i++){


            if (obj1[i].id==parseInt($("#calif1_box").val())) {


                tipo_volumen= parseInt(obj1[i].valor);


            }


        }


        Calificar();


    });


    $("label[id^='calif2_']").click(function(){


        id = $(this).attr("id");


        id = id.slice(7,id.length);


        if (id=="1") {


            $("#calif2_1").attr('class', 'btn btn-primary active');


            $("#calif2_2").attr('class', 'btn btn-default');


            obj2 = objetoJson2.si;


        }else  if (id=="2"){


            $("#calif2_2").attr('class', 'btn btn-primary active');


            $("#calif2_1").attr('class', 'btn btn-default');


            obj2 = objetoJson2.no;


        };


        $('#calif2_box').removeAttr('disabled');


        $('#calif2_box').html('');


        $("#calif2_box").append('<option value="0">Seleccione</option>');


        for(var i=0;i<obj2.length;i++){


            $("#calif2_box").append('<option value="' + obj2[i].id + '">' + obj2[i].nombre + '</option>');


        }


        que_productos=0;


        Calificar();


    });


    $("#calif2_box").change(function(){


        for(var i=0;i<obj2.length;i++){


            if (obj2[i].id==parseInt($("#calif2_box").val())) {


                que_productos= parseInt(obj2[i].valor);


            }


        }


        Calificar();


    });


    $("#calificar_forzado").click(function(){


        if ($(this).attr('class')=="btn btn-primary") {


            $("#calificar_forzadoX").val("1");


            $('#justificar').fadeIn(500);


        }else{


            $("#calificar_forzadoX").val("0");


            $('#justificar').fadeOut(500);


        };


    });








    ////Contacto con el lead


    $("label[id^='comuni_']").click(function(){


        clase = $(this).attr('class');


        if (clase=="btn btn-default") {


            $(this).attr('class', 'btn btn-primary');


        }else{


            $(this).attr('class', 'btn btn-default active');


        };


    });


});
