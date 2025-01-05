<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD_API_UI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-center">Registro de productos</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="$_POST" id="frm">
                            <div class="form-group">
                            <input type="hidden" name="idp" id="idp" value="">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" id="codigo" placeholder="Código" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="producto">Producto</label>
                                <input type="text" name="producto" id="producto" placeholder="Descripción" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="text" name="precio" id="precio" placeholder="Precio" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="button" value="Registrar" id="registrar" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="" method="$_GET">
                            <div class="form-group">
                                <label for="buscar">Buscar por nombre o descripción:</label>
                                <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="$_GET">
                            <div class="form-group">
                                <label for="buscarId">Buscar por ID:</label>
                                <input type="number" name="buscarId" id="buscarId" placeholder="ID del producto" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-resposive">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultado">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
