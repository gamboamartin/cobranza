<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\html\cob_concepto_html;
use gamboamartin\cobranza\html\cob_tipo_concepto_html;
use gamboamartin\cobranza\models\cob_tipo_concepto;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_base;
use gamboamartin\system\links_menu;

use gamboamartin\template\html;


use PDO;
use stdClass;

class controlador_cob_tipo_concepto extends _ctl_base {
public string $link_cob_concepto_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){


        $modelo = new cob_tipo_concepto(link: $link);
        $html_ = new cob_tipo_concepto_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_tipo_concepto_id']['titulo'] = 'Id';
        $datatables->columns['cob_tipo_concepto_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_tipo_concepto_descripcion']['titulo'] = 'Tipo Concepto';
        $datatables->columns['cob_tipo_ingreso_descripcion']['titulo'] = 'Tipo Ingreso';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_tipo_concepto.id';
        $datatables->filtro[] = 'cob_tipo_concepto.codigo';
        $datatables->filtro[] = 'cob_tipo_concepto.descripcion';
        $datatables->filtro[] = 'cob_tipo_ingreso.descripcion';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Concepto';
        $link_cob_concepto_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_concepto');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_concepto_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_concepto_alta_bd = $link_cob_concepto_alta_bd;

        $this->lista_get_data = true;
    }

    public function conceptos(bool $header = true, bool $ws = false): array|string
    {


        $data_view = new stdClass();
        $data_view->names = array('Id','Cod','Concepto');
        $data_view->keys_data = array('cob_concepto_id', 'cob_concepto_codigo','cob_concepto_descripcion');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\cobranza\\models';
        $data_view->name_model_children = 'cob_concepto';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__, not_actions: $this->not_actions);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }


    public function alta(bool $header, bool $ws = false): array|string
    {

        $r_alta = $this->init_alta();
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al inicializar alta',data:  $r_alta, header: $header,ws:  $ws);
        }


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_ingreso_id',
            keys_selects: array(), id_selected: -1, label: 'Tipo Ingreso');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }



        $keys_selects['descripcion'] = new stdClass();
        $keys_selects['descripcion']->cols = 12;



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
        $init_data['cob_tipo_ingreso'] = "gamboamartin\\cobranza";
        $campos_view = $this->campos_view_base(init_data: $init_data,keys:  $keys);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al inicializar campo view',data:  $campos_view);
        }


        return $campos_view;
    }

    protected function inputs_children(stdClass $registro): stdClass|array
    {
        $cob_concepto_id = (new cob_concepto_html(html: $this->html_base))->input_codigo(
            cols:6,row_upd:  new stdClass(),value_vacio:  false);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_concepto_id',data:  $cob_concepto_id);
        }

        $cob_concepto_codigo = (new cob_concepto_html(html: $this->html_base))->input_codigo(
            cols:6,row_upd:  new stdClass(),value_vacio:  false);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_concepto_codigo',data:  $cob_concepto_codigo);
        }

        $cob_concepto_descripcion = (new cob_concepto_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Concepto');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_concepto_descripcion',data:  $cob_concepto_descripcion);
        }


        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->cob_concepto_id = $cob_concepto_id;
        $this->inputs->cob_concepto_codigo = $cob_concepto_codigo;
        $this->inputs->cob_concepto_descripcion = $cob_concepto_descripcion;



        return $this->inputs;
    }


    protected function key_selects_txt(array $keys_selects): array
    {

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo', keys_selects: $keys_selects, place_holder: 'Cod');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Tipo Concepto');
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


        $keys_selects = $this->key_select(cols:12, con_registros: true,filtro:  array(), key: 'cob_tipo_ingreso_id',
            keys_selects: array(), id_selected: $this->registro['cob_tipo_ingreso_id'], label: 'Tipo Ingreso');
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




}
