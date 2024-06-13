
<?php include("../header.php") ?>
           <!--------main-content------------->


            <div class="main-content">
              <div class="row">
                
                <div class="col-md-12">
                <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
          <h2 class="ml-lg-2">Padres</h2>
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

        $sentencia = $connect->query("SELECT count(*) AS conteo FROM padres;");
    $conteo = $sentencia->fetchObject()->conteo;
    $paginas = ceil($conteo / $productosPorPagina);
    $sentencia = $connect->prepare("SELECT * FROM padres LIMIT ? OFFSET ?");
    $sentencia->execute([$limit, $offset]);
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
       ?>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            
          <th>Foto</th>
          <th>Cédula</th>
          <th>Nombre y apellido</th>
          <th>Profesion</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Estado</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach($productos as $producto){ ?>
            <tr>
               <td><img src="../../Assets/img/subidas/<?php echo $producto->foto ?>" width='90'></td>
               <td><?php echo $producto->dnifa ?></td>
               <td><?php echo $producto->nomfa ?>&nbsp;
               <td><?php echo $producto->profefa ?> </td>
               <td><?php echo $producto->correo ?></td>
               <td><?php echo $producto->telefa ?></td>
               <td>
                       

                        <?php if($producto->state==1)  { ?> 
        <span class="badge badge-success">Activo</span>
    <?php  }   else {?> 
        <span class="badge badge-danger">No activo</span>
        <?php  } ?>  
                            
                    </td>
               <td>
<form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idfa' value="<?php echo  $producto->idfa; ?>">
<button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
</form>
                   
               </td>
               <td>
<form  onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idfa' value="<?php echo  $producto->idfa; ?>">
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

                    <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> padres disponibles</p>
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
$idfa = $_POST['idfa'];
$sql= "SELECT * FROM padres WHERE idfa = :idfa"; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idfa', $idfa, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
 
?>

    <div class="col-12 col-md-12"> 

<form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input value="<?php echo $obj->idfa;?>" name="idfa" type="hidden">
  <div class="form-row">

    <div class="form-group col-md-6">
      <label for="nombres">Cédula</label>
      <input value="<?php echo $obj->dnifa;?>" maxlength="8"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="dnifa" type="text" class="form-control"  placeholder="Cédula">
    </div>

    <div class="form-group col-md-6">
      <label for="edad">Nombre y apellidos</label>
      <input value="<?php echo $obj->nomfa;?>" name="nomfa" type="text" placeholder="Nombre y apellidos" class="form-control">
    </div>
  </div>


  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombres">Profesión</label>
      <input value="<?php echo $obj->profefa;?>" name="profefa" type="text" class="form-control" placeholder="Profesión">
    </div>

    

     <div class="form-group col-md-6">
      <label for="nombres">Correo</label>
      <input value="<?php echo $obj->correo;?>" name="correo" type="email" class="form-control" placeholder="Correo">
    </div>
  </div>


    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombres">Teléfono</label>
      <input value="<?php echo $obj->telefa;?>" name="telefa" maxlength="9"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" type="text" class="form-control" placeholder="Teléfono móvil">
    </div>

     <div class="form-group col-md-6">
      <label for="nombres">Dirección</label>
      <input value="<?php echo $obj->direc;?>" name="direc" type="text" class="form-control" placeholder="Dirección">
    </div>
  </div>



<!--
  <div class="form-row">
     <div class="form-group col-md-6">
      <label for="nombres">Usuario</label>
      <input value="<?php //echo $obj->usuario;?>" name="usuario" type="text" class="form-control" placeholder="Usuario">
    </div>
  </div>
-->
      

<div class="form-group">
          <button name="actualizar" type="submit" class="btn btn-primary  btn-block">Actualizar Registro</button>
        </>
</form>
    </div>  

<?php }?>
 
<!-- add Modal HTML -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
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
                                    <label for="modal_contact_firstname">Cédula</label>
                                    <div class="input-group">
                                       
                                        <input type="text"  name="txtdni" maxlength="8" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required class="form-control" placeholder="Cédula" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Nombre y apellidos</label>
                                    <div class="input-group">       
                                        <input type="text"  name="txtnom" placeholder="Nombre y apellidos" required class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Profesión</label>
                                    <div class="input-group">
                                       
                                        <input type="text"  name="txtpro" required class="form-control" placeholder="Profesión" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Correo</label>
                                    <div class="input-group">
                                        <input type="email"  name="txtcor" required class="form-control" placeholder="Correo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                         <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Teléfono</label>
                                    <div class="input-group">
                                        <input type="text" name="txttel" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="Teléfono" required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Dirección</label>
                                    <div class="input-group">
                                        <input type="text" name="txtdir" placeholder="Dirección" required class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Foto</label>
                                    <div class="input-group">
                                     <input type="file" id="imagen" name="foto" onchange="readURL(this);" data-toggle="tooltip">
                 <img id="blah"  alt="your image" style="max-width:90px;" />
                                    </div>
                                </div>
                            </div>
