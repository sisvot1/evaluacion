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
	
		$producto = new producto;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$producto->beginTransaction();

			foreach ($id as $idDel){
			
				$producto->delete($idDel);
			
			}
			
			if ($producto->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($producto->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->closeMessageBox();

			$this->MYLIST_reload('lst_producto');
			
		}else{
		
			$this->messageBox($producto->getErrorLog(),'error');
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
 		
 		$this->modalWindow(scaffolding_producto::getFormAddModproducto($idParam),htmlentities('Nuevo Producto'),450,360,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('id_objetivo','id_estado','nombre_producto','id_usuario','descripcion','fecha_inicio','fecha_finalizacion', 'peso'))){
		
			$producto = new producto;
			
			if ($id)
				
			$producto->find($id);	
			
			$producto->id_objetivo = $datForm['id_objetivo'];

			$producto->id_estado = $datForm['id_estado'];

			$producto->nombre_producto = $datForm['nombre_producto'];

			$producto->id_usuario = $datForm['id_usuario'];

			$producto->descripcion = $datForm['descripcion'];

			$producto->fecha_inicio = $datForm['fecha_inicio'];

			$producto->fecha_finalizacion = $datForm['fecha_finalizacion'];

			$producto->peso = $datForm['peso'];

			if ($producto->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_producto');
 				
			}else{
				
				$this->messageBox($producto->getErrorLog(),'error');
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