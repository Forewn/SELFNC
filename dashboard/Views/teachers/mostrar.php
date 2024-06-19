<?php include("../header.php") ?>
<!--------main-content------------->
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Docentes</h2>
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
                $sentencia = $connect->prepare("SELECT * FROM profesores;");
                $sentencia->execute();
                $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
                ?>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Género</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productos as $producto){ ?>
                        <tr>
                            <td><?php echo $producto->cedula_profesor ?></td>
                            <td><?php echo $producto->nombre ?></td>
                            <td><?php echo $producto->correo ?></td>
                            <td><?php echo $producto->telefono ?></td>
                            <td>
                                <?php 
                                echo $producto->genero == 'M' ? 'Masculino' : ($producto->genero == 'F' ? 'Femenino' : $producto->genero); 
                                ?>
                            </td>
                            <td>
                                <form method='POST' action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                                    <input type='hidden' name='cedula_profesor' value="<?php echo $producto->cedula_profesor; ?>">
                                    <button name='editar' class='btn btn-warning text-white'>
                                        <i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                                    <input type='hidden' name='cedula_profesor' value="<?php echo $producto->cedula_profesor; ?>">
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

        <?php 
        if (isset($_POST['editar'])){
            $cedula_profesor = $_POST['cedula_profesor'];
            $sql= "SELECT * FROM profesores WHERE cedula_profesor = :cedula_profesor"; 
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':cedula_profesor', $cedula_profesor, PDO::PARAM_INT); 
            $stmt->execute();
            $obj = $stmt->fetchObject();
        ?>

        <div class="col-12 col-md-12">
            <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <input value="<?php echo $obj->cedula_profesor;?>" name="cedula_profesor" type="hidden">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Cédula</label>
                        <input value="<?php echo $obj->cedula_profesor;?>" maxlength="8" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cedula_profesor" type="text" class="form-control" placeholder="Cédula">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="edad">Nombre y apellidos</label>
                        <input value="<?php echo $obj->nombre;?>" name="nombre" type="text" placeholder="Nombre y apellidos" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Género</label>
                        <select required name="genero" class="form-control">
                            <option value="<?php echo $obj->genero;?>"><?php echo $obj->genero;?></option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombres">Correo</label>
                        <input value="<?php echo $obj->correo;?>" name="correo" type="email" class="form-control" placeholder="Correo">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Teléfono</label>
                        <input value="<?php echo $obj->telefono;?>" name="telefono" maxlength="20" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" type="text" class="form-control" placeholder="Teléfono móvil">
                    </div>
                </div>

                <div class="form-group">
                    <button name="actualizar" type="submit" class="btn btn-primary btn-block">Actualizar Registro</button>
                </div>
            </form>
        </div>
        <?php }?>

        <!-- Add Modal HTML -->
        <div id="addEmployeeModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myTitle" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" autocomplete="off">
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
                            <div id="step1"> 
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="cedula_profesor" maxlength="8" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Cédula" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">       
                                                <input type="text" name="nombre" placeholder="Nombre y apellidos" required class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="email" name="correo" required class="form-control" placeholder="Correo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select class="form-control" required name="genero">
                                                    <option selected>GÉNERO</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="telefono" maxlength="11" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Teléfono" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button name='agregar' class="btn btn-success btn-block">GUARDAR</button>
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- PHP Code for CRUD operations -->
        <?php  
        if(isset($_POST['agregar']))
        {
            $cedula_profesor = $_POST['cedula_profesor'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $genero = $_POST['genero'];
            $telefono = $_POST['telefono'];

            if(empty($cedula_profesor)){
                $errMSG = "Por favor ingrese la cédula.";
            } else if(empty($nombre)){
                $errMSG = "Por favor ingrese el nombre.";
            } else if(empty($genero)){
                $errMSG = "Por favor ingrese el género.";
            } else if(empty($correo)){
                $errMSG = "Por favor ingrese el correo.";
            } else if(empty($telefono)){
                $errMSG = "Por favor ingrese el teléfono.";
            } else {
                $stmt = $connect->prepare("INSERT INTO profesores(cedula_profesor, nombre, correo, genero, telefono) VALUES(:cedula_profesor, :nombre, :correo, :genero, :telefono)");
                $stmt->bindParam(':cedula_profesor', $cedula_profesor);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':genero', $genero);
                $stmt->bindParam(':telefono', $telefono);
                
                if($stmt->execute()) {
                    echo '<script type="text/javascript">
                    swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
                        window.location = "mostrar.php";
                    });
                    </script>';
                } else {
                    $errMSG = "Error al insertar.";
                }
            }
        }

        if(isset($_POST['eliminar'])){
            $cedula_profesor = trim($_POST['cedula_profesor']);
            $consulta = "DELETE FROM profesores WHERE cedula_profesor = :cedula_profesor";
            $sql = $connect->prepare($consulta);
            $sql->bindParam(':cedula_profesor', $cedula_profesor, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount() > 0) {
                echo '<script type="text/javascript">
                swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
                    window.location = "mostrar.php";
                });
                </script>';
            } else {
                echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";
                print_r($sql->errorInfo()); 
            }
        }

        if(isset($_POST['actualizar'])){
            $cedula_profesor = trim($_POST['cedula_profesor']);
            $nombre = trim($_POST['nombre']);
            $genero = trim($_POST['genero']);
            $correo = trim($_POST['correo']);
            $telefono = trim($_POST['telefono']);

            $consulta = "UPDATE profesores SET nombre = :nombre, genero = :genero, correo = :correo, telefono = :telefono WHERE cedula_profesor = :cedula_profesor";
            $sql = $connect->prepare($consulta);
            $sql->bindParam(':cedula_profesor', $cedula_profesor, PDO::PARAM_STR, 25);
            $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
            $sql->bindParam(':genero', $genero, PDO::PARAM_STR, 25);
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR, 25);
            $sql->bindParam(':telefono', $telefono, PDO::PARAM_STR, 25);

            $sql->execute();

            if($sql->rowCount() > 0) {
                echo '<script type="text/javascript">
                swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
                    window.location = "mostrar.php";
                });
                </script>';
            } else {
                echo "<div class='content alert alert-danger'> No se pudo actualizar el registro  </div>";
                print_r($sql->errorInfo()); 
            }
        }
        ?>

        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).ready(function(){
                $(".xp-menubar").on('click', function(){
                    $('#sidebar').toggleClass('active');
                    $('#content').toggleClass('active');
                });

                $(".xp-menubar, .body-overlay").on('click', function(){
                    $('#sidebar, .body-overlay').toggleClass('show-nav');
                });

                setTimeout(function() {
                    $(".content").fadeOut(1500);
                }, 3000);
            });
        </script>
        <script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
        <script src="../../Assets/js/popper.min.js"></script>
        <script src="../../Assets/js/bootstrap-1.min.js"></script>
        <script src="../../Assets/js/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    </div>
</div>
