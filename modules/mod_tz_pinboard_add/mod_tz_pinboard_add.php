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
   $param_pinboard  = JComponentHelper::getParams('com_tz_pinboard');
    $text_board     = $param_pinboard->get('text_boar');
    $text_board_ds  = $param_pinboard->get('text_boar_description');
    $text_key       = $param_pinboard->get('text_keyword');
    $text_title     = $param_pinboard->get('text_title');
    $text_title_ds  = $param_pinboard->get('text_descript_pin');
    $bord           = modTz_Pinboard_add::getBoard();
    $user           = modTz_Pinboard_add::getCheckuser();

    require JModuleHelper::getLayoutPath('mod_tz_pinboard_add', $params->get('layout', 'default'));
?>