<?php include("header.php"); ?>
<?php include("connection.php"); ?>
<?php

if ($_POST) {

    $titulo = $_POST['titulo'];

    $fecha = new DateTime();

    $imagen = $fecha->getTimestamp() . "_" . $_FILES['archivo']['name'];

    $img_tmp = $_FILES['archivo']['tmp_name'];

    move_uploaded_file($img_tmp, "img/" . $imagen);

    $Objconnect = new Conn();
    $sql = "INSERT INTO `fotos` (`id`, `titulo`, `imagen`) VALUES (NULL, '$titulo', '$imagen');";
    $Objconnect->execute($sql);
    header("location:galeria.php");
}

if ($_GET) {
    $id = $_GET['borrar'];
    $Objconnect = new Conn();

    $imagen = $Objconnect->listar("SELECT imagen FROM `fotos` WHERE id=" . $id);
    unlink("img/" . $imagen[0]['imagen']);
    $sql = "DELETE FROM fotos WHERE `fotos`.`id` = " . $id;
    $Objconnect->execute($sql);
    header("location:galeria.php");
}

$Objconnect = new Conn();
$result = $Objconnect->listar("SELECT * FROM `fotos`");
// print_r($result);
?>


<div class="container">
    <div class="row">
        <div class="col-4">
            <br />
            <div class="card">
                <div class="card-header">
                    Datos del proyecto
                </div>
                <div class="card-body">
                    <form action="galeria.php" method="post" enctype="multipart/form-data">
                        Titulo: <input required class="form-control" type="text" name="titulo" id="">
                        <br />
                        Imagen: <input required class="form-control" type="file" name="archivo" id="">
                        <br />

                        <input class="btn btn-success" type="submit" value="Enviar Foto">

                    </form>
                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $foto) { ?>
                            <tr class="">
                                <td scope="row"> <?php echo $foto['id'] ?> </td>
                                <td> <?php echo $foto['titulo'] ?> </td>
                                <td>
                                    <img width="100" src="img/<?php echo $foto['imagen'] ?>" alt="" srcset="">
                                </td>
                                <td> <a class="btn btn-danger" href="?borrar=<?php echo $foto['id'] ?>">Eliminar</a> </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include("footer.php"); ?>