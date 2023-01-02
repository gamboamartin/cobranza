<?php /** @var  \gamboamartin\cobranza\controllers\controlador_adm_session $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->fecha_de_pago; ?>
<?php echo $controlador->inputs->monto; ?>

<?php echo $controlador->inputs->cob_deuda_id; ?>
<?php echo $controlador->inputs->bn_cuenta_id; ?>
<?php echo $controlador->inputs->cat_sat_forma_de_pago_id; ?>


<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>