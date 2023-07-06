<?php
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT *, 
    (SELECT nombredelpuesto FROM tbl_puestos where tbl_puestos.id=tbl_empleados.idpuesto limit 1) 
    as nombrepuesto  FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    print_r($registro);

//Entre los [""] deben ir como está el nombre en la base de datos
    $primernombre=$registro["primer_nombre"];
    $segundonombre=$registro["segundo_nombre"];
    $primerapellido=$registro["primer_apellido"];
    $segundoapellido=$registro["segundo_apellido"];

    $nombreCompleto = $primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;

    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $nombrepuesto = $registro["nombrepuesto"];
    $idpuesto = $registro["idpuesto"];



    $fechadeingreso = $registro["fechadeingreso"];

    $fechaInicio=new DateTime($fechadeingreso);
    $fechaFin=new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio,$fechaFin);

} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendación</title>
</head>
<body>

<h1> Carta de recomendación laboral</h1>    
<br> 
<br>
Bogotá,Colombia, <strong> <?php echo date('d M Y');?></strong>.
<br> 
<br>
A quien pueda interesar:
<br>
<br>
A través de la presente, otorgo esta recomendación personal a nombre de <strong> <?php echo $nombreCompleto; ?></strong>, quién laboró en mi organización durante <strong> <?php echo $diferencia->y; ?>año(s)</strong> en el cargo de <strong> <?php echo $nombrepuesto;?></strong>,
<br><br>                                                                                                                                                                                                
Durante el tiempo en el que nos conocemos ha demostrado ser una persona responsable, con valores, comprometido y bastante leal. Esto hace que goce de mi entera confianza por lo cual lo recomiendo ampliamente como una persona digna y con ética. 
<br><br>                                                                                                                                                                                        
Sin más que agregar, me despido no sin antes agradecerles por la atención prestada y quedando a su entera disposición en caso de necesitar mayor información. 
<br>
<br>
Atentamente,
<br>
<strong>Juan Sebastian Diaz Parra</strong>
    
</body>
</html>


<?php
$HTML=ob_get_clean(); 
require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf= new Dompdf();
$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnable"=>true)); 
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false))
?>

