<?php

namespace gamboamartin\cobranza\controllers;

use gamboamartin\cobranza\models\cob_tipo_ingreso;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\cob_tipo_ingreso_html;



use PDO;
use stdClass;

class controlador_cob_tipo_ingreso extends _ctl_parent_sin_codigo {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new cob_tipo_ingreso(link: $link);
        $html_ = new cob_tipo_ingreso_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['cob_tipo_ingreso_id']['titulo'] = 'Id';
        $datatables->columns['cob_tipo_ingreso_codigo']['titulo'] = 'Cod';
        $datatables->columns['cob_tipo_ingreso_descripcion']['titulo'] = 'Tipo Ingreso';

        $datatables->filtro = array();
        $datatables->filtro[] = 'cob_tipo_ingreso.id';
        $datatables->filtro[] = 'cob_tipo_ingreso.codigo';
        $datatables->filtro[] = 'cob_tipo_ingreso.descripcion';


        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link,
            datatables: $datatables, paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Ingreso';

    }



    protected function inputs_children(stdClass $registro): stdClass|array
    {
        $select_cob_tipo_ingreso_id = (new cob_tipo_ingreso_html(html: $this->html_base))->select_cob_tipo_ingreso_id(
            cols:12,con_registros: true,id_selected:  $registro->cob_tipo_ingreso_id,link:  $this->link);

        if(errores::$error){
            return $this->errores->error(
                mensaje: 'Error al obtener select_cob_tipo_ingreso_id',data:  $select_cob_tipo_ingreso_id);
        }
        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->cob_tipo_cliente_id = $select_cob_tipo_ingreso_id;
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
            cols: 6,key: 'descripcion', keys_selects:$keys_selects, place_holder: 'Tipo Ingreso');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        return $keys_selects;
    }



}