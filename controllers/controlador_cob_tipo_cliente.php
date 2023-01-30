<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\html\cob_cliente_html;
use gamboamartin\cobranza\html\cob_tipo_cliente_html;
use gamboamartin\cobranza\models\cob_tipo_cliente;
use gamboamartin\errores\errores;
use gamboamartin\organigrama\html\org_sucursal_html;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;

use PDO;
use stdClass;

class controlador_cob_tipo_cliente extends _ctl_parent_sin_codigo {

    public string $link_cob_cliente_alta_bd = '';
    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new cob_tipo_cliente(link: $link);
        $html_ = new cob_tipo_cliente_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_tipo_cliente_id']['titulo'] = 'Id';
        $datatables->columns['cob_tipo_cliente_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_tipo_cliente_descripcion']['titulo'] = 'Tipo cliente';
        $datatables->columns['cob_tipo_cliente_n_clientes']['titulo'] = 'N Clientes';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_tipo_cliente.id';
        $datatables->filtro[] = 'cob_tipo_cliente.codigo';
        $datatables->filtro[] = 'cob_tipo_cliente.descripcion';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Cliente';

        $link_cob_cliente_alta_bd = $this->obj_link->link_alta_bd(link: $link, seccion: 'cob_cliente');
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al obtener link',data:  $link_cob_cliente_alta_bd);
            print_r($error);
            exit;
        }
        $this->link_cob_cliente_alta_bd = $link_cob_cliente_alta_bd;

        $this->lista_get_data = true;
    }


    public function clientes(bool $header = true, bool $ws = false): array|string
    {


        $data_view = new stdClass();
        $data_view->names = array('Id','Cod','Cliente');
        $data_view->keys_data = array('cob_cliente_id', 'cob_cliente_codigo','cob_cliente_descripcion');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\cobranza\\models';
        $data_view->name_model_children = 'cob_cliente';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__, not_actions: $this->not_actions);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;


    }


    protected function inputs_children(stdClass $registro): stdClass|array
    {

        $cob_cliente_codigo = (new cob_cliente_html(html: $this->html_base))->input_codigo(
            cols:6,row_upd:  new stdClass(),value_vacio:  false);
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_codigo',data:  $cob_cliente_codigo);
        }

        $cob_cliente_codigo_bis = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Cod Bis');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_codigo_bis',data:  $cob_cliente_codigo_bis);
        }

        $cob_cliente_descripcion = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Cliente');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_descripcion',data:  $cob_cliente_descripcion);
        }

        $cob_cliente_nombre = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Nombre');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_nombre',data:  $cob_cliente_nombre);
        }

        $cob_cliente_ap = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'AP');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_ap',data:  $cob_cliente_ap);
        }

        $cob_cliente_am = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'AM');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_am',data:  $cob_cliente_am);
        }

        $cob_cliente_curp = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Curp');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_curp',data:  $cob_cliente_curp);
        }


        $cob_cliente_razon_social = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:6,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'Razon social');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_razon_social',data:  $cob_cliente_razon_social);
        }

        $cob_cliente_rfc = (new cob_cliente_html(html: $this->html_base))->input_descripcion(
            cols:12,row_upd:  new stdClass(),value_vacio:  false,place_holder: 'RFC');
        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener cob_cliente_rfc',data:  $cob_cliente_rfc);
        }

        $select_cob_tipo_cliente_id = (new cob_tipo_cliente_html(html: $this->html_base))->select_cob_tipo_cliente_id(
            cols:12,con_registros: true,id_selected:  $registro->cob_tipo_cliente_id,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_adm_menu_id',data:  $select_cob_tipo_cliente_id);
        }

        $select_org_sucursal_id = (new org_sucursal_html(html: $this->html_base))->select_org_sucursal_id(
            cols:12,con_registros: true,id_selected:  -1,link:  $this->link,label: 'Empresa');

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_adm_menu_id',data:  $select_org_sucursal_id);
        }






        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->cob_tipo_cliente_id = $select_cob_tipo_cliente_id;
        $this->inputs->select->org_sucursal_id = $select_org_sucursal_id;
        $this->inputs->cob_cliente_codigo = $cob_cliente_codigo;
        $this->inputs->cob_cliente_codigo_bis = $cob_cliente_codigo_bis;
        $this->inputs->cob_cliente_nombre = $cob_cliente_nombre;
        $this->inputs->cob_cliente_ap = $cob_cliente_ap;
        $this->inputs->cob_cliente_am = $cob_cliente_am;
        $this->inputs->cob_cliente_curp = $cob_cliente_curp;
        $this->inputs->cob_cliente_descripcion = $cob_cliente_descripcion;
        $this->inputs->cob_cliente_razon_social = $cob_cliente_razon_social;
        $this->inputs->cob_cliente_rfc = $cob_cliente_rfc;

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
            cols: 12,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Tipo Cliente');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }



        return $keys_selects;
    }



}