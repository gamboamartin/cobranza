<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\html\cob_subscripcion_html;
use gamboamartin\cobranza\models\cob_subscripcion;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_base;
use gamboamartin\system\links_menu;

use gamboamartin\template\html;
use PDO;
use stdClass;

class controlador_cob_subscripcion extends _ctl_base {

    public string $link_cob_deuda_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){

        $modelo = new cob_subscripcion(link: $link);
        $html_ = new cob_subscripcion_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_cliente_id']['titulo'] = 'Id';
        $datatables->columns['cob_cliente_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_cliente_descripcion']['titulo'] = 'Cliente';
        $datatables->columns['cob_cliente_n_deudas']['titulo'] = 'N Deudas';
        $datatables->columns['cob_cliente_nombre']['titulo'] = 'Nombre';
        $datatables->columns['cob_cliente_ap']['titulo'] = 'AP';
        $datatables->columns['cob_cliente_am']['titulo'] = 'AM';
        $datatables->columns['cob_tipo_cliente_descripcion']['titulo'] = 'Tipo Cliente';
        $datatables->columns['org_sucursal_descripcion']['titulo'] = 'Sucursal';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_cliente.id';
        $datatables->filtro[] = 'cob_cliente.codigo';
        $datatables->filtro[] = 'cob_cliente.descripcion';
        $datatables->filtro[] = 'cob_cliente.nombre';
        $datatables->filtro[] = 'cob_cliente.ap';
        $datatables->filtro[] = 'cob_cliente.am';
        $datatables->filtro[] = 'cob_tipo_cliente.descripcion';
        $datatables->filtro[] = 'org_sucursal.descripcion';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Cliente';

        $link_cob_deuda_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_deuda');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_deuda_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_deuda_alta_bd = $link_cob_deuda_alta_bd;

        $this->lista_get_data = true;
    }

    public function alta(bool $header, bool $ws = false): array|string
    {

        $r_alta = $this->init_alta();
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al inicializar alta',data:  $r_alta, header: $header,ws:  $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_cliente_id',
            keys_selects: array(), id_selected: -1, label: 'Tipo Cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'org_sucursal_id',
            keys_selects: $keys_selects, id_selected: -1, label: 'Empresa');
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
        $keys->inputs = array('codigo', 'codigo_bis','descripcion','nombre','ap','am','razon_social','rfc','curp');
        $keys->selects = array();

        $init_data = array();
        $init_data['cob_tipo_cliente'] = "gamboamartin\\cobranza";
        $init_data['org_sucursal'] = "gamboamartin\\organigrama";
        $campos_view = $this->campos_view_base(init_data: $init_data,keys:  $keys);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al inicializar campo view',data:  $campos_view);
        }


        return $campos_view;
    }

    protected function key_selects_txt(array $keys_selects): array
    {

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo', keys_selects: $keys_selects, place_holder: 'Cod');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo_bis', keys_selects: $keys_selects, place_holder: 'Cod Bis');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Cliente');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'nombre', keys_selects:$keys_selects, place_holder: 'Nombre');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'ap', keys_selects:$keys_selects, place_holder: 'AP');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'am', keys_selects:$keys_selects, place_holder: 'AM', required: false);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'razon_social', keys_selects:$keys_selects, place_holder: 'Razon Social');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12,key: 'rfc', keys_selects:$keys_selects, place_holder: 'RFC');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'curp', keys_selects:$keys_selects, place_holder: 'CURP');
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


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_cliente_id',
            keys_selects: array(), id_selected: $this->registro['cob_tipo_cliente_id'], label: 'Tipo Cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }

        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'org_sucursal_id',
            keys_selects: $keys_selects, id_selected: $this->registro['org_sucursal_id'], label: 'Empresa');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }


        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 6;





        $base = $this->base_upd(keys_selects: $keys_selects, params: array(),params_ajustados: array());
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


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__, not_actions: $this->not_actions);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }






}
