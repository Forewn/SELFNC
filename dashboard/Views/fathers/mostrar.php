<?php include("../header.php") ?>

<!--------main-content------------->

<div class="main-content">
  <div class="row">
    <div class="col-md-12">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
              <h2 class="ml-lg-2">Representantes Legales</h2>
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

        $sentencia = $connect->query("SELECT * FROM representante_legal");
        $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
        ?>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Cédula</th>
              <th>Nombre</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Dirección</th>
              <th>Sexo</th>
              <th>Parentezco</th>
              <th>Profesion</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($productos as $producto){ ?>
              <tr>
                <td><?php echo $producto->cedula_representante_legal ?></td>
                <td><?php echo $producto->nombre ?></td>
                <td><?php echo $producto->telefono ?></td>
                <td><?php echo $producto->correo ?></td>
                <td><?php echo $producto->direccion ?></td>
                <td><?php echo $producto->sexo == 'M' ? 'Masculino' : 'Femenino'; ?></td>
                <td><?php 
                    $parentezco = $connect->prepare("SELECT parentezco FROM parentezcos WHERE id_parentezco = ?");
                    $parentezco->execute([$producto->id_parentezco]);
                    echo $parentezco->fetchColumn();
                ?></td>
                <td><?php echo $producto->profesion ?></td>
                <td>
                  <form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                    <input type='hidden' name='cedula_representante_legal' value="<?php echo $producto->cedula_representante_legal; ?>">
                    <button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
                  </form>
                </td>
                <td>
                  <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                    <input type='hidden' name='cedula_representante_legal' value="<?php echo $producto->cedula_representante_legal; ?>">
                    <button name='eliminar' class='btn btn-danger text-white'><i class='material-icons' title='Delete'>&#xE872;</i></button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php 
    // Obtener las opciones de parentezco
    $parentezcos = $connect->query("SELECT id_parentezco, parentezco FROM parentezcos")->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST['editar'])){
      $cedula_representante_legal = $_POST['cedula_representante_legal'];
      $sql= "SELECT * FROM representante_legal WHERE cedula_representante_legal = :cedula_representante_legal"; 
      $stmt = $connect->prepare($sql);
      $stmt->bindParam(':cedula_representante_legal', $cedula_representante_legal, PDO::PARAM_INT); 
      $stmt->execute();
      $obj = $stmt->fetchObject();
      ?>

      <div class="col-12 col-md-12"> 

        <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <input value="<?php echo $obj->cedula_representante_legal;?>" name="cedula_representante_legal" type="hidden">
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="cedula">Cédula</label>
              <input value="<?php echo $obj->cedula_representante_legal;?>" maxlength="11" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cedula_representante_legal" type="text" class="form-control" placeholder="Cédula">
            </div>

            <div class="form-group col-md-6">
              <label for="nombre">Nombre</label>
              <input value="<?php echo $obj->nombre;?>" name="nombre" type="text" placeholder="Nombre" class="form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="profesion">Profesión</label>
              <input value="<?php echo $obj->profesion;?>" name="profesion" type="text" class="form-control" placeholder="Profesión">
            </div>

            <div class="form-group col-md-6">
              <label for="correo">Correo</label>
              <input value="<?php echo $obj->correo;?>" name="correo" type="email" class="form-control" placeholder="Correo">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="telefono">Teléfono</label>
              <input value="<?php echo $obj->telefono;?>" name="telefono" maxlength="15" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" type="text" class="form-control" placeholder="Teléfono móvil">
            </div>

            <div class="form-group col-md-6">
              <label for="direccion">Dirección</label>
              <input value="<?php echo $obj->direccion;?>" name="direccion" type="text" class="form-control" placeholder="Dirección">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="sexo">Sexo</label>
              <select name="sexo" class="form-control">
                <option value="M" <?php if ($obj->sexo == "M") echo "selected"; ?>>Masculino</option>
                <option value="F" <?php if ($obj->sexo == "F") echo "selected"; ?>>Femenino</option>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="id_parentezco">Parentezco</label>
              <select name="id_parentezco" class="form-control">
                <?php foreach ($parentezcos as $parentezco) { ?>
                  <option value="<?php echo $parentezco->id_parentezco; ?>" <?php if ($obj->id_parentezco == $parentezco->id_parentezco) echo "selected"; ?>>
                    <?php echo $parentezco->parentezco; ?>
                  </option>
                <?php } ?>
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
      <div class="modal-dialog " role="document">
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
              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Cédula</label>
                    <div class="input-group">
                      <input type="text" name="cedula_representante_legal" maxlength="11" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Cédula" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_lastname">Nombre</label>
                    <div class="input-group">
                      <input type="text" name="nombre" placeholder="Nombre" required class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Profesión</label>
                    <div class="input-group">
                      <input type="text" name="profesion" required class="form-control" placeholder="Profesión" />
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Correo</label>
                    <div class="input-group">
                      <input type="email" name="correo" required class="form-control" placeholder="Correo" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Teléfono</label>
                    <div class="input-group">
                      <input type="text" name="telefono" maxlength="15" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="Teléfono" required class="form-control"/>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Dirección</label>
                    <div class="input-group">
                      <input type="text" name="direccion" placeholder="Dirección" required class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Sexo</label>
                    <div class="input-group">
                      <select name="sexo" class="form-control" required>
                        
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Parentezco</label>
                    <div class="input-group">
                      <select name="id_parentezco" class="form-control" required>
                        <?php foreach ($parentezcos as $parentezco) { ?>
                          <option value="<?php echo $parentezco->id_parentezco; ?>">
                            <?php echo $parentezco->parentezco; ?>
                          </option>
                        <?php } ?>
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
<script type="text/javascript">

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php  

if(isset($_POST['agregar'])) {
  $cedula_representante_legal = $_POST['cedula_representante_legal'];
  $nombre = $_POST['nombre'];
  $profesion = $_POST['profesion'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $direccion = $_POST['direccion'];
  $sexo = $_POST['sexo'];
  $id_parentezco = $_POST['id_parentezco'];

  if(empty($cedula_representante_legal)){
    $errMSG = "Please enter your cedula.";
  } else if(empty($nombre)){
    $errMSG = "Please enter your name.";
  } else if(empty($profesion)){
    $errMSG = "Please enter your profession.";
  } else if(empty($correo)){
    $errMSG = "Please enter your email.";
  } else if(empty($telefono)){
    $errMSG = "Please enter your phone.";
  } else if(empty($direccion)){
    $errMSG = "Please enter your address.";
  } else if(empty($sexo)){
    $errMSG = "Please enter your sexo.";
  } else if(empty($id_parentezco)){
    $errMSG = "Please enter your parentezco.";
  } else {
    $stmt = $connect->prepare("INSERT INTO representante_legal (cedula_representante_legal, nombre, profesion, correo, telefono, direccion, sexo, id_parentezco) VALUES (:cedula_representante_legal, :nombre, :profesion, :correo, :telefono, :direccion, :sexo, :id_parentezco)");
    $stmt->bindParam(':cedula_representante_legal', $cedula_representante_legal);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':profesion', $profesion);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':id_parentezco', $id_parentezco);

    if($stmt->execute()) {
      echo '<script type="text/javascript">
      swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
        window.location = "mostrar.php";
      });
      </script>';
    } else {
      $errMSG = "Error while inserting....";
    }
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

