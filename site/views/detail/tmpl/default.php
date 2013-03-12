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




?>
<script type="text/javascript">
    jQuery(document).ready(function(){
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
          jQuery("#tz_post_cm").live("click",function(){ // ajax comment
         
                    var checkTexs = jQuery("#tz_comment").val();
                    if(checkTexs==""){
                            alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
                            jQuery("#tz_comment").focus();
                            return false;

                  }else{
                      jQuery.ajax({
                           url: "index.php?option=com_tz_pinboard&view=detail&task=tz.insert.comment&Itemid=<?php echo JRequest::getVar('Itemid');?>",
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
               url: "index.php?option=com_tz_pinboard&view=detail&task=tz.delete.comment",
                type: "post",
               data:{
                   id: jQuery(this).attr("data-option-id"),
                   id_pins: jQuery(this).attr('data-option-text')
               }
           }).success(function(data){
                         var getData = jQuery.parseJSON(data);
                         jQuery("#tz_count_number").html(getData.count_number);
                         jQuery(".tz_content_cm ul").html(getData.contents);
                   });
        });
      jQuery("#tz_comment_pt_a").live("click",function(){
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
                      jQuery("#tz_comment_pt_a").css("display","none");
                      jQuery("#tz_comment_pt_emty").css("display","block");
                  } else{

                      jQuery(".tz_content_cm ul").prepend(data);
                        var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-page");
                         var pages = parseInt(pages)+1;
                      jQuery("#tz_comment_pt_a").attr("data-optio-page",pages);
                  }
                       });
            });

        jQuery('#tz_post_cm_erro').live("click",function(){
                        window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
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
                jQuery(this).html('<span><?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?></span>');
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
</script>
<div  class="thumbnails" id="tz_detail">
  <?php     if(isset($this->show_detail) && $this->show_detail != false){ ?>
  <div class="thumbnail" >
      
        <?php echo $this->loadTemplate('ajaxpins'); ?>

  </div>
  <?php } else{
    ?>
    <div class="alert alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4><?php echo JText::_('COM_TZ_PINBOARD_ERRO_DETAIL'); ?></h4>
        <?php echo JText::_('COM_TZ_PINBOARD_ERRO_DETAIL2'); ?>
    </div>
  <?php
  } ?>

</div>
