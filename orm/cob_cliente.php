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

        $columnas_extra['cob_cliente_n_deudas'] = /** @lang sql */
            "(SELECT COUNT(*) FROM cob_deuda WHERE cob_deuda.cob_cliente_id = cob_cliente.id)";




        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, columnas_extra: $columnas_extra, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }


}