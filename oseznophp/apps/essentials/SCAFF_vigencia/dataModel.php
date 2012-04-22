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
 
 class scaffolding_vigencia {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_vigencia (){
 	
 		$myForm = new OPF_myForm('FormStartUp_vigencia');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModvigencia($id){
            
                $ano = date ('Y-m-d');

		$ess_system_users = new ess_system_users;


 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModvigencia');
 		
 		$vigencia = new vigencia;
 		
 		if ($id)
 		$vigencia->find($id);
 		
		$myForm->addText('Nombre Vigencia:', 'nombre_vigencia', $vigencia->nombre_vigencia, 22, 100);
                
                //$myForm->addText($etq, $name, $value, $size, $maxlength, $validacion_numerica, $CampoFecha)

		$arrayValuesid_usuario = array();

		foreach ($ess_system_users->find() as $row){

			$arrayValuesid_usuario[$row->id] = $row->user_name;

		}

		$myForm->addSelect('Lider Vigencia:', 'id_usuario', $arrayValuesid_usuario, $vigencia->id_usuario);

		$myForm->addText('Correo Electrónico:', 'correo_electronico', $vigencia->correo_electronico, 22, 100);

		$myForm->addTextArea('Descripción:', 'descripcion', $vigencia->descripcion,70, 4);
                
                $myForm->addHidden('fecha', $ano);
                
 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_vigencia (){
 		
 		$sql = 'SELECT vigencia.id_vigencia AS "Eliminar", vigencia.id_vigencia AS "Modificar", vigencia.nombre_vigencia AS "Nombre Vigencia", rel1.user_name AS "Lider Vigencia", vigencia.correo_electronico AS "Correo Electrónico", vigencia.descripcion AS "Descripción" FROM vigencia LEFT OUTER JOIN ess_system_users rel1 ON (rel1.id = vigencia.id_usuario) ';
 		
 		$myList = new OPF_myList('lst_vigencia',$sql);
 		
 		$myList->width = 990;
 		
		$myList->setRealNameInQuery('Nombre Vigencia','vigencia.nombre_vigencia');

		$myList->setRealNameInQuery('Lider Vigencia','rel1.user_name');

		$myList->setRealNameInQuery('Correo Electrónico','vigencia.correo_electronico');

		$myList->setRealNameInQuery('Descripción','vigencia.descripcion');

 		$myList->setExportData(false,false,false);
 		
 		$myList->setPagination(true,50);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Modificar','onClickAddRecord');

 		
 		
		$myList->setWidthColumn('Nombre Vigencia', 180);

		$myList->setWidthColumn('Lider Vigencia', 140);

		$myList->setWidthColumn('Correo Electrónico', 160);

		$myList->setWidthColumn('Descripción', 420);

		$myList->setWidthColumn('Eliminar', 50);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(false);
 	}
 
 }
 
 class vigencia extends OPF_myActiveRecord {

	public $id_vigencia;

	public $nombre_vigencia;

	public $id_usuario;

	public $correo_electronico;

	public $descripcion;
        
        public $fecha;

 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

}


 
?>