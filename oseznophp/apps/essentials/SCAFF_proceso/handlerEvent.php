<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
  
/**
 * Manejador de eventos de usuario
 *
 */	
 class controller extends OPF_myController {
	
	/**
	 * Confirma la acción solicitada de eliminar uno o varios registros de la tabla.
	 */ 
	public function deleteRecordsConfirm ($id){
	
		$proceso = new proceso;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$proceso->beginTransaction();

			foreach ($id as $idDel){
			
				$proceso->delete($idDel);
			
			}
			
			if ($proceso->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($proceso->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->closeMessageBox();

			$this->MYLIST_reload('lst_proceso');
			
		}else{
		
			$this->messageBox($proceso->getErrorLog(),'error');
		}
	
		return $this->response;
	}

	/**
	 * Acción solcitida para eliminar uno o varios registros especificos.
	 */
 	public function onClickDeleteRecord ($id){
 		
 		$this->messageBox(OPF_SCAFF_46,'HELP',array(YES=>'deleteRecordsConfirm',NO),$id);
 		
 		return $this->response;
 	}
 	
	/**
	 * Evento de lanzar la ventana de nuevo registro
	 */
	 public function onClickAddRecord ($id){
 		
 		$idParam = '';
 		
 		if (!is_array($id))
 		
 			$idParam = $id;
 		
 		$this->modalWindow(scaffolding_proceso::getFormAddModproceso($idParam),htmlentities('Nuevo Proceso'),450,300,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('id_vigencia','nombre_proceso','id_usuario','correo_electronico','descripcion'))){
		
			$proceso = new proceso;
			
			if ($id)
				
				$proceso->find($id);	
			
			$proceso->id_vigencia = $datForm['id_vigencia'];

			$proceso->nombre_proceso = $datForm['nombre_proceso'];

			$proceso->id_usuario = $datForm['id_usuario'];

			$proceso->correo_electronico = $datForm['correo_electronico'];

			$proceso->descripcion = $datForm['descripcion'];

			if ($proceso->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_proceso');
 				
			}else{
				
				$this->messageBox($proceso->getErrorLog(),'error');
			}
		
		}else{
		
			$this->notificationWindow(htmlentities(MSG_CAMPOS_REQUERIDOS),3,'error');
		
		}
	
		return $this->response;
	}
	
 }

$controller = new controller();

$controller->processRequest();
 
?>