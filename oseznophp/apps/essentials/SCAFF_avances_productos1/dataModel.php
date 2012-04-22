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
 
 class scaffolding_evaluacion_indicadores {
     /*
      * Formulario informacion
      */
     public static function formulario_info()
	{   
                $ano = date ('Y');
                
                $myAct = new OPF_myActiveRecord();
                
                $myForm = new OPF_myForm('formulario_info');
                                                                                            
                if ($res = $myAct->query ("SELECT vig.nombre_vigencia, users.name, users.lastname, users.user_name   
                                            FROM producto prod, objetivo obj, proceso pro, vigencia vig, ess_system_users users
                                            WHERE vig.fecha like \"%$ano%\"
                                            AND prod.id_objetivo = obj.id_objetivo
                                            AND obj.id_proceso = pro.id_proceso
                                            AND pro.id_vigencia = vig.id_vigencia
                                            AND users.id = ".$_SESSION['user_id']." 
                                            LIMIT 0 , 1 ")){
                                                                        

                   if (isset ($res))
                   { 
                    foreach($res as $row)
                        
                $myForm->addText('Vigencia: ', 'vigencia', $row->nombre_vigencia, '38' ); //$value  
                
                $myForm->addText('Colaborador: ', 'responsable',$row->name." ".$row->lastname , '38' ); //$value 
                
                $myForm->addText('Usuario: ', 'Usuario',$row->user_name, '38' ); //$value 
                   }
                }

                //$myForm->addGroup('grupo1','Información Producto:',array( 'vigencia',  'nombre_objetivo',  'estado', 'responsable', 'Usuario', 'nombre_proceso'),1);
                
                $myForm->width = 200;
                
                $myForm->addDisabled('vigencia');
                //$myForm->addDisabled('nombre_proceso');
                //$myForm->addDisabled('nombre_objetivo');
                //$myForm->addDisabled('estado');
                $myForm->addDisabled('responsable');
                $myForm->addDisabled('Usuario');
                
                
                return $myForm->getForm(1);
	}
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	/*public static function getFormStartUp_evaluacion_indicadores (){
 	
 		$myForm = new OPF_myForm('FormStartUp_evaluacion_indicadores');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}*/
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddModevaluacion_indicadores($id){

		$producto = new producto;

		$valor_indicador = new valor_indicador;

                $ano = date("Y-m-d");
                
 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModevaluacion_indicadores');
 		
 		$evaluacion_indicadores = new evaluacion_indicadores;
 		
 		if ($id)
 			$evaluacion_indicadores->find($id);
                
                $myForm->addTextArea('Proceso:', 'nombre_proceso', 'Gerencia de innovación y desarrollo de tecnologías de información y comunicación', 80); //despues del nombre del objeto:2 
                
                $myForm->addText('objetivo:', 'nombre_objetivo', '1.01', 22);
                
                $myForm->addText('Estado:', 'nombre_estado', 'Mejoramiento', 22);
                
                $myForm->addTextArea('Producto:', 'nombre_producto', 'Matricculas estudiantes facultada Ingenieria', 80);

                $myForm->addGroup('grupo1', 'Información', array('nombre_proceso','nombre_objetivo','nombre_estado','nombre_producto'), 1);
                
                $myForm->addtext('Peso:', 'peso:2', '5', 2);

		$arrayValuesrecurso = array();

		foreach ($valor_indicador->find() as $row){

			$arrayValuesrecurso[$row->valor] = $row->valor;

		}

		$myForm->addSelect('Recurso:', 'recurso', $arrayValuesrecurso, $evaluacion_indicadores->recurso);
                

		$arrayValuesproceso = array();

		foreach ($valor_indicador->find() as $row){

			$arrayValuesproceso[$row->valor] = $row->valor;

		}

		$myForm->addSelect('Proceso:', 'proceso', $arrayValuesproceso, $evaluacion_indicadores->proceso);

		$arrayValuesproducto = array();

		foreach ($valor_indicador->find() as $row){

			$arrayValuesproducto[$row->valor] = $row->valor;

		}

		$myForm->addSelect('Producto:', 'producto', $arrayValuesproducto, $evaluacion_indicadores->producto);

		$arrayValuescliente = array();

		foreach ($valor_indicador->find() as $row){

			$arrayValuescliente[$row->valor] = $row->valor;

		}

		$myForm->addSelect('Cliente:', 'cliente', $arrayValuescliente, $evaluacion_indicadores->cliente);
                
                $myForm->addtext('Puntaje Ponderado:', 'puntaje_ponderado:2', '5', 2);
                
                $myForm->addHidden('fecha_modificacion', $ano);
		
		$myForm->addTextArea('Descripción:', 'descripcion', $evaluacion_indicadores->descripcion,90, 3);
                
                $myForm->addGroup('grupo2', 'Avances', array('peso','recurso','proceso','producto','cliente','puntaje_ponderado'), 2);
                
                $myForm->addHidden('validacion','2');
                
                $myForm->addHidden('id_usuario',$_SESSION['user_id']);
                
                $myForm->addDisabled('nombre_proceso');
                
                $myForm->addDisabled('nombre_objetivo');
                
                $myForm->addDisabled('nombre_estado');
                
                $myForm->addDisabled('nombre_producto');
                
                $myForm->addDisabled('peso');
                
                $myForm->addDisabled('puntaje_ponderado');
                
 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_evaluacion_indicadores (){
 		
 		$sql = 'SELECT prod.id_producto AS "Avance Producto", prod.nombre_producto AS  "Producto", prod.peso AS  "Peso", prod.fecha_inicio AS  "Fecha Inicio", prod.fecha_finalizacion AS  "Fecha Final"
                          FROM producto prod
                           WHERE prod.id_usuario = '.$_SESSION['user_id'].''; //PENDIENTE COLOCAR EL FILTRO DE LA AÑOOOOO
 		
 		$myList = new OPF_myList('lst_evaluacion_indicadores',$sql);
 		
 		$myList->width = 730;
 		
		$myList->setRealNameInQuery('Producto','prod.nombre_producto ');

		$myList->setRealNameInQuery('Peso','prod.peso');

		$myList->setRealNameInQuery('Fecha Inicio','prod.fecha_inicio');

		$myList->setRealNameInQuery('Fecha Final','prod.fecha_finalizacion');

		$myList->setExportData(false,false,false);
 		
 		$myList->setPagination(true,10);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Avance Producto','onClickAddRecord');

 		//$myList->setGlobalEventOnColumn('Eliminar', array('Eliminar'=>'onClickDeleteRecord') );
 		
		$myList->setWidthColumn('Producto', 300); 

		$myList->setWidthColumn('Peso', 10);

		$myList->setWidthColumn('Fecha Inicio', 130);

		$myList->setWidthColumn('Fecha Final', 130);

		$myList->setWidthColumn('Avance Producto', 160);

 		return $myList->getList(false,false);
 	}
        
        /**
 	 * Lista dinámica de los registros evaluacion indicadores
 	 */
 	public function getList_evaluacion_indicadores1 (){
 		
 		$sql = 'SELECT prod.nombre_producto AS  "Nombre Producto", eva.peso AS  "Peso", eva.recurso AS  "Recurso", eva.proceso "Proceso", eva.producto AS  "Producto", eva.cliente AS  "Cliente", eva.puntaje_ponderado AS  "Puntaje Ponderado", eva.descripcion AS "Descripción", eva.fecha_modificacion AS  "Fecha Modificación", eva.validacion AS  "Validación"
                            FROM evaluacion_indicadores eva, producto prod
                            WHERE eva.id_producto = prod.id_producto
                            AND eva.id_usuario = '.$_SESSION['user_id'].'
                            '; //validar anooooooooooo ademas enmarcar las etiquetas correspondientes a set realname y de ahi de para abajoooooo...
 		
 		$myList = new OPF_myList('lst_evaluacion_indicadores1',$sql);
 		
 		$myList->width = 730;
 		
		$myList->setRealNameInQuery('Producto','prod.nombre_producto ');

		$myList->setRealNameInQuery('Peso','prod.peso');

		$myList->setRealNameInQuery('Fecha Inicio','prod.fecha_inicio');

		$myList->setRealNameInQuery('Fecha Final','prod.fecha_finalizacion');

		$myList->setExportData(false,false,false);
 		
 		$myList->setPagination(true,10);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Avance Producto','onClickAddRecord');

 		//$myList->setGlobalEventOnColumn('Eliminar', array('Eliminar'=>'onClickDeleteRecord') );
 		
		$myList->setWidthColumn('Producto', 300); 

		$myList->setWidthColumn('Peso', 10);

		$myList->setWidthColumn('Fecha Inicio', 130);

		$myList->setWidthColumn('Fecha Final', 130);

		$myList->setWidthColumn('Avance Producto', 160);

 		return $myList->getList(false,false);
 	}
 
 }
 
 
 class evaluacion_indicadores extends OPF_myActiveRecord {

	public $id_evaluacion_indicadores;

	public $peso;

	public $recurso;

	public $proceso;

	public $producto;

	public $cliente;

	public $puntaje_ponderado;

	public $descripcion;

	public $fecha_modificacion;

	public $id_usuario;

	public $compromisos;

	public $id_producto;

	public $validacion;

 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 class producto extends OPF_myActiveRecord {

	public $id_producto;

	public $peso;

}

class valor_indicador extends OPF_myActiveRecord {

	public $valor;

}

class vigencia extends OPF_myActiveRecord {
    
    public $id_vigencia;
    
    public $nombre_vigencia;
    
    public $id_usuario;
    
    public $correo_electronico;
    
    public $descripcion;
}
 
?>