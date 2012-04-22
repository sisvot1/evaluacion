<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 
 class scaffolding_producto {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_producto (){
 	
 		$myForm = new OPF_myForm('FormStartUp_producto');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModproducto($id){

		$objetivo = new objetivo;

		$estado = new estado;

		$ess_system_users = new ess_system_users;


 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModproducto');
 		
 		$producto = new producto;

 		$valor_indicador = new valor_indicador;
 		
 		if ($id)
 			$producto->find($id);
 		
		$arrayValuesid_objetivo = array();

		foreach ($objetivo->find() as $row){

			$arrayValuesid_objetivo[$row->id_objetivo] = $row->nombre_objetivo;

		}

		$myForm->addSelect('Objetivo:', 'id_objetivo', $arrayValuesid_objetivo, $producto->id_objetivo);

		$arrayValuesid_estado = array();

		foreach ($estado->find() as $row){

			$arrayValuesid_estado[$row->id_estado] = $row->nombre_estado;

		}

		$myForm->addSelect('Estado:', 'id_estado', $arrayValuesid_estado, $producto->id_estado);

		$myForm->addText('Nombre Producto:', 'nombre_producto', $producto->nombre_producto, 22, 244);

		$arrayValuespeso = array();
                //declarar array id_producto utilizar metodo find devolvera registros su hay dentro de la fila
                // declarar array llamar al valor del atributo
		foreach ($valor_indicador->find() as $row) {
			
			$arrayValuespeso[$row->valor] = $row->valor;
		}

		$myForm->addSelect('Peso','peso', $arrayValuespeso, $producto->peso);

		$arrayValuesid_usuario = array();

		foreach ($ess_system_users->find() as $row){

			$arrayValuesid_usuario[$row->id] = $row->user_name;

		}

		$myForm->addSelect('Propietario Producto:', 'id_usuario', $arrayValuesid_usuario, $producto->id_usuario);

		$myForm->addTextArea('Descripción:', 'descripcion', $producto->descripcion,70, 4);

		$myForm->addText('Fecha Inicio:', 'fecha_inicio', $producto->fecha_inicio, 10, 12, true, true);

		$myForm->addText('Fecha Final:', 'fecha_finalizacion', $producto->fecha_finalizacion, 10, 12, true, true);

 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_producto (){
 		
                $ano = date("Y");
                
 		$sql = 'SELECT  prod.id_producto AS "Eliminar", prod.id_producto AS "Modificar", obj.nombre_objetivo AS "Objetivo", est.nombre_estado AS "Estado", prod.nombre_producto AS "Producto", users.user_name AS "Usuario",  prod.descripcion AS "Descripción",   prod.fecha_inicio AS "Fecha Inicio", prod.fecha_finalizacion AS "Fecha Final", prod.peso AS  "Peso"
                        FROM  `producto` prod, estado est, objetivo obj, ess_system_users users
                        WHERE prod.id_usuario = '.$_SESSION['user_id']."
                        AND est.id_estado = prod.id_estado
                        AND obj.id_objetivo = prod.id_objetivo
                        AND prod.id_usuario = users.id
                        AND prod.fecha_inicio like  \"%$ano%\" 
                        ";
                //\'%2012%\'
 		// if ($usuarios->find('usuario=jose & apellido='.$apellido))
 		$myList = new OPF_myList('lst_producto',$sql);
 		
 		$myList->width = 950;
                
              //$myList->setSqlDebug();
 		
		$myList->setRealNameInQuery('Objetivo','obj.nombre_objetivo');

		$myList->setRealNameInQuery('Estado','est.nombre_estado');

		$myList->setRealNameInQuery('Producto','prod.nombre_producto');

		$myList->setRealNameInQuery('Usuario','users.user_name');

		$myList->setRealNameInQuery('Descripción','prod.descripcion');

		$myList->setRealNameInQuery('Fecha Inicio','prod.fecha_inicio'); 

		$myList->setRealNameInQuery('Fecha Final','prod.fecha_finalizacion'); 
		$myList->setRealNameInQuery('Peso','prod.peso');

 		$myList->setExportData(true,true,true);
 		
 		$myList->setPagination(true,50);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Modificar','onClickAddRecord');

 		
 		
		$myList->setWidthColumn('Objetivo', 10);

		$myList->setWidthColumn('Estado', 100);

		$myList->setWidthColumn('Producto', 170);

		$myList->setWidthColumn('Uusario', 150);

		$myList->setWidthColumn('Descripción', 250);

		$myList->setWidthColumn('Fecha Inicio', 90); 

		$myList->setWidthColumn('Fecha Final', 90);  

		$myList->setWidthColumn('Peso', 10);

		$myList->setWidthColumn('Eliminar', 40);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(true,true);
 	}
 
 }
 
 class producto extends OPF_myActiveRecord {

	public $id_producto;

	public $id_objetivo;

	public $id_estado;

	public $nombre_producto;

	public $id_usuario;

	public $descripcion;

	public $fecha_inicio;

	public $fecha_finalizacion;

	public $peso;

 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 class objetivo extends OPF_myActiveRecord {

	public $id_objetivo;

	public $nombre_objetivo;

}

class estado extends OPF_myActiveRecord {

	public $id_estado;

	public $nombre_estado;

}

class valor_indicador extends OPF_myActiveRecord {

    public $id_valor_indicador;
        
    public $valor;
}

class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

}
 
?>