<?php include("../header.php"); ?>

<!--------main-content------------->
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Años Académicos</h2>
                        </div>
                    
                        <!-- <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">
                            <a href="plantilla.php" class="btn btn-danger">
                                <i class="material-icons">print</i>
                            </a>
                        </div> -->

                        
                    </div>
                </div>

                <?php 
                require '../../Config/config.php';

                $sentencia = $connect->prepare("SELECT * FROM anios");
                $sentencia->execute();
                $años = $sentencia->fetchAll(PDO::FETCH_OBJ);
                ?>

                <table class="table table-striped table-hover">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <?php foreach($años as $año){ ?>
                            <tr>
                                <td><?php echo $año->anio . ' año' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

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
            $(document).ready(function() {
                setTimeout(function() {
                    $(".content").fadeOut(1500);
                },3000);
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    </div>
</div>
<!----------html code compleate----------->
