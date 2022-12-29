<?php
namespace gamboamartin\cobranza\models;
use base\orm\_modelo_parent;
use PDO;

class cob_cliente extends _modelo_parent {

    public function __construct(PDO $link){
        $tabla = 'cob_cliente';
        $columnas = array($tabla=>false,'cob_tipo_cliente'=>$tabla,'org_sucursal'=>$tabla,'org_empresa'=>'org_sucursal');
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'descripcion_select';

        $tipo_campos['codigos'] = 'cod_1_letras_mayusc';



        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }


}