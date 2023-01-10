<?php /** @var gamboamartin\cobranza\controllers\controlador_cob_cliente $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<main class="main section-color-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <form method="post" action="<?php echo $controlador->link_cob_cliente_alta_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates."head/title.php"; ?>
                        <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates."mensajes.php"; ?>

                        <?php echo $controlador->inputs->cob_cliente_codigo; ?>
                        <?php echo $controlador->inputs->cob_cliente_codigo_bis; ?>
                        <?php echo $controlador->inputs->cob_cliente_nombre; ?>
                        <?php echo $controlador->inputs->cob_cliente_ap; ?>
                        <?php echo $controlador->inputs->cob_cliente_am; ?>
                        <?php echo $controlador->inputs->cob_cliente_curp; ?>
                        <?php echo $controlador->inputs->cob_cliente_descripcion; ?>
                        <?php echo $controlador->inputs->cob_cliente_razon_social; ?>
                        <?php echo $controlador->inputs->cob_cliente_rfc; ?>

                        <?php echo $controlador->inputs->select->org_sucursal_id; ?>
                        <?php echo $controlador->inputs->select->cob_tipo_cliente_id; ?>

                        <?php echo $controlador->inputs->hidden_row_id; ?>
                        <?php echo $controlador->inputs->hidden_seccion_retorno; ?>
                        <?php echo $controlador->inputs->hidden_id_retorno; ?>
                        <div class="controls">
                            <button type="submit" class="btn btn-success" value="clientes" name="btn_action_next">Alta</button><br>
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

