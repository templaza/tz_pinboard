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

        if(isset($this->ShowCommnet) && !empty($this->ShowCommnet)){
            foreach($this->ShowCommnet as $row_cm){
           
?>
            <li>
                     <?php if(isset($row_cm->img_user) && !empty($row_cm->img_user)){  ?>
                               <img class="tz_comment_imgs"  src="<?php echo JUri::root().'/'.$row_cm->img_user;  ?>">
                        <?php }else{ ?>
                                  <img class="tz_comment_imgs" src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>" >
                         <?php   }?>

                            <a class="tz_comment_name"  href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($row_cm->id_user)); ?>">
                                <?php
                                    $name =$row_cm->user_name ;
                                     echo ucwords($name);
                                ?>
                            </a>
                            <p class="tz_comment_cn">
                                     <?php echo $row_cm->content_cm; ?>
                            </p>
                            <p class="tz_comment_dt">
                               <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_TIME') ?>:  <?php echo date('Y F d',strtotime($row_cm->dates)); ?>
                            </p>
                            <?php if($this->sosanhuser == $row_cm->id_user || $this->sosanhuser == $row_cm->create_by){ ?>
                                 <img class="tz_comment_delete" data-option-id=<?php echo $row_cm->id_comment ?> data-option-text=<?php echo $row_cm->content_id_cm; ?>  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/delete3.png'?>" >
                            <?php } ?>
            </li>
                        
            <?php
                }
            }
        ?>