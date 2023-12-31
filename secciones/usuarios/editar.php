
<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_usuarios WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $usuario = $registro["usuario"];
    $password = $registro["password"];
    $correo = $registro["correo"];

    }
    
if($_POST){
  //Se imprime lo que se coloca en el input del nombre del puesto
  print_r($_POST);

  // Se recolectan los datos del metodo POST
  $txtID=(isset($_POST["txtID"])?$_POST["txtID"]:"");
  $usuario=(isset($_POST["nombredelusuario"])?$_POST["nombredelusuario"]:"");
  $password=(isset($_POST["password"])?$_POST["password"]:"");
  $correo=(isset($_POST["correo"])?$_POST["correo"]:"");

  
  //Se prepara la insercion de los datos
  $sentencia=$conexion->prepare("UPDATE tbl_usuarios set 
  usuario =:usuario,
  password=:password,
  correo=:correo
  where id=:id");
  //Asignando los valores que vienen del metodo POST del formulario
  $sentencia->bindParam(":usuario",$usuario);
  $sentencia->bindParam(":password",$password);
  $sentencia->bindParam(":correo",$correo);
  $sentencia->bindParam(":id",$txtID);
  $sentencia->execute();
  $mensaje= "Registro Actualizado";
  header("Location:index.php?mensaje=".$mensaje); 

}


?>


<?php include("../../templates/header.php");?>


<br>
<div class="card">
    <div class="card-header">
        Datos del usuario
    </div>
    <div class="card-body">
   <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">

    <div class="mb-3">
    <label for="txtID" class="form-label">ID:</label>
          <input type="text"
          value="<?php echo $txtID; ?>"
            class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
        </div>

      <label for="nombredelusuario" class="form-label">Nombre del usuario:</label>
      <input type="text"
      value="<?php echo $usuario; ?>"
        class="form-control" name="nombredelusuario" id="nombredelusuario" aria-describedby="helpId" placeholder="Nombre del Usuario">
    </div>
    
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password"
      value="<?php echo $password; ?>"
        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escriba su contraseña">
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo:</label>
      <input type="email"
      value="<?php echo $correo; ?>"
        class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su Correo">
    </div>


    <button type="submit" class="btn btn-success">Agregar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
   
   </form>
    </div>
</div>


<?php include("../../templates/footer.php");?>