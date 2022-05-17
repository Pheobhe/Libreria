  /* jQueryKnob */
  $(".knob").knob();
  getProductosDia();
  getConsumos();
  getProductosMasConsumos();
  getCategoriasConsumo();
  



  function getProductosDia(){
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getProductosDia', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        //console.log(data);
        datos=data;
         var area = new Morris.Area({
          element: 'artPorDia',
          resize: true,
          data: datos,
          xkey: 'fecha',
          ykeys: ['total','total2'],
          labels: ['Productos','Remitos'],
          lineColors: ['#3c8dbc','#efefef'],
          lineWidth: 2,
          hideHover: 'auto',
          gridTextColor: "#fff",
          gridStrokeWidth: 0.4,
          pointSize: 4,
          pointStrokeColors: ["#efefef"],
          gridLineColor: "#efefef",
          gridTextFamily: "Open Sans",
          gridTextSize: 10
        });
      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
 
  }





function getConsumos(){
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getConsumos', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        //console.log(data);
       //console.log(data);
       var bar= new Morris.Bar({
          element: 'bar-example',
          data: data,
          xkey: 'destino',
          hideHover: 'auto',
          ykeys: ['total'],
          labels: ['Productos']
        });



      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
 
  }


function getProductosMasConsumos(){
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getProductosMasConsumos', 
            cache: false,
            data: 'json',
            dataType: 'json',
           //data: {id_producto: "producto"},           
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        //console.log(data);
       //console.log(data);
       var bar= new Morris.Bar({
          element: 'top10egresos',
          data: data,
          xkey: 'Producto',
          ykeys: ['total'],
          hideHover: 'auto',
          labels: ['Cantidad'],
          barColors:['green']
        });



      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
 
  }



  function getCategoriasConsumo(){
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getCategoriasConsumo', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        var aaa=[];
        var bbb=[];
        $.each(data,function(key,value){
          aaa.push(value.presentacion);
          bbb.push(value.total);
          //console.log(value.presentacion);
        })
        //console.log(aaa);
       // console.log(data);
        graficarDatos(data);
      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
 
  }


  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}


  function graficarDatos(data){
    //-------------
          //- PIE CHART -
          //-------------
          // Get context with jQuery - using jQuery's .get() method.

          //var rgb = [];
          /*$.each(largeJSONobject.ReleatedDoc, function (index,value) {
              $('select.mrdDisplayBox').addOption(value.Id, value.Id + ' - ' + value.Number, false);
          });
          */
          $.each(data, function (index,value) {
              data[index].color=getRandomColor();
          });
   
          
          console.log(data);
          
             // data.push("#"+((1<<24)*Math.random()|0).toString(16));
          
            //console.log(data);
          var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
          var pieChart = new Chart(pieChartCanvas);
          var PieData = data;
          var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 1,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
            //String - A tooltip template
            tooltipTemplate: "<%=value%> <%=label%> "
          };
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          var datos=pieChart.Pie(PieData, pieOptions);
          var legend = datos.generateLegend();

          document.getElementById('js-legend').innerHTML = datos.generateLegend();;


}