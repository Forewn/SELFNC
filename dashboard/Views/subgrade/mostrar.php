<?php include("../header.php") ?>
           <!--------main-content------------->


            <div class="main-content">
              <div class="row">
                
                <div class="col-md-12">
                <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
          <h2 class="ml-lg-2">Subgrado académico</h2>
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

        $sentencia = $connect->query("SELECT subgrade.idsub, degree.iddeg, degree.nomgra, subgrade.nomsub, subgrade.fere, GROUP_CONCAT(period.idper, '..', period.numperi, '..' SEPARATOR '__') AS period, count(*) AS conteo  FROM subgrade INNER JOIN degree ON subgrade.iddeg = degree.iddeg INNER JOIN period ON period.idper = degree.idper;");
    $conteo = $sentencia->fetchObject()->conteo;
    $paginas = ceil($conteo / $productosPorPagina);
    $sentencia = $connect->prepare("SELECT subgrade.idsub, degree.iddeg, degree.nomgra, subgrade.nomsub, subgrade.fere, GROUP_CONCAT(period.idper, '..', period.numperi, '..' SEPARATOR '__') AS period, count(*) AS conteo  FROM subgrade INNER JOIN degree ON subgrade.iddeg = degree.iddeg INNER JOIN period ON period.idper = degree.idper  GROUP BY subgrade.idsub DESC LIMIT ? OFFSET ?");
    $sentencia->execute([$limit, $offset]);
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

       ?>
      
    <table class="table table-striped table-hover" id="myTable">
      <thead>
        <tr>
        
          <th>Periodo escolar</th>
          <th>Grado</th>
          <th>Subgrado</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>

      <tbody>
          <?php foreach($productos as $producto){ ?>
            <tr>
               

                 <?php foreach(explode("__", $producto->period) as $periodoConcatenados){ 
                                $period = explode("..", $periodoConcatenados)
                                ?>
                               <td><?php echo $period[1] ?></td>

                <?php } ?>

               <td><?php echo $producto->nomgra ?></td>
               <td><?php echo $producto->nomsub ?></td>
               <td>
<form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idsub' value="<?php echo  $producto->idsub; ?>">
<button name='editar' class='btn btn-warning text-white'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
</form>
                   
               </td>
               <td>
<form  onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idsub' value="<?php echo  $producto->idsub; ?>">
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

                    <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> subgrado  disponibles</p>
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
$idsub = $_POST['idsub'];
$sql= "SELECT subgrade.idsub, degree.iddeg, degree.nomgra, subgrade.nomsub, subgrade.fere, GROUP_CONCAT(period.idper, '..', period.numperi, '..' SEPARATOR '__') AS period  FROM subgrade INNER JOIN degree ON subgrade.iddeg = degree.iddeg INNER JOIN period ON period.idper = degree.idper   WHERE idsub = :idsub  GROUP BY subgrade.idsub "; 
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idsub', $idsub, PDO::PARAM_INT); 
$stmt->execute();
$obj = $stmt->fetchObject();
 
?>

    <div class="col-12 col-md-12"> 

<form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input value="<?php echo $obj->idsub;?>" name="idsub" type="hidden">
  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombres">Grado</label>
      <select required name="iddeg" class="form-control" disabled>
    <option value="<?php echo $obj->iddeg;?>"><?php echo $obj->nomgra;?></option>        
    <option value=""><< >></option>

    <?php 
    $stmt = $connect->prepare('SELECT * FROM degree');
    $stmt->execute();

while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <option value="<?php echo $iddeg; ?>"><?php echo $nomgra; ?></option>
            <?php
        }
        ?>
     ?>
    </select>
    </div>

    <div class="form-group col-md-6">
      <label for="edad">Subgrado</label>
      <input value="<?php echo $obj->nomsub;?>" name="nomsub" type="text" class="form-control">
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
                                    <label for="modal_contact_lastname">Periodo</label>
                                    <div class="input-group">
                                         
                         <select required  class="form-control" onchange="showselect(this.value)">
                                        <option value="" >-Seleccione un periodo-</option>
                                       <?php 
                                       $stmt = $connect->prepare('SELECT * FROM period');
                                        $stmt->execute();

                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            extract($row);
                                            ?>

                                            <option value="<?php echo $idper; ?>"><?php echo $numperi; ?></option>
                                            <?php
                                        }
                                        ?>
                                        ?>     

                                      </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6" id="periodo">
                                <div class="form-group">
                                    <label for="modal_contact_lastname">Grado</label>
                                    <div class="input-group">
                                         
                                      <select required name="iddeg" id="periodo" class="form-control">
                                           <option value="">-- Seleccione una grado --</option>

                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="modal_contact_firstname">Subgrado</label>
                                    <div class="input-group">
                                       
                                        <input type="text"  name="nomsub" required class="form-control" placeholder="Nombre del subgrado" />
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
if(isset($_POST["agregar"])){

///////////// Informacion enviada por el formulario /////////////
$nomsub=$_POST['nomsub'];
$iddeg=$_POST['iddeg'];

///////// Fin informacion enviada por el formulario /// 

////////////// Insertar a la tabla la informacion generada /////////
$sql="insert into subgrade(nomsub,iddeg) 
values(:nomsub,:iddeg)";
    
$sql = $connect->prepare($sql);
    
$sql->bindParam(':nomsub',$nomsub,PDO::PARAM_STR, 25);
$sql->bindParam(':iddeg',$iddeg,PDO::PARAM_STR, 25);

    
$sql->execute();

$lastInsertId = $connect->lastInsertId();
if($lastInsertId>0){

echo '<script type="text/javascript">
swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
}
else{
    echo '<script type="text/javascript">
swal("ERROR!", "No se pudo agregar", "error").then(function() {
            window.location = "mostrar.php";
        });
        </script>';

print_r($sql->errorInfo()); 
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
$consulta = "DELETE FROM `subgrade` WHERE `idsub`=:idsub";
$sql = $connect-> prepare($consulta);
$sql -> bindParam(':idsub', $idsub, PDO::PARAM_INT);
$idsub=trim($_POST['idsub']);
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
$idsub=trim($_POST['idsub']);
$nomsub=trim($_POST['nomsub']);


///////// Fin informacion enviada por el formulario /// 

////////////// Actualizar la tabla /////////
$consulta = "UPDATE subgrade
SET `nomsub`= :nomsub WHERE `idsub` = :idsub";
$sql = $connect->prepare($consulta);
$sql->bindParam(':nomsub',$nomsub,PDO::PARAM_STR, 25);
$sql->bindParam(':idsub',$idsub,PDO::PARAM_INT);

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


 <script type="text/javascript">
            function showselect(str){
                var xmlhttp; 
                if (str=="")
                  {
                  document.getElementById("txtHint").innerHTML="";
                  return;
                  }
                if (window.XMLHttpRequest)
                  {// code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                     {
                     document.getElementById("periodo").innerHTML=xmlhttp.responseText;
                     }
                  }
                xmlhttp.open("GET","../funciones/grado.php?c="+str,true);
                xmlhttp.send();
            }
        </script>
  </body>
  
  </html>


