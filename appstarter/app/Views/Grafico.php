<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grafico UF</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- Jquery and Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
         $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $( function() {
            $( "#desdeDate" ).datepicker()
        } );
        $( function() {
            $( "#hastaDate" ).datepicker()
        } );
    </script>

    <!-- echarts js -->
    <script type="text/javascript" src="<?= base_url() ?>/echarts/dist/echarts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.2.1/moment.min.js"></script>
    
</head>
<body>

<!-- CONTENT -->
<div class="container">
    <section>

        <h1>Grafico</h1>

        <p>Esta es una prueba en la vista:</p>
        <form id="formFechas"> 
            <div class="col-sm-3">
                <select class="form-select form-select-sm" id="selectIndicador">
                    <option selected>Seleccionar indicador</option>
                    <option value="uf">Unidad de fomento (UF)</option>
                    <option value="libra_cobre">Libra de Cobre</option>
                    <option value="tasa_desempleo">Tasa de desempleo</option>
                    <option value="euro">Euro</option>
                    <option value="imacec">Imacec</option>
                    <option value="dolar">Dólar observado</option>
                    <option value="tpm">Tasa Política Monetaria (TPM)</option>
                    <option value="ivp">Indice de valor promedio (IVP)</option>
                    <option value="ipc">Indice de Precios al Consumidor (IPC)</option>
                    <option value="dolar_intercambio">Dólar acuerdo</option>
                    <option value="utm">Unidad Tributaria Mensual (UTM)</option>
                    <option value="bitcoin">Bitcoin</option>
                </select>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-sm-3">
                    <label>Desde: </label>
                    <input id="desdeDate" type="text" >
                </div>
                <div class="col-6 col-sm-3">
                    <label>Hasta: </label>
                    <input id="hastaDate" type="text" >
                </div>
                <div class="col-6 col-sm-3">
                    <input id="buscarBtn" type="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
        <!-- Prepare a DOM with a defined width and height for ECharts -->
        <div id="main" style="width: 600px;height:400px;"></div>

    </section>
</div>


<!-- SCRIPTS -->
<script>
    // Attach a submit handler to the form
    $( "#formFechas" ).submit(function( event ) {
    
    // Stop form from submitting normally
    event.preventDefault();
    
    // Get some values from elements on the page:
    var $form = $( this ),
        indicador = $form.find("select#selectIndicador option:checked").val();
        fechaDesde = $form.find("input[id=desdeDate]").val();
        fechaHasta = $form.find("input[id=hastaDate]").val();

    //Ajax Function to send a get request
    $.ajax({
        type: "POST",
        url: '<?= base_url('listar') ?>',
        data: { "indicador": indicador, "fechaInicio": fechaDesde, "fechaFin":  fechaHasta},
        dataType:"json",
        success: function(response){
            //if request if made successfully then the response represent the data
            console.log(response);

            let fechas = [];
            let valores = [];
            var unidad = "";
            var indica = "";

            for (let i = 0; i < response.length; i++) {
                indica = response[i].indicador;
                unidad = response[i].unidad;
                fechas.push(moment(response[i].fecha).format('DD-MM-YYYY'));
                valores.push(response[i].valor);
            }

            console.log(fechas);
            console.log(valores);

            option = {
                title: {
                    text: indica.toUpperCase()
                },
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: fechas
                },
                series: [
                    {
                        name: unidad,
                        data: valores,
                        type:  'line',
                        smooth: true
                    }
                ]
            };

            myChart.setOption(option);


        },
        error: function(response) {
            console.log('error');
        }

    });
    
    });
</script>



<script type="text/javascript">
    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById('main'));

    // Specify the configuration items and data for the chart
    option = {
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [ "15-08-1980", 
                    "10-02-1998",
                    "25-06-2001",
                    "07-11-2008",
                    "21-04-2013",
                    "30-09-2021"]
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Indicador',
                data: [150, 230, 224, 218, 135, 147],
                type:  'line',
                smooth: true
            }
        ]
    };

    option && myChart.setOption(option);
</script>

<!-- -->

</body>
</html>