<!--
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Usuario</label>
                                    <div class="input-group">
                                        <input type="text" name="txtusu" placeholder="Usuario" required class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="txtcla" placeholder="Contraseña" required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Permisos</label>
                                    <div class="input-group">
                                        <select class="form-control" required name="txtrol">
                                          <option selected>SELECCIONE</option>
                                          <option value="3">Padre</option>
                                   
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                    </div>
                          -->
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


    $dnifa=$_POST['txtdni'];
    $nomfa=$_POST['txtnom'];
    $profefa=$_POST['txtpro'];
    $correo=$_POST['txtcor'];
    $telefa=$_POST['txttel'];
    $direc=$_POST['txtdir'];

  
    $imgFile = $_FILES['foto']['name'];
    $tmp_dir = $_FILES['foto']['tmp_name'];
    $imgSize = $_FILES['foto']['size'];
/*
    $usuario=$_POST['txtusu'];
    $clave=MD5($_POST['txtcla']);
    $rol=$_POST['txtrol'];
  */
  
  if(empty($dnifa)){
   $errMSG = "Please enter your dni.";
  }
  else if(empty($nomfa)){
   $errMSG = "Please Enter your name.";
  }
  else if(empty($profefa)){
   $errMSG = "Please Enter your profession.";
  }
  else if(empty($correo)){
   $errMSG = "Please Enter your email.";
  }

  else if(empty($telefa)){
   $errMSG = "Please Enter your phone.";
  }

  else if(empty($direc)){
   $errMSG = "Please Enter your address.";
  }

  else if(empty($imgFile)){
   $errMSG = "Please Select Image File.";
  }
  /*
  else if(empty($usuario)){
   $errMSG = "Please Enter your user.";
  }

  else if(empty($clave)){
   $errMSG = "Please Enter your password.";
  }
  else if(empty($rol)){
   $errMSG = "Please Enter your permission.";
  }*/
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
   $stmt = $connect->prepare("INSERT INTO padres(dnifa, nomfa, profefa, correo, telefa,direc,foto, state) VALUES(:dnifa, :nomfa,:profefa,:correo,:telefa,:direc,:foto,'1')");
   $stmt->bindParam(':dnifa',$dnifa);
   $stmt->bindParam(':nomfa',$nomfa);
   $stmt->bindParam(':profefa',$profefa);
   $stmt->bindParam(':correo',$correo);
   $stmt->bindParam(':telefa',$telefa);
   $stmt->bindParam(':direc',$direc);
   $stmt->bindParam(':foto',$foto);
  /* $stmt->bindParam(':usuario',$usuario);
   $stmt->bindParam(':clave',$clave);
   $stmt->bindParam(':rol',$rol);
   */
  
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
$consulta = "DELETE FROM `padres` WHERE `idfa`=:idfa";
$sql = $connect-> prepare($consulta);
$sql -> bindParam(':idfa', $idfa, PDO::PARAM_INT);
$idfa=trim($_POST['idfa']);
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
$idfa=trim($_POST['idfa']);
$dnifa=trim($_POST['dnifa']);
$nomfa=trim($_POST['nomfa']);
$profefa=trim($_POST['profefa']);
$correo=trim($_POST['correo']);
$telefa=trim($_POST['telefa']);
$direc=trim($_POST['direc']);
//$usuario=trim($_POST['usuario']);

///////// Fin informacion enviada por el formulario /// 

////////////// Actualizar la tabla /////////
$consulta = "UPDATE padres
SET `dnifa`= :dnifa, `nomfa` = :nomfa, `profefa` = :profefa, `correo` = :correo, `telefa` = :telefa, `direc` = :direc WHERE `idfa` = :idfa";
$sql = $connect->prepare($consulta);
$sql->bindParam(':dnifa',$dnifa,PDO::PARAM_STR, 25);
$sql->bindParam(':nomfa',$nomfa,PDO::PARAM_STR, 25);
$sql->bindParam(':profefa',$profefa,PDO::PARAM_STR,25);
$sql->bindParam(':correo',$correo,PDO::PARAM_STR,25);
$sql->bindParam(':telefa',$telefa,PDO::PARAM_STR,25);
$sql->bindParam(':direc',$direc,PDO::PARAM_STR,25);
//$sql->bindParam(':usuario',$usuario,PDO::PARAM_STR,25);
$sql->bindParam(':idfa',$idfa,PDO::PARAM_INT);

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
  </body>
  
  </html>


