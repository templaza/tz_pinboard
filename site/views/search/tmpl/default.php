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

        $app    =   &JFactory::getDocument();
        $app    ->  addStyleSheet('components/com_tz_pinboard/css/detail.css');
        $app    ->  addStyleSheet('components/com_tz_pinboard/css/search.css');
        $app    ->  addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');
        $app    -> addStyleSheet('components/com_tz_pinboard/css/comment.css');
        $app    ->  addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.masonry.min.js"></script>');
        $app    ->  addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.infinitescroll.min.js"></script>');

?>
<script type="text/javascript">

    function tz_init(defaultwidth){
        var contentWidth    = jQuery('#tz_pinboard').width();
        var columnWidth     = defaultwidth;
        if(columnWidth >contentWidth ){
            columnWidth     = contentWidth;
        }
        var curColCount     = Math.floor(contentWidth / columnWidth);
        var newwidth        = columnWidth * curColCount;
        var newwidth2       = contentWidth - newwidth;
        var newwidth3       = newwidth2/curColCount;
        var newColWidth     = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pin_all_content').css("width",newColWidth);
            jQuery('#tz_pinboard').masonry({
            itemSelector: '.tz_pin_all_content'
        });

    }

    var resizeTimer = null;
    jQuery(window).bind('load resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init("+"<?php echo $this->width_columns; ?>)", 100);
    });
    var  urls ="<?php echo JRoute::_("index.php?option=com_users&view=login") ; ?>";

    jQuery(document).ready(function(){
        // add css
        jQuery('.tz_pin_content_class').live("mouseenter",function(){
            jQuery(this).addClass("Tz_plaza");
            jQuery(this).find('.tz_unlike').addClass('tz_unlike_u');
            jQuery(this).find('.tz_like').addClass('tz_like_l');
        });
        jQuery('.tz_pin_content_class').live("mouseleave",function(){
            jQuery(this).removeClass("Tz_plaza");
            jQuery('.tz_like').removeClass('tz_like_l');
            jQuery('.tz_unlike').removeClass('tz_unlike_u');
        });

        jQuery('#tz_more_conten').live("mouseenter",function(){
            jQuery(this).find('.tz_unlike').addClass('tz_unlike_d');
            jQuery(this).find('.tz_like').addClass('tz_like_d');
        });
        jQuery('#tz_more_conten').live("mouseleave",function(){
            jQuery('.tz_like').removeClass('tz_like_d');
            jQuery('.tz_unlike').removeClass('tz_unlike_d');
        });// and add css

        jQuery(".tz_like_l").live("click",function(){
            jQuery(".tz_like_l").css("display","none");
            jQuery(".tz_unlike_u").css("display","block");
            jQuery(".Tz_plaza").addClass("Tz_l");
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
                            jQuery(".Tz_l .tz_pin_like").html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");
                            jQuery("div").removeClass("Tz_l");
                        }
                    });
        });

        jQuery(".tz_unlike_u").live("click",function(){
            jQuery(".tz_like_l").css("display","block");
            jQuery(".tz_unlike_u").css("display","none");
            jQuery(".Tz_plaza").addClass("Tz_l");
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
                            jQuery(".Tz_l .tz_pin_like").html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");
                            jQuery("div").removeClass("Tz_l");
                        }


                    });
        });
        jQuery(".tz_like_d").live("click",function(){
            jQuery(".tz_like_d").css("display","none");
            jQuery(".tz_unlike_d").css("display","block");
            jQuery('.Tz_plazas').find(".tz_like").css("display","none");
            jQuery('.Tz_plazas').find(".tz_unlike").css("display","block");

            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                        jQuery('.Tz_plazas').find('.tz_pin_like').html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");

                    });
        });
        jQuery(".tz_unlike_d").live("click",function(){
            jQuery(".tz_like_d").css("display","block");
            jQuery(".tz_unlike_d").css("display","none");
            jQuery('.Tz_plazas').find(".tz_unlike").css("display","none");
            jQuery('.Tz_plazas').find(".tz_like").css("display","block");
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                        jQuery('.Tz_plazas').find('.tz_pin_like').html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");
                    });
        });
        tz_init(<?php echo $this->width_columns ?>); // call function tz_init
        jQuery('#tz_pinboard_wrap').append('<div id="top"></div>');
        jQuery(window).scroll(function() {
            if(jQuery(window).scrollTop() != 0) {
                jQuery('#top').fadeIn();
            } else {
                jQuery('#top').fadeOut();
            }
        });
        jQuery('#top').click(function() {
            jQuery('html, body').animate({scrollTop:0},500);
        });


        // start repin
        jQuery('.tz_repin').live("click",function(){
            jQuery('#tz_more_conten').fadeOut();
            jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
                if(data!="0"){
                     jQuery("body").css("overflow-y","hidden");
                    jQuery('#tz_repin_more_warp_form').html(data);
                    jQuery('#tz_repin_more_warp').fadeIn(400);
                    jQuery('#tz_repin_more_warp_form').fadeIn(50);
                    jQuery("#tz_repin_more_warp_form img").load(function(){
                        var height = jQuery("#tz_repin_more_warp_form").height();
                        jQuery('#tz_warp_hide').css("height",height);
                    });


                    jQuery('#tz_repin_img_delete, #tz_warp_hide').click(function(){
                        jQuery('#tz_repin_more_warp_form').fadeOut(50);
                        jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                            jQuery("body").css("overflow-y","scroll");
                        });

                    });
                    jQuery('#tz_repin_title').focus(function(){
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
                    });
                    jQuery('#tz_repin_introtext').focus(function(){
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
                    });

                }else{
                    window.location=urls;
                }
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
                        jQuery("#tz_repin_more_warp_form").fadeOut(1000);
                        jQuery("#tz_repin_more_notice").animate({bottom:"60%"},900);
                        jQuery("#tz_repin_more_notice").animate({"opacity":"hide"},1800, function(){
                            jQuery("#tz_repin_more_notice").css({
                                "bottom":"-100%",
                                "display":"block"
                            });
                            jQuery("#tz_repin_more_warp").fadeOut(400, function(){
                                jQuery("body").css("overflow-y","scroll");
                            });
                    jQuery('#tz_pinboard').prepend( jQuery(data) ).masonry( 'reload' );
                    jQuery('.tz_pin_content_class img').load(function(){
                        tz_init(<?php echo $this->width_columns ?>);   // call function tz_init
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
                        });
                    });
                });
            });
        }); // and repin




        jQuery(".tz_pin_conmments_ero").live("click",function(){
            window.location=urls;
        });

        jQuery(".tz_like_ero").live("click",function(){
            window.location=urls;
        });



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


        // count text comment
        jQuery(".Tz_plaza textarea").live("focus",function(){
            jQuery(".Tz_plaza .tz_bt_pin_add").css("display","block");
            var checkTex =  jQuery(".Tz_plaza textarea").val();
            jQuery('.Tz_plaza textarea').live("keyup",function(){
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
        }); // and count text


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
                    url: "index.php?option=com_tz_pinboard&view=pinboard&task=tz.insert.comment_cm",
                    type: "post",
                    data:{
                    id_content: jQuery(".Tz_cm input").val(),
                        content: jQuery(".Tz_cm textarea").val()
                    }
                }).success(function(data){
                    var getData = jQuery.parseJSON(data);
                    jQuery(".Tz_cm .tz_pin_comment").html(getData.count_number + " <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>");
                    jQuery(".Tz_cm textarea").attr("value","");
                    jQuery(".Tz_cm .tz_pin_comsPins_content ul").append(getData.contents);
                    var pages =  jQuery(".Tz_cm .tz_comment_pt_span").attr("data-optio-id");
                    var pages = parseInt(pages)+1;
                    jQuery(".Tz_cm .tz_comment_pt_span").attr("data-optio-id",pages);
                    jQuery("div").removeClass("Tz_cm");
                    jQuery('#tz_pinboard').masonry({
                    itemSelector: '.tz_pin_all_content'
                    });
                });
            }
        }); // and insert comment



        //  detail pin
        jQuery('.tz_more_pin').live("click",function(){
            jQuery(".Tz_plaza").addClass("Tz_plazas");
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.detail.pins',
                type: 'post',
                data:{
                    id_pins: jQuery(this).attr("data-option-id-img")
                }
            }).success(function(data){
                jQuery("body").css("overflow-y","hidden");
                jQuery('#tz_more_conten').html(data);
                jQuery('#tz_repin_more_warp').fadeIn();
                jQuery('#tz_more_conten').fadeIn(50);
                        jQuery("#tz_more_conten img").load(function(){
                            var height = jQuery("#tz_more_conten").height();
                            jQuery('#tz_warp_hide').css("height",height);
                        });
                jQuery('.tz_detail_pins, #tz_warp_hide').click(function(){ // click
                    jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                        jQuery('#tz_more_conten').fadeOut(50);
                          jQuery("body").css("overflow-y","scroll");
                    });

                });
                jQuery('.tz_erro_follow').click(function(){
                    window.location=urls;
                });

                jQuery('.tz_follow').toggle(function(){
                    jQuery(this).addClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&detail=pinboard&task=tz.pin.follow',
                        type: 'post',
                        data:{
                            id_user_guest: jQuery(this).attr('data-option-id')
                        }
                    }).success(function(){

                    });
                },function(){
                    jQuery(this).removeClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>');
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
                    jQuery(this).removeClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
                        type: 'post',
                        data:{
                        id_user_guest: jQuery(this).attr('data-option-id')
                        }
                    }).success(function(){

                    });
                },function(){
                    jQuery(this).addClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>');
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



        // check text comment
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
            window.location=urls;
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
                jQuery(".tz_content_cm ul").append(getData.contents);
                jQuery('#tz_comment').attr("value","");
                var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-id");
                var pages = parseInt(pages)+1;
                jQuery("#tz_comment_pt_a").attr("data-optio-id",pages);
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

        // delete comment
        jQuery(".Tz_delete .tz_comment_delete").live("click",function(){
            jQuery(".Tz_delete").addClass("tz_d");
            jQuery(".tz_notice_detail").fadeIn();
            jQuery(".tz_notice_detail").animate({"top":"30%"},300);
            jQuery(".tz_detail_canel").click(function(){

                jQuery(".tz_notice_detail").animate({"top":"-100%"},function(){
                    jQuery(".tz_notice_detail").css("display","none");
                    jQuery("li").removeClass("tz_d");
                });

            })
            jQuery(".tz_detail_delete").live("click",function(){

                jQuery.ajax({
                    url: "index.php?option=com_tz_pinboard&view=detail&task=tz.delete.comment",
                    type: "post",
                    data:{
                        id: jQuery(".tz_d .tz_comment_delete").attr("data-option-id"),
                        id_pins: jQuery(".tz_d .tz_comment_delete").attr('data-option-text')
                    }
                }).success(function(data){
                            var getData = jQuery.parseJSON(data);
                            jQuery("#tz_count_number").html(getData.count_number);
                            jQuery(".tz_d").remove();
                            jQuery(".tz_notice_detail").animate({"top":"-100%"},function(){
                                jQuery(".tz_notice_detail").css("display","none");
                            });
                            //jQuery(".tz_content_cm ul").html(getData.contents);
                            var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-id");
                            var pages = parseInt(pages) - 1;
                            jQuery("#tz_comment_pt_a").attr("data-optio-id",pages);
                        });
            });
        }); // and delete

        // ajax page
        jQuery("#tz_comment_pt_a").live("click",function(){
            jQuery("#tz_page_stop").css("display","block");
            jQuery.ajax({
                url:"index.php?option=com_tz_pinboard&view=detail&task=tz.ajax.pt.cm",
                type: "post",
                data:{
                    id_pins: jQuery("#tz_hd_id_pin").val(),
                    page: jQuery(this).attr("data-optio-page"),
                    counts: jQuery("#tz_comment_pt_a").attr("data-optio-id")
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
                    jQuery("#tz_page_stop").css("display","none");
                }
            });
        });
        // page on
        jQuery(".Tz_plaza .tz_comment_pt_span").live("click",function(){
            jQuery(".Tz_plaza").addClass("Tz_pt");
            jQuery(".tz_ajax_page_stop").css("display","block");
            jQuery.ajax({
                url:"index.php?option=com_tz_pinboard&view=pinboard&task=tz.pt.cm",
                type: "post",
                data:{
                    id_pins: jQuery(".Tz_plaza .tz_hd_id_pin").val(),
                    page: jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-page"),
                    counts: jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-id")
                }
            }).success(function(data){
                        data =  data.replace(/^\s+|\s+$/g,'');
                        if(data==""){
                            jQuery(".Tz_pt .tz_comment_pt_span").css("display","none");
                            jQuery(".Tz_pt .tz_empty_span").css("display","block");
                            jQuery("div").removeClass("Tz_pt");
                        } else{
                            jQuery(".Tz_pt .tz_pin_comsPins_content ul").prepend(data);
                            jQuery('#tz_pinboard').masonry({
                                itemSelector: '.tz_pin_all_content'
                            });
                            var pages =  jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-page");
                            var pages = parseInt(pages)+1;
                            jQuery(".Tz_pt .tz_comment_pt_span").attr("data-optio-page",pages);
                            jQuery(".tz_ajax_page_stop").css("display","none");
                            jQuery("div").removeClass("Tz_pt");
                        }
                    });
        });
    });
