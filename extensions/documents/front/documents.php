<?php

/**
 * @package     Documents
 * @subpackage  ControllerFront
 * @author      IT&L@bs <csicard.ext@orange.com>
 * @copyright   2012 Orange. All rights reserved.
 * @link        http://www.itlabs.fr.orange-business.com/
 */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
require_once( JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$classname    = 'DocumentsController';
$controller   = new $classname( );
 
// Perform the Request task
$controller->execute( JRequest::getWord( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();