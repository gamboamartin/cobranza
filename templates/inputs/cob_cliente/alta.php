<?php /** @var  \gamboamartin\cobranza\controllers\controlador_adm_session $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->nombre; ?>
<?php echo $controlador->inputs->ap; ?>
<?php echo $controlador->inputs->am; ?>
<?php echo $controlador->inputs->razon_social; ?>
<?php echo $controlador->inputs->rfc; ?>
<?php echo $controlador->inputs->curp; ?>

<?php echo $controlador->inputs->cob_tipo_cliente_id; ?>
<?php echo $controlador->inputs->org_sucursal_id; ?>


<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>