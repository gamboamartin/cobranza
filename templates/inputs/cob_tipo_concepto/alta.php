<?php /** @var  \gamboamartin\banco\controllers\controlador_adm_session $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>


<?php echo $controlador->inputs->descripcion; ?>

<?php echo $controlador->inputs->cob_tipo_ingreso_id; ?>


<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>