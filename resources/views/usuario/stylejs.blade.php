
<!--<script src= "{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>-->
<!-- jQuery UI 1.11.4 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!--Instanciar jquery ajax-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<!--<script src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>-->
<!--
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
-->
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->

<!--mensajes infor-->
<script src="{{ asset('dist/js/toastr.min.js')}}"></script>
<!--datatables-->

<!---para intro de los mensajes -->
<script src="{{ asset('dist/js/intro.min.js')}}"></script>

<!---script para la carga lazy de imagenes-->
<script src="{{ asset('dist/js/lazy.js')}}"></script>


<!-- Script para Gráficos -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    const ctxTimeline = document.getElementById('timelineChart').getContext('2d');
    let rectime = window.rectime;
    console.log('datos info', rectime);

    // Modificar los campos data
    let meses = Array.from({ length: 12 }, (v, k) => k + 1); // Meses del 1 al 12
    let valData = [Array(12).fill(0), Array(12).fill(0), Array(12).fill(0), Array(12).fill(0), Array(12).fill(0)];
    let descriptions = [null, null, null, null, null];

    rectime.forEach(item => {
        if (item.idcat >= 1 && item.idcat <= 5) {
            valData[item.idcat - 1][item.mes - 1] += item.total;
            descriptions[item.idcat - 1] = item.descat;
        }
    });

    // Definir los colores
    const colors = [
        { background: 'rgba(60,141,188,0.9)', border: 'rgba(60,141,188,0.8)', point: '#3b8bba' },
        { background: 'rgba(210,214,222,1)', border: 'rgba(210,214,222,1)', point: 'rgba(210,214,222,1)' },
        { background: 'rgb(10,231,128)', border: 'rgb(10,231,128)', point: 'rgb(10,231,128)' },
        { background: 'rgb(255,239,11)', border: 'rgb(255,239,11)', point: 'rgb(255,239,11)' },
        { background: 'rgb(255,11,214)', border: 'rgb(255,11,214)', point: 'rgb(255,11,214)' }
    ];

    // Filtrar datasets que tengan valores distintos de 0
    let datasets = descriptions
        .map((desc, index) => {
            if (desc && valData[index].some(value => value !== 0)) {
                return {
                    label: desc,
                    backgroundColor: colors[index].background,
                    borderColor: colors[index].border,
                    pointRadius: 5,
                    pointColor: colors[index].point,
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: colors[index].border,
                    data: valData[index]
                };
            }
            return null;
        })
        .filter(dataset => dataset !== null);

    new Chart(ctxTimeline, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    let datos = window.datos;

    var donutData        = {
      labels: datos.map(item => item.descrip), 

      datasets: [
        {
          data: datos.map(item => item.valor), 
          backgroundColor : ['#439a86', '#ebb93b', '#DB636B', '#5959C8', '#79D0F0'],
        }
      ]
    }
    var donutOptions   = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

})
</script>