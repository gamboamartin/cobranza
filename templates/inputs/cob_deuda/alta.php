<?php /** @var  \gamboamartin\cobranza\controllers\controlador_adm_session $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>

<?php echo $controlador->inputs->cob_concepto_id; ?>
<?php echo $controlador->inputs->cob_cliente_id; ?>



<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>