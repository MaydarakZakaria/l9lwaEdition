<?php

/**
 * Installer file
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


function com_install() {

     $return = true;

     //find out where we are
     $basedir = dirname(__FILE__);

     //load language file
     $lang = & JFactory::getLanguage();
     $lang->load('com_futfactory', JPATH_BASE);

     //see if we need to create SQL tables
     $db = & JFactory::getDBO();
     $table_list = $db->getTableList();
     $table_prefix = $db->getPrefix();
        
     //create table if it does not exist already
     if (array_search($table_prefix . 'ff_fut', $table_list) == false) {
        $comupgrade = 0;
        // Alter table users
        $batch_query = <<<'EOT'
ALTER TABLE #__users
        ADD COLUMN `firstName` VARCHAR(255) NOT NULL DEFAULT ''  AFTER `params` ,
        ADD COLUMN `mobilePhone` VARCHAR(10) NULL DEFAULT NULL  AFTER `privateEmail` ,
        ADD COLUMN `phone` VARCHAR(10) NULL DEFAULT NULL  AFTER `mobilePhone` ;
EOT;
        $db->setQuery($batch_query);
        if (!$db->queryBatch()) {
            echo $db->stderr() . "<br />";
            $return = false;
            return $return;
        }
        // Table ff_fut
        $batch_query = <<<'EOT'
CREATE TABLE #__ff_fut (
    id int(11) NOT null auto_increment,
    PRIMARY KEY  (id)
) DEFAULT CHARACTER SET utf8;
EOT;
        $db->setQuery($batch_query);
        if (!$db->queryBatch()) {
            echo $db->stderr() . "<br />";
            $return = false;
            return $return;
        }
     } else {
          //this is an upgrade
          $comupgrade = 1;
     }
     
//output some info to the user
?>
<h2>
<?php echo JText::_('FUTFACTORY') . ' 1.0.0 ' . JText::_('INSTALLATION'); ?>
</h2>
<h3>
<?php echo JText::_('STARTING') . ' ' . JText::_('INSTALLATION') . ' ...' ?>
</h3>

<?php
//install the JFusion packages
jimport('joomla.installer.helper');
$packages = array();
//$packages['NAMEMODULE'] = $basedir . DS . 'packages' . DS . 'futfactory_mod_NAMEMOD.zip';


foreach ($packages as $name => $filename) {
     $package = JInstallerHelper::unpack($filename);
     $tmpInstaller = new JInstaller();
     if (!$tmpInstaller->install($package['dir'])) { ?>

<table bgcolor="#f9ded9" width="100%">
     <tr style="height: 30px">
          <td width="50px"><img
               src="components/com_futfactory/images/check_bad.png" height="20px"
               width="20px">
          </td>
          <td><font size="2"> <b> <?php echo JText::_('ERROR') . ' ' . JText::_('INSTALLING') . ' ' . JText::_('FUTFACTORY') . ' ' . $name; ?>
               </b> </font>
          </td>
     </tr>
</table>
     <?php
     }
     unset($package, $tmpInstaller);
}
?>
<table bgcolor="#d9f9e2" width="100%">
     <tr>
          <td width="50px"><img
               src="components/com_futfactory/images/check_good.png" height="20px"
               width="20px">
          </td>
          <td><font size="2"> <b> <?php
          if ($compupgrade == 1) {
               echo JText::_('FUTFACTORY') . ' ' . JText::_('UPDATE') . ' ' .JText::_('SUCCESS');
        } else {
               echo JText::_('FUTFACTORY') . ' ' . JText::_('INSTALL') . ' ' .JText::_('SUCCESS');
        }

?>          </b> </font>
          </td>
     </tr>
</table>
<?php
    return $return;
}