</script>
<div id="tz_pinboard_wrap">
    <div id="tz_pinboard_top">
        <span>
            <?php echo JText::_('COM_TZ_PINBOARD_SEARCH_RESULTS'); ?>
            "  <?php
            echo $this->search_results;
            ?>
            "
        </span>
    </div>
    <div id="tz_pinboard" class="transitions-enabled clearfix">
        <?php
            echo $this->loadTemplate('pinboard');
        ?>
        <div class="cler"></div>
    </div>

<?php if($this->tz_layout=="default"){ ?>
    <div class="pagination pagination-toolbar ">
        <?php
            echo $this -> PaginationPins -> getPagesLinks();
        ?>
    </div>
<?php   } else if($this->Check_pt_pin=='tr'){
?>
    <div id="tz_append">
        <?php
            if($this->tz_layout =="ajaxButton"){
        ?>
            <a  id="tz_append_a"  href="#tz_append"><?php echo JText::_("COM_TZ_PINBOARD_ADD_ITEMS"); ?></a>
            <p style="display: none"> <?php echo JText::_("COM_TZ_PINBOARD_NO_ITEMS"); ?></p>
        <?php
            }
        ?>
    </div>
    <div id="tz_load" style="display: none;">
    <a href="<?php echo JURI::root().'index.php?option=com_tz_pinboard&view=search&task=add_ajax&tz_search_url='.base64_encode(json_encode($this->tz_search)).'&page=2&Itemid='.JRequest::getInt('Itemid'); ?>">
    </a>
    </div>



<script type="text/javascript">
    var   $container = jQuery('#tz_pinboard') ;
    $container.infinitescroll({
        navSelector  : '#tz_load a',    // selector for the paged navigation
        nextSelector : '#tz_load a:first',  // selector for the NEXT link (to page 2)
        itemSelector : '.tz_pin_all_content',     // selector for all items you'll retrieve
        errorCallback: function(){
            <?php if($this->tz_layout =="ajaxButton"):?> // option type paging
                jQuery('#tz_append a').hide();
                jQuery('#tz_append p').show(1200);
            <?php endif;?>
            <?php if($this->tz_layout =="ajaxInfiScroll"):?>
                jQuery('#tz_append').removeAttr('style').html('<a id="tz_not_item"><?php echo JText::_('COM_TZ_PINBOARD_NOT_ITEM');?></a>');
            <?php endif;?>
        },
        loading: {
            msgText: "<em><?php echo JText::_("COM_TZ_PINBOARD_LOAD_MORE"); ?></em>",
            finishedMsg: '',
            img:'<?php echo JURI::root();?>components/com_tz_pinboard/images/ajax-loader.gif',
            selector: '#tz_append'
        }
    },
    function( newElements ){
        if(newElements.length){
            jQuery("#tz_pinboard").css("opacity","0");
            jQuery(newElements).imagesLoaded(function(){
                //jQuery('#tz_pinboard').prepend( jQuery(newElements) ).masonry( 'reload' );
                jQuery('#tz_pinboard').append( jQuery(newElements) ).masonry( 'appended',jQuery(newElements),true );
                tz_init(<?php echo $this->width_columns ?>);

                jQuery('div#tz_append').find('a:first').show();
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
                });


            });
            jQuery("#tz_pinboard").css("opacity","1");
        }

    });
    <?php if($this->tz_layout =="ajaxButton"){?>
        jQuery(window).unbind('.infscr');
        jQuery('#tz_append >a').click(function(){
            jQuery(this).stop();
            jQuery('div#tz_append').find('a:first').hide();
            $container.infinitescroll('retrieve');
        });

    <?php
        }
    }
    ?>

</script>
</div>
<div id="tz_repin_more_warp">
    <div id="tz_warp_hide">

    </div>
    <div id="tz_repin_more_warp_form">

    </div>
    <div id="tz_more_conten">

    </div>
    <div id="tz_repin_more_notice">
    <p>
        <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN'); ?>
    </p>
    </div>

</div>
