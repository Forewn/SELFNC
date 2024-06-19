<?php include("../header.php") ?>

<!--------main-content------------->

<div class="main-content">
  <div class="row">
    <div class="col-md-12">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
              <h2 class="ml-lg-2">Alumnos</h2>
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

          function calcularEdad($fecha_nacimiento) {
            $fecha_nacimiento = new DateTime($fecha_nacimiento);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento);
            return $edad->y;
          }

          $sentencia = $connect->query("SELECT * FROM estudiantes");
          $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
        ?>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Cédula</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Edad</th>
              <th>Fecha de Nacimiento</th>
              <th>Genero</th>
              <th>Número de telefono</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($productos as $producto){ ?>
              <tr>
                <td><?php echo $producto->cedula_estudiante ?></td>
                <td><?php echo $producto->nombres ?></td>
                <td><?php echo $producto->correo ?></td>
                <td><?php echo calcularEdad($producto->fecha_nac) ?></td>
                <td><?php echo $producto->fecha_nac ?></td>
                <td>
                  <?php 
                    echo $producto->genero == 'M' ? 'Masculino' : ($producto->genero == 'F' ? 'Femenino' : $producto->genero); 
                  ?>
                </td>
                <td><?php echo $producto->telefono ?></td>
                <td>
                  <form method='POST' action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                    <input type='hidden' name='idstu' value="<?php echo $producto->cedula_estudiante; ?>">
                    <button name='editar' class='btn btn-warning text-white'>
                      <i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i>
                    </button>
                  </form>
                </td>
                <td>
                  <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                    <input type='hidden' name='idstu' value="<?php echo $producto->cedula_estudiante; ?>">
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

    <?php if (isset($_POST['editar'])) {
      $idstu = $_POST['idstu'];
      $sql= "SELECT * FROM estudiantes WHERE cedula_estudiante = :idstu"; 
      $stmt = $connect->prepare($sql);
      $stmt->bindParam(':idstu', $idstu, PDO::PARAM_INT); 
      $stmt->execute();
      $obj = $stmt->fetchObject();
    ?>
    <div class="col-12 col-md-12"> 
      <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input value="<?php echo $obj->cedula_estudiante;?>" name="cedula_estudiante" type="hidden">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="cedula_estudiante">Cédula</label>
            <input value="<?php echo $obj->cedula_estudiante;?>" maxlength="8" readonly name="cedula_estudiante" type="text" class="form-control" placeholder="Cédula">
          </div>
          <div class="form-group col-md-6">
            <label for="nombres">Nombre y apellidos</label>
            <input value="<?php echo $obj->nombres;?>" name="nombres" type="text" placeholder="Nombre y apellidos" class="form-control">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="correo">Correo</label>
            <input value="<?php echo $obj->correo;?>" name="correo" type="email" class="form-control" placeholder="Correo">
          </div>
          <div class="form-group col-md-6">
            <label for="direccion">Dirección</label>
            <input value="<?php echo $obj->direccion;?>" name="direccion" type="text" class="form-control" placeholder="Dirección">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="genero">Género</label>
            <select required name="genero" class="form-control">
              <option value="<?php echo $obj->genero;?>"><?php echo $obj->genero;?></option>        
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="fecha_nac">Fecha de nacimiento</label>
            <input value="<?php echo $obj->fecha_nac;?>" name="fecha_nac" type="date" class="form-control">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="telefono">Teléfono</label>
            <input value="<?php echo $obj->telefono;?>" name="telefono" type="text" class="form-control" placeholder="Teléfono">
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
                        <input type="text" name="cedula_estudiante" maxlength="8" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Cédula" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group">       
                        <input type="text" name="nombres" placeholder="Nombre y apellidos" required class="form-control"/>
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
                        <input type="date" name="fecha_nac" required class="form-control"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" name="direccion" required class="form-control" placeholder="Dirección" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="input-group">       
                        <input type="text" name="telefono" placeholder="Número de telefono" required class="form-control"/>
                      </div>
                    </div>
                  </div>
                </div>   
                <button name='agregar' class="btn btn-primary">GUARDAR</button>
                <br>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              </div>
            </div>   
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php
    if(isset($_POST['agregar'])) {
      $cedula_estudiante = $_POST['cedula_estudiante'];
      $nombres = $_POST['nombres'];
      $fecha_nac = $_POST['fecha_nac'];
      $direccion = $_POST['direccion'];
      $correo = $_POST['correo'];
      $genero = $_POST['genero'];
      $telefono = $_POST['telefono'];

      if(empty($cedula_estudiante)){
        $errMSG = "Por favor, ingrese la cédula.";
      } else if(empty($nombres)){
        $errMSG = "Por favor, ingrese el nombre.";
      } else if(empty($fecha_nac)){
        $errMSG = "Por favor, ingrese la fecha de nacimiento.";
      } else if(empty($direccion)){
        $errMSG = "Por favor, ingrese la dirección.";
      } else if(empty($correo)){
        $errMSG = "Por favor, ingrese el correo.";
      } else if(empty($genero)){
        $errMSG = "Por favor, ingrese el género.";
      } else {
        if(!isset($errMSG)) {
          $stmt = $connect->prepare("INSERT INTO estudiantes (cedula_estudiante, nombres, fecha_nac, direccion, correo, genero, telefono) VALUES(:cedula_estudiante, :nombres, :fecha_nac, :direccion, :correo, :genero, :telefono)");
          $stmt->bindParam(':cedula_estudiante', $cedula_estudiante);
          $stmt->bindParam(':nombres', $nombres);
          $stmt->bindParam(':fecha_nac', $fecha_nac);
          $stmt->bindParam(':direccion', $direccion);
          $stmt->bindParam(':correo', $correo);
          $stmt->bindParam(':genero', $genero);
          $stmt->bindParam(':telefono', $telefono);

          try {
            if($stmt->execute()) {
              echo '<script type="text/javascript">
              swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
                window.location = "mostrar.php";
              });
              </script>';
            } else {
              $errMSG = "Error al insertar.";
            }
          } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
              $errMSG = "Error: La cédula ya existe.";
            } else {
              $errMSG = "Error: " . $e->getMessage();
            }
            echo '<script type="text/javascript">swal("¡Error!", "'.$errMSG.'", "error");</script>';
          }
        }
      }
    }

    if(isset($_POST['eliminar'])) {
      $idstu = $_POST['idstu'];
      $consulta = "DELETE FROM estudiantes WHERE cedula_estudiante = :idstu";
      $sql = $connect->prepare($consulta);
      $sql->bindParam(':idstu', $idstu, PDO::PARAM_INT);
      $sql->execute();

      if($sql->rowCount() > 0) {
        echo '<script type="text/javascript">
        swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
          window.location = "mostrar.php";
        });
      </script>';
      } else {
        echo "<div class='content alert alert-danger'> No se pudo eliminar el registro </div>";
        print_r($sql->errorInfo()); 
      }
    }

    if(isset($_POST['actualizar'])) {
      $cedula_estudiante = trim($_POST['cedula_estudiante']);
      $nombres = trim($_POST['nombres']);
      $fecha_nac = trim($_POST['fecha_nac']);
      $direccion = trim($_POST['direccion']);
      $correo = trim($_POST['correo']);
      $genero = trim($_POST['genero']);
      $telefono = trim($_POST['telefono']);
      
      $consulta = "UPDATE estudiantes
      SET nombres = :nombres, fecha_nac = :fecha_nac, direccion = :direccion, correo = :correo, genero = :genero, telefono = :telefono
      WHERE cedula_estudiante = :cedula_estudiante";
      $sql = $connect->prepare($consulta);
      $sql->bindParam(':nombres', $nombres, PDO::PARAM_STR, 45);
      $sql->bindParam(':fecha_nac', $fecha_nac, PDO::PARAM_STR);
      $sql->bindParam(':direccion', $direccion, PDO::PARAM_STR);
      $sql->bindParam(':correo', $correo, PDO::PARAM_STR);
      $sql->bindParam(':genero', $genero, PDO::PARAM_STR);
      $sql->bindParam(':telefono', $telefono, PDO::PARAM_STR);
      $sql->bindParam(':cedula_estudiante', $cedula_estudiante, PDO::PARAM_INT);

      try {
        if($sql->execute()) {
          echo '<script type="text/javascript">
          swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
            window.location = "mostrar.php";
          });
          </script>';
        } else {
          echo '<script type="text/javascript">
          swal("¡Error!", "No se pudo actualizar el registro.", "error");
          </script>';
        }
      } catch(PDOException $e) {
        echo '<script type="text/javascript">
        swal("¡Error!", "'.$e->getMessage().'", "error");
        </script>';
      }
    }
    ?>
  </div>
</div>
</div>
<!----------html code complete----------->


<!-- Optional JavaScript -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
