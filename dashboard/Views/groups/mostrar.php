
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

        $sentencia = $connect->query("SELECT seccion.idsec, seccion.nomsec, subgrade.idsub, subgrade.nomsub, teachers.idtea, teachers.dnite, teachers.nomte, teachers.correo, teachers.telet, teachers.usuario, course.idcur, course.nomcur, seccion.capa, seccion.state, GROUP_CONCAT(degree.iddeg, '..', degree.nomgra, '..' SEPARATOR '__') AS degree, count(*) AS conteo FROM seccion INNER JOIN subgrade ON seccion.idsub =subgrade.idsub INNER JOIN teachers ON seccion.idtea = teachers.idtea INNER JOIN course ON seccion.idcur = course.idcur INNER JOIN degree ON subgrade.iddeg =degree.iddeg ;");
    $conteo = $sentencia->fetchObject()->conteo;
    $paginas = ceil($conteo / $productosPorPagina);
    $sentencia = $connect->prepare("SELECT seccion.idsec, seccion.nomsec, subgrade.idsub, subgrade.nomsub, teachers.idtea, teachers.dnite, teachers.nomte, teachers.correo, teachers.telet, teachers.usuario, course.idcur, course.nomcur, seccion.capa, seccion.state, GROUP_CONCAT(degree.iddeg, '..', degree.nomgra, '..' SEPARATOR '__') AS degree FROM seccion INNER JOIN subgrade ON seccion.idsub =subgrade.idsub INNER JOIN teachers ON seccion.idtea = teachers.idtea INNER JOIN course ON seccion.idcur = course.idcur INNER JOIN degree ON subgrade.iddeg =degree.iddeg GROUP BY seccion.idsec LIMIT ? OFFSET ?");
    $sentencia->execute([$limit, $offset]);
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
       ?>

    <table class="table table-striped table-hover">
      <thead>
        <tr>
        
          <th>Docente</th>
          <th>Sección</th>
          <th>Grado</th>
          <th>Subgrado</th>
          <th>Curso</th>
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

               <td><span class="badge bg-info text-white"><?php echo $persona->nomsec ?></span></td>
                    <?php foreach(explode("__", $persona->degree) as $periodoConcatenados){ 
                                $degree = explode("..", $periodoConcatenados)
                                ?>
                               <td><span class="badge bg-dark text-white"><?php echo $degree[1] ?></span></td>
                               
                <?php } ?>
                
                <td><?php echo $persona->nomsub ?></td>
               <td><span class="badge badge-danger"><?php echo $persona->nomcur ?></span></td>
               <td><?php echo $persona->capa ?></td>
               <td>
                       

         <?php if($persona->state==1)  { ?> 
        <span class="badge badge-success">Activo</span>
    <?php  }   else {?> 
        <span class="badge badge-danger">No activo</span>
        <?php  } ?>  
                            
                    </td>
        <td><a href="entrar?id=<?php echo  $persona->idsec; ?>"  class="btn btn-primary text-white"><i class='material-icons' data-toggle='tooltip' title='Entrar'>login</i></a></td>
               
               <td>

<form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idsec' value="<?php echo  $persona->idsec; ?>">
<button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
</form>
                   
               </td>
               <td>
<form  onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idsec' value="<?php echo  $persona->idsec; ?>">
<button name='eliminar' class='btn btn-danger text-white' ><i class='material-icons'  title='Delete'>&#xE872;</i></button>
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
                <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
                <?php if ($pagina > 1) { ?>
                    <li>
                        <a href="./mostrar.php?pagina=<?php echo $pagina - 1 ?>">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>

                <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
                <?php for ($x = 1; $x <= $paginas; $x++) { ?>
                    <li class="<?php if ($x == $pagina) echo "active" ?>">
                        <a href="./mostrar.php?pagina=<?php echo $x ?>">
                            <?php echo $x ?></a>
                    </li>
                <?php } ?>
                <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
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

<?php 

if (isset($_POST['editar'])){
$idsec = $_POST['idsec'];
$sql= "SELECT seccion.idsec, seccion.nomsec, subgrade.idsub, subgrade.nomsub, teachers.idtea, teachers.dnite, teachers.nomte, teachers.correo, teachers.telet, teachers.usuario, course.idcur, course.nomcur, seccion.capa, seccion.state FROM seccion INNER JOIN subgrade ON seccion.idsub =subgrade.idsub INNER JOIN teachers ON seccion.idtea = teachers.idtea INNER JOIN course ON seccion.idcur = course.idcur WHERE idsec = :idsec"; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idsec', $idsec, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
 
?>

    <div class="col-12 col-md-12"> 

<form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input value="<?php echo $obj->idsec;?>" name="idsec" type="hidden">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombres">Sección</label>

      <select required name="nomsec" class="form-control">
    <option value="<?php echo $obj->nomsec;?>"><?php echo $obj->nomsec;?></option>        
    <option value=""><< >></option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    </select>
      
    </div>
    <div class="form-group col-md-6">
      <label for="edad">Docente </label>
      <select required name="idtea" class="form-control">
    <option value="<?php echo $obj->idtea;?>"><?php echo $obj->nomte;?></option>        
    <option value=""><< >></option>

    <?php 
    $stmt = $connect->prepare('SELECT * FROM teachers');
    $stmt->execute();

while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <option value="<?php echo $idtea; ?>"><?php echo $nomte; ?></option>
            <?php
        }
        ?>
     ?>
 
    
    </select>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombres">Capacidad</label>

      <input maxlength="2"onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $obj->capa;?>" name="capa" type="text" class="form-control">
      
    </div>
    
  </div>

        <div class="form-group">
          <button name="actualizar" type="submit" class="btn btn-primary  btn-block">Actualizar Registro</button>
        </div>
</form>
    </div>  
<?php }?>

