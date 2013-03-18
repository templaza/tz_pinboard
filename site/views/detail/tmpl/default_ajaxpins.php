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


?>


<div class="tz_detail_content">
    <?php if(isset($this->type_details) && $this->type_details==1){?>
        <span class="tz_detail_pins">
        </span>
    <?php } ?>
    <?php
        $img_size = $this->img_size;
        $img_type = JFile::getExt($this->show_detail->poro_img);
        $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$this->show_detail->poro_img);
    ?>
    <img class="tz_imgs" src="<?php echo JUri::root()."/".$img_type_replaca; ?>">
    <div class="tz_detail_pl">
        <button class="tz_button_repin  tz_btn tz_repin" data-option-id="<?php echo $this->show_detail->content_id; ?>" > <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?></button>
        <?php
            if($this->show_detail->id_user == $this->sosanhuser ){
        ?>
            <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute('',$this->show_detail->content_id)) ?>"  rel="nofollow">
                <button class="tz_button_repin  tz_btn"> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?></button>
            </a>
        <?php
            }else{

//                if($this->show_detail->check_like['p'] =='0'  || $this->show_detail->check_like['p']  =='')
//                {
        ?>
                    <button class="tz_button_repin  tz_btn   <?php   if($this->show_detail->check_like['p']=='1' ){  echo "tz_check_like"; } ?>  <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_like_ero"; }else{ echo"tz_like"; }  ?>" data-option-id="<?php echo $this->show_detail->content_id; ?>">
                        <?php  echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>
                    </button>
<!--        --><?php
//            }else
//                if($this->show_detail->check_like['p']=='1' ){
//        ?>
                    <button class="tz_button_repin  tz_btn disabled_d tz_unlike <?php  if($this->show_detail->check_like['p'] =='0'  || $this->show_detail->check_like['p']  ==""){ echo "tz_check_like"; } ?> " data-option-id="<?php echo $this->show_detail->content_id; ?>">
                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                    </button>
        <?php
            }
        ?>

        <?php
        if($this->show_detail->id_user != $this->sosanhuser){
        ?>
        <?php
        if($this->show_detail->follow['f'] =='0' || $this->show_detail->follow['f']=='' )
        {
        ?>
        <button class="tz_button_repin  tz_btn  <?php if(!isset($this->sosanhuser) || empty($this->sosanhuser)){ echo "tz_erro_follow"; }else{ echo "tz_follow"; } ?> " data-option-text="<?php echo $this->show_detail->name_user; ?>"  data-option-id="<?php echo $this->show_detail->id_user; ?>">
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>
        </button>
        <?php
        }else if($this->show_detail->follow['f'] =='1'){
        ?>
            <button class="tz_button_repin  tz_btn disabled_d tz_unfollow" data-option-id="<?php echo $this->show_detail->id_user; ?>">
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>
            </button>
        <?php
        }
        } ?>
        <?php if(isset($this->show_detail->website) && !empty($this->show_detail->website)){ ?>
        <a target="_blank"  href="<?php echo $this->show_detail->website; ?>" rel="nofollow">
        <button class="btn tz_btn"><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_VITSIT_SITE'); ?></button>
        </a>

        <?php
        }
        ?>


    </div>

    <div id="tz_detail_user">
    <div class="tz_detail_user_left">
        <a  href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($this->show_detail->id_user)); ?>">
            <?php if(isset($this->show_detail->img_user) && !empty($this->show_detail->img_user)){  ?>
            <img id="tz_thumbnails_img"  src="<?php echo JUri::root().'/'.$this->show_detail->img_user;  ?>">
            <?php }else{ ?>
            <img id="tz_thumbnails_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
            <?php   }?>
        </a>
    </div>
    <div class="tz_detail_user_right">
    <?php if(isset($this->show_title) && $this->show_title==1){ ?>
    <h6>
    <?php echo $this->show_detail->conten_title; ?>
    </h6>
    <?php } ?>
    <p>
    <?php if(isset($this->show_detail->website) && !empty($this->show_detail->website)){ ?>
    <span class="tz_web"><?php echo JText::_('COM_TZ_PINBOARD_SOURCE_BY'); ?> </span>
    <a target="_blank"  href="<?php echo $this->show_detail->website; ?>" rel="nofollow">
    <?php echo $this->show_detail->website; ?>
    </a>
    <?php
    }
        ?>
    </p>

    </div>
    <div class="cler">

    </div>
    </div>
    <p class="tz_detail_intro">
    <?php echo $this->show_detail->content_introtext; ?>
    </p>
    <?php if(isset($this->show_detail->tags) && !empty($this->show_detail->tags) && $this->show_tags=='1'){ ?>
    <p class="tz_show_all">

    <?php
    foreach($this->show_detail->tags as $tag){
    ?>

    <a class="tz_detail_tags"  href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"  rel="nofollow">
    <?php echo"#  ".$tag->tagname; ?>
    </a>
    <?php
    }
    ?>

    </p>
    <?php
    }
    ?>


    <p class="tz_show_all">


    <a class="tz_detail_title_board" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManagetuset2('',$this->show_detail->id_user,$this->show_detail->category_id)); ?>"  rel="nofollow">
    <?php echo $this->show_detail->boar_title; ?>
    </a>

    <span class="tz_detail_date">
        <?php echo date(JText::_('TZ_PINBOARD_DATE_FOMAT'),strtotime($this->show_detail->c_created)); ?>
    </span>
    <p class="cler"></p>
    </p>


    <div class="thumbnails tz_content_cm">
        <?php if((int)$this->page_comment < (int)$this->Demcommnet->number_id){ ?>
            <div class="tz_detail_page">
                <a id="tz_comment_pt_a" data-optio-page="2" data-optio-id="0">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LOAD_MORE'); ?>
                </a>
                <span id="id_loadding">

                </span>
                <div class="cler"></div>
                <div id="tz_page_stop">
                </div>
        </div>

        <?php } ?>
    <ul>
    <?php echo $this->loadTemplate('comment'); ?>
    </ul>

    </div>
    <div class="thumbnails tz_datail_comment">
<!--    <p>-->
<!--    <span class="tz_bt">--><?php //echo JText::_('COM_TZ_PINBOARD_COMMENTS_COUNT'); ?><!--</span>-->
<!--    <span class="badge badge-info" id="tz_count_number">--><?php //echo $this->Demcommnet->number_id; ?><!--</span>-->
<!--    </p>-->

    <form>
    <input type="hidden" id="tz_hd_id_pin" value="<?php echo $this->show_detail->content_id; ?>">
    <textarea id="tz_comment"  maxlength="<?php echo $this->limit_comment;  ?>" placeholder="<?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); }else{ echo JText::_('COM_TZ_PINBOARD_LOGIN_COMMENT');  } ?>"></textarea>
    <span id="tz_comment_erroc_p"></span>
    <button  type="button" class="btn" id="<?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ echo"tz_post_cm"; }else{ echo "tz_post_cm_erro"; } ?>"><?php echo JText::_('COM_TZ_PINBOARD_POST_COMMENT'); ?></button>
    </form>

    <div class="cler"></div>

    </div>

</div>
    <div class="tz_notice_detail">

            <h5><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_YOU_WANT_COMMENT'); ?></h5>
            <div class="tz_delete_option">
                <a class="btn btn-large tz_detail_canel" type="button"><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_CANCEL_COMMENT'); ?></a>
                <a class="btn btn-danger btn-large tz_detail_delete" type="button"><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_DELETE_COMMENT') ?></a>
            </div>

    </div>