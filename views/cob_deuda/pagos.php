<?php /** @var gamboamartin\cobranza\controllers\controlador_cob_pago $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <form method="post" action="<?php echo $controlador->link_cob_pago_alta_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates."head/title.php"; ?>
                        <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates."mensajes.php"; ?>

                        <?php echo $controlador->inputs->cob_pago_codigo; ?>
                        <?php echo $controlador->inputs->cob_pago_descripcion; ?>
                        <?php echo $controlador->inputs->cob_pago_fecha_de_pago; ?>
                        <?php echo $controlador->inputs->cob_pago_monto; ?>
                        <?php echo $controlador->inputs->select->cob_deuda_id; ?>
                        <?php echo $controlador->inputs->select->bn_cuenta_id; ?>
                        <?php echo $controlador->inputs->select->cat_sat_forma_pago_id; ?>
                        <?php echo $controlador->inputs->select->cob_caja_id; ?>

                        <?php echo $controlador->inputs->hidden_row_id; ?>
                        <?php echo $controlador->inputs->hidden_seccion_retorno; ?>
                        <?php echo $controlador->inputs->hidden_id_retorno; ?>
                        <div class="controls">
                            <button type="submit" class="btn btn-success" value="pagos" name="btn_action_next">Alta</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="widget widget-box box-container widget-mylistings">
                    <?php echo $controlador->contenido_table; ?>
                </div> <!-- /. widget-table-->
            </div><!-- /.center-content -->
        </div>
    </div>
</main>

