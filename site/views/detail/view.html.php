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

        class TZ_PinboardViewDetail extends JViewLegacy{
                function  display($tpl=null){
                    $sate =$this -> get('State') -> get('params');
                    $Limits_comment = $sate->get('Limits_comment');
                    $page_comment = $sate->get('page_commnet_detail');
                    $show_tags_detail = $sate->get('show_tags_detail');
                    $show_tags_title = $sate->get('show_tags_title');
                    $show_date_comment  = $sate->get('show_date_comment');
                    $type_detail        =$sate->get('type_detail');
                    $this->assign('type_details',$type_detail);
                    $this->assign('show_date',$show_date_comment);
                    $this->assign('page_comment',$page_comment);
                    $this->assign('show_title',$show_tags_title);
                    $this->assign('show_tags',$show_tags_detail);
                    $this->assign('limit_comment',$Limits_comment);
                    $this->assign('show_detail',$this->get('DetailPins'));
                    $this->assign('sosanhuser',$this->get('Sosanhuser'));
                    $this->assign('Demcommnet',$this->get('Demcommnet'));
                    $this->assign('ShowCommnet',$this->get('ShowCommnet'));
                    $img_size = $sate->get('pinboard_image_size');
                    $this->assign('img_size',$img_size);
                    parent::display();
                }
        }
?>