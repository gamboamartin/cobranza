<?php
namespace gamboamartin\cobranza\models;
use base\orm\_modelo_parent;
use PDO;

class cob_tipo_cliente extends _modelo_parent{

    public function __construct(PDO $link){
        $tabla = 'cob_tipo_cliente';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'descripcion_select';

        $tipo_campos['codigos'] = 'cod_1_letras_mayusc';

        $columnas_extra['cob_tipo_cliente_n_clientes'] = /** @lang sql */
            "(SELECT COUNT(*) FROM cob_cliente WHERE cob_cliente.cob_tipo_cliente_id = cob_tipo_cliente.id)";


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, columnas_extra: $columnas_extra, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }


}