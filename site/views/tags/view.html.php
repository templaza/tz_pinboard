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



 class TZ_PinboardViewTags extends JViewLegacy{
     function display($tpl=null){
         $state  = $this -> get('State') -> get('params');
         $tz_layout = $state->get('tz_pinboard_layout');
         $width_columns = $state->get('width_columns');
         $type_detail = $state->get('type_detail');
         $limit_pin = $state->get('tz_article_limit');
         $page_commnet   = $state->get('page_commnet');
         $this->assign('page_com',$page_commnet);
         $this->assign('limit_pin',$limit_pin);
         $this->assign('tags',$this -> get('State')->get('tag_id'));
         $this->assign('type_detail',$type_detail);
         $this->assign('Pins',$this->get('Pins'));
         $this->assign('PaginationPins',$this->get('PaginationPins'));
         $this->assign('UserImgLogin',$this->get('UserImgLogin'));
         $this->assign('sosanhuser',$this->get('Sosanhuser'));
         $show_date_comment  = $state->get('show_date_comment');
         $this->assign('show_date',$show_date_comment);

         $this->assign('NameTag',$this->get('NameTag'));
         $param_pinboard = JComponentHelper::getParams('com_tz_pinboard');
         $img_size = $param_pinboard->get('portfolio_image_size');

         $text_commnet = $param_pinboard->get('Limits_comment');
         $this->assign('tz_layout',$tz_layout);
            $this->assign('width_columns',$width_columns);
         $this->assign('Limit_comment',$text_commnet);

             $this->assign('img_size',$img_size);

         parent::display();
     }
 }
?>