<?php include("../header.php") ?>

   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Incluyendo los iconos de Material Design -->

<body>
    <!--------main-content------------->
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                                <h2 class="ml-lg-2">Materias</h2>
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
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
                    <?php  
                    require '../../Config/config.php';

                    $sentencia = $connect->prepare("SELECT m.id_materia, m.materia, t.tipo, a.anio 
                                                    FROM materias m 
                                                    INNER JOIN tipo_materia t ON m.id_tipo = t.id_tipo 
                                                    INNER JOIN anios a ON m.id_anio = a.id_anio");
                    $sentencia->execute();
                    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Tipo</th>
                                <th>Año</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($productos as $producto){ ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($producto->materia) ?></td>
                                    <td><?php echo htmlspecialchars($producto->tipo) ?></td>
                                    <td><?php echo htmlspecialchars($producto->anio) ?></td>
                                    <td>
                                        <form method='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>'>
                                            <input type='hidden' name='id_materia' value="<?php echo htmlspecialchars($producto->id_materia); ?>">
                                            <button name='editar' class='btn btn-warning text-white'>
                                                <i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>'>
                                            <input type='hidden' name='id_materia' value="<?php echo htmlspecialchars($producto->id_materia); ?>">
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
        $id_materia = $_POST['id_materia'];
        $sql= "SELECT m.id_materia, m.materia, m.id_tipo, m.id_anio 
               FROM materias m 
               WHERE id_materia = :id_materia"; 
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT); 
        $stmt->execute();
        $obj = $stmt->fetchObject();

        $tipos = $connect->query("SELECT id_tipo, tipo FROM tipo_materia")->fetchAll(PDO::FETCH_OBJ);
        $anios = $connect->query("SELECT id_anio, anio FROM anios")->fetchAll(PDO::FETCH_OBJ);
    ?>
        <div class="col-12 col-md-12"> 
            <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <input value="<?php echo htmlspecialchars($obj->id_materia); ?>" name="id_materia" type="hidden">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="materia">Materia</label>
                        <input value="<?php echo htmlspecialchars($obj->materia); ?>" name="materia" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="id_tipo">Tipo</label>
                        <select name="id_tipo" class="form-control">
                            <?php foreach($tipos as $tipo) { ?>
                                <option value="<?php echo htmlspecialchars($tipo->id_tipo); ?>" <?php if($tipo->id_tipo == $obj->id_tipo) echo 'selected'; ?>><?php echo htmlspecialchars($tipo->tipo); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="id_anio">Año</label>
                        <select name="id_anio" class="form-control">
                            <?php foreach($anios as $anio) { ?>
                                <option value="<?php echo htmlspecialchars($anio->id_anio); ?>" <?php if($anio->id_anio == $obj->id_anio) echo 'selected'; ?>><?php echo htmlspecialchars($anio->anio); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button name="actualizar" type="submit" class="btn btn-primary btn-block">Actualizar Registro</button>
                </div>
            </form>
        </div>
    <?php } ?>

    <!-- Add Modal HTML -->
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
                                    <label for="modal_contact_firstname">Materia</label>
                                    <input type="text" name="txtmateria" required class="form-control" placeholder="Nombre de la materia" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Tipo</label>
                                    <select required name="txtidtipo" class="form-control">
                                        <option value="" disabled selected>Selecciona el tipo</option>
                                        <?php
                                        $tipos = $connect->query("SELECT id_tipo, tipo FROM tipo_materia")->fetchAll(PDO::FETCH_OBJ);
                                        foreach($tipos as $tipo) { ?>
                                            <option value="<?php echo htmlspecialchars($tipo->id_tipo); ?>"><?php echo htmlspecialchars($tipo->tipo); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Año</label>
                                    <select required name="txtid_anio" class="form-control">
                                        <option value="" disabled selected>Selecciona el año</option>
                                        <?php
                                        $anios = $connect->query("SELECT id_anio, anio FROM anios")->fetchAll(PDO::FETCH_OBJ);
                                        foreach($anios as $anio) { ?>
                                            <option value="<?php echo htmlspecialchars($anio->id_anio); ?>"><?php echo htmlspecialchars($anio->anio); ?></option>
                                        <?php } ?>
                                    </select>
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
    </div>

    <?php
    if (isset($_POST['actualizar'])){
        $id_materia = $_POST['id_materia'];
        $materia = $_POST['materia'];
        $id_tipo = $_POST['id_tipo'];
        $id_anio = $_POST['id_anio'];

        $sql = "UPDATE materias SET materia = :materia, id_tipo = :id_tipo, id_anio = :id_anio WHERE id_materia = :id_materia";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':materia', $materia);
        $stmt->bindParam(':id_tipo', $id_tipo);
        $stmt->bindParam(':id_anio', $id_anio);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registro actualizado con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar el registro.</div>";
        }
    }

    if (isset($_POST['agregar'])){
        $materia = $_POST['txtmateria'];
        $id_tipo = $_POST['txtidtipo'];
        $id_anio = $_POST['txtid_anio'];

        $sql = "INSERT INTO materias (materia, id_tipo, id_anio) VALUES (:materia, :id_tipo, :id_anio)";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':materia', $materia);
        $stmt->bindParam(':id_tipo', $id_tipo);
        $stmt->bindParam(':id_anio', $id_anio);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registro agregado con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al agregar el registro.</div>";
        }
    }

    if (isset($_POST['eliminar'])){
        $id_materia = $_POST['id_materia'];

        $sql = "DELETE FROM materias WHERE id_materia = :id_materia";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registro eliminado con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el registro.</div>";
        }
    }
    ?>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>

<!-- Optional JavaScript -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
