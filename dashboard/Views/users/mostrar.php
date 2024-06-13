<?php include("../header.php") ?>

<!--------main-content------------->

<div class="main-content">
  <div class="row">
    <div class="col-md-12">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
              <h2 class="ml-lg-2">Usuarios</h2>
            </div>
            <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">
              <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons">&#xE147;</i>
              </a>
            </div>
          </div>
        </div>
        <table class="table table-striped table-hover" id="myTable">
          <thead>
            <tr>
              <th colspan="2">Nombre</th>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Permisos</th>
              <th>Estado</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <?php 
            require '../../Config/config.php';

            $sql = "SELECT a.id_usuario, a.usuario, a.status, c.rol, a.cedula_profesor, b.nombre, b.correo
                    FROM usuarios a
                    JOIN profesores b
                    ON b.cedula_profesor = a.cedula_profesor
                    JOIN roles c
                    ON c.id_rol = a.id_rol"; 
            $stmt = $connect->prepare($sql); 
            $stmt->execute(); 
            $results = $stmt->fetchAll(PDO::FETCH_OBJ); 

            if ($stmt->rowCount() > 0) { 
              foreach ($results as $result) { 
                echo "
                  <tbody>
                    <tr>
                      <td colspan='2'>".$result->nombre."</td>
                      <td>".$result->usuario."</td>
                      <td>".$result->correo."</td>
                      <td>".$result->rol."</td>
                      <td>".$result->status."</td>
                      <td>
                        <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                          <input type='hidden' name='id' value='".$result->id_usuario."'>
                          <button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
                        </form>
                      </td>
                      <td>
                        <form onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                          <input type='hidden' name='id' value='".$result->id_usuario."'>
                          <button name='eliminar' class='btn btn-danger text-white'><i class='material-icons' title='Delete'>&#xE872;</i></button>
                        </form>
                      </td>
                    </tr>
                  </tbody>";
              }
            }
          ?>
        </table>
      </div>
    </div>

    <?php 
      if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM usuarios JOIN profesores ON profesores.cedula_profesor = usuarios.cedula_profesor WHERE id_usuario = :id"; 
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();
        $obj = $stmt->fetchObject();
        $cedula = $obj->cedula_profesor;
    ?>
    <div class="col-12 col-md-12"> 
      <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input value="<?php echo $obj->id_usuario;?>" name="id" type="hidden">
        <input value="<?php echo $obj->cedula_profesor;?>" name="cedula" type="hidden">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="nombres">Nombre</label>
            <input value="<?php echo $obj->nombre;?>" name="nombre" type="text" class="form-control" placeholder="Nombres">
          </div>
          <div class="form-group col-md-6">
            <label for="edad">Usuario</label>
            <input value="<?php echo $obj->usuario;?>" name="usuario" type="text" class="form-control" placeholder="Usuario">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="nombres">Correo</label>
            <input value="<?php echo $obj->correo;?>" name="correo" type="text" class="form-control" placeholder="Correo">
          </div>
        </div>
        <div class="form-group">
          <button name="actualizar" type="submit" class="btn btn-primary btn-block">Actualizar Registro</button>
        </div>
      </form>
    </div>  
    <?php } ?>

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
                    <label for="modal_contact_firstname">Cedula</label>
                    <div class="input-group">
                      <input type="text" name="txtidu" required class="form-control" placeholder="Cedula" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_lastname">Usuario</label>
                    <div class="input-group">
                      <input type="text" name="txtusua" placeholder="Usuario" required class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_firstname">Contraseña</label>
                    <div class="input-group">
                      <input type="password" name="txtcont" required class="form-control" placeholder="Contraseña" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_lastname">Permisos</label>
                    <div class="input-group">
                      <select class="form-control" required name="txtperm">
                          <option selected>SELECCIONE</option>
                          <?php
                          $sql = "SELECT * FROM roles";
                          $stmt = $connect->prepare($sql);
                          $stmt->execute();
                      
                          // Obtener los resultados
                          $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                          if (!empty($roles)) {
                              foreach ($roles as $role) {
                                  echo '<option value="' . htmlspecialchars($role['id_rol'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($role['rol'], ENT_QUOTES, 'UTF-8') . '</option>';
                              }
                          }
                          ?> 
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="modal_contact_lastname">Estado</label>
                    <div class="input-group">
                      <select class="form-control" required name="txtesta">
                        <option selected>SELECCIONE</option>
                        <option value="1">Activo</option>
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".xp-menubar").on('click', function(){
      $('#sidebar').toggleClass('active');
      $('#content').toggleClass('active');
    });
    $(".xp-menubar,.body-overlay").on('click', function(){
      $('#sidebar,.body-overlay').toggleClass('show-nav');
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php  
if(isset($_POST['agregar'])){
  $usuario = $_POST['txtusua'];
  $cedulaU = $_POST['txtidu'];
  $clave = MD5($_POST['txtcont']);
  $rol = $_POST['txtperm'];
  $estado = $_POST['txtesta'];
  
  $sql = "INSERT INTO usuarios (usuario, cedula_profesor, password, id_rol, status) VALUES (:usuario, :cedula, :clave, :rol, :estado)";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':usuario', $usuario);
  $statement->bindValue(':cedula', $cedulaU);
  $statement->bindValue(':clave', $clave);
  $statement->bindValue(':rol', $rol);
  $statement->bindValue(':estado', $estado);

  $inserted = $statement->execute();

  if ($inserted) {
    echo '<script type="text/javascript">
            swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
              window.location = "mostrar.php";
            });
          </script>';
  }
}

if(isset($_POST['eliminar'])){
  $id = $_POST['id'];
  
  $consulta = "DELETE FROM usuarios WHERE id_usuario = :id";
  $sql = $connect->prepare($consulta);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);
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

if(isset($_POST['actualizar'])){
  $id = trim($_POST['id']);
  $usuario = trim($_POST['usuario']);
  $nombre = trim($_POST['nombre']);
  $correo = trim($_POST['correo']);
  $cedula = trim($_POST['cedula']); // Recuperar cédula para actualizar en la tabla de profesores

  $usuarioUpdate = "UPDATE usuarios SET usuario = :usuario WHERE id_usuario = :id";
  $profesoresUpdate = "UPDATE profesores SET nombre = :nombre, correo = :correo WHERE cedula_profesor = :cedula";

  $usuarioStmt = $connect->prepare($usuarioUpdate);
  $profesoresStmt = $connect->prepare($profesoresUpdate);

  $usuarioStmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 25);
  $usuarioStmt->bindParam(':id', $id, PDO::PARAM_INT);

  $profesoresStmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 25);
  $profesoresStmt->bindParam(':correo', $correo, PDO::PARAM_STR, 25);
  $profesoresStmt->bindParam(':cedula', $cedula, PDO::PARAM_STR, 25);

  $usuarioStmt->execute();
  $profesoresStmt->execute();

  if ($usuarioStmt->rowCount() > 0 || $profesoresStmt->rowCount() > 0) {
    echo '<script type="text/javascript">
            swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
              window.location = "mostrar.php";
            });
          </script>';
  } else {
    echo "<div class='content alert alert-danger'> No se pudo actualizar el registro </div>";
    print_r($usuarioStmt->errorInfo()); 
    print_r($profesoresStmt->errorInfo());
  }
}
?>
</body>
</html>

