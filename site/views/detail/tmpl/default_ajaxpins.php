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



            <p id="tz_p">
                <?php if(isset($this->show_detail->img_user) && !empty($this->show_detail->img_user)){  ?>
                <img id="tz_thumbnails_img"  src="<?php echo JUri::root().'/'.$this->show_detail->img_user;  ?>">
                <?php }else{ ?>
                <img id="tz_thumbnails_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                <?php   }?>

                <a class="tz_detail_user"><?php echo ucwords($this->show_detail->name_user); ?></a>
                <?php
                    if($this->show_detail->id_user != $this->sosanhuser){
                ?>
                <?php
                     if($this->show_detail->follow['f'] =='0' || $this->show_detail->follow['f']=='' )
                     {
                ?>
                <button  class="btn btn-large btn-primary tz_follows <?php if(!isset($this->sosanhuser) || empty($this->sosanhuser)){ echo "tz_erro_follow"; }else{ echo "tz_follow"; } ?> " data-option-text="<?php echo $this->show_detail->name_user; ?>"  data-option-id="<?php echo $this->show_detail->id_user; ?>">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>
                </button>
                   <?php
                    }else if($this->show_detail->follow['f'] =='1'){
                    ?>

                <button  class="btn btn-large btn-primary tz_unfollow disabled" data-option-id="<?php echo $this->show_detail->id_user; ?>">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>
                </button>
                <?php }
              } ?>
            </p>

            <?php
                $img_size = $this->img_size;
                $img_type = JFile::getExt($this->show_detail->poro_img);
                $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$this->show_detail->poro_img);


            ?>
            <img class="tz_imgs" src="<?php echo JUri::root()."/".$img_type_replaca; ?>">
            <?php if(isset($this->show_detail->tags) && !empty($this->show_detail->tags) && $this->show_tags=='1'){ ?>
                <p class="tz_tag_all">
                   <span class="tz_tag"> <?php echo JText::_('COM_TZ_PINBOARD_TAGS'); ?> </span>
                    <?php
                        foreach($this->show_detail->tags as $tag){
                    ?>

                    <a class="label label-info" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"  rel="nofollow">
                        <?php echo $tag->tagname; ?>
                    </a>
                    <?php
                         }
                    ?>

                </p>
            <?php
                }
            ?>
            <?php if(isset($this->show_detail->website) && !empty($this->show_detail->website)){ ?>
                <p>
                    <span class="tz_web"><?php echo JText::_('COM_TZ_PINBOARD_SOURCE_BY'); ?> </span>
                    <a target="_blank"  href="<?php echo $this->show_detail->website; ?>" rel="nofollow">
                        <?php echo $this->show_detail->website; ?>
                    </a>
                </p>
            <?php
                  }
            ?>
            <?php if(isset($this->show_title) && $this->show_title==1){ ?>
                <h6>
                    <?php echo $this->show_detail->conten_title; ?>
                </h6>
            <?php } ?>
            <p>
                <?php echo $this->show_detail->content_introtext; ?>
            </p>
            <div class="thumbnails tz_datail_board">
                <p>
                    <span>
                       <?php echo JText::_('COM_TZ_PINBOARD_SOURCE_BY_PINNED_ONTO'); ?>
                    </span>
                    <a class="tz_name_board" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManagetuset2('',$this->show_detail->id_user,$this->show_detail->category_id)); ?>"  rel="nofollow">
                        <?php echo $this->show_detail->boar_title; ?>
                     </a>
                </p>
                <?php if( isset($this->show_detail->pinboard)  && !empty($this->show_detail->pinboard)){ ?>
                <p>
                    <?php
                     foreach($this->show_detail->pinboard as $pinboard){
                         $img_type = JFile::getExt($pinboard->xr_img);
                         $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$pinboard->xr_img);
                     ?>
                       <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManagetuset2('',$pinboard->created_by_c,$pinboard->catid_cm)); ?>"  rel="nofollow">
                            <img class="tz_img_b" src="<?php echo JUri::root()."/".$img_type_replaca; ?>">
                       </a>
                    <?php
                    }
                    ?>
                </p>
                    <?php } ?>
                <p class="cler"></p>
                <p class="tz_comment_dt">

                     <span> <?php echo JText::_('COM_TZ_PINBOARD_CREATE_DATE')." ".date('Y F d, g:i a',strtotime($this->show_detail->c_created)); ?> </span
                </p>
            </div>
            <div class="thumbnails tz_datail_comment">
                  <p>
                      <span class="tz_bt"><?php echo JText::_('COM_TZ_PINBOARD_COMMENTS_COUNT'); ?></span>
                      <span class="badge badge-info" id="tz_count_number"><?php echo $this->Demcommnet->number_id; ?></span>
                  </p>
                  <p>
                      <from>
                           <input type="hidden" id="tz_hd_id_pin" value="<?php echo $this->show_detail->content_id; ?>">
                          <textarea id="tz_comment"  maxlength="<?php echo $this->limit_comment;  ?>" placeholder="<?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); }else{ echo JText::_('COM_TZ_PINBOARD_LOGIN_COMMENT');  } ?>"></textarea>
                           <span id="tz_comment_erroc_p"></span>
                          <button class="btn" id="<?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ echo"tz_post_cm"; }else{ echo "tz_post_cm_erro"; } ?>"><?php echo JText::_('COM_TZ_PINBOARD_POST_COMMENT'); ?></button>
                      </from>
                  </p>
                <div class="cler"></div>

            </div>

            <div class="thumbnails tz_content_cm">
                    <ul>
                         <?php echo $this->loadTemplate('comment'); ?>
                   </ul>
            <?php if((int)$this->page_commnet < (int)$this->Demcommnet->number_id){ ?>
                    <div class="thumbnails">
                        <a id="tz_comment_pt_a" data-optio-page="2" class="btn btn-large btn-block">
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LOAD_MORE'); ?>
                        </a>
                        <a id="tz_comment_pt_emty">
                           <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_NOT_PAGES'); ?>
                        </a>
                      </div>
                <?php } ?>
            </div>

