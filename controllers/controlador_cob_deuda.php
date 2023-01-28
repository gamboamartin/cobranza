<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\html\cob_caja_html;
use gamboamartin\cobranza\html\cob_cliente_html;
use gamboamartin\cobranza\html\cob_concepto_html;
use gamboamartin\cobranza\html\cob_deuda_html;
use gamboamartin\cobranza\html\cob_pago_html;
use gamboamartin\cobranza\models\cob_deuda;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_base;
use gamboamartin\system\links_menu;

use gamboamartin\template\html;

use html\bn_cuenta_html;
use html\cat_sat_forma_pago_html;
use PDO;
use stdClass;

class controlador_cob_deuda extends _ctl_base {

    public string $link_cob_pago_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){

        $modelo = new cob_deuda(link: $link);
        $html_ = new cob_deuda_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_deuda_id']['titulo'] = 'Id';
        $datatables->columns['cob_deuda_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_deuda_descripcion']['titulo'] = 'Deuda';
        $datatables->columns['cob_deuda_n_pagos']['titulo'] = 'N Pagos';
        $datatables->columns['cob_deuda_monto']['titulo'] = 'Monto';
        $datatables->columns['cob_deuda_fecha_vencimiento']['titulo'] = 'Fecha de vencimiento';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_deuda.id';
        $datatables->filtro[] = 'cob_deuda.codigo';
        $datatables->filtro[] = 'cob_deuda.descripcion';
        $datatables->filtro[] = 'cob_deuda.monto';
        $datatables->filtro[] = 'cob_deuda.fecha_vencimiento';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Deuda';


        $link_cob_pago_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_pago');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_pago_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_pago_alta_bd = $link_cob_pago_alta_bd;

        $this->lista_get_data = true;
    }


    public function alta(bool $header, bool $ws = false): array|string
    {

        $r_alta = $this->init_alta();
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al inicializar alta',data:  $r_alta, header: $header,ws:  $ws);
        }

        $this->row_upd->fecha_vencimiento = date('Y-m-d');


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_cliente_id',
            keys_selects: array(), id_selected: -1, label: 'Cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_concepto_id',
            keys_selects: $keys_selects, id_selected: -1, label: 'Concepto');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }


        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 6;

        $keys_selects['fecha_vencimiento'] = new stdClass();
        $keys_selects['fecha_vencimiento']->cols = 6;


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
        $keys->inputs = array('codigo','descripcion','monto');
        $keys->selects = array();
        $keys->fechas = array('fecha_vencimiento');

        $init_data = array();
        $init_data['cob_cliente'] = "gamboamartin\\cobranza";
        $init_data['cob_concepto'] = "gamboamartin\\cobranza";
        $campos_view = $this->campos_view_base(init_data: $init_data,keys:  $keys);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al inicializar campo view',data:  $campos_view);
        }


        return $campos_view;
    }

    protected function inputs_children(stdClass $registro): stdClass|array
    {
        $select_cob_cliente_id = (new cob_cliente_html(html: $this->html_base))->select_cob_cliente_id(
            cols:6,con_registros: true,id_selected:  -1,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_cliente_id',data:  $select_cob_cliente_id);
        }
        $select_bn_cuenta_id = (new bn_cuenta_html(html: $this->html_base))->select_bn_cuenta_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_cliente_id',data:  $select_bn_cuenta_id);
        }

        $select_cob_concepto_id = (new cob_concepto_html(html: $this->html_base))->select_cob_concepto_id(
            cols:6,con_registros: true,id_selected:  -1,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_concepto_id',data:  $select_cob_concepto_id);
        }

        $cob_pago_descripcion = (new cob_pago_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Observaciones');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_pago_descripcion',data:  $cob_pago_descripcion);
        }

        $cob_pago_codigo = (new cob_pago_html(html: $this->html_base))->input_codigo(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Cod');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_pago_codigo',data:  $cob_pago_codigo);
        }

        $cob_deuda_id = (new cob_deuda_html(html: $this->html_base))->select_cob_deuda_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_deuda_id',data:  $cob_deuda_id);
        }

        $cob_pago_fecha_de_pago = (new cob_pago_html(html: $this->html_base))->input_fecha(
            cols:12,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Fecha de pago',
            value: date('Y-m-d'));
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_pago_fecha_de_pago',data:  $cob_pago_fecha_de_pago);
        }

        $cob_pago_monto = (new cob_pago_html(html: $this->html_base))->input_monto(
            cols:12,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Monto');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_pago_monto',data:  $cob_pago_monto);
        }

        $cat_sat_forma_pago_id = (new cat_sat_forma_pago_html(html: $this->html_base))->select_cat_sat_forma_pago_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cat_sat_forma_pago_id',data:  $cat_sat_forma_pago_id);
        }

        $cob_caja_id = (new cob_caja_html(html: $this->html_base))->select_cob_caja_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_caja_id',data:  $cob_caja_id);
        }



        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->cob_cliente_id = $select_cob_cliente_id;
        $this->inputs->select->bn_cuenta_id = $select_bn_cuenta_id;
        $this->inputs->select->cob_concepto_id = $select_cob_concepto_id;
        $this->inputs->select->cob_deuda_id = $cob_deuda_id;
        $this->inputs->select->cob_caja_id = $cob_caja_id;
        $this->inputs->select->cat_sat_forma_pago_id = $cat_sat_forma_pago_id;

        $this->inputs->cob_pago_descripcion = $cob_pago_descripcion;
        $this->inputs->cob_pago_codigo = $cob_pago_codigo;
        $this->inputs->cob_pago_fecha_de_pago = $cob_pago_fecha_de_pago;
        $this->inputs->cob_pago_monto = $cob_pago_monto;

        return $this->inputs;
    }


    protected function key_selects_txt(array $keys_selects): array
    {

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo', keys_selects: $keys_selects, place_holder: 'Cod');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'fecha_vencimiento', keys_selects: $keys_selects, place_holder: 'Fecha de vencimiento');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

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

        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_cliente_id',
            keys_selects: array(), id_selected: $this->registro['cob_cliente_id'], label: 'Cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }

        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_concepto_id',
            keys_selects: $keys_selects, id_selected: $this->registro['cob_concepto_id'], label: 'Concepto');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }


        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 6;

        $keys_selects['codigo'] = new stdClass();
        $keys_selects['codigo']->disabled = true;

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(),params_ajustados: array());
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar base',data:  $base, header: $header,ws:  $ws);
        }




        return $r_modifica;
    }
    public function pagos(bool $header = true, bool $ws = false): array|string
    {


        $data_view = new stdClass();
        $data_view->names = array('Id','Cod','Pago','Fecha de pago','Deuda','Cuenta');
        $data_view->keys_data = array('cob_pago_id', 'cob_pago_codigo','cob_pago_descripcion'
        ,'cob_pago_fecha_de_pago','cob_deuda_id','bn_cuenta_id');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\cobranza\\models';
        $data_view->name_model_children = 'cob_pago';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__, not_actions: $this->not_actions);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }





}
