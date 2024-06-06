
<?php include("../header.php") ?>

           <!--------main-content------------->


            <div class="main-content">
              <div class="row">
                
                <div class="col-md-12">
                <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
          <h2 class="ml-lg-2">Asistencias</h2>
        </div>

        <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">
         

          <a href="#" class="btn btn-danger">
          <i class="material-icons">print</i> </a>
         
        </div>
      </div>
    </div>
   <?php
    require '../../Config/config.php';
  
    $sentencia = $connect->prepare("SELECT asisten_alumn.idasisa,asisten_alumn.presen,asisten_alumn.fecha_create ,estudiantes.idstu, estudiantes.dnist, estudiantes.nomstu,estudiantes.edast,estudiantes.direce, estudiantes.correo, estudiantes.sexes, estudiantes.fenac, estudiantes.foto, teachers.idtea, teachers.dnite, teachers.nomte, teachers.sexte, teachers.correo, teachers.telet, teachers.foto, seccion.idsec, seccion.nomsec, seccion.capa, GROUP_CONCAT(subgrade.idsub, '..', subgrade.nomsub, '..' SEPARATOR '__') AS subgrade , GROUP_CONCAT(course.idcur, '..', course.nomcur, '..' SEPARATOR '__') AS course, GROUP_CONCAT(degree.iddeg, '..', degree.nomgra, '..' SEPARATOR '__') AS degree, count(*) AS conteo FROM asisten_alumn  INNER JOIN estudiantes ON asisten_alumn.idstu = estudiantes.idstu INNER JOIN teachers ON asisten_alumn.idtea = teachers.idtea INNER JOIN seccion ON asisten_alumn.idsec = seccion.idsec INNER JOIN subgrade ON seccion.idsub  = subgrade.idsub INNER JOIN course ON seccion.idcur = course.idcur INNER JOIN degree ON subgrade.iddeg  = degree.iddeg GROUP BY asisten_alumn.idasisa;");
    

 $sentencia->execute();

$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}
    ?> 
     <?php if(count($data)>0):?>
    <?php foreach($data as $d):?>  
    <table class="table table-striped table-hover" id="myTable">
      <thead>
        <tr>
        
          <th>Alumnos</th>
          <th>Docente</th>
          <th>Sección</th>
          <th>Grado</th>
          <th>Subgrado</th>
          <th>Asistencia</th>
          <th>Fecha</th>
         
        </tr>
      </thead>

      <tbody>
          
            <tr>
               <td><?php echo $d->nomstu ?></td>
               <td><span class="badge badge-dark text-white"><?php echo $d->nomte ?></span></td>
            <td><span class="badge badge-danger text-white"><?php echo $d->nomsec ?></span></td>

                 <?php foreach(explode("__", $d->degree) as $periodoConcatenados){ 
                                $degree = explode("..", $periodoConcatenados)
                                ?>
                               <td><span class="badge badge-warning text-white"><?php echo $degree[1] ?></span></td>
                               
                <?php } ?>
                <?php foreach(explode("__", $d->subgrade) as $periodoConcatenados){ 
                                $subgrade = explode("..", $periodoConcatenados)
                                ?>
                               <td><?php echo $subgrade[1] ?></td>
                <?php } ?>

               <td>      
            <?php if($d->presen=='Asistio')  { ?> 
        <span class="badge badge-success">Asistió</span>
    <?php  }   else {?> 
        <span class="badge badge-danger">No asistió</span>
        <?php  } ?>  
                            
                    </td>
               
               <td><span class="badge badge-primary text-white"><?php echo $d->fecha_create ?></span></td>
            <?php endforeach; ?>
    <?php else:?>
      
      <div class="alert alert-warning" style="position: relative;
    margin-left: 705px;
    margin-top: 14px;
    margin-bottom: 0px;">
            <strong>No hay asistencias!</strong>
        </div>
    <?php endif; ?> 
            
      </tbody>
    </table>

    
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

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>




  </body>
  
  </html>


