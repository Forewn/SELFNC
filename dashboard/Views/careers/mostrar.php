<?php include("../header.php") ?>

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
          <i class="material-icons">&#xE147;</i> </a>

          <a href="plantilla.php" class="btn btn-danger">
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

        $sentencia = $connect->query("SELECT course.idcur, course.nomcur, period.idper, period.numperi, period.starperi, period.endperi, period.nomperi, degree.iddeg, degree.nomgra, subgrade.idsub, subgrade.nomsub, course.foto, course.estado, count(*) AS conteo FROM course INNER JOIN period ON course.idper = period.idper INNER JOIN degree ON course.iddeg = degree.iddeg INNER JOIN subgrade ON course.idsub =  subgrade.idsub;");
    $conteo = $sentencia->fetchObject()->conteo;
    $paginas = ceil($conteo / $productosPorPagina);
    $sentencia = $connect->prepare("SELECT course.idcur, course.nomcur, period.idper, period.numperi, period.starperi, period.endperi, period.nomperi, degree.iddeg, degree.nomgra, subgrade.idsub, subgrade.nomsub, course.foto, course.estado FROM course INNER JOIN period ON course.idper = period.idper INNER JOIN degree ON course.iddeg = degree.iddeg INNER JOIN subgrade ON course.idsub =  subgrade.idsub LIMIT ? OFFSET ?");
    $sentencia->execute([$limit, $offset]);
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
        ?>
    <table class="table table-striped table-hover" id="myTable">
      <thead>
        <tr>
          <th>Foto</th>  
          <th>Materia</th>
          <th>Periodo</th>
          <th>Grado</th>
          <th>Subgrado</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach($productos as $producto){ ?>
            <tr>
               <td><img src="../../Assets/img/subidas/<?php echo $producto->foto ?>" width='90'></td>
               <td><?php echo $producto->nomcur ?></td>
               <td><?php echo $producto->numperi ?></td>
               <td><?php echo $producto->nomgra ?></td>
               <td><?php echo $producto->nomsub ?></td>
               <td>
<form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idcur' value="<?php echo  $producto->idcur; ?>">
<button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
</form>
                   
               </td>
               <td>
<form  onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idcur' value="<?php echo  $producto->idcur; ?>">
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

                    <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> Materias disponibles</p>
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
$idcur = $_POST['idcur'];
$sql= "SELECT course.idcur, course.nomcur, period.idper, period.numperi, period.starperi, period.endperi, period.nomperi, degree.iddeg, degree.nomgra, subgrade.idsub, subgrade.nomsub, course.foto, course.estado FROM course INNER JOIN period ON course.idper = period.idper INNER JOIN degree ON course.iddeg = degree.iddeg INNER JOIN subgrade ON course.idsub =  subgrade.idsub WHERE idcur = :idcur"; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idcur', $idcur, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
 
?>

    <div class="col-12 col-md-12"> 

<form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input value="<?php echo $obj->idcur;?>" name="idcur" type="hidden">
  <div class="form-row">

    <div class="form-group col-md-6">
      <label for="edad">Materias </label>
      <input value="<?php echo $obj->nomcur;?>" name="nomcur" type="text" class="form-control">
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
                                    <label for="modal_contact_firstname">Materias</label>
                                    <div class="input-group">
                                       
                                        <input type="text"  name="txtnomcur" required class="form-control" placeholder="Nombre de la materias" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Periodo</label>
                                    <div class="input-group">
                                      <select required name="txtidper" id="periodo" class="form-control">
                                       <option value="" disabled="" selected="">Selecciona el periodo</option>

                                      </select>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">                         
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Grado</label>
                                    <div class="input-group">
                                      <select required name="txtgra" id="grado" class="form-control">
                                       <option value="" disabled="" selected="">Selecciona el grado</option>

                                      </select>
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Subgrado</label>
                                    <div class="input-group">
                                      <select required name="txtsub" id="sub" class="form-control">
                                       <option value="" disabled="" selected="">Selecciona el subgrado</option>

                                      </select>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">                         
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Foto</label>
                                    <div class="input-group">
                                       <input type="file" id="imagen" name="foto" onchange="readURL(this);" data-toggle="tooltip">
                 <img id="blah"  alt="your image" style="max-width:90px;" />
                                    
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
  //$username = $_POST['user_name'];// user name
  //$userjob = $_POST['user_job'];// user email


    $nomcur=$_POST['txtnomcur'];
    $idper=$_POST['txtidper'];
    $iddeg=$_POST['txtgra'];
    $idsub=$_POST['txtsub'];

    $imgFile = $_FILES['foto']['name'];
    $tmp_dir = $_FILES['foto']['tmp_name'];
    $imgSize = $_FILES['foto']['size'];

  
  if(empty($nomcur)){
   $errMSG = "Please enter your name.";
  }
  else if(empty($idper)){
   $errMSG = "Please Enter your period.";
  }
  else if(empty($iddeg)){
   $errMSG = "Please Enter your grade.";
  }
  else if(empty($idsub)){
   $errMSG = "Please Enter your subgrade.";
  }

  else
  {
   $upload_dir = '../../Assets/img/subidas/'; // upload directory
 
   $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
  
   // valid image extensions
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
  
   // rename uploading image
   $foto = rand(1000,1000000).".".$imgExt;
    
   // allow valid image file formats
   if(in_array($imgExt, $valid_extensions)){   
    // Check file size '5MB'
    if($imgSize < 5000000)    {
     move_uploaded_file($tmp_dir,$upload_dir.$foto);
    }
    else{
     $errMSG = "Sorry, your file is too large.";
    }
   }
   else{
    $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
   }
  }
  
  
  // if no error occured, continue ....
  if(!isset($errMSG))
  {
   $stmt = $connect->prepare("INSERT INTO course(nomcur, idper, iddeg, idsub,foto,estado) VALUES(:nomcur, :idper,:iddeg,:idsub,:foto ,'1')");
   $stmt->bindParam(':nomcur',$nomcur);
   $stmt->bindParam(':idper',$idper);
   $stmt->bindParam(':iddeg',$iddeg);
   $stmt->bindParam(':idsub',$idsub);
   $stmt->bindParam(':foto',$foto);
   
   if($stmt->execute())
   {
    echo '<script type="text/javascript">
swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
   }
   else
   {
    $errMSG = "error while inserting....";
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
////////////// Actualizar la tabla /////////
$consulta = "DELETE FROM `course` WHERE `idcur`=:idcur";
$sql = $connect-> prepare($consulta);
$sql -> bindParam(':idcur', $idcur, PDO::PARAM_INT);
$idcur=trim($_POST['idcur']);
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
$iddeg=trim($_POST['iddeg']);    
$idper=trim($_POST['idper']);
$nomgra=trim($_POST['nomgra']);


///////// Fin informacion enviada por el formulario /// 

////////////// Actualizar la tabla /////////
$consulta = "UPDATE degree
SET `idper`= :idper, `nomgra` = :nomgra WHERE `iddeg` = :iddeg";
$sql = $connect->prepare($consulta);
$sql->bindParam(':idper',$idper,PDO::PARAM_STR, 25);
$sql->bindParam(':nomgra',$nomgra,PDO::PARAM_STR, 25);
$sql->bindParam(':iddeg',$iddeg,PDO::PARAM_INT);

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
<script>
   function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
  </script>
  <script src="../../Assets/js/periodo.js"></script>
  </body>
  
  </html>


