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


if(isset($this->Pins)){
    foreach($this->Pins as $Pins){
?>
        <div class="tz_pin_all_content">
            <div class="thumbnail tz_pin_content_class">
                <?php
                    $img_size = $this->img_size;
                    $img_type = JFile::getExt($Pins->poro_img);
                    $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$Pins->poro_img);
                ?>
                <a class="tz_a_center" <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?> rel="nofollow">
                    <img  data-option-id-img="<?php echo $Pins->content_id; ?>" <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> src="<?php echo JUri::root().'/'.$img_type_replaca ?>">
                </a>

                <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?> rel="nofollow">
                    <h6 <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> data-option-id-img="<?php echo $Pins->content_id; ?>">
                        <?php echo $Pins->conten_title; ?>
                    </h6>
                </a>
                <p>
                    <span class="tz_pin_like"><?php echo $Pins->demL->count_l; ?> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?></span>
                    <span class="tz_pin_unlike"><?php echo $Pins->countComment->count_l; ?>  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?></span>
                    <span class="tz_pin_unlike"><?php echo $Pins->countComment->count_l; ?>  View</span>
                </p>
                <p class="tz_pin_tag">
                    <span> <?php echo JText::_('COM_TZ_PINBOARD_TAGS'); ?> </span>
                    <?php
                    foreach($Pins->tags as $tag){
                        ?>

                        <a  href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"  rel="nofollow">
                            <?php echo $tag->tagname; ?>
                        </a>
                        <?php
                    }
                    ?>



                </p>

                <p>
                    <?php if(isset($Pins->user_img) && !empty($Pins->user_img)){  ?>
                        <img class="tz_pin_img_user"  src="<?php echo JUri::root().'/'.$Pins->user_img;  ?>">
                    <?php }else{ ?>
                        <img class="tz_pin_img_user"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                    <?php   }?>

                    <a class="tz_pin_name_user" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($Pins->id_user)); ?>" rel="nofollow">
                        <?php echo $Pins->user_name; ?>
                            <?php if(isset($Pins->name_user_repin) && !empty($Pins->name_user_repin)){ ?>
                        <strong class="tz_by">
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN_BY'); ?>
                        </strong>
                        <?php
                            echo $Pins->name_user_repin;
                        }
                        ?>
                    </a>
                    <div class="cler"></div>
                </p>
                <div class="tz_buttom_pins">
                    <a class="tz_buttom_repin tz_repin"  data-option-id="<?php echo $Pins->content_id; ?>" >
                        <span>
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
                        </span>
                    </a>
                    <?php
                        if($Pins->id_user == $this->sosanhuser ){
                    ?>
                        <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute('',$Pins->content_id)); ?>" class="tz_buttom_repin" rel="nofollow">
                        <span>
                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>
                        </span>
                        </a>
                        <?php
                    }else{
                    ?>
                        <?php
                        if($Pins->checl_l['p'] =='0'  || $Pins->checl_l['p']  =='')
                        {
                        ?>

                            <a   class="tz_buttom_repin  <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_like_ero"; }else{ echo"tz_like"; }  ?>" data-text-like="tz_like" data-option-id="<?php echo $Pins->content_id; ?>">
                            <span>

                            <?php  echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>

                            </span>
                            </a>
                        <?php
                        } else   if($Pins->checl_l['p']  =='1' ){
                        ?>

                            <a style="background: #C0C0C0"  class="tz_buttom_repin  tz_unlike" data-text-like="tz_unlike" data-option-id="<?php echo $Pins->content_id; ?>">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                            </span>
                            </a>
                        <?php
                        }

                        ?>


                    <?php
                    }
                    ?>
                    <a data-option-id-img="<?php echo $Pins->content_id; ?>"   class="tz_buttom_repin <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_pin_conmments_ero"; }else{ echo"tz_pin_conmments"; }  ?>">
                        <span>
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>
                        </span>
                    </a>
                </div>
                <div class="tz_pin_comsPins">
                    <div class="tz_pin_comsPins_content">

                        <ul>
                            <?php if(isset($Pins->showcomment) && !empty($Pins->showcomment)){
                            foreach($Pins->showcomment as $showComemnt){
                            ?>
                                <li>

                                <?php if(isset($showComemnt->img_user) && !empty($showComemnt->img_user)){  ?>
                                    <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/'.$showComemnt->img_user;  ?>">
                                <?php }else{ ?>
                                    <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                                <?php } ?>

                                <a rel="nofollow" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($showComemnt->id_user)); ?>">
                                <p class="tz_more_conten_commnet_p_names">
                                <?php echo $showComemnt->user_name; ?>
                                </p>
                                </a>
                                <p class="tz_more_conten_commnet_ps">
                                <?php echo $showComemnt->content_cm; ?>
                                </p>
                                <p class="tz_more_conten_commnet_dates">
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_TIME'); ?>:  <?php echo date('Y F d',strtotime( $showComemnt->dates )); ?>
                                </p>
                                </li>
                            <?php
                            }
                            }
                            ?>
                        </ul>
                        <?php
                        if(isset($Pins->showcomment) && count($Pins->showcomment) >= $this->page_com ){
                            ?>
                            <div class="tz_ajax_page_cm">
                                <a class="tz_commnet_pt_span" data-optio-page="2" class="btn btn-large btn-block">
                                <span>
                                    <?php
                                    echo JText::_('COM_TZ_PINBOARD_VIEW_COMMENT');
                                    ?>
                                </span>
                                </a>
                                <a class="tz_empty_span" style="display: none">
                                    <span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_NOT_PAGES'); ?></span>
                                </a>
                            </div>
                            <?php } ?>
                    </div>
                    <div class="tz_pin_comsPins_from">
                        <?php if(isset($this->UserImgLogin->images) && !empty($this->UserImgLogin->images)){  ?>
                            <img class="tz_pin_comsPins_img"  src="<?php echo JUri::root().'/'.$this->UserImgLogin->images;  ?>">
                        <?php }else{ ?>
                            <img class="tz_pin_comsPins_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                        <?php   }?>
                        <img class="tz_pin_comsPins_img" src="<?php echo JUri::root().'/'.$this->UserImgLogin->images; ?>" alt="">
                        <form method="<?php echo JRoute::_('index.php?option=com_tz_pinboard'); ?>">
                            <input type="hidden" class="tz_hd_id_pin" value="<?php echo $Pins->content_id; ?>">
                            <textarea class="tz_commnet_add_pin" maxlength="<?php echo $this->Limit_comment;  ?>" style="width: 64%" placeholder="<?php echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); ?>"></textarea>
                            <p class="tz_comment_erroc_p"></p>
                            <?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ ?>
                            <input class="tz_bt_pin_add btn btn-small" type="button" name="tz_bt_pin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADD_COMMENT'); ?>">
                            <?php } else{
                            ?>
                            <span class="tz_commnet_sp"><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LOGGED_IN'); ?></span>
                            <?php
                                }
                            ?>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php
    }
}
?>
