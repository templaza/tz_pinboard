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
$doc = &JFactory::getDocument();
$doc->addStyleSheet('components/com_tz_pinboard/css/detail.css');
$doc->addStyleSheet('components/com_tz_pinboard/css/manageruser.css');
$doc->addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');
$doc    -> addStyleSheet('components/com_tz_pinboard/css/comment.css');
$doc -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.masonry.min.js"></script>');
$doc -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.infinitescroll.min.js"></script>');


?>
<script type="text/javascript">


    /*
    * method calculated width of tags div
    */
    function tz_init(defaultwidth){
        var contentWidth    = jQuery('#tz_pins_conten_all').width();
        var columnWidth     = defaultwidth;
        if(columnWidth >contentWidth ){
            columnWidth = contentWidth;
        }
        var  curColCount = Math.floor(contentWidth / columnWidth);
        var newwidth = columnWidth * curColCount;
        var newwidth2 = contentWidth - newwidth;
        var newwidth3 = newwidth2/curColCount;
        var newColWidth = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pin_content_class').css("width",newColWidth); // running masonry
        jQuery('#tz_pins_conten_all').masonry({
            itemSelector: '.tz_pin_content_class'
        });
    }
    var resizeTimer = null;
    jQuery(window).bind('load resize', function() { // when the browser changes the div tag changes accordingly
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init("+"<?php echo $this->width_pin; ?>)", 100);
    });
    var  urls ="<?php echo JRoute::_("index.php?option=com_users&view=login") ; ?>";

    jQuery(document).ready(function(){
        tz_init(<?php echo $this->width_columns; ?>); //call functon tz_init
        jQuery('.tz_repin').click(function(){ // show light box repin
            jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin',
            type: 'post',
            data:{
                id_conten: jQuery(this).attr('data-option-id')
            }
        }).success(function(data){
            data =  data.replace(/^\s+|\s+$/g,'');
            if(data!="0"){
                 jQuery("body").css("overflow-y","hidden");
                    jQuery('#tz_repin_more_warp_form').html(data);
                    jQuery('#tz_repin_more_warp').fadeIn(400);
                    var height = jQuery("#tz_repin_more_warp").height();
                    jQuery('#tz_warp_hide').css("height",height);
                    jQuery('#tz_repin_more_warp_form').fadeIn(50);
                    jQuery('#tz_repin_img_delete, #tz_warp_hide').click(function(){
                            jQuery('#tz_repin_more_warp_form').fadeOut(50);
                            jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                            jQuery("body").css("overflow-y","scroll");
                         });
                    });
                jQuery('#tz_repin_title').focus(function(){ // jquery title
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
                });// and title
                jQuery('#tz_repin_introtext').focus(function(){ // jquery introtext
                    jQuery('#tz_repin_introtext').keyup(function(){
                        var Max_Text_input = jQuery('#tz_repin_introtext').attr('maxlength');
                        var Text_value_input = jQuery('#tz_repin_introtext').attr('value');
                        var Den_text_input = Text_value_input.length;
                        var p_title = document.getElementById('tz_repin_more_descript');
                        var HieuText = Max_Text_input - Den_text_input;
                        if(HieuText >0){
                            p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?> "+HieuText;
                        }else{
                            p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
                        }
                    });
                });
                jQuery('#tz_repin_introtext').blur(function(){
                    var p_title = document.getElementById('tz_repin_more_descript');
                    p_title.innerHTML=" ";
                }); // and introtext

            }else{
                window.location=urls;
            }
        });
        });

        jQuery("#tz_repin_button").live("click",function(){ // start repin
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
                jQuery("#tz_repin_more_warp_form").fadeOut(1000);
                jQuery("#tz_repin_more_notice").animate({bottom:"60%"},900);
                jQuery("#tz_repin_more_notice").animate({"opacity":"hide"},2800, function(){
                jQuery("#tz_repin_more_notice").css({
                    "bottom":"-100%",
                    "display":"block"
                });
                 jQuery("#tz_repin_more_warp").fadeOut(400, function(){
                           jQuery("body").css("overflow-y","scroll");
                    });
                });
            });
        });
        // like
        jQuery('.tz_like').toggle(function(){
            jQuery(".Tz_plaza").addClass("Tz_l");
            jQuery(this).css("background","#c0c0c0");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?></span>');
            jQuery.ajax({
               url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                 if(data =='f'){
                     window.location=urls;
                }else{
                     jQuery(".Tz_l .tz_pin_like").html(data+ "   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?>");
                     jQuery("div").removeClass("Tz_l");
                }
            });
        },function(){
            jQuery(".Tz_plaza").addClass("Tz_l");
            jQuery(this).css("background","");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                data =  data.replace(/^\s+|\s+$/g,'');
                if(data =='f'){
                    window.location=urls;
                }else{
                    jQuery(".Tz_l .tz_pin_like").html(data+ "   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?>");
                    jQuery("div").removeClass("Tz_l");
                }
            });
        }); // end like
        jQuery('.tz_unlike').toggle(function(){ // unlike
            jQuery(".Tz_plaza").addClass("Tz_l");
            jQuery(this).css({
                "background": "rgb(255,255,255)",
                "background": "-moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%)",
                "background": "-webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1))",
                "background": "-webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                "background":"-o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                "background": "-ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)",
                "background": "linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%)"
            });
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?></span>');
            jQuery.ajax({
                 url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                 if(data =='f'){
                     window.location=urls;
                }else{
                     jQuery(".Tz_l .tz_pin_like").html(data+ "   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?>");
                     jQuery("div").removeClass("Tz_l");
                 }
            });
        },function(){
            jQuery(".Tz_plaza").addClass("Tz_l");
            jQuery(this).css("background","#c0c0c0");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                if(data =='f'){
                    window.location=urls;
                }else{
                    jQuery(".Tz_l .tz_pin_like").html(data+ "   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?>");
                    jQuery("div").removeClass("Tz_l");
                }
            });
        }); // end unlike


        jQuery('.tz_more_pin').live("click",function(){ // show detail
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.detail.pins',
                type: 'post',
                data:{
                    id_pins: jQuery(this).attr("data-option-id-img")
                }
            }).success(function(data){
                jQuery("body").css("overflow-y","hidden");
                jQuery('#tz_detail_ajax').html(data);
                jQuery('#tz_repin_more_warp').fadeIn();
                jQuery('#tz_more_conten').fadeIn(50);
                var height = jQuery("#tz_more_conten").height();
                jQuery('#tz_warp_hide').css("height",height);
                jQuery('.tz_detail_pins, #tz_warp_hide').click(function(){ // click
                    jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                        jQuery('#tz_more_conten').fadeOut(50);
                          jQuery("body").css("overflow-y","scroll");
                    });

                });
                jQuery('.tz_erro_follow').click(function(){
                    window.location=urls;
                });
                jQuery('.tz_follow').toggle(function(){ // follow
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
                }); // end foolow
                jQuery('.tz_unfollow').toggle(function(){ // jquery unfollow
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
                });//end unfollo
            });
        });

        jQuery("#tz_comment").live("blur",function(){ // jquery comment
            var textra = jQuery('#tz_comment').val();
            document.getElementById('tz_comment_erroc_p').innerHTML="";
        });
        jQuery('#tz_comment').live("focus",function(){
            var textra = jQuery('#tz_comment').val();
            jQuery('#tz_comment').keyup(function(){  // count text
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
            window.location=urls;
        });
        jQuery("#tz_post_cm").live("click",function(){ // ajax insert comment
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

        // add css
        jQuery('.tz_content_cm ul li').live("mouseenter",function(){
            jQuery(this).addClass("Tz_delete");
        });
        jQuery('.tz_content_cm ul li').live("mouseleave",function(){
            jQuery(this).removeClass("Tz_delete");
        }); // and add css

        jQuery(".Tz_delete .tz_comment_delete").live("click",function(){ // ajax delete comment
            jQuery(".Tz_delete").addClass("tz_d");
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
                        jQuery(".tz_d").remove();
            });
        });

        jQuery("#tz_comment_pt_a").live("click",function(){ // ajax insert comment
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




          // add css
        jQuery('.tz_pin_content_class').live("mouseenter",function(){
            jQuery(this).addClass("Tz_plaza");
        });
        jQuery('.tz_pin_content_class').live("mouseleave",function(){
            jQuery(this).removeClass("Tz_plaza");
        }); // and add css

        //click comment
        jQuery('.tz_pin_conmments').toggle(function(){
            jQuery(".Tz_plaza .tz_pin_comsPins_from").css("display","block");
            jQuery('#tz_pinboard').masonry({
                itemSelector: '.tz_pin_all_content'
            });
        },function(){
            jQuery(".Tz_plaza .tz_pin_comsPins_from").css("display","none");
            jQuery('#tz_pinboard').masonry({
                itemSelector: '.tz_pin_all_content'
            });
        });//and click

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

        jQuery(".tz_bt_pin_add").live("click",function(){ // ajax comment
            jQuery(".Tz_plaza").addClass("Tz_cm");
            var checkTexs = jQuery(".Tz_cm textarea").val();
            if(checkTexs==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
                jQuery(".Tz_cm textarea").focus();
                jQuery("div").removeClass("Tz_cm");
                return false;

            }else{
                jQuery.ajax({
                    url: "index.php?option=com_tz_pinboard&view=pinboard&task=tz.insert.comment_cm&Itemid=<?php echo JRequest::getVar('Itemid');?>",
                    type: "post",
                    data:{
                        id_content: jQuery(".Tz_cm input").val(),
                        content: jQuery(".Tz_cm textarea").val()
                    }
                }).success(function(data){
                    var getData = jQuery.parseJSON(data);
                            jQuery(".Tz_cm .tz_pin_comment").html(getData.count_number + " <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>");
                    jQuery(".Tz_cm textarea").attr("value","");
                    jQuery(".Tz_cm .tz_pin_comsPins_content ul").prepend(getData.contents);
                            jQuery("div").removeClass("Tz_cm");
                      jQuery('#tz_pins_conten_all').masonry({
                        itemSelector: '.tz_pin_content_class'
                    });

                });
            }
        });
         // page on
        jQuery(".Tz_plaza .tz_comment_pt_span").live("click",function(){
            jQuery(".Tz_plaza").addClass("Tz_pt");
            jQuery.ajax({
                url:"index.php?option=com_tz_pinboard&view=pinboard&task=tz.pt.cm",
                type: "post",
                data:{
                    id_pins: jQuery(".Tz_pt .tz_hd_id_pin").val(),
                    page: jQuery(this).attr("data-optio-page")
                }
            }).success(function(data){
                        data =  data.replace(/^\s+|\s+$/g,'');
                        if(data.length==0){
                            jQuery(".Tz_pt .tz_comment_pt_span").css("display","none");
                            jQuery(".Tz_pt .tz_empty_span").css("display","block");
                        }else{
                            jQuery(".Tz_pt .tz_pin_comsPins_content ul").prepend(data);
                             jQuery('#tz_pins_conten_all').masonry({
                                itemSelector: '.tz_pin_content_class'
                            });
                            var pages =  jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-page");
                            var pages = parseInt(pages)+1;
                            jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-page",pages);
                        }
                        jQuery("div").removeClass("Tz_pt");
                    });
        });

        jQuery(".tz_pin_conmments_ero").live("click",function(){
            window.location=urls;
        });

        jQuery(".tz_like_ero").live("click",function(){
            window.location=urls;
        });
    });
</script>

<div id="tz_pinboard_warp">
    <?php
        echo $this->loadtemplate('menu');
    ?>
<div class="cler"></div>
</div>
<div id="tz_pinboar_warp_conten_pins">
    <div id="tz_pins_conten_all">
        <?php
              if(isset($this->PinLike) && !empty($this->PinLike)){
                foreach($this->PinLike as $Pins){
        ?>
                    <div class="tz_pin_content_class">
                        <div class="tz_thumbnail thumbnail">
                            <?php
                                $img_size = $this->img_size;
                                $img_type = JFile::getExt($Pins->poro_img);
                                $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$Pins->poro_img);
                            ?>
                            <a class="tz_a_center" <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?>  rel="nofollow">
                                <img  data-option-id-img="<?php echo $Pins->content_id; ?>" <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> src="<?php echo JUri::root().'/'.$img_type_replaca ?>">
                            </a>
                            <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?>  rel="nofollow">
                                <h6 <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> data-option-id-img="<?php echo $Pins->content_id; ?>">
                                    <?php echo $Pins->conten_title; ?>
                                </h6>
                            </a>
                              <p class="tz_pinboard_like">
                                <span class="tz_pin_like"><?php  echo $Pins->number_like->num_like; ?> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?></span>
                                <span class="tz_pin_comment"><?php echo $Pins->number_comment->count_l; ?>   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?></span>
                                <span class="tz_pin_hits"><?php echo $Pins->content_hit; ?>   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_HITS'); ?></span>
                            </p>
                                <?php if(isset($Pins->tags) && !empty($Pins->tags)){ ?>
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
                        <?php } ?>
                            <?php
                                if(isset($Pins->website) && !empty($Pins->website)){
                            ?>
                                    <p>
                                    <a class="tz_pin_content_class_2_web" href="<?php echo $Pins->website; ?>" target="_blank" rel="nofollow">
                                    <?php
                                          echo $Pins->website;
                                     ?>
                                    </a>
                                    <?php
                                } else if(isset($Pins->name_user_repin) && !empty($Pins->name_user_repin)){
                                    ?>

                                    <a class="tz_pin_content_class_2_web " href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&id_guest='.$Pins->id_user_repin); ?>"  rel="nofollow">
                                    <?php    echo  JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN_BY')." ". $Pins->name_user_repin; ?>
                                    </a>
                                    <?php
                                 }else{
                                    ?>
                                       <a class="tz_pin_content_class_2_web " >
                                             <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_USER_BY'); ?>
                                        </a>
                                    </p>
                                <?php
                                }
                                ?>
                            <div class="tz_button_pins">
                                <a class="tz_button_repin tz_repin"  data-option-id="<?php echo $Pins->content_id; ?>" >
                                    <span>
                                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
                                    </span>
                                </a>
                            <?php
                                if($Pins->id_user == $this->sosanhuser ){
                             ?>
                                        <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&task=tz.edit.pins&view=manageruser&id_pins='.$Pins->content_id) ?>" class="tz_button_repin"  rel="nofollow">
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

                                         <a   class="tz_button_repin  <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_like_ero"; }else{ echo"tz_like"; }  ?>" data-text-like="tz_like" data-option-id="<?php echo $Pins->content_id; ?>">
                                             <span>

                                                 <?php  echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?>

                                             </span>
                                         </a>
                                 <?php
                                    } else  if($Pins->checl_l['p']  =='1' ){
                                 ?>
                                         <a style="background: #c0c0c0"  class="tz_button_repin  tz_unlike" data-text-like="tz_unlike" data-option-id="<?php echo $Pins->content_id; ?>">
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
                                <a data-option-id-img="<?php echo $Pins->content_id; ?>"   class="tz_button_repin <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_pin_conmments_ero"; }else{ echo"tz_pin_conmments"; }  ?>">
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
                            <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/'.$showComemnt->img_user;  ?>">
                        <?php }else{ ?>
                            <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                        <?php } ?>

                        <a rel="nofollow" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($showComemnt->id_user)); ?>">
                            <p class="tz_more_conten_comment_p_names">
                            <?php echo $showComemnt->user_name; ?>
                            </p>
                        </a>
                        <p class="tz_more_conten_comment_ps">
                            <?php echo $showComemnt->content_cm; ?>
                        </p>
                        <?php if(isset($this->show_date) && $this->show_date ==1){ ?>
                        <p class="tz_more_conten_comment_dates">
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_TIME'); ?>:  <?php echo date('Y F d',strtotime( $showComemnt->dates )); ?>
                        </p>
                        <?php } ?>
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>
            <?php if(isset($Pins->showcomment) && count($Pins->showcomment) >= $this->page_com ){ ?>
            <div class="tz_ajax_page_cm">
                <a class="tz_comment_pt_span" data-optio-page="2" class="btn btn-large btn-block">
                        <span>
                        <?php
                            echo JText::_('COM_TZ_PINBOARD_VIEW_COMMENT');
                            ?>
                        </span>
                </a>
                <a class="tz_empty_span" style="display: none">
                        <span>
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_NOT_PAGES'); ?>
                        </span>
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
            <form method="<?php echo JRoute::_('index.php?option=com_tz_pinboard'); ?>">
                <input type="hidden" class="tz_hd_id_pin" value="<?php echo $Pins->content_id; ?>">
                <textarea class="tz_comment_add_pin" maxlength="<?php echo $this->Limit_comment;  ?>" style="width: 64%" placeholder="<?php echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); ?>"></textarea>
                <p class="tz_comment_erroc_p"></p>
                <input class="tz_bt_pin_add btn btn-small " type="button" name="tz_bt_pin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADD_COMMENT'); ?>">
            </form>
        </div>
    </div>
                        </div>
                    </div>
        <?php
                    }
        }
        ?>
        <div style="clear: both"></div>
    </div>
    <?php
        if(!isset($this->Pins) || empty($this->Pins)){
    ?>
    <div class="tz_not_followers">
        <span class="tz_not_fol_sp">
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_PINS_NOT_DS'); ?>
        </span>
    </div>
    <?php
        }
    ?>
    <div class="pagination pagination-toolbar ">
          <?php  echo $this -> PaginationLike -> getPagesLinks();?>
    </div>
</div>


<div id="tz_repin_more_warp">
    <div id="tz_warp_hide">

    </div>
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


