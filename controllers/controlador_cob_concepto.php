<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\models\cob_concepto;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_base;
use gamboamartin\system\links_menu;

use gamboamartin\template\html;



use html\cob_cliente_html;
use html\cob_concepto_html;
use html\cob_deuda_html;
use html\cob_tipo_concepto_html;

use PDO;
use stdClass;

class controlador_cob_concepto extends _ctl_base {

    public string $link_cob_deuda_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){

        $modelo = new cob_concepto(link: $link);
        $html_ = new cob_concepto_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_concepto_id']['titulo'] = 'Id';
        $datatables->columns['cob_concepto_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_concepto_descripcion']['titulo'] = 'Concepto';
        $datatables->columns['cob_concepto_n_deudas']['titulo'] = 'N Deudas';
        $datatables->columns['cob_tipo_concepto_descripcion']['titulo'] = 'Tipo Concepto';
        $datatables->columns['cob_tipo_ingreso_descripcion']['titulo'] = 'Tipo Ingreso';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_concepto.id';
        $datatables->filtro[] = 'cob_concepto.codigo';
        $datatables->filtro[] = 'cob_concepto.descripcion';
        $datatables->filtro[] = 'cob_tipo_concepto.descripcion';
        $datatables->filtro[] = 'cob_tipo_ingreso.descripcion';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Concepto';

        $link_cob_deuda_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_deuda');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_deuda_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_deuda_alta_bd = $link_cob_deuda_alta_bd;



    }

    public function alta(bool $header, bool $ws = false): array|string
    {

        $r_alta = $this->init_alta();
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al inicializar alta',data:  $r_alta, header: $header,ws:  $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_concepto_id',
            keys_selects: array(), id_selected: -1, label: 'Tipo Concepto');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }




        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 6;


        $inputs = $this->inputs(keys_selects: $keys_selects);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener inputs',data:  $inputs, header: $header,ws:  $ws);
        }



        return $r_alta;
    }

    protected function campos_view(): array
    {
        $keys = new stdClass();
        $keys->inputs = array('codigo','descripcion');
        $keys->selects = array();

        $init_data = array();
        $init_data['cob_tipo_concepto'] = "gamboamartin\\cobranza";
        $campos_view = $this->campos_view_base(init_data: $init_data,keys:  $keys);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al inicializar campo view',data:  $campos_view);
        }


        return $campos_view;
    }

    protected function inputs_children(stdClass $registro): stdClass|array
    {
        $select_cob_tipo_concepto_id = (new cob_tipo_concepto_html(html: $this->html_base))->select_cob_tipo_concepto_id(
            cols:6,con_registros: true,id_selected:  -1,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_tipo_concepto_id',data:  $select_cob_tipo_concepto_id);
        }
        $select_cob_cliente_id = (new cob_cliente_html(html: $this->html_base))->select_cob_cliente_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_cliente_id',data:  $select_cob_cliente_id);
        }


        $cob_deuda_monto = (new cob_deuda_html(html: $this->html_base))->input_monto(
            cols:12,row_upd:  new stdClass(),value_vacio:  false);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_deuda_monto',data:  $cob_deuda_monto);
        }

        $fecha_vencimiento = (new cob_deuda_html(html: $this->html_base))->input_fecha_vencimiento(
            cols:12,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Fecha de vencimiento',
            value: date('Y-m-d'));
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_deuda_fecha_vencimiento',data:  $fecha_vencimiento);
        }

        $cob_concepto_id = (new cob_concepto_html(html: $this->html_base))->select_cob_concepto_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_concepto_id',data:  $cob_concepto_id);
        }




        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->cob_tipo_concepto_id = $select_cob_tipo_concepto_id;
        $this->inputs->cob_cliente_id = $select_cob_cliente_id;
        $this->inputs->cob_deuda_monto = $cob_deuda_monto;
        $this->inputs->fecha_vencimiento = $fecha_vencimiento;
        $this->inputs->cob_concepto_id = $cob_concepto_id;



        return $this->inputs;
    }


    protected function key_selects_txt(array $keys_selects): array
    {

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo', keys_selects: $keys_selects, place_holder: 'Cod');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Concepto');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }


        return $keys_selects;
    }

    public function modifica(
        bool $header, bool $ws = false): array|stdClass
    {
        $r_modifica = $this->init_modifica(); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al generar salida de template',data:  $r_modifica,header: $header,ws: $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_concepto_id',
            keys_selects: array(), id_selected: $this->registro['cob_tipo_concepto_id'], label: 'Concepto');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }




        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 6;

        $keys_selects['codigo'] = new stdClass();
        $keys_selects['codigo']->disabled = true;

        $base = $this->base_upd(keys_selects: $keys_selects, not_actions: array(__FUNCTION__), params: array(),params_ajustados: array());
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar base',data:  $base, header: $header,ws:  $ws);
        }




        return $r_modifica;
    }

    public function deudas(bool $header = true, bool $ws = false): array|string
    {


        $data_view = new stdClass();
        $data_view->names = array('Id','Monto','N pagos','Monto pagado','Saldo','Fecha de vencimiento','Concepto','Cliente');
        $data_view->keys_data = array('cob_deuda_id','cob_deuda_monto','cob_deuda_n_pagos','cob_deuda_pagado','cob_deuda_saldo','cob_deuda_fecha_vencimiento',
            'cob_concepto_descripcion','cob_cliente_razon_social');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\cobranza\\models';
        $data_view->name_model_children = 'cob_deuda';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }




}
