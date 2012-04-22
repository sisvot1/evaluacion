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
 
 class scaffolding_proceso {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_proceso (){
 	
 		$myForm = new OPF_myForm('FormStartUp_proceso');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModproceso($id){

		$vigencia = new vigencia;

		$ess_system_users = new ess_system_users;


 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModproceso');
 		
 		$proceso = new proceso;
 		
 		if ($id)
 			$proceso->find($id);
 		
		$arrayValuesid_vigencia = array();

		foreach ($vigencia->find() as $row){

			$arrayValuesid_vigencia[$row->id_vigencia] = $row->nombre_vigencia;

		}

		$myForm->addSelect('Nombre Vigencia:', 'id_vigencia', $arrayValuesid_vigencia, $proceso->id_vigencia);

		$myForm->addText('Nombre Proceso:', 'nombre_proceso', $proceso->nombre_proceso, 22, 120);

		$arrayValuesid_usuario = array();

		foreach ($ess_system_users->find() as $row){

			$arrayValuesid_usuario[$row->id] = $row->user_name;

		}

		$myForm->addSelect('Lider Proceso:', 'id_usuario', $arrayValuesid_usuario, $proceso->id_usuario);

		$myForm->addText('Correo Electrónico:', 'correo_electronico', $proceso->correo_electronico, 22, 100);

		$myForm->addTextArea('Descripción:', 'descripcion', $proceso->descripcion,70, 4);

 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_proceso (){
 		
 		$sql = 'SELECT proceso.id_proceso AS "Eliminar", proceso.id_proceso AS "Modificar", rel1.nombre_vigencia AS "Nombre Vigencia", proceso.nombre_proceso AS "Proceso", rel2.user_name AS "Lider Proceso", proceso.correo_electronico AS "Correo Electrónico", proceso.descripcion AS "Descripción" FROM proceso LEFT OUTER JOIN vigencia rel1 ON (rel1.id_vigencia = proceso.id_vigencia)  LEFT OUTER JOIN ess_system_users rel2 ON (rel2.id = proceso.id_usuario) ';
 		
 		$myList = new OPF_myList('lst_proceso',$sql);
 		
 		$myList->width = 990;
 		
		$myList->setRealNameInQuery('Nombre Vigencia','rel1.nombre_vigencia');

		$myList->setRealNameInQuery('Proceso','proceso.nombre_proceso');

		$myList->setRealNameInQuery('Lider Proceso','rel2.user_name');

		$myList->setRealNameInQuery('Correo Electrónico','proceso.correo_electronico');

		$myList->setRealNameInQuery('Descripción','proceso.descripcion');

 		$myList->setExportData(true,true,true);
 		
 		$myList->setPagination(true,30);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Modificar','onClickAddRecord');

 		
 		
		$myList->setWidthColumn('Nombre Vigencia', 190);

		$myList->setWidthColumn('Proceso', 110);

		$myList->setWidthColumn('Lider Proceso', 150);

		$myList->setWidthColumn('Correo Electrónico', 150);

		$myList->setWidthColumn('Descripción', 300);

		$myList->setWidthColumn('Eliminar', 50);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(true,true);
 	}
 
 }
 
 class proceso extends OPF_myActiveRecord {

	public $id_proceso;

	public $id_vigencia;

	public $nombre_proceso;

	public $id_usuario;

	public $correo_electronico;

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
 
 class vigencia extends OPF_myActiveRecord {

	public $id_vigencia;

	public $nombre_vigencia;

}

class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

}


 
?>