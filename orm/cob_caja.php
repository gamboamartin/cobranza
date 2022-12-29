<?php
namespace gamboamartin\cobranza\models;
use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class cob_caja extends _modelo_parent {

    public function __construct(PDO $link){
        $tabla = 'cob_caja';
        $columnas = array($tabla=>false,'bn_cuenta'=>$tabla,'org_sucursal'=>'bn_cuenta',
            'org_tipo_sucursal'=>'org_sucursal','org_empresa'=>'org_sucursal','org_tipo_empresa'=>'org_empresa',
            'bn_sucursal'=>'bn_cuenta','bn_tipo_sucursal'=>'bn_sucursal','bn_banco'=>'bn_sucursal',
            'bn_tipo_banco'=>'bn_banco','bn_tipo_cuenta'=>'bn_cuenta','bn_empleado'=>'bn_cuenta');
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'descripcion_select';

        $tipo_campos['codigos'] = 'cod_1_letras_mayusc';



        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }




}