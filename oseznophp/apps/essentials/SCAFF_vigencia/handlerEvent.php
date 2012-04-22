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
	
		$vigencia = new vigencia;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$vigencia->beginTransaction();

			foreach ($id as $idDel){
			
				$vigencia->delete($idDel);
			
			}
			
			if ($vigencia->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($vigencia->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->closeMessageBox();

			$this->MYLIST_reload('lst_vigencia');
			
		}else{
		
			$this->messageBox($vigencia->getErrorLog(),'error');
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
 		
 		$this->modalWindow(scaffolding_vigencia::getFormAddModvigencia($idParam),htmlentities('Nueva Vigencia'),450,290,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('nombre_vigencia','id_usuario','correo_electronico','descripcion'))){
		
			$vigencia = new vigencia;
			
			if ($id)
				
			$vigencia->find($id);	
			
			$vigencia->nombre_vigencia = $datForm['nombre_vigencia'];

			$vigencia->id_usuario = $datForm['id_usuario'];

			$vigencia->correo_electronico = $datForm['correo_electronico'];

			$vigencia->descripcion = $datForm['descripcion'];
                        
                        $vigencia->fecha = $datForm['fecha'];

			if ($vigencia->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_vigencia');
 				
			}else{
				
				$this->messageBox($vigencia->getErrorLog(),'error');
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