$(document).ready(function(){
	new Morris.Donut({
	  // ID of the element in which to draw the chart.
	  element: 'Grafico1',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: datos1,
	  // The name of the data record attribute that contains x-values.
	  formatter: function (x) { return x + "%"}
	});

	new Morris.Bar({
	  // ID of the element in which to draw the chart.
	  element: 'Grafico2',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: datos2,
	  // The name of the data record attribute that contains x-values.
	  xkey: 'y',
	  ykeys: ['a'],
	  labels: ['Registros']
	});

	new Morris.Donut({
	  // ID of the element in which to draw the chart.
	  element: 'Grafico3',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: datos3,
	  // The name of the data record attribute that contains x-values.
	  formatter: function (x) { return x + "%"}
	});
});