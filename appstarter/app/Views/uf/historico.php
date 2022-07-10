<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Historico de UF</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- echarts js -->
    <script type="text/javascript" src="<?= base_url() ?>/echarts/dist/echarts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.2.1/moment.min.js"></script>
    

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/datatables.net-dt/css/jquery.dataTables.css">
</head>
<body>

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


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar UF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-6">
                        <label>Fecha:</label>
                        <input type="text" id="fechaEdit" readonly="true">
                    </div>
                    <div class="col-6">
                        <label>Valor:</label>
                        <input type="number" id="valorEdit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarEdit">Guardar</button>
            </div>
            </div>
        </div>
        </div>



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
                        { name: 'Fecha', data: 'fecha' },
                        { name: 'Valor', data: 'valor' },
                        { name: 'Opciones', data: 'fecha' , render: function ( data, type, row ) {  
                            return '<button class="btn btn-success" id="editar" value="'+ data + '">Editar</button> <button  class="btn btn-danger" id="eliminar" value="' + data + '">Eliminar</a>';
                        }}
                    ],
                    ordering: false,
                });
            },
            error: function(response) {
                console.log('error');
            }

        });


        $('#tablaUf tbody').on('click', '#editar', function (e) {
            var t = $('#tablaUf').DataTable();
            var edit = t.row($(this).parents('tr')).data();
            $('#fechaEdit').val(edit.fecha);
            $('#valorEdit').val(edit.valor);
            $('#exampleModal').modal('show');
        });

        $('#exampleModal').on('click', '#guardarEdit', function (e) {
            var t = $('#tablaUf').DataTable();
            var f = $('#fechaEdit').val();
            var v = $('#valorEdit').val();

            // Find indexes of rows which have `Yes` in the second column
            var indexes = t.rows().eq( 0 ).filter( function (rowIdx) {
                return t.cell( rowIdx, 0 ).data() === f ? true : false;
            } );

            $('#tablaUf').dataTable().fnUpdate(v, indexes[0], 1);

            $('#exampleModal').modal('hide');
        });

        $('#tablaUf tbody').on('click', '#eliminar', function (e) {
            var t = $('#tablaUf').DataTable();
            var eliminar = t.row($(this).parents('tr')).data();
            var f = eliminar.fecha;

            var indexes = t.rows().eq( 0 ).filter( function (rowIdx) {
                return t.cell( rowIdx, 0 ).data() === f ? true : false;
            } );

            t.row(indexes[0]).remove().draw( false );
        });

        

</script>

<!-- -->

</body>
</html>
