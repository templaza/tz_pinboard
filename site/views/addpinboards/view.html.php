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
defined("_JEXEC") or die;
class Tz_pinboardViewAddpinboards extends JViewLegacy
{

    function display($tpl = null)
    {
        $state = $this->get('State')->get('params');
        $max_text_board = $state->get('text_boar');
        $max_text_board_ds = $state->get('text_boar_description');
        $text_title = $state->get('text_title');

        $text_derscript = $state->get('text_descript_pin');

        $this->assign('max_text_board_ds', $max_text_board_ds);
        $this->assign('max_text_board', $max_text_board);
        $this->assign('text_descript', $text_derscript);
        $this->assign('text_title', $text_title);
        $param_porfolio = & JComponentHelper::getParams('com_tz_pinboard');
        $img_size = $param_porfolio->get('portfolio_image_size');
        $this->assign('img_size', $img_size);
        $this->assign('showboard_chitet', $this->get('Showboard_chitet'));
        $this->assign('showcountpin', $this->get('Showcountpin'));
        $this->assign('chitiet', $this->get('Morepin'));
        $this->assign('Showboardd', $this->get('Boardweb'));

        $this->assign('CheckUser', $this->get('CheckUser'));
        $this->get('Img');

        $this->assign('show_category', $this->get('ShowCategory'));
        parent::display($tpl);
    }
}

?>