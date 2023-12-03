<?php
if (isset($_GET)) {
    if (!empty($_GET['accion']) && !empty($_GET['id'])) {
        require_once "../config/conexion.php";
        $id = $_GET['id'];
        if ($_GET['accion'] == 'pro') {
            $query = mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
            if ($query) {
                header('Location: productos.php');
            }
        }



        if ($_GET['accion'] == 'cli') {
            try{
                $query = mysqli_query($conexion, "DELETE FROM categorias WHERE id = $id");
            if ($query) {
                header('Location: categorias.php');
            }


            }catch(Exception $e){
                $query = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = $id");
                $data = mysqli_fetch_assoc($query);
                echo '<script>';
                echo 'alert("No se puede eliminar la categoria de ',$data['categoria'],' por que aun tiene productos");';
                echo 'window.location.href = "categorias.php";';
                echo '</script>';
                
                //die('No se puede eliminar esta categoria por que aun contiene productos');
                    
                
            }

        }
        if ($_GET['accion'] == 'usu') {
            $query = mysqli_query($conexion, "DELETE FROM usuarios WHERE id = $id");
            if ($query) {
                header('Location: Usuarios.php');
            }
        }
    }
}
?>