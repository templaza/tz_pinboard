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
    class Tz_pinboardViewManageruser extends JViewLegacy{
        function display($tpl=null){
            $state  = $this -> get('State') -> get('params');
            $max_text_board = $state->get('text_boar');
            $max_text_board_ds = $state->get('text_boar_description');
            $type_detail = $state->get('type_detail');
            $width_columns = $state->get('width_columns');
            $columns_board = $state->get('column_board');
            $columns_pins = $state->get('column_pins');
            $columns_follow = $state->get('column_follow');
            $page_commnet   = $state->get('page_commnet');
            $show_date_comment  = $state->get('show_date_comment');
            $this->assign('show_date',$show_date_comment);
            $this->assign('page_com',$page_commnet);
            $this->assign('width_follow',$columns_follow);
            $this->assign('width_pin',$columns_pins);
            $this->assign('width_board',$columns_board);
            $this->assign('width_columns',$width_columns);
            $this->assign('type_detail',$type_detail);
            $this->assign('max_text_board_ds',$max_text_board_ds);
            $this->assign('max_text_board',$max_text_board);
            $limit_commnet = $state->get('Limits_comment');
            $this->assign('Limit_comment',$limit_commnet);
           $this->assign('category',$this->get('Category')); // show category
           $this->assign('showboard',$this->get('Showboard')); // show all board
           $this->assign('editboard',$this->get('Editboard')); // show edit board
            $this->assign('erroinsertboard',$this->get('Insertboard'));
            $this->assign('sosanhuser',$this->get('Sosanhuser'));
            $this->assign('Boarpin',$this->get('Boarpin'));
            $this->assign('Showpinboard',$this->get('Showpinboard'));

            $param_porfolio = &JComponentHelper::getParams('com_tz_pinboard');
            $img_size = $param_porfolio->get('portfolio_image_size');
            $this->assign('img_size',$img_size);

            $this->assign('showboardandpin',$this->get('ShowBoarAndPin'));
            $this->assign('shownameboard',$this->get('ShowcategoryBoarAndPin'));

            $this->assign('Pins',$this->get('Pins'));
            $this->assign('editpin',$this->get('Showeditpins'));
            $this->assign('ShowBoarname',$this->get('ShowBoarname'));
            $this->assign('userInfo',$this->get('InfoUSer'));
            $this->assign('PinLike', $this->get('Like'));

            $this->assign('ShowFollow',$this->get('ShowFollow'));
            $this->assign('ShowFollowers',$this->get('ShowFollowers'));

            $this->assign('pagination',$this->get('Pagination'));
            $this->assign('PaginationLike',$this->get('PaginationLike'));
            $this->assign('PaginationPins',$this->get('PaginationPins'));
            $this->assign('PaginationBoardPin',$this->get('PaginationBoardPin'));
            $this->assign('PaginationFollow',$this->get('PaginationFollow'));
            $this->assign('PaginationFolloing',$this->get('PaginationFolloing'));
            $this->assign('CheckIdGuest',$this->get('CheckUserId'));

            $this->assign('numberboard',$this->get('NumberBoars'));
            $this->assign('NumberPin',$this->get('NumberPin'));
            $this->assign('NumberLike',$this->get('NumberLike'));
            $this->assign('NumberFollow',$this->get('NumberFollow'));
            $this->assign('NumberFollowing',$this->get('NumberFollowing'));

            $this->assign('UserImgLogin',$this->get('UserImgLogin'));

            $this->assign('newboard',$this->get('CheckNewboar'));
            $this->assign('checkInfo',$this->get('CheckInfo'));


             parent::display($tpl);
              
        }
    }
?>
 
