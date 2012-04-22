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
 OPF_osezno::assign('nom_modulo','EVALUACIÓN DE PRODUCTOS - INDICADORES DE CALIDAD');
 
 OPF_osezno::assign('desc_modulo','Evaluación De Desempeño Universidad Ean');
 
 OPF_osezno::assign('content1', scaffolding_evaluacion_indicadores::formulario_info());
         
 OPF_osezno::assign('content3',scaffolding_evaluacion_indicadores::getList_evaluacion_indicadores1());
 
 OPF_osezno::assign('content2',scaffolding_evaluacion_indicadores::getList_evaluacion_indicadores());
 
                            
 /**
  * Mostrar la plantilla
  */
OPF_osezno::call_template('modulo'.DS.'modulo1.tpl');
 
?>