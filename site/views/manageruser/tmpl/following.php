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

    $doc = JFactory::getDocument();
    $doc->addStyleSheet('components/com_tz_pinboard/css/manageruser.css');

    $doc->addStyleSheet('components/com_tz_pinboard/css/more_pin.css');
    $doc->addStyleSheet('components/com_tz_pinboard/css/like.css');
?>

<script type="text/javascript">
    /*
    * method calculated width of tags div
    */
    function tz_init(defaultwidth){
        var contentWidth    = jQuery('.tz_pin_following_warp').width();
        var columnWidth     = defaultwidth;
        if(columnWidth >contentWidth ){
            columnWidth = contentWidth;
        }
        var  curColCount = Math.floor(contentWidth / columnWidth);
        var newwidth = columnWidth * curColCount;
        var newwidth2 = contentWidth - newwidth;
        var newwidth3 = newwidth2/curColCount;
        var newColWidth = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pin_following_user').css("width",newColWidth); // running masonry
    }
    var resizeTimer = null;
    jQuery(window).bind('load resize', function() { // when the browser changes the div tag changes accordingly
    if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init("+"<?php echo $this->width_follow;  ?>)", 100);
    });

    jQuery(document).ready(function(){
        jQuery('.tz_following').toggle(function(){
            jQuery(this).css("background","#c0c0c0");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?></span>');
            jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.follow',
            type: 'post',
            data:{
                id_user_guest: jQuery(this).attr('data-option-id')

            }
            }).success(function(data){
                data =  data.replace(/^\s+|\s+$/g,'');
                if(data =='f'){
                    window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                }
            });
        },function(){
            jQuery(this).css("background","");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unfollow',
                type: 'post',
                data:{
                    id_user_guest: jQuery(this).attr('data-option-id')

                }
            }).success(function(){

            });
        });

        jQuery('.untz_following').toggle(function(){
            jQuery(this).css({
                "background": "rgb(238,238,238)",
                "background": "-moz-linear-gradient(top, rgba(238,238,238,1) 0%, rgba(238,238,238,1) 100%)",
                "background": " -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(238,238,238,1)))",
                "background": " -webkit-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%)",
                "background":"-o-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%)",
                "background": " -ms-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%)",
                "background": "linear-gradient(to bottom, rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%)"

            });
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW') ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unfollow',
                type: 'post',
                data:{
                id_user_guest: jQuery(this).attr('data-option-id')

                }
            }).success(function(){

            });
        },function(){
            jQuery(this).css("background","#c0c0c0");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.follow',
                type: 'post',
                data:{
                id_user_guest: jQuery(this).attr('data-option-id')

                }
            }).success(function(){

            });
        });

    });
</script>

<div id="tz_pinboard_warp">
    <?php echo $this->loadtemplate('menu'); ?>
    <div class="cler"></div>
</div>
<div class="tz_pin_following">
    <div class="tz_pin_following_warp">
        <?php
            if(isset($this->ShowFollow) && !empty($this->ShowFollow)){

                foreach($this->ShowFollow as $followes){
        ?>
                     <div class="tz_pin_following_user">
        <div class="tz_pin_following_warp_user">
            <div class="tz_pin_following_left">
               <?php if(isset($followes->tzimages) && !empty($followes->tzimages)){  ?>
                      <img class="tz_pin_following_left_img"  src="<?php echo JUri::root().'/'.$followes->tzimages;  ?>">
               <?php }else{ ?>
                       <img class="tz_pin_following_left_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                 <?php   }?>

            </div>
            <div class="tz_pin_following_right">
                    <ul>
                        <li class="tz_pin_following_right_li1">
                            <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($followes->uid)); ?>" rel="nofollow">
                                <?php echo $followes->uname; ?>
                            </a>
                            <?php
                            if($followes->uid != $this->sosanhuser){
                               if($followes->followCheck['f'] =='0' ||$followes->followCheck['f']=='' ){

                               ?>
                                   <button class="tz_pin_following_button tz_following" data-option-id="<?php echo $followes->uid ?>" >
                                       <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>
                                   </button>
                             <?php
                                    }else if($followes->followCheck['f'] =='1'){
                               ?>
                                   <button style="background: #c0c0c0" class="tz_pin_following_button untz_following" data-option-id="<?php echo $followes->uid ?>" >
                                       <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>
                                    </button>
                              <?php
                               }
                            }
                            ?>

                        </li>
                        <li class="tz_pin_following_right_li2">
                            <?php

                            $dem = count($followes->follow);
                                for($i=0; $i< $dem; $i++){

                                $img_size = $this->img_size;
                                $img_type = JFile::getExt($followes->follow[$i]->tzimgaes);
                                $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$followes->follow[$i]->tzimgaes);
                             ?>
                            <a class="tz_pin_following_button_a" href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.more.board&id_guest='.$followes->follow[$i]->cid.'&id_board='.$followes->follow[$i]->bordid); ?>" rel="nofollow">
                                <img class="tz_pin_following_left_img"  src="<?php echo JUri::root().'/'.$img_type_replaca ?>"  >
                            </a>
                            <?php
                                }
                            ?>
                            <a class="cler"></a>
                        </li>
                    </ul>
              </div>
            <div class="cler"></div>
        </div>
            </div>
            <?php
            }

            }else{
                ?>
                <div class="tz_not_followers">
                                 <span class="tz_not_fol_sp">
                                     <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOWING_NOT_DS'); ?>
                                 </span>
                             </div>
         <?php
            }
        ?>

        <div class="cler"></div>
    </div>
    <div class="pagination pagination-toolbar ">

                     <?php  echo $this -> PaginationFolloing -> getPagesLinks(); ?>
                  </div>
</div>