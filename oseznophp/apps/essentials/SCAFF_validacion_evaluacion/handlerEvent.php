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
	
		$evaluacion_indicadores = new evaluacion_indicadores;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$evaluacion_indicadores->beginTransaction();

			foreach ($id as $idDel){
			
				$evaluacion_indicadores->delete($idDel);
			
			}
			
			if ($evaluacion_indicadores->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($evaluacion_indicadores->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->closeMessageBox();

			$this->MYLIST_reload('lst_evaluacion_indicadores');
			
		}else{
		
			$this->messageBox($evaluacion_indicadores->getErrorLog(),'error');
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
 		
 		$this->modalWindow(scaffolding_evaluacion_indicadores::getFormAddModevaluacion_indicadores($idParam),htmlentities('Avances Producto'),650,520,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('peso','recurso','proceso','producto','cliente','puntaje_ponderado','descripcion','fecha_modificacion','compromisos','id_producto'))){
		
			$evaluacion_indicadores = new evaluacion_indicadores;
			
			if ($id)
				
			$evaluacion_indicadores->find($id);	
			
			$evaluacion_indicadores->peso = $datForm['peso'];

			$evaluacion_indicadores->recurso = $datForm['recurso'];

			$evaluacion_indicadores->proceso = $datForm['proceso'];

			$evaluacion_indicadores->producto = $datForm['producto'];

			$evaluacion_indicadores->cliente = $datForm['cliente'];

			$evaluacion_indicadores->puntaje_ponderado = $datForm['puntaje_ponderado'];

			$evaluacion_indicadores->descripcion = $datForm['descripcion'];

			$evaluacion_indicadores->fecha_modificacion = $datForm['fecha_modificacion'];

			$evaluacion_indicadores->compromisos = $datForm['compromisos'];

			$evaluacion_indicadores->id_producto = $datForm['id_producto'];

    			$evaluacion_indicadores->validacion = $datForm['validacion'];

			if ($evaluacion_indicadores->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_evaluacion_indicadores');
 				
			}else{
				
				$this->messageBox($evaluacion_indicadores->getErrorLog(),'error');
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