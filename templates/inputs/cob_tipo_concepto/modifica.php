<?php /** @var  \gamboamartin\cobranza\controllers\controlador_cob_tipo_concepto $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>


<?php echo $controlador->inputs->cob_tipo_ingreso_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>

<div class="cold-row-12">
    <?php foreach ($controlador->buttons as $button){ ?>
        <?php echo $button; ?>
    <?php }?>
</div>
