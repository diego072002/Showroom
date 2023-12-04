<?php
require_once "../config/conexion.php";

if (isset($_POST)) {
    if (!empty($_POST)) {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $contra = $_POST['contra'];
        $confcontra = $_POST['confirmarcontra'];
        $nivel = 2;

        if ($contra == $confcontra) {
            $contraencrip = md5($_POST['contra']);
            $query = mysqli_query($conexion, "INSERT INTO usuarios(usuario, nombre, clave,nivel) VALUES ('$usuario', '$nombre', '$contraencrip','$nivel')");
            if ($query) {
                header('Location: Usuarios.php');
            }
        } 
    }
}
include("includes/header.php"); ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirProducto"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Accion</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nivel>1 ORDER BY id DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['nombre']; ?></td>
                            <td><?php echo $data['usuario']; ?></td>
                            <td>
                                <form method="post" action="eliminar.php?accion=usu&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nuevo Usuario</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form action="" method="POST" enctype="multipart/form-data" autocomplete="off" onsubmit="return validarFormulario()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Ingrese el usuario" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contra">Contraseña</label>
                                <input id="contra" class="form-control" type="password" name="contra" placeholder="Ingrese la contraseña" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cnfirmacontra">Confirmar contraseña</label>
                                <input id="confirmarcontra" class="form-control" type="password" name="confirmarcontra" placeholder="Ingrese la contraseña" required>
                                <p id="mensajeError" style="color: red;"></p>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function validarFormulario() {
        var contra = document.getElementById('contra').value;
        var confirmarcontra = document.getElementById('confirmarcontra').value;
        var mensajeError = document.getElementById('mensajeError');

        if (contra !== confirmarcontra) {
            mensajeError.innerText = 'Las contraseñas no coinciden. Por favor, inténtelo de nuevo.';
            return false; // Evita que se envíe el formulario
        } else {
            mensajeError.innerText = '';
            return true; // Permite que se envíe el formulario
        }
    }
</script>
<?php include("includes/footer.php"); ?>