<!-- add Modal HTML -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form  enctype="multipart/form-data" method="POST"  autocomplete="off">
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
                                    <label for="modal_contact_firstname">Periodo escolar</label>
                                    <div class="input-group">

                                       <select required id="periodo" class="form-control">
                                            <option value="">Selecciona el periodo</option>
                                      </select>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Grado</label>
                                    <div class="input-group">
                                      <select required id="grado" class="form-control">
                                            <option value="">Seleccione el grado</option>
                                      </select>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Subgrado </label>
                                    <div class="input-group">

                                       <select required name="idsub" id="sub" class="form-control">
                                            <option value="">Selecciona el subgrado</option>
                                      </select>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Letra</label>
                                    <div class="input-group">
                                      <select required id="grado" name="nomsec" class="form-control">
                                            <option value="">Seleccione la sección</option>
             <option value="U">U</option>
                                      </select>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Docentes</label>
                                    <div class="input-group">
                                      <select required name="idtea" class="form-control">
                                        <option value="" disabled="" selected="">Selecciona el docente</option>
                                       <?php 
                                       $stmt = $connect->prepare('SELECT * FROM teachers');
                                        $stmt->execute();

                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            extract($row);
                                            ?>

                                            <option value="<?php echo $idtea; ?>"><?php echo $nomte; ?></option>
                                            <?php
                                        }
                                        ?>
                                        ?>     

                                      </select>
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Capacidad</label>
                                    <div class="input-group">
                                       
                                        <input type="text" maxlength="2" name="capa" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Capacidad" />
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group pad-ver">
    <div class="form-group">
                <label>Cursos:</label>
    </div>
    <div class="card bg-light" style="width: 100%;">
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-6" id="curso">
                    <div  class="custom-control custom-checkbox mr-sm-2">
                        <label><input type="checkbox" name="idcur[]"></label>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div> 

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
    
    $nomsec = $_POST['nomsec'];
    $idsub = $_POST['idsub'];
    $idtea = $_POST['idtea'];
    $curso =  $_POST['curso'];
    $capa = $_POST['capa'];
    foreach($curso as $item)
    {
        // echo $item . "<br>";
        
        $statement = $connect->prepare("INSERT INTO seccion (nomsec,idsub,idtea,idcur,capa,state) VALUES ('$nomsec','$idsub','$idtea',
            '$item','$capa','1')");
        //Execute the statement and insert our values.
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

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);

});
</script>


<?php  
if(isset($_POST['eliminar'])){
////////////// Actualizar la tabla /////////
$consulta = "DELETE FROM `seccion` WHERE `idsec`=:idsec";
$sql = $connect-> prepare($consulta);
$sql -> bindParam(':idsec', $idsec, PDO::PARAM_INT);
$idsec=trim($_POST['idsec']);
$sql->execute();

if($sql->rowCount() > 0)
{
$count = $sql -> rowCount();
echo '<script type="text/javascript">
swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
}
else{
    echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";

print_r($sql->errorInfo()); 
}
}// Cierra envio de guardado
?>
  


  <?php
    
if(isset($_POST['actualizar'])){
///////////// Informacion enviada por el formulario /////////////
$idsec=trim($_POST['idsec']); 
$nomsec=trim($_POST['nomsec']);    
$idtea=trim($_POST['idtea']);
$capa=trim($_POST['capa']);


///////// Fin informacion enviada por el formulario /// 

////////////// Actualizar la tabla /////////
$consulta = "UPDATE seccion
SET `nomsec`= :nomsec, `idtea` = :idtea, `capa` = :capa WHERE `idsec` = :idsec";
$sql = $connect->prepare($consulta);
$sql->bindParam(':nomsec',$nomsec,PDO::PARAM_STR, 25);
$sql->bindParam(':idtea',$idtea,PDO::PARAM_STR, 25);
$sql->bindParam(':capa',$capa,PDO::PARAM_STR, 25);
$sql->bindParam(':idsec',$idsec,PDO::PARAM_INT);

$sql->execute();

if($sql->rowCount() > 0)
{
$count = $sql -> rowCount();
echo '<script type="text/javascript">
swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
}
else{
    echo "<div class='content alert alert-danger'> No se pudo actulizar el registro  </div>";

print_r($sql->errorInfo()); 
}
}// Cierra envio de guardado
?>
<script src="../../Assets/js/periodo.js"></script>
  </body>
  
  </html>


