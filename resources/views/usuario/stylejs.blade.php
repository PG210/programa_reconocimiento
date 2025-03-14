
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix@1.2.0"></script>
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

document.addEventListener("DOMContentLoaded", function() {
                let recmes = window.recmes;
                let totcat = window.totcat;

                //console.log('datos', recmes);
                const meses = {
                        '01': 'Enero',
                        '02': 'Febrero',
                        '03': 'Marzo',
                        '04': 'Abril',
                        '05': 'Mayo',
                        '06': 'Junio',
                        '07': 'Julio',
                        '08': 'Agosto',
                        '09': 'Septiembre',
                        '10': 'Octubre',
                        '11': 'Noviembre',
                        '12': 'Diciembre'
                    };
                
                const labels = recmes.map(item => {
                        const [year, month] = item.mes.split('-');
                        return `${meses[month]} ${year}`; // Ej. "Agosto 2024"
                    });
                
                const data = recmes.map(item => item.tot); // Ej. [15, 10, 5]
                
                new Chart(document.getElementById('trendChart').getContext('2d'), {
                    type: 'line',
                    data: { labels: labels, datasets: [{ label: 'Reconocimientos Totales', data: data, borderColor: '#cdcdcd', backgroundColor: 'rgba(29, 131, 32, 0.2)', fill: true }] }
                });

                const labelstotcat = totcat.map(item => item.des); // ['Participar', 'Aprender']
                const datatotcat = totcat.map(item => item.tot);   // [24, 4]


                new Chart(document.getElementById('categoryChart-grupo').getContext('2d'), {
                    type: 'bar',
                    data: { labels: labelstotcat, datasets: [{ label: 'Cantidad de Reconocimientos', data: datatotcat, backgroundColor: ['#EBB93B', '#79D0F0'] }] }
                });

                new Chart(document.getElementById('radarChart').getContext('2d'), {
                    type: 'radar',
                    data: { labels: labelstotcat, datasets: [{ label: 'Balance de Categorías', data: datatotcat, borderColor: '#EBB93B', backgroundColor: 'rgba(255, 152, 0, 0.2)', fill: true }] }
                });
                
            });

// Mapa de Calor
document.addEventListener("DOMContentLoaded", function() {
                let recdia = window.recdia;
                // Adaptar los datos al formato requerido por la gráfica
                const data = recdia.map(item => ({
                    x: item.dia,
                    y: `${item.hora.toString().padStart(2, '0')}:00`,
                    v: item.tot
                }));
                
                // Calcular el día más activo
                const dayTotals = recdia.reduce((acc, item) => {
                    acc[item.dia] = (acc[item.dia] || 0) + item.tot;
                    return acc;
                }, {});

                const mostActiveDay = Object.keys(dayTotals).reduce((a, b) => dayTotals[a] > dayTotals[b] ? a : b);

                document.getElementById("mostActiveDay").innerText = `🔥 Día más activo: ${mostActiveDay} con ${dayTotals[mostActiveDay]} reconocimientos.`;

                new Chart(document.getElementById('heatmapChart').getContext('2d'), {
                    type: 'matrix',
                    data: {
                        datasets: [{
                            label: 'Frecuencia de Reconocimientos',
                            data: data,
                            backgroundColor(ctx) {
                                const value = ctx.raw.v;
                                return value > 15 ? '#DB636B' : value > 10 ? '#EBB93B' : '#439A86';
                            },
                            borderWidth: 1,
                            borderColor: '#cdcdcd',
                            width: ({chart}) => (chart.chartArea || {}).width / 5 - 10,
                            height: ({chart}) => (chart.chartArea || {}).height / 5 - 10,
                            labels: {
                                display: true,
                                font: { size: 14 },
                                color: "black"
                            }
                        }]
                    },
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.raw.v} reconocimientos`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { 
                                type: 'category',
                                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                                title: { display: true, text: 'Día de la Semana' }
                            },
                            y: { 
                                type: 'category',
                                labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', 
                                 '14:00', '15:00', '16:00', '17:00', '18:00'],
                                title: { display: true, text: 'Hora del Día' }
                            }
                        }
                    }
                });
            });

  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------
    const ctxTimeline = document.getElementById('timelineChart').getContext('2d');
    let rectime = window.rectime;
    console.log('datos', rectime);

    // Definir todos los meses de enero (01) a diciembre (12)
    let mesesTotales = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // Obtener todas las categorías únicas
    let categoriasUnicas = [...new Set(rectime.map(item => item.descat))];

    // Inicializar estructura de datos con ceros para cada categoría en cada mes
    let valData = categoriasUnicas.map(() => Array(mesesTotales.length).fill(0));

    // Asignar valores a los meses correspondientes
    rectime.forEach(item => {
        let mesIndex = mesesTotales.indexOf(item.mes); // Ubicar el mes en el array
        let catIndex = categoriasUnicas.indexOf(item.descat); // Ubicar la categoría

        if (mesIndex !== -1 && catIndex !== -1) {
            valData[catIndex][mesIndex] += item.total; // Sumar los valores al mes correspondiente
        }
    });

    // Definir colores para cada categoría
    const colors = [
        { background: 'rgba(60,141,188,0.9)', border: 'rgba(60,141,188,0.8)', point: '#3b8bba' },
        { background: 'rgba(210, 214, 222, 0.9)', border: 'rgba(210, 214, 222, 0.8)', point: '#d2d6de' }
    ];

    // Crear datasets para la gráfica
    let datasets = categoriasUnicas.map((desc, index) => {
        return {
            label: desc,
            backgroundColor: colors[index % colors.length].background,
            borderColor: colors[index % colors.length].border,
            pointRadius: 5,
            pointBackgroundColor: colors[index % colors.length].point,
            pointBorderColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: colors[index % colors.length].border,
            data: valData[index]
        };
    });

    console.log('datasets', datasets);

    // Crear gráfico con los meses en el eje X
    new Chart(ctxTimeline, {
        type: 'line',
        data: {
            labels: mesesTotales, // Todos los meses del año
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { 
                    grid: { display: false },
                    title: { display: true, text: "Mes" }
                },
                y: { 
                    beginAtZero: true,
                    title: { display: true, text: "Total" }
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

    var donutData  = {
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


$(function () {

    // Get context with jQuery - using jQuery's .get() method.
    const ctxTimeline = document.getElementById('timelineChart11').getContext('2d');
        let grafinsig = window.grafinsig; //capturar los datos en formato json

        const meses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];

        let datosMap = {};
        grafinsig.forEach(item => {
            datosMap[item.mes] = item.total;
        });

        let labels = meses; //extraer fechas
        let data = meses.map(mes => datosMap[mes] || 0); //extraer total

        new Chart(ctxTimeline, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label               : 'Insignias',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : 5,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : data,
                        
                    }
                ]
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
    var donutChartCanvas = $('#donutChart11').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Participar',
          'Aprender',
      ],
      datasets: [
        {
          data: [8,1],
          backgroundColor : ['#439a86', '#ebb93b'],
        }
      ]
    }
    var donutOptions     = {
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

