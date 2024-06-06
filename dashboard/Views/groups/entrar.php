
<?php include("../header.php") ?>

           <!--------main-content------------->


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

        </div>

      </div>
    </div>

   
<div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="../admin/pages-admin.php">Home</a></li>
              <li class="breadcrumb-item"><a href="../groups/mostrar">Sección</a></li>
              <li class="breadcrumb-item active" aria-current="page">Secciones alumnos</li>
            </ol>
          </nav>
          <!-- /Breadcrumb ------------>
    <?php 
require '../../Config/config.php';
$id = $_GET['id'];
$sql= "SELECT seccion.idsec, seccion.nomsec, subgrade.idsub, subgrade.nomsub, teachers.idtea, teachers.dnite, teachers.nomte, teachers.correo, teachers.telet, teachers.usuario,teachers.foto,teachers.sexte, course.idcur, course.nomcur, seccion.capa, seccion.state, GROUP_CONCAT(degree.iddeg, '..', degree.nomgra, '..' SEPARATOR '__') AS degree FROM seccion INNER JOIN subgrade ON seccion.idsub =subgrade.idsub INNER JOIN teachers ON seccion.idtea = teachers.idtea INNER JOIN course ON seccion.idcur = course.idcur INNER JOIN degree ON subgrade.iddeg =degree.iddeg  WHERE idsec= '$id'  GROUP BY seccion.idsec"; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idsec', $idsec, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
     ?>
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="../../Assets/img/subidas/<?php echo $obj->foto;?>" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?php echo $obj->nomte;?></h4>
                      <p class="text-secondary mb-1"><strong>Docente</strong></p>
                      <p class="text-secondary mb-1">Curso:&nbsp;<span class="badge bg-danger text-white"><?php echo $obj->nomcur;?></span></p>
                      <p class="text-muted font-size-sm"><?php echo $obj->correo;?></p>
                      <?php foreach(explode("__", $obj->degree) as $periodoConcatenados){ 
                                $degree = explode("..", $periodoConcatenados)
                                ?>
                               <p class="text-muted font-size-sm">Grado:&nbsp;<span class="badge bg-dark text-white"><?php echo $degree[1] ?></span></p>
                               
                <?php } ?>
                    <p class="text-muted font-size-sm">Sugrado:&nbsp;<span class="badge bg-success text-white"><?php echo $obj->nomsub;?></span></p>



                     <br>
                      <button class="btn btn-outline-primary">Message</button>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">DNI</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     <?php echo $obj->dnite;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Nombre</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     <?php echo $obj->nomte;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Correo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     <?php echo $obj->correo;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Teléfono</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $obj->telet;?>
                    </div>
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Usuario</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $obj->usuario;?>
                    </div>
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Género</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $obj->sexte;?>
                    </div>
                  </div>
                 
                  
                </div>
              </div>
            </div>
          </div>
          <?php ?>
<!-- /Breadcrumb ------------------------------------------>
        </div>
    </div>

<section style="background-color: #eee;">
  <div class="container py-5">
    <!-- COMIENZA------------------------- -->
    <?php
    $id = $_GET['id'];  
     $productosPorPagina = 5;
        $pagina = 1;
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                }
        $limit = $productosPorPagina;
        $offset = ($pagina - 1) * $productosPorPagina;


$stmt = $connect->query("SELECT alum_secc.idaluse, seccion.idsec, seccion.nomsec, seccion.capa, estudiantes.idstu, estudiantes.dnist, estudiantes.nomstu, estudiantes.edast, estudiantes.direce, estudiantes.correo, estudiantes.sexes, estudiantes.fenac, estudiantes.foto, count(*) AS conteo FROM alum_secc INNER JOIN  seccion ON alum_secc.idsec = seccion.idsec INNER JOIN estudiantes ON alum_secc.idstu =estudiantes.idstu WHERE alum_secc.idsec= '$id'");

$conteo = $stmt->fetchObject()->conteo;
$paginas = ceil($conteo / $productosPorPagina);


$stmt = $connect->prepare("SELECT alum_secc.idaluse, seccion.idsec, seccion.nomsec, seccion.capa, estudiantes.idstu, estudiantes.dnist, estudiantes.nomstu, estudiantes.edast, estudiantes.direce, estudiantes.correo, estudiantes.sexes, estudiantes.fenac, estudiantes.foto FROM alum_secc INNER JOIN  seccion ON alum_secc.idsec = seccion.idsec INNER JOIN estudiantes ON alum_secc.idstu =estudiantes.idstu WHERE alum_secc.idsec= '$id' LIMIT ? OFFSET ?");


