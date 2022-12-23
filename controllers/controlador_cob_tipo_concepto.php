<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\models\cob_tipo_concepto;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\cob_cliente_html;


use html\cob_concepto_html;
use html\cob_tipo_concepto_html;
use html\cob_tipo_ingreso_html;
use PDO;
use stdClass;

class controlador_cob_tipo_concepto extends _ctl_parent_sin_codigo {

    public string $link_cob_concepto_alta_bd = '';
    public string $link_cob_tipo_ingreso_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new cob_tipo_concepto(link: $link);
        $html_ = new cob_tipo_concepto_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_tipo_concepto_id']['titulo'] = 'Id';
        $datatables->columns['cob_tipo_concepto_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_tipo_concepto_descripcion']['titulo'] = 'Tipo concepto';
        $datatables->columns['cob_tipo_concepto_n_conceptos']['titulo'] = 'N Conceptos';
        $datatables->columns['cob_tipo_ingreso_descripcion']['titulo'] = 'Tipo Ingreso';


        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_tipo_concepto.id';
        $datatables->filtro[] = 'cob_tipo_concepto.codigo';
        $datatables->filtro[] = 'cob_tipo_concepto.descripcion';


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

        $link_cob_tipo_ingreso_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_tipo_ingreso');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_tipo_ingreso_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_tipo_ingreso_alta_bd = $link_cob_tipo_ingreso_alta_bd;

    }




    public function conceptos(bool $header = true, bool $ws = false): array|string
    {


        $data_view = new stdClass();
        $data_view->names = array('Id','Cod','Concepto','Ingreso');
        $data_view->keys_data = array('cob_concepto_id', 'cob_concepto_codigo','cob_concepto_descripcion','cob_tipo_ingreso_id');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\cobranza\\models';
        $data_view->name_model_children = 'cob_concepto';



        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }


    protected function inputs_children(stdClass $registro): stdClass|array
    {
        $select_cob_tipo_concepto_id = (new cob_tipo_concepto_html(html: $this->html_base))->select_cob_tipo_concepto_id(
            cols:12,con_registros: true,id_selected:  $registro->cob_tipo_concepto_id,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_tipo_concepto_id',data:  $select_cob_tipo_concepto_id);
        }

        $select_cob_tipo_ingreso_id = (new cob_tipo_ingreso_html(html: $this->html_base))->select_cob_tipo_ingreso_id(
            cols:12,con_registros: true,id_selected:  $registro->cob_tipo_ingreso_id,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_tipo_ingreso_id',data:  $select_cob_tipo_ingreso_id);
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
        $this->inputs->select->cob_tipo_concepto_id = $select_cob_tipo_concepto_id;
        $this->inputs->select->cob_tipo_ingreso_id = $select_cob_tipo_ingreso_id;
        $this->inputs->cob_concepto_codigo = $cob_concepto_codigo;
        $this->inputs->cob_concepto_descripcion = $cob_concepto_descripcion;

        return $this->inputs;
    }

    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(
            cols: 6,key: 'codigo', keys_selects:$keys_selects, place_holder: 'Cod');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(
            cols: 6,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Tipo Concepto');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        return $keys_selects;
    }



}