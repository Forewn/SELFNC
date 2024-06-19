<?php include("../header.php") ?>
           <!--------main-content------------->

    <div class="main-content">

       <div class="container">
            <div class="row">
    <div class="col-md-3">
      <div class="card-counter primary">
      
        <i class="material-icons">sentiment_very_satisfied</i>
          <?php require '../../Config/config.php'; ?>
         <?php 
        $sql = "SELECT COUNT(*) total FROM estudiantes";
        $result = $connect->query($sql); //$pdo sería el objeto conexión
        $total = $result->fetchColumn();

         ?>
        <span class="count-numbers"><?php echo  $total; ?></span>
        <span class="count-name">Estudiantes</span>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-counter danger">
        <i class="material-icons">psychology</i>
         <?php 
        $sql = "SELECT COUNT(*) total FROM profesores";
        $result = $connect->query($sql); //$pdo sería el objeto conexión
        $total = $result->fetchColumn();

         ?>
        <span class="count-numbers"><?php echo  $total; ?></span>
        <span class="count-name">Docentes</span>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-counter success">
        <i class="material-icons">supervisor_account</i>
         <?php 
        $sql = "SELECT COUNT(*) total FROM representante_legal";
        $result = $connect->query($sql); //$pdo sería el objeto conexión
        $total = $result->fetchColumn();

         ?>
        <span class="count-numbers"><?php echo  $total; ?></span>
        <span class="count-name">Padres</span>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-counter info">
        <i class="material-icons">person_outline</i>
         <?php 
        $sql = "SELECT COUNT(*) total FROM usuarios";
        $result = $connect->query($sql); //$pdo sería el objeto conexión
        $total = $result->fetchColumn();

         ?>
        <span class="count-numbers"><?php echo  $total; ?></span>
        <span class="count-name">Administrador</span>
      </div>
    </div>
  </div>
 <div class="row">

  <div class="col-sm-6 mb-3 mb-md-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?php echo ucfirst($_SESSION['nombre']); ?></h5>
        <p class="card-text">Nombre de usuario: <?php echo ucfirst($_SESSION['usuario']); ?></p>
        <p class="card-text">Correo: <?php echo ucfirst($_SESSION['correo']); ?></p>
        <p class="card-text">Rol: ADMIN</p>
<a href="../profile/mostrar.php" class="btn btn-primary">Configuración de la cuenta</a>
<a href="../pages-logout.php" class="btn btn-primary">Cerrar Sesión</a>


      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Estudiantes recientes<a href="../students/mostrar" class="btn btn-success btn-sm">Ver todos</a></h5>

        
        <?php  
        $sentencia = $connect->query("SELECT * FROM estudiantes ORDER BY cedula_estudiante ASC LIMIT 3;");
        $personas = $sentencia->fetchAll(PDO::FETCH_OBJ);

        ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>   
                    <th>Apellidos/Nombres</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($personas as $persona){ ?>
                <tr>
                    <td><?php echo $persona->nombres?></td>
                    <td>
                       

                        <?php if($persona->status==1)  { ?> 
        <span class="badge badge-success">Estudiando</span>

    <?php  }   else {?> 
        <span class="badge badge-danger">No estudia</span>
        <?php  } ?>  
                            
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            
        </table>

      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Docentes recientes<a href="../teachers/mostrar" class="btn btn-success btn-sm">Ver todos</a></h5>

     
        <?php  
        $sentencia = $connect->query("SELECT * FROM profesores ORDER BY cedula_profesor ASC LIMIT 3;");
        $personas = $sentencia->fetchAll(PDO::FETCH_OBJ);

        ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>   
                    <th>Apellidos/Nombres</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($personas as $persona){ ?>
                <tr>
                    <td><?php echo $persona->nombre ?></td>
                </tr>
                <?php } ?>
            </tbody>
            
        </table>

      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Cumpleaños recientes</h5>

     
        <?php  
        $sentencia = $connect->query("SELECT * FROM estudiantes;");
        $personas = $sentencia->fetchAll(PDO::FETCH_OBJ);

        ?>
          
            <?php foreach($personas as $persona){ ?>
              <?php

$hoy = date("m");
$fecha_cumple = $persona->fecha_nac;
$nomstu = $persona->nombres;


$dianac = date('d', strtotime($fecha_cumple));
$mes_cumple = date('m', strtotime($fecha_cumple));

$hoy2 = strtotime($hoy);

$aniohoy = date('Y', $hoy2);
$nfecha = date($aniohoy.'-'.$mes_cumple.'-'.$dianac);
$diasfaltantes = (strtotime($nfecha)- strtotime($hoy));
$dfalta = $diasfaltantes/(60*60*24);
$diasf = floor($dfalta);

if ($hoy == $mes_cumple) {

    echo '<span  class="badge badge-success">
                <strong>Felicidades!</strong> Cumpleaños al alumn@  '.$nomstu.' </span >

                '; 
}


?>
            <?php } ?>
          

      </div>
    </div>
  </div>


</div>
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
    <script src="../../Assets/DataTables/js/datatables.min.js"></script>
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
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
  
  </body>
  
  </html>


