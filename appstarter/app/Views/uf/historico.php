<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Historico de UF</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

    <!-- Bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    
    <!-- echarts js -->
    <script type="text/javascript" src="<?= base_url() ?>/echarts/dist/echarts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.2.1/moment.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/datatables.net-dt/css/jquery.dataTables.css">
</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<header>

</header>

<!-- CONTENT -->
<div class="container">
    <section>

        <h1>Historico de UF</h1>

        <p>Esta es una prueba en la vista:</p>

        <table id="tablaUf" class="table">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Valor (Pesos)</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table> 

    </section>
</div>


<!-- SCRIPTS -->
<script type="text/javascript" charset="utf8" src="<?= base_url() ?>/datatables.net/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        tabla = $('#tablaUf').DataTable();
    } );
</script>

<script type="text/javascript">

    $.ajax({
        type: "GET",
        url: '<?= base_url('uf/listar') ?>',
        data: { "get": ''},
        dataType:"json",
        success: function(response){
            //if request if made successfully then the response represent the data
            tabla.destroy();
            
            $('#tablaUf').DataTable({
                data: response,
                columns: [
                    { name: 'Fecha', data: 'fecha'},
                    { name: 'Valor', data: 'valor' },
                ],
                ordering: false
            });

        },
        error: function(response) {
            console.log('error');
        }

    });

</script>

<!-- -->

</body>
</html>