$stmt->bindParam(':idsec', $idsec, PDO::PARAM_INT); 

$stmt->execute([$limit, $offset]);

$data =  array();
if($stmt){
  while($r = $stmt->fetchObject()){
    $data[] = $r;
  }
}
    ?>

    <?php if(count($data)>0):?>
    <?php foreach($data as $d):?> 
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-xl-10">
        <div class="card shadow-0 border rounded-3">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                <div class="bg-image hover-zoom ripple rounded ripple-surface">
                  <img src="../../Assets/img/subidas/<?php echo $d->foto;?>"
                    class="w-100" />
                  <a href="#!">
                    <div class="hover-overlay">
                      <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-6">
                <h5><?php echo $d->nomstu;?></h5>
                <div class="d-flex flex-row">
                  <div class="text-danger mb-1 me-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
               
                </div>
                <div class="mt-1 mb-0 text-muted small">
                  <span>Estudiante</span>
                 
                </div>
                
                <p class="text-truncate mb-4 mb-md-0">
                  <?php echo $d->nomsec;?>
                </p>
              </div>
              <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                <div class="d-flex flex-column mt-4">
                  <button class="btn btn-primary btn-sm" type="button">Detalles</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
    <?php else:?>
      
      <div class="alert alert-warning" style="position: relative;
    margin-left: 705px;
    margin-top: 14px;
    margin-bottom: 0px;">
            <strong>No hay alumnos para esta sección!</strong>
        </div>
    <?php endif; ?> 
        

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
                <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
                <?php if ($pagina > 1) { ?>
                    <li>
                        <a href="./entrar?id=<?php echo  $d->idsec; ?>?pagina=<?php echo $pagina - 1 ?>">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>

                <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
                <?php for ($x = 1; $x <= $paginas; $x++) { ?>
                    <li class="<?php if ($x == $pagina) echo "active" ?>">
                        <a href="./entrar?id=<?php echo  $d->idsec; ?>?pagina=<?php echo $x ?>">
                            <?php echo $x ?></a>
                    </li>
                <?php } ?>
                <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
                <?php if ($pagina < $paginas) { ?>
                    <li>
                        <a href="./entrar?id=<?php echo  $d->idsec; ?>?pagina=<?php echo $pagina + 1 ?>">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
<!-- TERMINA------------------------- -->

  </div>
</section>



  </div>

</div>

<!-- add Modal HTML -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form  enctype="multipart/form-data" method="POST"  autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-user mr-1"></i>REGISTRO DEL ALUMNOS
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                <div class="col-sm-6" style="display:none;">
                   <div class="form-group">
                      <label class="control-label">Nombre de la seccion</label>
                        <input type="text" value="<?php echo $obj->idsec;?>" name="idsec" required="" class="form-control">
                    </div>
                </div>  

<div class="col-sm-12" >
    <?php
   
    $sql= "SELECT * FROM estudiantes"; 
$stmt = $connect->prepare($sql);
$stmt->execute();

$data =  array();
if($stmt){
  while($r = $stmt->fetchObject()){
    $data[] = $r;
  }
}
    ?> 
<?php if(count($data)>0):?>
    <?php foreach($data as $d):?>
    <label class="image-checkbox">
      <img class="img-responsive" src="../..\Assets\img\subidas/<?php echo $d->foto; ?>" width="50" height="50"/>
      <label style="color:black; text-align: center;  display: block;"><?php echo $d->nomstu; ?></label>
      <input type="checkbox" value="<?php echo $d->idstu; ?>" name="alumno[]" value="" />
      
    </label>

<?php endforeach; ?>
    <?php else:?>
      
      <div class="alert alert-warning" style="position: relative;
    margin-left: 705px;
    margin-top: 14px;
    margin-bottom: 0px;">
            <strong>No hay datos!</strong>
        </div>
    <?php endif; ?>

</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button  name='agregar' class="btn btn-primary">GUARDAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Edit Modal HTML -->
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

if(isset($_POST['agregar']))
{
    
    $idsec = $_POST['idsec'];
    $alumno = $_POST['alumno'];
    
    foreach($alumno as $item)
    {
        // echo $item . "<br>";
        
        $statement = $connect->prepare("INSERT INTO alum_secc (idsec,idstu) VALUES ('$idsec','$item')");
        //Execute the statement and insert our values.
$inserted = $statement->execute();
    }

    if($inserted){
    echo '<script type="text/javascript">
swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
            window.location = "mostrar";
        });
        </script>';
}
}

?>
  

  </body>
  
  </html>


