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
 
 class scaffolding_objetivo {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_objetivo (){
 	
 		$myForm = new OPF_myForm('FormStartUp_objetivo');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModobjetivo($id){

		$proceso = new proceso;

		$ess_system_users = new ess_system_users;


 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModobjetivo');
 		
 		$objetivo = new objetivo;
 		
 		if ($id)
 			$objetivo->find($id);
 		
		$arrayValuesid_proceso = array();

		foreach ($proceso->find() as $row){

			$arrayValuesid_proceso[$row->id_proceso] = $row->nombre_proceso;

		}

		$myForm->addSelect('Nombre Proceso:', 'id_proceso', $arrayValuesid_proceso, $objetivo->id_proceso);

		$myForm->addText('Objetivo:', 'nombre_objetivo', $objetivo->nombre_objetivo, 22, 120);

		$arrayValuesid_usuario = array();

		foreach ($ess_system_users->find() as $row){

			$arrayValuesid_usuario[$row->id] = $row->user_name;

		}

		$myForm->addSelect('Responsable Objetivo:', 'id_usuario', $arrayValuesid_usuario, $objetivo->id_usuario);

		$myForm->addText('Fecha Inicio:', 'fecha_inicio', $objetivo->fecha_inicio, 10, 12, true, true);
                
                
		$myForm->addText('Fecha Final:', 'fecha_finalizacion', $objetivo->fecha_finalizacion, 10, 12, true, true);

		$myForm->addTextArea('Descripción:', 'descripcion', $objetivo->descripcion,70, 4);

 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_objetivo (){
 		
 		$sql = 'SELECT objetivo.id_objetivo AS "Eliminar", objetivo.id_objetivo AS "Modificar", rel1.nombre_proceso AS "Nombre Proceso", objetivo.nombre_objetivo AS "Objetivo", rel2.user_name AS "Responsable Objetivo", objetivo.fecha_inicio AS "Fecha Inicio", objetivo.fecha_finalizacion AS "Fecha Final", objetivo.descripcion AS "Descripción" FROM objetivo LEFT OUTER JOIN proceso rel1 ON (rel1.id_proceso = objetivo.id_proceso)  LEFT OUTER JOIN ess_system_users rel2 ON (rel2.id = objetivo.id_usuario) ';
 		
 		$myList = new OPF_myList('lst_objetivo',$sql);
 		
 		$myList->width = 980; 
 		
		$myList->setRealNameInQuery('Nombre Proceso','rel1.nombre_proceso');

		$myList->setRealNameInQuery('Objetivo','objetivo.nombre_objetivo');

		$myList->setRealNameInQuery('Responsable Objetivo','rel2.user_name');

		$myList->setRealNameInQuery('Fecha Inicio','objetivo.fecha_inicio');

		$myList->setRealNameInQuery('Fecha Final','objetivo.fecha_finalizacion');

		$myList->setRealNameInQuery('Descripción','objetivo.descripcion');

 		$myList->setExportData(true,true,true);
 		
 		$myList->setPagination(true,50);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Modificar','onClickAddRecord');

 		
 		
		$myList->setWidthColumn('Nombre Proceso', 270);

		$myList->setWidthColumn('Objetivo', 40);

		$myList->setWidthColumn('Responsable Objetivo', 150);

		$myList->setWidthColumn('Fecha Inicio', 90);

		$myList->setWidthColumn('Fecha Final', 90);

		$myList->setWidthColumn('Descripción', 250);

		$myList->setWidthColumn('Eliminar', 50);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(true,true);
 	}
 
 }
 
 class objetivo extends OPF_myActiveRecord {

	public $id_objetivo;

	public $id_proceso;

	public $nombre_objetivo;

	public $id_usuario;

	public $fecha_inicio;

	public $fecha_finalizacion;

	public $descripcion;

 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 class proceso extends OPF_myActiveRecord {

	public $id_proceso;

	public $nombre_proceso;

}

class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

}


 
?>