<?php
require_once "../config/conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM productos WHERE id=$id";
    $result = mysqli_query($conexion, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $cantidad = $row['cantidad'];
        $p_normal = $row['precio_normal'];
        $p_rebajado = $row['precio_rebajado'];
        $categoria = $row['id_categoria'];
        $imagen = $row['imagen'];
    }
}

//ACTUALIZAR PRODUCTO
if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $p_normal = $_POST['p_normal'];
    $p_rebajado = $_POST['p_rebajado'];
    $categoria = $_POST['categoria'];
    $img = $_FILES['foto'];
    $tmpname = $img['tmp_name'];
    $fecha = date("YmdHis");
    $foto = $fecha . ".jpg";
    $destino = "../assets/img/" . $foto;


    if (!empty($_FILES['foto']['name'])) {
        $query = "UPDATE productos set nombre = '$nombre', descripcion = '$descripcion',precio_normal = '$p_normal',precio_rebajado = '$p_rebajado', cantidad= '$cantidad', imagen = '$foto', id_categoria='$categoria'  WHERE id=$id";
        mysqli_query($conexion, $query);

        if ($query) {
            if (move_uploaded_file($tmpname, $destino)) {
                $_SESSION['message'] = 'Task Updated Successfully';
                header('Location: productos.php');
            }
        }
    }else{
        $query = "UPDATE productos set nombre = '$nombre', descripcion = '$descripcion',precio_normal = '$p_normal',precio_rebajado = '$p_rebajado', cantidad= '$cantidad', id_categoria='$categoria'  WHERE id=$id";
        mysqli_query($conexion, $query);

        if ($query) {
                $_SESSION['message'] = 'Task Updated Successfully';
                header('Location: productos.php');
            



    }
    }
}



include("includes/header.php"); ?>




<form action="modificar.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
    <h1 class="text-center">Modificar producto</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required value="<?php echo $nombre; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" required value="<?php echo $cantidad; ?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción" rows="3" required><?php echo $descripcion; ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="p_normal">Precio Normal</label>
                <input id="p_normal" class="form-control" type="text" name="p_normal" placeholder="Precio Normal" required value="<?php echo $p_normal; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="p_rebajado">Precio Rebajado</label>
                <input id="p_rebajado" class="form-control" type="text" name="p_rebajado" placeholder="Precio Rebajado" required value="<?php echo $p_rebajado; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select id="categoria" class="form-control" name="categoria" required>
                    <?php
                    $categorias = mysqli_query($conexion, "SELECT * FROM categorias");
                    foreach ($categorias as $cat) { ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['categoria']; ?></option>
                    <?php }  ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="imagen">Foto</label>
                <img src="../assets/img/<?php echo $imagen; ?>" alt="Imagen Actual" style="max-width: 200px; max-height: 200px;">
                <input type="file" class="form-control" name="foto" value="<?php echo $imagen; ?>">
            </div>
        </div>
    </div>
    <button class="btn btn-primary" name="update">Modificar</button>
</form>


<?php include("includes/footer.php"); ?>