<?php
session_start();

if(!isset($_SESSION['usuario']))
	header('location: login.php');

include('../librerias/conexion.php');
include('../librerias/utiles.php');

$conexion = conectar();

$cod_doc 		= $_REQUEST['cod_doc'];
$tipo 			= $_REQUEST['tipo'];
$fecha 			= $_REQUEST['fecha'];
$datos_registro = $_REQUEST['datos_registro'];
$abogado_redactor 	= $_REQUEST['abogado_redactor'];
$descripcion 	= $_REQUEST['descripcion'];

$consulta = "insert into documento (cod_doc, tipo, fecha, datos_registro, abogado_redactor, descripcion)
			values ('$cod_doc', '$tipo', '$fecha', '$datos_registro', '$abogado_redactor', '$descripcion')";

mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

$id = mysqli_insert_id($conexion);
$folder = "uploads/documentos/" . $id;

if (!is_dir($folder)) {
	mkdir($folder);
}

foreach ($_FILES['archivo_doc']['error'] as $key => $error) {
	if ($error == UPLOAD_ERR_OK) {
		$name = sanitize_file_name(basename($_FILES['archivo_doc']['name'][$key]));
		move_uploaded_file($_FILES['archivo_doc']['tmp_name'][$key], $folder . "/" . $name);
	}
}
