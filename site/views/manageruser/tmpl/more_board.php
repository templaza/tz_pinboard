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

    $add = JFactory::getDocument();
    $add->addStyleSheet('components/com_tz_pinboard/css/detail.css');
    $add->addStyleSheet('components/com_tz_pinboard/css/manageruser.css');
    $add->addStyleSheet('components/com_tz_pinboard/css/more_pin.css');
$add->addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');
    $add -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.masonry.min.js"></script>');
    $add -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.infinitescroll.min.js"></script>');

?>

<script type="text/javascript" xmlns="http://www.w3.org/1999/html">
    jQuery(document).ready(function(){
        jQuery('.tz_repin').click(function(){

        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin',
            type: 'post',
            data:{
                id_conten: jQuery(this).attr('data-option-id')
            }
            }).success(function(data){
                    data =  data.replace(/^\s+|\s+$/g,'');
                      if(data =='0'){
                          window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                         }
                    jQuery('#tz_repin_more_warp_form').html(data);
                    jQuery('#tz_repin_more_warp').fadeIn();
                    jQuery('#tz_repin_more_warp_form_img img').load(function(){
                        var height_div = jQuery('#tz_repin_more_warp_form').height();
                       var height_warp = jQuery('#tz_repin_more_warp').height();
                       if(height_div >= height_warp){
                          jQuery('#tz_repin_more_warp_form').css({ "height":"80%" });
                           jQuery('#tz_repin_more_warp_form').animate({top:'6%'},500);
                       }else if(height_div < height_warp){
//                       var margin_height = Math.floor(((height_warp - height_div)/2) - 10);
                       jQuery('#tz_repin_more_warp_form').animate({top:'6%'},500);
                                           }
                  });
                    jQuery('#tz_repin_title').focus(function(){ // jquery  TITLE
                           jQuery('#tz_repin_title').keyup(function(){
                               var Max_Text_input = jQuery('#tz_repin_title').attr('maxlength');

                               var Text_value_input = jQuery('#tz_repin_title').attr('value');
                               var Den_text_input = Text_value_input.length;

                               var p_title = document.getElementById('tz_repin_more_title');
                               var HieuText = Max_Text_input - Den_text_input;
                               if(HieuText >0){

                                  p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?> "+HieuText;
                               }else{
                                   p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
                               }
                           });
                       });
                  jQuery('#tz_repin_title').blur(function(){
                      var p_title = document.getElementById('tz_repin_more_title');
                      p_title.innerHTML=" ";
                  }); // OVER TITLE


                jQuery('#tz_repin_introtext').focus(function(){ // jquery  Descript
                        jQuery('#tz_repin_introtext').keyup(function(){
                            var Max_Text_input = jQuery('#tz_repin_introtext').attr('maxlength');

                            var Text_value_input = jQuery('#tz_repin_introtext').attr('value');
                            var Den_text_input = Text_value_input.length;
                            var p_title = document.getElementById('tz_repin_more_descript');
                            var HieuText = Max_Text_input - Den_text_input;
                            if(HieuText >0){

                               p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?> "+HieuText;
                            }else{
                                p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?> ";
                            }
                        });
                    });
               jQuery('#tz_repin_introtext').blur(function(){
                   var p_title = document.getElementById('tz_repin_more_descript');
                   p_title.innerHTML=" ";
               }); // OVER Descript

                    jQuery('#tz_repin_img_delete, #tz_repin_more_warp_2').click(function(){

                                jQuery('#tz_repin_more_warp_form').animate({top:'-100%'},500);
                               jQuery('#tz_repin_more_warp').fadeOut(1000);
                           });



                });
        });
        jQuery("#tz_repin_button").live("click",function(){

            var Texra = jQuery("#tz_repin_introtext").attr("value");
            var Title = jQuery("#tz_repin_title").attr("value");
            var board = jQuery("#tz_repin_select").attr("value");
            if(Title ==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_LOCAL_TITLE'); ?>");
                jQuery("#tz_repin_title").focus();
                return false;
            }
            if(Texra ==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_LOCAL_DESCRIPTION'); ?>");
                jQuery("#tz_repin_introtext").focus();
                return false;
            }
            if(board ==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_ERRO_SELECT'); ?>");
                jQuery("#tz_repin_select").focus();
                return false;
            }
                                             jQuery.ajax({
                                                 url: "index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin_insert",
                                                 type: "post",
                                                 data:{
                                                     id_usert: jQuery("#tz_user_id").val(),
                                                     tz_user_name: jQuery("#tz_user_name").val(),
                                                     id_category: jQuery("#tz_repin_select").val(),
                                                     img_conten: jQuery("#tz_repin_img").val(),
                                                     websit_conten: jQuery("#tz_repin_website").val(),
                                                     title_content: jQuery("#tz_repin_title").val(),
                                                     introtex_content: jQuery("#tz_repin_introtext").val(),
                                                     tz_content_alias: jQuery("#tz_content_alias").val(),
                                                     tz_content_access: jQuery("#tz_content_access").val(),
                                                     tz_tag: jQuery("#tz_content_tag").val()

                                                 }
                                             }).success(function(data){

                                                         jQuery("#tz_repin_more_warp_form").animate({top:"-100%"},600);
                                                         jQuery("#tz_repin_more_notice").animate({bottom:"60%"},900);
                                                         jQuery("#tz_repin_more_notice").animate({"opacity":"hide"},2800, function(){
                                                         jQuery("#tz_repin_more_notice").css({
                                                                                             "bottom":"-100%",
                                                                                             "display":"block"
                                                                                             })
                                                          jQuery("#tz_repin_more_warp").fadeOut(1000);

                                                         });


                                              });
                                        });



        jQuery('.tz_like').toggle(function(){
                              jQuery(this).css("background","#c0c0c0");
                               jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?></span>');
                                                       jQuery.ajax({
                                                           url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.like',
                                                           type: 'post',
                                                           data:{
                                                               id_conten: jQuery(this).attr('data-option-id')
                                                           }
                                                       }).success(function(data){
                                                                   data =  data.replace(/^\s+|\s+$/g,'');
                                                                     if(data =='f'){
                                                                         window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                                                                        }
                                                               });

                           },function(){
                               jQuery(this).css("background","");
                               jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?></span>');
                                                       jQuery.ajax({
                                                           url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unlike',
                                                           type: 'post',
                                                           data:{
                                                               id_conten: jQuery(this).attr('data-option-id')
                                                           }
                                                       }).success(function(data){
                                                                   data =  data.replace(/^\s+|\s+$/g,'');
                                                                             if(data =='f'){
                                                                                 window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                                                                                }
                                                               });
                           });
               jQuery('.tz_unlike').toggle(function(){
                   jQuery(this).css({
                                    "background": "rgb(255,255,255)",
                                    "background": "-moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%)",
                                   "background": "-webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1))",
                                   "background": "-webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                                   "background":"-o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                                   "background": "-ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                                   "background": "linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)"


                                   });
                       jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?></span>');
                       jQuery.ajax({
                           url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unlike',
                           type: 'post',
                           data:{
                               id_conten: jQuery(this).attr('data-option-id')
                           }
                       }).success(function(){

                               });
               },function(){
                   jQuery(this).css("background","#c0c0c0");
                   jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?></span>');
                                           jQuery.ajax({
                                               url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.like',
                                               type: 'post',
                                               data:{
                                                   id_conten: jQuery(this).attr('data-option-id')
                                               }
                                           }).success(function(){

                                                   });
               });


        jQuery('.tz_more_pin').live("click",function(){
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.detail.pins',
                type: 'post',
                data:{
                    id_pins: jQuery(this).attr("data-option-id-img")

                }
            }).success(function(data){
                        jQuery('#tz_detail_ajax').html(data);
                        jQuery('#tz_repin_more_warp').fadeIn();
                        jQuery('#tz_more_conten').animate({bottom:'5%'},400);
                        jQuery('.tz_detail_pins, #tz_repin_more_warp_2').click(function(){

                            jQuery('#tz_more_conten').animate({bottom:'-100%'},500);
                            jQuery('#tz_repin_more_warp').fadeOut(1000);
                        });


                        jQuery('.tz_erro_follow').click(function(){
                            window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                        });
                        jQuery('.tz_follow').toggle(function(){
                            jQuery(this).addClass('disabled');
                            jQuery(this).html('<span><?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?></span>');
                            jQuery.ajax({
                                url: 'index.php?option=com_tz_pinboard&detail=pinboard&task=tz.pin.follow',
                                type: 'post',
                                data:{
                                    id_user_guest: jQuery(this).attr('data-option-id')
                                }
                            }).success(function(){

                                    });

                        },function(){
                            jQuery(this).removeClass('disabled');
                            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
                            jQuery.ajax({
                                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
                                type: 'post',
                                data:{
                                    id_user_guest: jQuery(this).attr('data-option-id')

                                }
                            }).success(function(){

                                    });
                        });


                        jQuery('.tz_unfollow').toggle(function(){
                            jQuery(this).removeClass('disabled');
                            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
                            jQuery.ajax({
                                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
                                type: 'post',
                                data:{
                                    id_user_guest: jQuery(this).attr('data-option-id')

                                }
                            }).success(function(){

                                    });
                        },function(){
                            jQuery(this).addClass('disabled');
                            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?></span>');
                            jQuery.ajax({
                                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.follow',
                                type: 'post',
                                data:{
                                    id_user_guest: jQuery(this).attr('data-option-id')

                                }
                            }).success(function(){

                                    });
                        });
                    });
        });


        jQuery("#tz_comment").live("blur",function(){
            var textra = jQuery('#tz_comment').val();
            document.getElementById('tz_comment_erroc_p').innerHTML="";

        });
        jQuery('#tz_comment').live("focus",function(){
            var textra = jQuery('#tz_comment').val();
            jQuery('#tz_comment').keyup(function(){
                var Max_Text_input = jQuery('#tz_comment').attr('maxlength');
                var Text_value_input = jQuery('#tz_comment').attr('value');
                var Den_text_input = Text_value_input.length;
                var p_title = document.getElementById('tz_comment_erroc_p');
                var HieuText = Max_Text_input - Den_text_input;
                if(HieuText >0){
                    p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT'); ?> "+HieuText;
                }else{
                    p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT_0'); ?>";
                }
            });

        });
        jQuery('#tz_post_cm_erro').live("click",function(){
            window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
        });
        jQuery("#tz_post_cm").live("click",function(){ // ajax comment

            var checkTexs = jQuery("#tz_comment").val();
            if(checkTexs==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
                jQuery("#tz_comment").focus();
                return false;

            }else{
                jQuery.ajax({
                    url: "index.php?option=com_tz_pinboard&view=detail&task=tz.insert.commnet&Itemid=<?php echo JRequest::getVar('Itemid');?>",
                    type: "post",
                    data: {
                        id_pins: jQuery("#tz_hd_id_pin").val(),
                        content: jQuery("#tz_comment").val()
                    }
                }).success(function(data){
                            var getData = jQuery.parseJSON(data);
                            jQuery("#tz_count_number").html(getData.count_number);
                            jQuery(".tz_content_cm ul").prepend(getData.contents);

                            jQuery('#tz_comment').attr("value","");
                        });
            }
        });


        jQuery(".tz_comment_delete").live("click",function(){
            jQuery.ajax({
                url: "index.php?option=com_tz_pinboard&view=detail&task=tz.delete.commnet",
                type: "post",
                data:{
                    id: jQuery(this).attr("data-option-id"),
                    id_pins: jQuery(this).attr('data-option-text')
                }
            }).success(function(data){
                        var getData = jQuery.parseJSON(data);
                        jQuery("#tz_count_number").html(getData.count_number);
                        jQuery(".tz_content_cm ul").html(getData.contents);
                        jQuery("#tz_commnet_pt_a").css("display","block");
                        jQuery("#tz_commnet_pt_emty").css("display","none");
                        jQuery("#tz_commnet_pt_a").attr("data-optio-page",2);
                    });
        });

        jQuery("#tz_commnet_pt_a").live("click",function(){
            jQuery.ajax({
                url:"index.php?option=com_tz_pinboard&view=detail&task=tz.ajax.pt.cm",
                type: "post",
                data:{
                    id_pins: jQuery("#tz_hd_id_pin").val(),
                    page: jQuery(this).attr("data-optio-page")
                }
            }).success(function(data){
                        data =  data.replace(/^\s+|\s+$/g,'');
                        if(data==""){
                            jQuery("#tz_commnet_pt_a").css("display","none");
                            jQuery("#tz_commnet_pt_emty").css("display","block");
                        } else{

                            jQuery(".tz_content_cm ul").prepend(data);
                            var pages =  jQuery("#tz_commnet_pt_a").attr("data-optio-page");
                            var pages = parseInt(pages)+1;
                            jQuery("#tz_commnet_pt_a").attr("data-optio-page",pages);
                        }
                    });
        });





        // comment pins





        jQuery('.tz_board_more_board_pin').mouseenter(function(){
                        jQuery(this).find(".tz_pin_comsPins").addClass("Tz_plaza");



                }).mouseleave(function(){
                    jQuery(".tz_pin_comsPins").removeClass("Tz_plaza");

                });
    <?php if(empty($this->sosanhuser)){ ?>;
                 jQuery('.tz_board_more_board_pin').live("mouseenter",function(){
                                 jQuery(".tz_pin_comsPins").removeClass("Tz_plaza");
                             });
                          jQuery('.tz_pin_conmments').click(function(){
                              window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                          });

                      <?php }
                        ?>
                jQuery('.tz_pin_conmments').toggle(function(){
                      jQuery(".Tz_plaza").css("display","block");
                      jQuery('#tz_board_more_board_conten').masonry({
                                  itemSelector: '.tz_board_more_board_pin'
                                });
                  },function(){

                      jQuery(".Tz_plaza").css("display","none");
                      jQuery('#tz_board_more_board_conten').masonry({
                                itemSelector: '.tz_board_more_board_pin'
                        });

                  });

            jQuery(".Tz_plaza textarea").live("focus",function(){
                jQuery(".Tz_plaza .tz_bt_pin_add").css("display","block");



                jQuery('.Tz_plaza textarea').keyup(function(){
                  var Max_Text_input = jQuery('.Tz_plaza textarea').attr('maxlength');

                  var Text_value_input = jQuery('.Tz_plaza textarea').attr('value');
                  var Den_text_input = Text_value_input.length;

                  var p_title = jQuery('.Tz_plaza .tz_comment_erroc_p');
                  var HieuText = Max_Text_input - Den_text_input;
                  if(HieuText >0){

                      p_title.text("<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT'); ?> "+HieuText);
                  }else{
                      p_title.text("<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT_0'); ?>");
                  }
              });
            });
                jQuery(".Tz_plaza textarea").live("blur",function(){
                    jQuery('.Tz_plaza .tz_comment_erroc_p').text("");

                });

                jQuery(".tz_bt_pin_add").live("click",function(){
                    var checkTexs = jQuery(".Tz_plaza textarea").val();
                    if(checkTexs==""){
                        alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
                        jQuery(".Tz_plaza textarea").focus();
                        return false;

                    }else{
                        jQuery.ajax({
                            url: "index.php?option=com_tz_pinboard&view=manageruser&task=tz.insert.commnet_cm&Itemid=<?php echo JRequest::getVar('Itemid');?>",
                            type: "post",
                            data:{
                                id_content: jQuery(".Tz_plaza input").val(),
                                content: jQuery(".Tz_plaza textarea").val()
                            }
                        }).success(function(data){
                                    var getData = jQuery.parseJSON(data);
                                    jQuery(".Tz_plaza .tz_pin_comsPins_content ul").append(getData.contents);
                                    jQuery(".Tz_plaza textarea").attr("value","");
                                    jQuery('#tz_board_more_board_conten').masonry({
                                                             itemSelector: '.tz_board_more_board_pin'
                                                           });

                                });
                }
                });

    });
