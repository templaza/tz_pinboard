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


 class TZ_PinboardViewSearch extends JViewLegacy{
     function display($tpl=null){
         $state  = $this -> get('State') -> get('params');

         $search_results  = $this -> get('State')->get('tz_search');
         $tz_layout = $state->get('tz_pinboard_layout');
         $type_detail = $state->get('type_detail');
         $page_commnet   = $state->get('page_commnet');

         $this->assign('page_com',$page_commnet);
         $this->assign('search_results',$search_results);
         $this->assign('Check_pt_pin',$this->get('Check_pt_pin'));
        $this->assign('tz_search',$this->get('State')->get('tz_search'));
         $this->assign('type_detail',$type_detail);
         $this->assign('Pins',$this->get('Pins'));
         $this->assign('PaginationPins',$this->get('PaginationPins'));
         $this->assign('UserImgLogin',$this->get('UserImgLogin'));
         $this->assign('sosanhuser',$this->get('Sosanhuser'));
         $param_pinboard = &JComponentHelper::getParams('com_tz_pinboard');
         $img_size = $param_pinboard->get('portfolio_image_size');
         $width_columns = $param_pinboard->get('width_columns');
         $text_commnet = $param_pinboard->get('Limits_comment');
         $this->assign('Limit_comment',$text_commnet);
         $this->assign('tz_layout',$tz_layout);
         $this->assign('width_columns',$width_columns);
             $this->assign('img_size',$img_size);

         parent::display();
     }
 }
?>