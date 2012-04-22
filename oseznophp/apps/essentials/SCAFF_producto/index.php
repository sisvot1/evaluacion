<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
  
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 OPF_osezno::assign('nom_modulo','Ingreso Nuevo Producto');
 
 OPF_osezno::assign('desc_modulo','Evaluación De Desempeño Universidad Ean');
 
 OPF_osezno::assign('content1',scaffolding_producto::getFormStartUp_producto());
 
 OPF_osezno::assign('content2',scaffolding_producto::getList_producto());
 
  
 /**
  * Mostrar la plantilla
  */
OPF_osezno::call_template('modulo'.DS.'modulo.tpl');
 
?>