</script>
<div id="tz_board_more_board">
        <div id="tz_board_more_board_name">
                <span>
                   <?php if(!empty($this->shownameboard->title)){
                        echo $this->shownameboard->title ; }
                    ?>
                </span>
                <span>

                </span>
        </div>
        <div id="tz_board_more_board_conten">
            <?php
                if(isset($this->showboardandpin) && !empty($this->showboardandpin)){
                    foreach($this->showboardandpin as $row_pin){

            ?>
                <div class="tz_board_more_board_pin">

                    <div class="tz_thumbnail thumbnail">

                        <?php
                                     $img_size = $this->img_size;
                                     $img_type = JFile::getExt($row_pin->poro_img);
                                     $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$row_pin->poro_img);
                       ?>

                        <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($row_pin->content_id)); ?>" <?php }  ?>>
                            <img  data-option-id-img="<?php echo $row_pin->content_id; ?>" <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> src="<?php echo JUri::root().'/'.$img_type_replaca ?>">
                        </a>

                        <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($row_pin->content_id)); ?>" <?php }  ?>>
                            <h6 <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> data-option-id-img="<?php echo $row_pin->content_id; ?>">
                                <?php echo $row_pin->conten_title; ?>
                            </h6>
                        </a>
                        <?php
                          if(isset($row_pin->website) && !empty($row_pin->website)){
                         ?>
                        <a class="tz_boar_more_pin_web" href="<?php  echo $row_pin->website; ?>" target="_blank" rel="nofollow">

                           <?php
                                  echo $row_pin->website;
                            ?>
                        </a>
                              <?php

                          } else if(isset($row_pin->id_user_repin) && !empty($row_pin->id_user_repin)){

                        ?>
                          <a class="tz_boar_more_pin_web" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($row_pin->id_user_repin)); ?>" rel="nofollow">
                              <strong><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN_BY'); ?></strong>
                                 <span>
                                   <?php    echo $row_pin->name_user; ?>
                                 </span>
                          </a>
                      <?php
                          }else{

                        ?>
                            <a class="tz_boar_more_pin_web">

                                 <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_USER_BY'); ?>
                             </a>
                        <?php
                          }
                        ?>
                    </p>
                    <div class="tz_buttom_board">
                           <a  class="tz_buttom_repin tz_repin"  data-option-id="<?php echo $row_pin->content_id; ?>" >
                               <span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
                               </span>
                           </a>

                        <?php
                             if($row_pin->id_user == $this->sosanhuser ){
                       ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&task=tz.edit.pins&view=manageruser&id_pins='.$row_pin->content_id) ?>"  rel="nofollow" class="tz_buttom_repin" >
                                    <span>
                                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>
                                    </span>
                                </a>
                     <?php
                          }else{
                       ?>
                     <?php
                           if($row_pin->checl_l['p'] =='0'  || $row_pin->checl_l['p']  =='')
                         {
                            ?>

                           <a   class="tz_buttom_repin  tz_like" data-text-like="tz_like" data-option-id="<?php echo $row_pin->content_id; ?>">
                                                           <span>

                                                               <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>

                                                           </span>
                                                     </a>
                               <?php
                           } else   if($row_pin->checl_l['p']  =='1' ){
                            ?>

                           <a style="background: #c0c0c0"  class="tz_buttom_repin  tz_unlike" data-text-like="tz_unlike" data-option-id="<?php echo $row_pin->content_id; ?>">
                                                             <span>
                                                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                                                             </span>
                           </a>
                               <?php
                           }
                             ?>
                             <?php } ?>
                            <a class="tz_buttom_repin tz_pin_conmments" data-option-id-img="<?php echo $row_pin->content_id; ?>">
                                              <span>
                                                  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>
                                              </span>
                            </a>


                    </div>
                    <div class="tz_pin_comsPins">

                                            <div class="tz_pin_comsPins_content">
                                                <ul>

                                                </ul>
                                            </div>
                                              <div class="tz_pin_comsPins_from">
                                                  <?php if(isset($this->UserImgLogin->images) && !empty($this->UserImgLogin->images)){  ?>
                                                       <img class="tz_pin_comsPins_img"  src="<?php echo JUri::root().'/'.$this->UserImgLogin->images;  ?>">
                                                <?php }else{ ?>
                                                <img class="tz_pin_comsPins_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                                                   <?php   }?>

                                               <form method="<?php echo JRoute::_('index.php?option=com_tz_pinboard'); ?>">
                                                   <input type="hidden" class="tz_hd_id_pin" value="<?php echo $row_pin->content_id; ?>">
                                                   <textarea class="tz_commnet_add_pin" maxlength="<?php echo $this->Limit_comment;  ?>" style="width: 64%"  placeholder="<?php echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); ?>"></textarea>
                                                   <p class="tz_comment_erroc_p"></p>

                                                   <input class="tz_bt_pin_add" type="button" name="tz_bt_pin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADD_COMMENT'); ?>">

                                               </form>
                                          </div>
                                        </div>
                    </div>
                </div>
                  <?php
                             }
                           }
                ?>
            <div class="cler">
            </div>
        </div>
    <?php
              if(!isset($this->showboardandpin) || empty($this->showboardandpin)){
          ?>
                         <div class="tz_not_followers">
                             <span class="tz_not_fol_sp">
                                 <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_PINS_NOT_DS'); ?>
                             </span>
                         </div>
          <?php } ?>
    <div class="pagination pagination-toolbar ">

                     <?php  echo $this -> PaginationBoardPin -> getPagesLinks();?>
    </div>
    <script type="text/javascript">
      jQuery(function(){

        jQuery('#tz_board_more_board_conten').masonry({
          itemSelector: '.tz_board_more_board_pin',
          isRTL: false
        });

      });
    </script>

</div>
<div id="tz_repin_more_warp">
             <div id="tz_repin_more_warp_2"></div>
             <div id="tz_repin_more_warp_form">

             </div>
            <div id="tz_more_conten">
                <img class="tz_detail_pins"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/delete_board.png'?>">
                <div id="tz_detail_ajax">

                </div>
              </div>
             <div id="tz_repin_more_notice">
                     <p>
                         <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN'); ?>
                     </p>
             </div>
    </div>
