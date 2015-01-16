$(document).on("ready", function(){
	$('.lista').drop_down_naan({
		clase_cabeza:"head-drop-down",
		clase_elemento:"element-drop-down",
		listas: [
			{
				valor_x_defecto:0,
				clase_x_defecto:"glyphicon glyphicon-minus",
				clase_x_texto:"glyphicon glyphicon-user",
				elementos:[
					{
						valor:1,
						clase:"usuario-sistema",
						texto:"AAA AAA"
					},
					{
						valor:2,
						clase:"usuario-sistema",
						texto:"BBB  BBBB"
					},
					{
						valor:3,
						clase:"usuario-sistema",
						texto:"CCC CCC"
					},
					{
						valor:4,
						clase:"usuario-sistema",
						texto:"DDD DDD"
					}
				],
				elemento_click: function(valor){
					console.log("Desde esta funcion 2 "+valor);
				}
			},
			{
				valor_x_defecto:3,
				clase_x_defecto:"glyphicon glyphicon-minus",
				clase_x_texto:false,
				elementos:[
					{
						valor:1,
						clase:"glyphicon glyphicon-star",
						texto:""
					},
					{
						valor:2,
						clase:"glyphicon glyphicon-remove",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					},
					{
						valor:3,
						clase:"glyphicon glyphicon-heart",
						texto:""
					}
				],
				elemento_click: function(valor){
					console.log("Desde esta funcion 1 "+valor);
				}
			},
		]
	});
});