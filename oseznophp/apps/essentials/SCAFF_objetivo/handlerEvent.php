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
	
		$objetivo = new objetivo;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$objetivo->beginTransaction();

			foreach ($id as $idDel){
			
				$objetivo->delete($idDel);
			
			}
			
			if ($objetivo->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($objetivo->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->closeMessageBox();

			$this->MYLIST_reload('lst_objetivo');
			
		}else{
		
			$this->messageBox($objetivo->getErrorLog(),'error');
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
 		
 		$this->modalWindow(scaffolding_objetivo::getFormAddModobjetivo($idParam),htmlentities('Nuevo Objetivo'),450,300,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('id_proceso','nombre_objetivo','id_usuario','fecha_inicio','fecha_finalizacion','descripcion'))){
		
			$objetivo = new objetivo;
			
			if ($id)
				
				$objetivo->find($id);	
			
			$objetivo->id_proceso = $datForm['id_proceso'];

			$objetivo->nombre_objetivo = $datForm['nombre_objetivo'];

			$objetivo->id_usuario = $datForm['id_usuario'];

			$objetivo->fecha_inicio = $datForm['fecha_inicio'];

			$objetivo->fecha_finalizacion = $datForm['fecha_finalizacion'];

			$objetivo->descripcion = $datForm['descripcion'];

			if ($objetivo->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_objetivo');
 				
			}else{
				
				$this->messageBox($objetivo->getErrorLog(),'error');
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