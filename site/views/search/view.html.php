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

        $state              =       $this -> get('State') -> get('params');
        $search_results     =       $this -> get('State')->get('tz_search');
        $tz_layout          =       $state->get('tz_pinboard_layout');
        $type_detail        =       $state->get('type_detail');
        $page_commnet       =       $state->get('page_commnet');
        $show_date_comment  =       $state->get('show_date_comment');
        $img_size           =       $state->get('portfolio_image_size');
        $width_columns      =       $state->get('width_columns');
        $text_commnet       =       $state->get('Limits_comment');
        $comment_thumbnails =   $state->get('comment_thumbnails');     // show comment thumbnails
        $show_button        =   $state->get('show_button');            // show button repin, edit, like, unlike, comment
        $show_title_thum    =   $state->get('show_title_thum');        // show or hide title thumbnails
        $show_tags_thum     =   $state->get('show_tags_thum');        // show or hide tags thumbnails
        $count_button       =   $state->get('show_count_button');     // show or hide count comment, like, hist
        $s_user             =   $state->get('show_user');             // show or hide info user
        $comment_detail     =   $state->get('comment_detail');        // show or hide comment detail
         $this -> assign('s_detail',$comment_detail);
         $this -> assign('s_user',$s_user);
         $this -> assign('count_button',$count_button);
         $this -> assign('tag_thum',$show_tags_thum);
         $this -> assign('title_thum',$show_title_thum);
         $this -> assign('s_button',$show_button);
         $this -> assign('s_thumb',$comment_thumbnails);
        $this -> assign('page_com',$page_commnet);
        $this -> assign('search_results',$search_results);
        $this -> assign('Check_pt_pin',$this->get('Check_pt_pin'));
        $this -> assign('tz_search',$this->get('State')->get('tz_search'));
        $this -> assign('type_detail',$type_detail);
        $this -> assign('Pins',$this->get('Pins'));
        $this -> assign('PaginationPins',$this->get('PaginationPins'));
        $this -> assign('UserImgLogin',$this->get('UserImgLogin'));
        $this -> assign('sosanhuser',$this->get('Sosanhuser'));
        $this -> assign('show_date',$show_date_comment);
        $this -> assign('Limit_comment',$text_commnet);
        $this -> assign('tz_layout',$tz_layout);
        $this -> assign('width_columns',$width_columns);
        $this -> assign('img_size',$img_size);

        parent::display();
     }
 }
?>