<?php  
if(isset($_POST['eliminar'])){
  //////////// Actualizar la tabla /////////
  $consulta = "DELETE FROM `representante_legal` WHERE `cedula_representante_legal`=:cedula_representante_legal";
  $sql = $connect-> prepare($consulta);
  $sql -> bindParam(':cedula_representante_legal', $cedula_representante_legal, PDO::PARAM_INT);
  $cedula_representante_legal=trim($_POST['cedula_representante_legal']);
  $sql->execute();

  if($sql->rowCount() > 0) {
    $count = $sql -> rowCount();
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
?>  

<?php
if(isset($_POST['actualizar'])){
  ///////////// Informacion enviada por el formulario /////////////
  $cedula_representante_legal=trim($_POST['cedula_representante_legal']);
  $nombre=trim($_POST['nombre']);
  $profesion=trim($_POST['profesion']);
  $correo=trim($_POST['correo']);
  $telefono=trim($_POST['telefono']);
  $direccion=trim($_POST['direccion']);
  $sexo=trim($_POST['sexo']);
  $id_parentezco=trim($_POST['id_parentezco']);

  ////////// Fin informacion enviada por el formulario /// 

  ////////////// Actualizar la tabla /////////
  $consulta = "UPDATE representante_legal SET `nombre` = :nombre, `profesion` = :profesion, `correo` = :correo, `telefono` = :telefono, `direccion` = :direccion, `sexo` = :sexo, `id_parentezco` = :id_parentezco WHERE `cedula_representante_legal` = :cedula_representante_legal";
  $sql = $connect->prepare($consulta);
  $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR, 45);
  $sql->bindParam(':profesion',$profesion,PDO::PARAM_STR, 50);
  $sql->bindParam(':correo',$correo,PDO::PARAM_STR);
  $sql->bindParam(':telefono',$telefono,PDO::PARAM_STR,15);
  $sql->bindParam(':direccion',$direccion,PDO::PARAM_STR);
  $sql->bindParam(':sexo',$sexo,PDO::PARAM_STR,2);
  $sql->bindParam(':id_parentezco',$id_parentezco,PDO::PARAM_INT);
  $sql->bindParam(':cedula_representante_legal',$cedula_representante_legal,PDO::PARAM_INT);

  $sql->execute();

  if($sql->rowCount() > 0) {
    $count = $sql -> rowCount();
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
</body>
</html>
