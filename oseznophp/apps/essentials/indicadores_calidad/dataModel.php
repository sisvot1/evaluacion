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

class informacion_usuario{
        /*
         * Por medio de esta funcion podemos ver los datos del usuario por medio de un formulario.
         */
	public static function formulario_info()
	{
                
		$myForm = new OPF_myForm('formulario_info');

                
                $myForm->addText('Vigencia: ', 'vigencia', 'Plan de Acción 2012 Universidad EAN', '35' ); //$value 
                
                $myForm->addText('Proceso: ', 'nombre_proceso', 'Rectoria', '80');

                $myForm->addText('Objetivo: ', 'nombre_objetivo','1.2', '35' ); //$value 
                
                $myForm->addText('Estado: ', 'estado','Mejoramiento', '35' ); //$value 
                
                $myForm->addText('Producto: ', 'producto','Producto 1', '35' ); //$value 
                
                $myForm->addText('Responsable Objetivo: ', 'responsable','Carlos  Andrès Moreno Gil', '35' ); //$value 
                
                $myForm->addText('Usuario: ', 'Usuario','camoreno', '35' ); //$value 

                $myForm->addGroup('grupo1','Información Producto:',array( 'vigencia',  'nombre_objetivo',  'estado', 'producto', 'responsable', 'Usuario'),1);
                
                $myForm->width = 400;
                
                return $myForm->getForm(1);
	}
        
        public function getList_objetivo()
               
        {
            $ano1 =  date("Y"); 
            $ano = (string) $ano1;
            $sql = 'SELECT  prod.id_producto AS "Eliminar", prod.id_producto AS "Modificar", obj.nombre_objetivo AS "Objetivo", est.nombre_estado AS "Estado", prod.nombre_producto AS "Producto", users.user_name AS "Usuario",  prod.descripcion AS "Descripción",   prod.fecha_inicio AS "Fecha Inicio", prod.fecha_finalizacion AS "Fecha Final", prod.peso AS  "Peso"
                        FROM  `producto` prod, estado est, objetivo obj, ess_system_users users
                        WHERE prod.id_usuario = '.$_SESSION['user_id']."
                        AND est.id_estado = prod.id_estado
                        AND obj.id_objetivo = prod.id_objetivo
                        AND prod.id_usuario = users.id
                        AND prod.fecha_inicio like  \"%$ano%\" 
                        ";
                        //AND prod.fecha_inicio like  \'%$ano%\'
                        //\'%2012%\'  manejo de cadenas 
            
            /*$_SESSION['user_id'];*/
            
            $myList = new OPF_myList('lista_objetivos_indicadores',$sql);
            $myList->setSqlDebug();     
            $myList->width = 1040;
            
            $myList->setRealNameInQuery('Usuario', 'users.user_name');
            
            $myList->setRealNameInQuery('Objetivo', 'obj.nombre_objetivo');
            
            $myList->setRealNameInQuery('Estado', 'est.nombre_estado');  
                    
            $myList->setRealNameInQuery('Producto', 'prod.nombre_producto');     

            $myList->setRealNameInQuery('Valor Peso', 'prod.Peso');
            
            $myList->setRealNameInQuery('Descripción', 'prod.descripcion');
            
            $myList->setRealNameInQuery('Fecha Inicio', 'prod.fecha_inicio');
            
            $myList->setRealNameInQuery('Fecha Finalización', 'prod.fecha_finalizacion');
            
            $myList->setExportData(true,true,true);
 			
 	    $myList->setPagination(true,10);

            $myList->setEventOnColumn('Peso','onClickDeleteRecord');
 		
 		//$myList->setUseOrderMethod(true);
            $myList->setWidthColumn('Peso', 40);
            $myList->setWidthColumn('Usuario', 80);  
            $myList->setWidthColumn('obj.nombre_objetivo', 80);  
            $myList->setWidthColumn('Estado', 110);
            $myList->setWidthColumn('Producto', 160); 
            $myList->setWidthColumn('Varlor Peso', 40);
            $myList->setWidthColumn('Descripción', 250); 
            $myList->setWidthColumn('Fecha Inicio', 140);
            $myList->setWidthColumn('Fecha Finalización', 140);
            
            return $myList->getList(false, false);
            
        }


}

?>