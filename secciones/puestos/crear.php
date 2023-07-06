<?php 
include("../../bd.php");

if($_POST){
    //Se imprime lo que se coloca en el input del nombre del puesto
    print_r($_POST);

    // Se recolectan los datos del metodo POST
    $nombredelpuesto=(isset($_POST["nombredelpuesto"])?$_POST["nombredelpuesto"]:"");
    //Se prepara la insercion de los datos
    $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) 
                VALUES (null, :nombredelpuesto)");
    //Asignando los valores que vienen del metodo POST del formulario
    $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
    $sentencia->execute();
    $mensaje= "Registro Creado";
    header("Location:index.php?mensaje=".$mensaje);

}

?>

<?php include("../../templates/header.php");?>

<br>
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
   <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nombredelpuesto" class="form-label">Nombre del puesto:</label>
      <input type="text"
        class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
    </div>
    <button type="submit" class="btn btn-success">Agregar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
   
   </form>
    </div>
</div>


<?php include("../../templates/footer.php");?>