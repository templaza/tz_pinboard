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

class TZ_PinboardViewPinboard extends JViewLegacy
{

    function display($tpl = null)
    {
        $state = $this->get('State')->get('params');
        $tz_layout = $state->get('tz_pinboard_layout'); // type layout
        $type_detail = $state->get('type_detail'); // type detail
        $limit_pin = $state->get('tz_article_limit'); // article limit
        $img_size = $state->get('portfolio_image_size'); // size img
        $text_commnet = $state->get('Limits_comment'); // limit comment
        $page_commnet = $state->get('page_commnet');
        $width_columns = $state->get('width_columns');
        $show_date_comment = $state->get('show_date_comment');
        $comment_thumbnails = $state->get('comment_thumbnails'); // show comment thumbnails
        $comment_detail = $state->get('comment_detail'); // show or hide comment detail
        $show_tags_thum = $state->get('show_tags_thum'); // show or hide tags thumbnails
        $show_title_thum = $state->get('show_title_thum'); // show or hide title thumbnails
        $show_button = $state->get('show_button'); // show or hide button repin, like, comment
        $count_button = $state->get('show_count_button'); // show or hide count comment, like, hist
        $s_user = $state->get('show_user'); // show or hide info user
        $this->assign('s_user', $s_user);
        $this->assign('count_button', $count_button);
        $this->assign('title_thum', $show_title_thum);
        $this->assign('tag_thum', $show_tags_thum);
        $this->assign('s_button', $show_button);
        $this->assign('s_detail', $comment_detail);
        $this->assign('s_thumb', $comment_thumbnails);
        $this->assign('show_date', $show_date_comment);
        $this->assign('page_com', $page_commnet);
        $this->assign('limit_pin', $limit_pin);
        $this->assign('type_detail', $type_detail);
        $this->assign('Pins', $this->get('Pins'));
        $this->assign('PaginationPins', $this->get('PaginationPins'));
        $this->assign('UserImgLogin', $this->get('UserImgLogin'));
        $this->assign('sosanhuser', $this->get('IdUser'));
        $this->assign('namecategory', $this->get('NameCategory'));
        $this->assign('Limit_comment', $text_commnet);
        $this->assign('tz_layout', $tz_layout);
        $this->assign('width_columns', $width_columns);
        $this->assign('img_size', $img_size);
        parent::display();
    }
}

?>