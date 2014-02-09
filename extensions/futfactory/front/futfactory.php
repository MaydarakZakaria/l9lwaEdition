<?php

/**
 * @package     FutFactory
 * @subpackage  ControllerFront
 * @author      IT&L@bs <csicard.ext@orange.com>
 * @copyright   2012 Orange. All rights reserved.
 * @link        http://www.itlabs.fr.orange-business.com/
 */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
 
// Create the controller
$classname    = 'FFController'.$controller;
$controller   = new $classname( );
 
// Perform the Request task
$controller->execute( JRequest::getWord( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();