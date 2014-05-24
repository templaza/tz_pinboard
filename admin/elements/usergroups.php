<?php
/**
 * @version        $Id: article.php 14401 2010-01-26 14:10:00Z louis $
 * @package        Joomla
 * @copyright    Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license        GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class JFormFieldUserGroups extends JFormField
{
    var $type = 'usergroups';

    function getInput()
    {

        return $this->fetchElement($this->name, $this->value, $this->element, $this->options['control']);
    }

    function fetchElement($name, $value, &$node, $control_name)
    {

        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__usergroups";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $html = JHTML::_('select.genericlist', $rows, $name . '[]', 'style="size=5;" multiple="true"', 'id', 'title', $value, $control_name . $name);
        return $html;
    }
}
