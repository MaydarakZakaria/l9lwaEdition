<?php

/**
 * Uninstaller file
 *
 * PHP version 5.3
 *
 * @category  FutFactory
 * @package   Install
 * @author    IT&L@bs <csicard.ext@orange.com>
 * @copyright 2012 Orange. All rights reserved.
 * @link      http://www.itlabs.fr.orange-business.com/
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Get the extension id
 * Grabbed this from the JPackageMan installer class with modification
 *
 * @param string $type        type
 * @param int    $id          id
 * @param string $group       group
 * @param string $description description
 *
 * @return unknown_type
 */

//require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_futfactory'.DS.'models'.DS.'model.factory.php');

function com_uninstall() {
    $return = true;
    echo '<h2>FutFactory ' . JText::_('UNINSTALL') . '</h2><br/>';

    //restore the normal login behaviour
    $db = & JFactory::getDBO();

    //remove the futfactory tables.
    $db = & JFactory::getDBO();
    $query = "DROP TABLE #__fut_fut";
    $db->setQuery($query);
    if (!$db->Query()){
        echo $db->stderr() . "<br />";
        $return = false;
    }

}