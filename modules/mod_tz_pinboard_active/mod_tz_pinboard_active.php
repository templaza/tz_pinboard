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
defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';
        $doc = JFactory::getDocument();
        $doc -> addStyleSheet('modules/mod_tz_pinboard_active/css/tz_active.css');
        $doc -> addStyleSheet('modules/mod_tz_pinboard_active/css/jquery.mCustomScrollbar.css');
        $doc -> addScript('modules/mod_tz_pinboard_active/js/jquery.mCustomScrollbar.concat.min.js');
        $id = modTZ_Pinboard_active::getDataActive();
        $limit = $params->get('tz_page');
        $data = modTZ_Pinboard_active::getActive($id,$limit);
require JModuleHelper::getLayoutPath('mod_tz_pinboard_active', $params->get('layout', 'default'));
?>