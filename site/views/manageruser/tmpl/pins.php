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
$doc    = JFactory::getDocument();
$doc    -> addStyleSheet('components/com_tz_pinboard/css/detail.css');
$doc    -> addStyleSheet('components/com_tz_pinboard/css/manageruser.css');
$doc    -> addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');
$doc    -> addStyleSheet('components/com_tz_pinboard/css/comment.css');
$doc    -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.masonry.min.js"></script>');
$doc    -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.infinitescroll.min.js"></script>');


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
        var  curColCount =  Math.floor(contentWidth / columnWidth);
        var newwidth     =  columnWidth * curColCount;
        var newwidth2    =  contentWidth - newwidth;
        var newwidth3    =  newwidth2/curColCount;
        var newColWidth  =  Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pin_content_class').css("width",newColWidth); // running masonry
        jQuery('#tz_pins_conten_all').masonry({
            itemSelector: '.tz_pin_content_class'
        });
    }
    // method check text
    function checkText(text, maxtext){
        var countText = text.length;
        var text      = maxtext - countText;
        return text;
    }

    var resizeTimer = null;
    jQuery(window).bind('load resize', function() { // when the browser changes the div tag changes accordingly
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init("+"<?php echo $this->width_pin; ?>)", 100);
    });
    var  urls ="<?php echo JRoute::_("index.php?option=com_users&view=login") ; ?>";


    jQuery(document).ready(function(){

        tz_init(<?php echo $this->width_columns; ?>); //call functon tz_init

        var ua = navigator.userAgent, // Check device
        event  = (ua.match(/iPad/i)) ? "touchstart" : "click";


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

        jQuery('#tz_more_content').live("mouseenter",function(){
            jQuery(this).find('.tz_unlike').addClass('tz_unlike_d');
            jQuery(this).find('.tz_like').addClass('tz_like_d');
        });
        jQuery('#tz_more_content').live("mouseleave",function(){
            jQuery('.tz_like').removeClass('tz_like_d');
            jQuery('.tz_unlike').removeClass('tz_unlike_d');
        });// and add css

        <?php if(isset($this->s_button) && $this->s_button==1){ ?>
            jQuery(".tz_like_l").live(event,function(){
                jQuery(".tz_like_l").css("display","none");
                jQuery(".tz_unlike_u").css("display","inline-block");
                jQuery(".Tz_plaza").addClass("Tz_l");
                jQuery.ajax({
                    url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
                    type: 'post',
                    data:{
                        id_conten: jQuery(this).attr('data-option-id'),
                        "<?php echo JSession::getFormToken(); ?>" : 1
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

            jQuery(".tz_unlike_u").live(event,function(){
                jQuery(".tz_like_l").css("display","inline-block");
                jQuery(".tz_unlike_u").css("display","none");
                jQuery(".Tz_plaza").addClass("Tz_l");
                jQuery.ajax({
                    url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
                    type: 'post',
                    data:{
                        id_conten: jQuery(this).attr('data-option-id'),
                        "<?php echo JSession::getFormToken(); ?>" : 1
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
        <?php } ?>
        jQuery(".tz_like_d").live("click",function(){
            jQuery(".tz_like_d").css("display","none");
            jQuery(".tz_unlike_d").css("display","inline-block");
            jQuery('.Tz_plazas').find(".tz_like").css("display","none");
            jQuery('.Tz_plazas').find(".tz_unlike").css("display","inline-block");

            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id'),
                    "<?php echo JSession::getFormToken(); ?>" : 1
                }
            }).success(function(data){
                        jQuery('.Tz_plazas').find('.tz_pin_like').html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");

                    });
        });
        jQuery(".tz_unlike_d").live("click",function(){
            jQuery(".tz_like_d").css("display","inline-block");
            jQuery(".tz_unlike_d").css("display","none");
            jQuery('.Tz_plazas').find(".tz_unlike").css("display","none");
            jQuery('.Tz_plazas').find(".tz_like").css("display","inline-block");
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
                type: 'post',
                data:{
                    id_conten: jQuery(this).attr('data-option-id'),
                    "<?php echo JSession::getFormToken(); ?>" : 1
                }
            }).success(function(data){
                        jQuery('.Tz_plazas').find('.tz_pin_like').html(data+ "  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES');?>");
                    });
        });

        jQuery('#tz_repin_img_delete, #tz_warp_hide').live("click",function(){
            jQuery('#tz_repin_more_warp_form').fadeOut(50);
            jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                jQuery("body").css("overflow-y","scroll");
            });

        });
        jQuery('.tz_repin').live(event,function(){ // show light box repin
            jQuery(".tz_iframe").attr("src","");
            jQuery('#tz_more_content').fadeOut();
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
                    jQuery('#tz_repin_more_warp_form').fadeIn(50);
                    jQuery("#tz_repin_more_warp_form img").load(function(){
                        var height = jQuery("#tz_repin_more_warp_form").height();
                        jQuery('#tz_warp_hide').css("height",height);
                    });


                jQuery('#tz_repin_title').focus(function(){ // jquery title
                    jQuery('#tz_repin_title').keyup(function(){
                        var Max_Text_input   = jQuery('#tz_repin_title').attr('maxlength');
                        var Text_value_input = jQuery('#tz_repin_title').attr('value');
                        var p_title          = document.getElementById('tz_repin_more_title');
                        var Text_t           = checkText(Text_value_input,Max_Text_input);
                        if(Text_t >0){
                            p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?> "+Text_t;
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
                        var Max_Text_input      = jQuery('#tz_repin_introtext').attr('maxlength');
                        var Text_value_input    = jQuery('#tz_repin_introtext').attr('value');
                        var p_title             = document.getElementById('tz_repin_more_descript');
                        var Text_i              = checkText(Text_value_input,Max_Text_input);
                        if(Text_i >0){
                            p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?> "+Text_i;
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

            var Title = jQuery("#tz_repin_title").attr("value");
            var board = jQuery("#tz_repin_select").attr("value");
            if(Title ==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_LOCAL_TITLE'); ?>");
                jQuery("#tz_repin_title").focus();
                return false;
            }

            if(board ==""){
                alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_ERRO_SELECT'); ?>");
                jQuery("#tz_repin_select").focus();
                return false;
            }
            document.getElementById("tz_repin_button").disabled=true;
            jQuery.ajax({
                url: "index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin_insert",
                type: "post",
                data:{
                    id_usert        :   jQuery("#tz_user_id").val(),
                    tz_user_name    :   jQuery("#tz_user_name").val(),
                    id_category     :   jQuery("#tz_repin_select").val(),
                    img_conten      :   jQuery("#tz_repin_img").val(),
                    websit_conten   :   jQuery("#tz_repin_website").val(),
                    title_content   :   jQuery("#tz_repin_title").val(),
                    introtex_content:   jQuery("#tz_repin_introtext").val(),
                    tz_content_alias:   jQuery("#tz_content_alias").val(),
                    tz_content_access:  jQuery("#tz_content_access").val(),
                    tz_tag           :  jQuery("#tz_content_tag").val(),
                    price            :  jQuery("#tz_repin_price").val(),
                    tz_video         :  jQuery("#tz_repin_video").val(),
                    "<?php echo JSession::getFormToken(); ?>" : 1
                }
            }).success(function(data){
                if(data !=""){
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
                }else{
                    jQuery("#tz_repin_more_warp_form").fadeOut(1000);
                    jQuery("#tz_repin_more_notice_erro").animate({bottom:"60%"},900);
                    jQuery("#tz_repin_more_notice_erro").animate({"opacity":"hide"},1800, function(){
                        jQuery("#tz_repin_more_notice_erro").css({
                            "bottom":"-100%",
                            "display":"block"
                        });
                        jQuery("#tz_repin_more_warp").fadeOut(400, function(){
                            jQuery("body").css("overflow-y","scroll");
                        });
                    });
                }
            });
        });

    <?php if(isset($this->type_detail) && $this->type_detail ==1){ ?>
        jQuery('.tz_detail_pins, #tz_warp_hide').live("click",function(){ // click
            jQuery(".tz_iframe").attr("src","");
            jQuery('#tz_repin_more_warp').fadeOut(400,function(){
                jQuery('#tz_more_content').fadeOut(50);
                jQuery("body").css("overflow-y","scroll");
            });

        });
        jQuery('.tz_more_pin, .TzIconVideo').live("click",function(){ // show detail
            jQuery(".Tz_plaza").addClass("Tz_plazas");
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.detail.pins',
                type: 'post',
                data:{
                    id_pins: jQuery(this).attr("data-option-id-img")
                }
            }).success(function(data){
                jQuery("body").css("overflow-y","hidden");
                jQuery('#tz_more_content').html(data);
                jQuery('#tz_repin_more_warp').fadeIn();
                jQuery('#tz_more_content').fadeIn(50);
                jQuery("#tz_more_content img").load(function(){
                    var height = jQuery("#tz_more_content").height();
                    jQuery('#tz_warp_hide').css("height",height);
                });


                jQuery('.tz_erro_follow').click(function(){
                    window.location=urls;
                });
                jQuery('.tz_follow').toggle(function(){ // follow
                    jQuery(this).addClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.follow',
                        type: 'post',
                        data:{
                            id_user_guest: jQuery(this).attr('data-option-id'),
                            "<?php echo JSession::getFormToken(); ?>" : 1
                        }
                    });
                },function(){
                    jQuery(this).removeClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
                        type: 'post',
                        data:{
                            id_user_guest: jQuery(this).attr('data-option-id'),
                            "<?php echo JSession::getFormToken(); ?>" : 1

                        }
                    });
                }); // end foolow
                jQuery('.tz_unfollow').toggle(function(){ // jquery unfollow
                    jQuery(this).removeClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
                        type: 'post',
                        data:{
                            id_user_guest: jQuery(this).attr('data-option-id'),
                            "<?php echo JSession::getFormToken(); ?>" : 1

                        }
                    });
                },function(){
                    jQuery(this).addClass('disabled_d');
                    jQuery(this).html('<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>');
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.follow',
                        type: 'post',
                        data:{
                            id_user_guest: jQuery(this).attr('data-option-id'),
                            "<?php echo JSession::getFormToken(); ?>" : 1

                        }
                    });
                });//end unfollo
            });
        });
        <?php if(isset($this->s_detail) && $this->s_detail==1){ ?>
            jQuery("#tz_comment").live("blur",function(){ // jquery comment
                var textra = jQuery('#tz_comment').val();
                document.getElementById('tz_comment_erroc_p').innerHTML="";
            });
            jQuery('#tz_comment').live("focus",function(){
                var textra = jQuery('#tz_comment').val();
                jQuery('#tz_comment').keyup(function(){  // count text
                    var Max_Text_input   =  jQuery('#tz_comment').attr('maxlength');
                    var Text_value_input =  jQuery('#tz_comment').attr('value');
                    var p_title          =  document.getElementById('tz_comment_erroc_p');
                    var Text_m           =  checkText(Text_value_input,Max_Text_input);
                    if(Text_m >0){
                        p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT'); ?> "+Text_m;
                    }else{
                        p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT_0'); ?>";
                    }
                });
            });
            jQuery('#tz_post_cm_erro').live("click",function(){
                window.location=urls;
            });
            jQuery("#tz_post_cm").live("click",function(){ // ajax insert comment
                jQuery(this).attr('disabled', true);
                var checkTexs  =  jQuery("#tz_comment").val();
                if(checkTexs   ==""){
                    alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
                    jQuery("#tz_comment").focus();
                    return false;
                }else{
                jQuery.ajax({
                    url: "index.php?option=com_tz_pinboard&view=detail&task=tz.insert.comment&Itemid=<?php echo JRequest::getVar('Itemid');?>",
                    type: "post",
                    data: {
                        id_pins: jQuery("#tz_hd_id_pin").val(),
                        content: jQuery("#tz_comment").val(),
                        "<?php echo JSession::getFormToken(); ?>" : 1
                    }
                }).success(function(data){
                    var getData = jQuery.parseJSON(data);
                    jQuery("#tz_count_number").html(getData.count_number);
                    jQuery(".tz_content_cm ul").append(getData.contents);
                    jQuery('#tz_comment').attr("value","");
                    var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-id");
                    var pages = parseInt(pages)+1;
                    jQuery("#tz_comment_pt_a").attr("data-optio-id",pages);
                    jQuery("#tz_post_cm").removeAttr('disabled');
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

            jQuery(".Tz_delete .tz_comment_delete").live("click",function(){
                jQuery(".Tz_delete").addClass("tz_d");
                jQuery(".tz_notice_detail").fadeIn(10);
                jQuery(".tz_notice_detail").animate({"top":"30%"},200);
                jQuery(".tz_detail_canel").click(function(){
                    jQuery(".tz_notice_detail").animate({"top":"-100%"},function(){
                        jQuery(".tz_notice_detail").css("display","none");
                        jQuery("li").removeClass("tz_d");
                    });
                });
            });
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
                            var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-id");
                            var pages = parseInt(pages) - 1;
                            jQuery("#tz_comment_pt_a").attr("data-optio-id",pages);
                        });
            });
            jQuery("#tz_comment_pt_a").live("click",function(){
                jQuery("#tz_page_stop").css("display","block");
                jQuery('#id_loadding').html("<img src='<?php echo JUri::root().'/components/com_tz_pinboard/images/ajax-comment.gif'?>' />").fadeIn('fast');
                jQuery.ajax({
                    url:"index.php?option=com_tz_pinboard&view=detail&task=tz.ajax.pt.cm",
                    type: "post",
                    data:{
                        id_pins: jQuery("#tz_hd_id_pin").val(),
                        page: jQuery(this).attr("data-optio-page"),
                        counts: jQuery("#tz_comment_pt_a").attr("data-optio-id")
                    }
                }).success(function(data){
                            jQuery('#id_loadding').fadeOut();
                            data =  data.replace(/^\s+|\s+$/g,'');
                            if(data==""){
                                jQuery("#tz_comment_pt_a").css("display","none");
                                jQuery(".tz_detail_page").css("display","none");
                            } else{
                                jQuery(".tz_content_cm ul").prepend(data);
                                var pages =  jQuery("#tz_comment_pt_a").attr("data-optio-page");
                                var pages = parseInt(pages)+1;
                                jQuery("#tz_comment_pt_a").attr("data-optio-page",pages);
                                jQuery("#tz_page_stop").css("display","none");
                            }
                        });
            }); // end

<?php  }
    }
?>

    <?php if(isset($this->s_button) && $this->s_button==1){ ?>
        //click comment
        jQuery('.tz_pin_conmments').toggle(function(){
            jQuery(".Tz_plaza .tz_pin_comsPins_from").css("display","block");
              jQuery('#tz_pins_conten_all').masonry({
                                itemSelector: '.tz_pin_content_class'
                            });
        },function(){
            jQuery(".Tz_plaza .tz_pin_comsPins_from").css("display","none");
              jQuery('#tz_pins_conten_all').masonry({
                                itemSelector: '.tz_pin_content_class'
                            });
        });//and click

        jQuery(".Tz_plaza textarea").live("focus",function(){
            jQuery(".Tz_plaza .tz_bt_pin_add").css("display","block");
            jQuery('.Tz_plaza textarea').keyup(function(){
                var Max_Text_input   = jQuery('.Tz_plaza textarea').attr('maxlength');
                var Text_value_input = jQuery('.Tz_plaza textarea').attr('value');
                var p_title          = jQuery('.Tz_plaza .tz_comment_erroc_p');
                var Text_c           = checkText(Text_value_input,Max_Text_input);
                if(Text_c >0){
                    p_title.text("<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT'); ?> "+Text_c);
                }else{
                    p_title.text("<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT_0'); ?>");
                }
            });
        });
        jQuery(".Tz_plaza textarea").live("blur",function(){
            jQuery('.Tz_plaza .tz_comment_erroc_p').text("");
        });

        jQuery(".tz_bt_pin_add").live("click",function(){ // ajax comment
            jQuery(this).attr('disabled', true);
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
                        id_content: jQuery(".Tz_plaza input").val(),
                        content: jQuery(".Tz_plaza textarea").val(),
                        "<?php echo JSession::getFormToken(); ?>" : 1
                    }
                }).success(function(data){
                    var getData = jQuery.parseJSON(data);
                    jQuery(".Tz_cm .tz_pin_comment").html(getData.count_number + " <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>");
                    jQuery(".Tz_cm textarea").attr("value","");
                    jQuery(".Tz_cm .tz_pin_comsPins_content ul").append(getData.contents);
                    var pages =  jQuery(".Tz_cm .tz_comment_page").attr("data-optio-id");
                    var pages = parseInt(pages)+1;
                    jQuery(".Tz_cm .tz_comment_page").attr("data-optio-id",pages);
                    jQuery("div").removeClass("Tz_cm");
                      jQuery('#tz_pins_conten_all').masonry({
                        itemSelector: '.tz_pin_content_class'
                    });
                    jQuery(".tz_bt_pin_add").removeAttr('disabled');
                });
            }
        });
        <?php } ?>
        <?php if(isset($this->s_thumb) && $this->s_thumb ==1){  ?>
            jQuery(".Tz_plaza .tz_comment_page").live("click",function(){   // page on
                jQuery(".Tz_plaza").addClass("Tz_pt");
                jQuery('.Tz_pt #id_load_thum').html("<img src='<?php echo JUri::root().'/components/com_tz_pinboard/images/ajax-comment.gif'?>' />").fadeIn('fast');
                jQuery(".tz_ajax_page_stop").css("display","block");
                jQuery.ajax({
                    url:"index.php?option=com_tz_pinboard&view=pinboard&task=tz.pt.cm",
                    type: "post",
                    data:{
                        id_pins: jQuery(".Tz_pt .tz_hd_id_pin").val(),
                        page: jQuery(".Tz_pt .tz_comment_page").attr("data-optio-page"),
                        counts: jQuery(".Tz_pt .tz_comment_page").attr("data-optio-id")
                    }
                }).success(function(data){
                            jQuery('.Tz_pt #id_load_thum').fadeOut();
                            data =  data.replace(/^\s+|\s+$/g,'');
                            if(data==""){
                                jQuery(".Tz_pt .tz_comment_page").css("display","none");
                                jQuery(".Tz_plaza .tz_ajax_page_cm").css("display","none");
                                jQuery(".tz_ajax_page_stop").css("display","none");
                                jQuery("div").removeClass("Tz_pt");
                            } else{
                                jQuery(".Tz_pt .tz_pin_comsPins_content ul").prepend(data);
                                jQuery('#tz_pins_conten_all').masonry({
                                    itemSelector: '.tz_pin_content_class'
                                });
                                var pages =  jQuery(".Tz_pt .tz_comment_page").attr("data-optio-page");
                                var pages = parseInt(pages)+1;
                                jQuery(".Tz_pt .tz_comment_page").attr("data-optio-page",pages);
                                jQuery(".tz_ajax_page_stop").css("display","none");
                                jQuery("div").removeClass("Tz_pt");
                            }
                        });
            });
        <?php } ?>
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
            if(isset($this->Pins) && !empty($this->Pins)){
                foreach($this->Pins as $Pins){
        ?>
                    <div class="tz_pin_content_class">
                        <div class="tz_thumbnail thumbnail">
                            <?php if(isset($Pins->c_attribs) && !empty($Pins->c_attribs)){ ?>
                                <p class="tz-detail-price2">
                                    <?php
                                        $price = new JRegistry($Pins->c_attribs);
                                        echo $price->get('price');
                                    ?>
                                </p>
                            <?php } ?>
                            <?php
                                $img_size = $this->img_size;
                                $img_type = JFile::getExt($Pins->poro_img);
                            if ($img_type == 'gif') {
                                $img_type_replaca = $Pins->poro_img;
                            } else {
                                $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $Pins->poro_img);
                            }
                            ?>
                            <div class="tz_hover_img">
                                <a class="tz_a_center" <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?>  rel="nofollow">
                                    <img  data-option-id-img="<?php echo $Pins->content_id; ?>" <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> src="<?php echo JUri::root().'/'.$img_type_replaca ?>">
                                </a>
                                <?php if(isset($Pins->pz_video) && !empty($Pins->pz_video)){ ?>
                                    <span class="TzIconVideo" data-option-id-img="<?php echo $Pins->content_id; ?>"></span>
                                <?php } ?>
                                <?php if(isset($this->title_thum) && $this->title_thum==1){ ?>
                                    <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php }  ?>  rel="nofollow">
                                        <h6 <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> data-option-id-img="<?php echo $Pins->content_id; ?>">
                                            <?php echo $Pins->conten_title; ?>
                                        </h6>
                                    </a>
                                <?php } ?>

                            </div>
                            <?php if(isset($this->count_button) && $this->count_button==1){ ?>
                                    <p>
                                        <span class="tz_pin_like"><?php  echo $Pins->number_like->num_like; ?> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?></span>
                                        <span class="tz_pin_comment"><?php echo $Pins->number_comment->count_l; ?>   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?></span>
                                        <span class="tz_pin_hits"><?php echo $Pins->content_hit; ?>   <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_HITS'); ?></span>
                                    </p>
                            <?php } ?>
                            <?php if(isset($Pins->tags) && !empty($Pins->tags) && $this->tag_thum==1){ ?>
                                <p>
                                    <span> <?php echo JText::_('COM_TZ_PINBOARD_TAGS'); ?> </span>
                                    <?php
                                    foreach($Pins->tags as $tag){
                                        ?>
                                        <a  href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"  rel="nofollow">
                                            <?php echo "# ".$tag->tagname; ?>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </p>
                            <?php } ?>
                            <?php if(isset($this->s_button) && $this->s_button == 1){ ?>
                            <div class="tz_button_pins">
                                <a class="tz_button_repin  tz_repin"  data-option-id="<?php echo $Pins->content_id; ?>" >
                                    <span>
                                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
                                    </span>
                                </a>
                                <span class="tz_pinboard_sp">/</span>
                                <?php
                                if($Pins->id_user == $this->sosanhuser ){
                                    ?>
                                    <a class="tz_button_repin"  href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&task=tz.edit.pins&view=manageruser&id_pins='.$Pins->content_id) ?>"  rel="nofollow">
                                        <span>
                                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>
                                        </span>
                                    </a>
                                    <span class="tz_pinboard_sp">/</span>
                                    <?php
                                }else{
                                    ?>
                                    <a class="tz_button_repin  <?php if($Pins->checl_l['p']  =='1' ){  echo "tz_check_like"; }  ?> <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_like_ero"; }else{ echo"tz_like"; }  ?>" data-text-like="tz_like" data-option-id="<?php echo $Pins->content_id; ?>">
                                        <span>
                                            <?php  echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>
                                        </span>
                                    </a>
                                    <a class="tz_button_repin   tz_unlike disabled_d <?php  if($Pins->checl_l['p'] =='0'  || $Pins->checl_l['p']  ==""){ echo "tz_check_like"; } ?> "  data-option-id="<?php echo $Pins->content_id; ?>">
                                        <span>
                                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                                        </span>
                                    </a>
                                    <span class="tz_pinboard_sp">/</span>
                                    <?php
                                }
                                ?>
                                <a data-option-id-img="<?php echo $Pins->content_id; ?>"   class="tz_button_repin  <?php if(empty($this->sosanhuser) || $this->sosanhuser=="0"){ echo"tz_pin_conmments_ero"; }else{ echo"tz_pin_conmments"; }  ?>">
                                   <span>
                                      <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>
                                   </span>
                                </a>
                            </div>
                            <?php } ?>
                            <?php
                            if(isset($this->s_user) && $this->s_user==1){
                            ?>
                                <p>
                                    <?php
                                        if(isset($Pins->website) && !empty($Pins->website)){
                                    ?>
                                            <a class="tz_pin_content_class_2_web" href="<?php echo $Pins->website; ?>" target="_blank" rel="nofollow">
                                                <?php
                                                    $arr_web = explode('/',$Pins->website);
                                                    $arr_web = array_slice($arr_web,0,$this->text_website);
                                                    $str_web = implode(" ",$arr_web);
                                                    $str     = str_replace(" ","/",$str_web);
                                                    echo $str;
                                                ?>
                                            </a>
                                            <?php
                                            }else if(isset($Pins->name_user_repin) && !empty($Pins->name_user_repin)){
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
                                    <?php
                                    }
                                    ?>
                                </p>
                            <?php
                            }
                            ?>

                            <div class="tz_pin_comsPins">
                                <?php if(isset($this->s_thumb) && $this->s_thumb==1){ ?>
                                    <div class="tz_pin_comsPins_content">
                                        <?php if(isset($Pins->showcomment) && ($Pins->number_comment->count_l > $this->page_com )){ ?>
                                            <div class="tz_ajax_page_cm">
                                                <a class="tz_comment_page" data-optio-page="2" data-optio-id="0" class="btn btn-large btn-block">
                                                    <span>
                                                        <?php echo JText::_('COM_TZ_PINBOARD_VIEW_COMMENT'); ?>
                                                    </span>
                                                </a>
                                                <span id="id_load_thum"></span>
                                                <div class="cler"></div>
                                                <div class="tz_ajax_page_stop"></div>
                                            </div>
                                        <?php } ?>
                                        <ul>
                                            <?php if(isset($Pins->showcomment) && !empty($Pins->showcomment)){
                                                $count = count($Pins->showcomment);
                                                for($i=$count-1; $i >=0; $i--){
                                                ?>
                                                    <li>
                                                        <?php if(isset($Pins->showcomment[$i]->img_user) && !empty($Pins->showcomment[$i]->img_user)){  ?>
                                                            <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/'.$Pins->showcomment[$i]->img_user;  ?>">
                                                        <?php }else{ ?>
                                                            <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                                                        <?php } ?>

                                                        <a rel="nofollow" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($Pins->showcomment[$i]->id_user)); ?>">
                                                            <p class="tz_more_conten_comment_p_names">
                                                                <?php echo $Pins->showcomment[$i]->user_name; ?>
                                                            </p>
                                                        </a>
                                                        <p class="tz_more_conten_comment_ps">
                                                            <?php echo $Pins->showcomment[$i]->content_cm; ?>
                                                        </p>
                                                        <?php if(isset($this->show_date) && $this->show_date ==1){ ?>
                                                            <p class="tz_more_conten_comment_dates">
                                                                <?php echo JText::sprintf("TZ_PINBOARD_TIME_DETAIL",date(JText::_('TZ_PINBOARD_DATE_FOMAT_COMMENT'),strtotime($Pins->showcomment[$i]->dates ))) ?>
                                                            </p>
                                                        <?php } ?>
                                                    </li>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </ul>

                                    </div>
                                <?php } ?>
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
        <?php  echo $this -> PaginationPins -> getPagesLinks();?>
    </div>
</div>


<div id="tz_repin_more_warp" class="row-fluid">
    <div id="tz_warp_hide">
    </div>
    <div id="tz_repin_more_warp_form" class="span5">
    </div>
    <div id="tz_more_content" class="span8">
    </div>
    <div id="tz_repin_more_notice">
        <p>
            <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN'); ?>
        </p>
    </div>
    <div id="tz_repin_more_notice_erro">
        <p>
            <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN_ERROR'); ?>
        </p>
    </div>
</div>


