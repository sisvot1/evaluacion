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
 
 class scaffolding_estado {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_estado (){
 	
 		$myForm = new OPF_myForm('FormStartUp_estado');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModestado($id){

 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModestado');
 		
 		$estado = new estado;
 		
 		if ($id)
 			$estado->find($id);
 		
		$myForm->addText('Nombre estado:', 'nombre_estado', $estado->nombre_estado);

 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_estado (){
 		
 		$sql = 'SELECT estado.id_estado AS "Eliminar", estado.id_estado AS "Modificar", estado.nombre_estado AS "Nombre estado" FROM estado';
 		
 		$myList = new OPF_myList('lst_estado',$sql);
 		
 		$myList->width = 290;
 		
		$myList->setRealNameInQuery('Nombre estado','estado.nombre_estado');

 		$myList->setExportData(false,false,false);
 		
 		$myList->setPagination(true,50);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Modificar','onClickAddRecord');

 		
 		
		$myList->setWidthColumn('Nombre estado', 200);

		$myList->setWidthColumn('Eliminar', 50);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(false);
 	}
 
 }
 
 class estado extends OPF_myActiveRecord {

	public $id_estado;

	public $nombre_estado;

 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 
 
?>