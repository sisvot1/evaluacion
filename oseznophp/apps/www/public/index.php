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
OPF_osezno::assign('librerias',$controller->htmlTeExt);

/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('osezno'.DS.'osezno.tpl');

?>
