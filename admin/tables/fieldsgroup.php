<?php
/*------------------------------------------------------------------------

# TZ Pinboard Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

 //no direct access
defined('_JEXEC') or die('Restricted access');

class TableFieldsGroup extends JTable
{
     /** @var int Primary key */
    var $id 				= null;
    /** @var string */
    var $name 				= null;
    /** @var string*/
    var $description		= null;

    function __construct(&$db) {
        parent::__construct('#__tz_pinboard_fields_group','id',$db);

    }
}
