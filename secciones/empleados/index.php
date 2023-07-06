<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Buscar el archivo relacionado
    $sentencia=$conexion->prepare("SELECT foto,cv FROM tbl_empleados where id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
    print_r($registro_recuperado);
    
if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!="") {

    if(file_exists("./".$registro_recuperado["foto"]))
    {
        unlink("./".$registro_recuperado["foto"]);

    }
}

if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!="") {

    if(file_exists("./".$registro_recuperado["cv"]))
    {
        unlink("./".$registro_recuperado["cv"]);

    }
}
    
    $sentencia=$conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje= "Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje); 

}


$sentencia=$conexion->prepare("SELECT *,
(SELECT nombredelpuesto FROM tbl_puestos where tbl_puestos.id=tbl_empleados.idpuesto limit 1) as nombrepuesto 
FROM tbl_empleados ");
$sentencia->execute();
$lista_tbl_empleados=$sentencia->fetchall(PDO::FETCH_ASSOC);

?>
<?php include("../../templates/header.php");?>
<br>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" 
        href="crear.php" role="button">Agregar Registro</a>

    </div>
    <div class="card-body">
   <div class="table-responsive-sm">
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Foto</th>
                <th scope="col">CV</th>
                <th scope="col">Puesto</th>
                <th scope="col">Fecha Ingreso</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_tbl_empleados as $registros) { ?>
            <tr class="">
                <td scope="row"><?php echo $registros['id']; ?></td>
                <td scope="row"><?php echo $registros['primer_nombre']; ?>
                <?php echo $registros['segundo_nombre']; ?>
                <?php echo $registros['primer_apellido']; ?>
                <?php echo $registros['segundo_apellido']; ?>
            </td>
                <td>
                <img width="50" src="<?php echo $registros['foto']; ?>" class="img-fluid rounded" alt=""/>

                <td>
                <a href="<?php echo $registros['cv']; ?>">  
                <?php echo $registros['cv']; ?>
            </a>
        </td>
                <td><?php echo $registros['nombrepuesto']; ?></td>
                <td><?php echo $registros['fechadeingreso']; ?></td>
                <td>
                <a class="btn btn-primary" href="carta_recomendacion.php?txtID=<?php echo $registros['id']; ?>" role="button">Carta</a>
                <a class="btn btn-primary" href="editar.php?txtID=<?php echo $registros['id']; ?>" role="button">Editar</a>
                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
            </td>
            </tr>

            <?php }?>
        </tbody>
    </table>
</div>

    </div>
</div>

<?php include("../../templates/footer.php");?>