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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/route.php');

class TZ_PinboardViewPinboard extends JViewLegacy{
    function display($tpl=null){
        $state          = $this -> get('State') -> get('params');
        $tz_layout      = $state->get('tz_pinboard_layout');
        $type_detail    = $state->get('type_detail');
        $limit_pin      = $state->get('tz_article_limit');
        $img_size       = $state->get('portfolio_image_size') ;
        $text_commnet   = $state->get('Limits_comment') ;
        $width_columns  = $state->get('width_columns');
        $this->assign('limit_pin',$limit_pin);
        $this->assign('type_detail',$type_detail);
        $this->assign('Pins',$this->get('Pins'));
        $this->assign('PaginationPins',$this->get('PaginationPins'));
        $this->assign('UserImgLogin',$this->get('UserImgLogin'));
        $this->assign('sosanhuser',$this->get('IdUser'));
        $this->assign('namecategory',$this->get('NameCategory'));
        $this->assign('Limit_comment',$text_commnet);
        $this->assign('tz_layout',$tz_layout);
        $this->assign('width_columns',$width_columns);
        $this->assign('img_size',$img_size);
        parent::display();
    }
}
?>