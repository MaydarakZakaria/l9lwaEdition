<?php

/**
 * @package     Documents
 * @subpackage  Controller
 * @author      IT&L@bs <csicard.ext@orange.com>
 * @copyright   2012 Orange. All rights reserved.
 * @link        http://www.itlabs.fr.orange-business.com/
 */
// No direct access

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Futer Component Controller
 *
 * @package     FutFactory
 * @subpackage  Controller
 */
class DocumentsController extends JController {

    /**
     * Method to display the view
     *
     * @access    public
     */
    function display() {
        // Disable main template
        JRequest::setVar('tmpl', 'component');

        $user = JFactory::getUser();
        if ($user->guest) {
            echo JText::_('NOT_ALLOWED');
            jexit();
        } else {
            $uri = parse_url(JRequest::getUri());
            $info = pathinfo($uri['path']);

            $filepath = JPATH_BASE.$info['dirname'].DS.$info['basename'];
            if (!file_exists($filepath)) {
                echo JText::_('RESOURCE_DOES_NOT_EXIST');
                jexit();
            }
            if (is_readable($filepath)
                    && is_file($filepath)) {
                $this->_writeHeaders($filepath, $info['basename']);
            } else {
                echo JText::_('RESOURCE_IS_NOT_AVAILABLE');
                jexit();
            }
        }
    }

    private function _writeHeaders($filepath, $filename) {
        header('Pragma: ');
        header('Cache-Control: cache');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . filesize($filepath));
        header('Content-Disposition: attachment; filename=' . $filename);
        readfile($filepath);
    }

}