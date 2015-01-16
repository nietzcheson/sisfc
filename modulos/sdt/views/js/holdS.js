$(document).ready(function(){
	var time=setInterval(seeS, 10000);
});
var seeS = function(){
	server = "http://"+window.location.hostname;
	$.post(server+'/sdt/session','fecha=today', function(datos){
        if (datos!="None" && datos!="") {
        	//console.log(datos);
        	SOnline=true;
        }
    }, 'json').fail(function() {
	    console.log("error de conexion");
	    SOnline=false;
	});
}