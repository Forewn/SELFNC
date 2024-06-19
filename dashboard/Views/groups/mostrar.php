<?php include("../header.php") ?>

<div class="main-content">
  <div class="row">
    <div class="col-md-12">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
              <h2 class="ml-lg-2">Sección</h2>
            </div>
            <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">
              <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons">&#xE147;</i> </a>
              <a href="#" class="btn btn-danger">
                <i class="material-icons">print</i> </a>
            </div>
          </div>
        </div>

        <?php 
          require '../../Config/config.php';

          $productosPorPagina = 5;
          $pagina = 1;
          if (isset($_GET["pagina"])) {
            $pagina = $_GET["pagina"];
          }
          $limit = $productosPorPagina;
          $offset = ($pagina - 1) * $productosPorPagina;

          $sentencia = $connect->query("SELECT count(*) AS conteo FROM seccion_profesor_periodo a INNER JOIN seccion b ON a.id_seccion = b.id_seccion INNER JOIN profesores c ON a.cedula_tutor = c.cedula_profesor;");
          $conteo = $sentencia->fetchObject()->conteo;
          $paginas = ceil($conteo / $productosPorPagina);
          $sentencia = $connect->prepare("SELECT a.*, b.letra, c.nombre AS nomte, d.anio AS anio FROM seccion_profesor_periodo a INNER JOIN seccion b ON a.id_seccion = b.id_seccion INNER JOIN profesores c ON a.cedula_tutor = c.cedula_profesor JOIN anios d ON a.id_año = d.id_anio GROUP BY a.id_seccion_profesor_periodo  LIMIT ? OFFSET ?");
          $sentencia->execute([$limit, $offset]);
          $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
        ?>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Tutor</th>
              <th>Año</th>
              <th>Sección</th>
              <th>Capacidad</th>
              <th>Estado</th>
              <th>Entrar</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($productos as $persona){ ?>
            <tr>
              <td><?php echo $persona->nomte ?></td>
              <td><span class="badge badge-danger"><?php echo $persona->anio ?></span></td>
              <td><?php echo $persona->letra ?></td>
              <td><?php echo "5"?></td>
              <td>Activo</td>
              <td><a href="entrar?id=<?php echo  $persona->idsec; ?>" class="btn btn-primary text-white"><i class='material-icons' data-toggle='tooltip' title='Entrar'>login</i></a></td>
              <td>
                <button class='btn btn-warning text-white edit-btn' data-id="<?php echo  $persona->idsec; ?>"><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
              </td>
              <td>
                <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                  <input type='hidden' name='idsec' value="<?php echo  $persona->idsec; ?>">
                  <button name='eliminar' class='btn btn-danger text-white'><i class='material-icons' title='Delete'>&#xE872;</i></button>
                </form>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <nav aria-label="Page navigation example">
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> secciones disponibles</p>
            </div>
            <div class="col-xs-12 col-sm-6">
              <p>Página <?php echo $pagina ?> de <?php echo $paginas ?> </p>
            </div>
          </div>
          <ul class="pagination">
            <?php if ($pagina > 1) { ?>
            <li>
              <a href="./mostrar.php?pagina=<?php echo $pagina - 1 ?>">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php } ?>

            <?php for ($x = 1; $x <= $paginas; $x++) { ?>
            <li class="<?php if ($x == $pagina) echo "active" ?>">
              <a href="./mostrar.php?pagina=<?php echo $x ?>">
                <?php echo $x ?></a>
            </li>
            <?php } ?>
            <?php if ($pagina < $paginas) { ?>
            <li>
              <a href="./mostrar.php?pagina=<?php echo $pagina + 1 ?>">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</div>

<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="modal-header">
          <h5 class="modal-title">Editar Sección</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit-idsec" name="idsec">
          <div class="form-group">
            <label>Sección</label>
            <input type="text" id="edit-nomsec" name="nomsec" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Docente</label>
            <select id="edit-idtea" name="idtea" class="form-control" required>
              <!-- Options will be loaded dynamically with JS -->
            </select>
          </div>
          <div class="form-group">
            <label>Capacidad</label>
            <input type="text" id="edit-capa" name="capa" class="form-control" maxlength="2" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    // Toggle sidebar
    $(".xp-menubar").on('click', function(){
      $('#sidebar').toggleClass('active');
      $('#content').toggleClass('active');
    });

    $(".xp-menubar, .body-overlay").on('click', function(){
      $('#sidebar, .body-overlay').toggleClass('show-nav');
    });

    // Edit button click
    $('.edit-btn').on('click', function(){
      var idsec = $(this).data('id');
      $.ajax({
        url: 'get_section_data.php',
        type: 'POST',
        data: { idsec: idsec },
        dataType: 'json',
        success: function(data){
          $('#edit-idsec').val(data.idsec);
          $('#edit-nomsec').val(data.nomsec);
          $('#edit-idtea').val(data.idtea);
          $('#edit-capa').val(data.capa);
          $('#editEmployeeModal').modal('show');
        }
      });
    });

    // Handle form submission for updating data
    $('#edit-form').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url: 'update_section.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response){
          swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
            window.location = "mostrar.php";
          });
        },
        error: function(response){
          swal("¡Error!", "No se pudo actualizar el registro", "error");
        }
      });
    });

    // Handle form submission for deleting data
    $('form').on('submit', function(e){
      if($(this).find('button[name="eliminar"]').length){
        e.preventDefault();
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data: form.serialize(),
          success: function(response){
            swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
              window.location = "mostrar.php";
            });
          },
          error: function(response){
            swal("¡Error!", "No se pudo eliminar el registro", "error");
          }
        });
      }
    });
  });
</script>

<?php 
  if(isset($_POST['eliminar'])){
    $consulta = "DELETE FROM `seccion` WHERE `idsec`=:idsec";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
    $idsec=trim($_POST['idsec']);
    $sql->execute();

    if($sql->rowCount() > 0){
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
    $idsec = trim($_POST['idsec']); 
    $nomsec = trim($_POST['nomsec']);    
    $idtea = trim($_POST['idtea']);
    $capa = trim($_POST['capa']);

    $consulta = "UPDATE seccion SET `nomsec`= :nomsec, `idtea` = :idtea, `capa` = :capa WHERE `idsec` = :idsec";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':nomsec', $nomsec, PDO::PARAM_STR, 25);
    $sql->bindParam(':idtea', $idtea, PDO::PARAM_STR, 25);
    $sql->bindParam(':capa', $capa, PDO::PARAM_STR, 25);
    $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
    $sql->execute();

    if($sql->rowCount() > 0){
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

  if(isset($_POST['agregar'])){
    $nomsec = $_POST['nomsec'];
    $idsub = $_POST['idsub'];
    $idtea = $_POST['idtea'];
    $curso = $_POST['curso'];
    $capa = $_POST['capa'];
    foreach($curso as $item){
      $statement = $connect->prepare("INSERT INTO seccion (nomsec, idsub, idtea, idcur, capa, state) VALUES ('$nomsec','$idsub','$idtea', '$item','$capa','1')");
      $inserted = $statement->execute();
    }

    if($inserted){
      echo '<script type="text/javascript">
        swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
          window.location = "mostrar.php";
        });
      </script>';
    }
  }
?>