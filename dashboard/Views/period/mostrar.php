<?php include("../header.php") ?>
<!--------main-content------------->
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Periodo Académico</h2>
                        </div>
                        <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i> 
                            </a>
                            <a href="plantilla.php" class="btn btn-danger">
                                <i class="material-icons">print</i> 
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                require '../../Config/config.php';
                
                $sentencia = $connect->query("SELECT * FROM periodo_academico;");
                $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
                ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productos as $producto){ ?>
                        <tr>
                            <td><?php echo $producto->nombre ?></td>
                            <td><?php echo $producto->fecha_inicio ?></td>
                            <td><?php echo $producto->fecha_fin ?></td>
                            <td>
                                <?php if($producto->status == '1') { ?> 
                                <span class="badge badge-success">Activo</span>
                                <?php } else { ?> 
                                <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>  
                            </td>
                            <td>
                                <form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                                    <input type='hidden' name='id_periodo' value="<?php echo $producto->id_periodo; ?>">
                                    <button name='editar' class='btn btn-warning text-white'>
                                        <i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                                    <input type='hidden' name='id_periodo' value="<?php echo $producto->id_periodo; ?>">
                                    <button name='eliminar' class='btn btn-danger text-white'>
                                        <i class='material-icons' title='Delete'>&#xE872;</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
if (isset($_POST['editar'])){
$id_periodo = $_POST['id_periodo'];
$sql= "SELECT * FROM periodo_academico WHERE id_periodo = :id_periodo"; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
?>
<div class="col-12 col-md-12"> 
    <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input value="<?php echo $obj->id_periodo;?>" name="id_periodo" type="hidden">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre</label>
                <input value="<?php echo $obj->nombre;?>" name="nombre" type="text" class="form-control" placeholder="Nombre">
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_fin">Fecha Fin</label>
                <input value="<?php echo $obj->fecha_fin;?>" name="fecha_fin" type="date" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input value="<?php echo $obj->fecha_inicio;?>" name="fecha_inicio" type="date" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="status">Estado</label>
                <select class="form-control" name="status">
                    <option value="1" <?php if($obj->status == '1') echo 'selected'; ?>>Activo</option>
                    <option value="0" <?php if($obj->status == '0') echo 'selected'; ?>>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button name="actualizar" type="submit" class="btn btn-primary btn-block">Actualizar Registro</button>
        </div>
    </form>
</div>
<?php }?>

<!-- add Modal HTML -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form enctype="multipart/form-data" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-user mr-1"></i>NUEVO
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal_contact_firstname">Nombre</label>
                                <div class="input-group">
                                    <input type="text" name="txtnombre" required class="form-control" placeholder="Nombre" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal_contact_lastname">Fecha Fin</label>
                                <div class="input-group">
                                    <input type="date" name="txtfecha_fin" required class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal_contact_firstname">Fecha Inicio</label>
                                <div class="input-group">
                                    <input type="date" name="txtfecha_inicio" required class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="modal_contact_lastname">Estado</label>
                                <div class="input-group">
                                    <select class="form-control" required name="txtestado">
                                        <option selected>SELECCIONE</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                    <button name='agregar' class="btn btn-primary">GUARDAR</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal HTML -->
</div>
</div>
<!----------html code compleate----------->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".xp-menubar").on('click',function(){
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });
        
        $(".xp-menubar,.body-overlay").on('click',function(){
            $('#sidebar,.body-overlay').toggleClass('show-nav');
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php  
if(isset($_POST['agregar'])){
    $sentencia = $connect->query("SELECT MAX(id_periodo) AS max_id FROM periodo_academico;");
    $max_id = $sentencia->fetchObject()->max_id;
    $new_id = ($max_id >= 2) ? $max_id + 1 : 2;

    $nombre = $_POST['txtnombre'];
    $fecha_inicio = $_POST['txtfecha_inicio'];
    $fecha_fin = $_POST['txtfecha_fin'];
    $estado = $_POST['txtestado'];

    $sql = "INSERT INTO periodo_academico (id_periodo, nombre, fecha_inicio, fecha_fin, status) VALUES (:id_periodo, :nombre, :fecha_inicio, :fecha_fin, :estado)";

    $statement = $connect->prepare($sql);
    $statement->bindValue(':id_periodo', $new_id, PDO::PARAM_INT);
    $statement->bindValue(':nombre', $nombre);
    $statement->bindValue(':fecha_inicio', $fecha_inicio);
    $statement->bindValue(':fecha_fin', $fecha_fin);
    $statement->bindValue(':estado', $estado);

    $inserted = $statement->execute();

    if($inserted){
        echo '<script type="text/javascript">
        swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
    }
}
?>

<?php  
if(isset($_POST['eliminar'])){
    $id_periodo = $_POST['id_periodo'];
    $consulta = "DELETE FROM `periodo_academico` WHERE `id_periodo`=:id_periodo";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
    $sql->execute();

    if($sql->rowCount() > 0)
    {
        echo '<script type="text/javascript">
        swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
    }
    else{
        echo "<div class='content alert alert-danger'> No se pudo eliminar el registro </div>";
        print_r($sql->errorInfo()); 
    }
}
?>

<?php  
if(isset($_POST['actualizar'])){
    $id_periodo = $_POST['id_periodo'];
    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['status'];

    $consulta = "UPDATE periodo_academico
    SET nombre = :nombre, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, status = :estado 
    WHERE id_periodo = :id_periodo";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
    $sql->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR, 25);
    $sql->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR, 25);
    $sql->bindParam(':estado', $estado, PDO::PARAM_STR, 25);
    $sql->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);

    $sql->execute();

    if($sql->rowCount() > 0)
    {
        echo '<script type="text/javascript">
        swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
    }
    else{
        echo "<div class='content alert alert-danger'> No se pudo actualizar el registro </div>";
        print_r($sql->errorInfo()); 
    }
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $(".content").fadeOut(1500);
        },3000);
    });
</script>
</body>
</html>
