<?php /** @var  \gamboamartin\cobranza\controllers\controlador_cob_cliente $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->bn_cuenta_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>

<div class="cold-row-12">
    <?php foreach ($controlador->buttons as $button){ ?>
        <?php echo $button; ?>
    <?php }?>
</div>
