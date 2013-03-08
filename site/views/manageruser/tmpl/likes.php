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
$doc->addStyleSheet('components/com_tz_pinboard/css/like.css');
$doc->addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');
$doc -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.masonry.min.js"></script>');
$doc -> addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.infinitescroll.min.js"></script>');
?>
<script type="text/javascript">
    /*
    * method calculated width of tags div
    */
    function tz_init(defaultwidth){
        var contentWidth    = jQuery('#tz_lik_pins_conten_all').width();
        var columnWidth     = defaultwidth;
        if(columnWidth >contentWidth ){
            columnWidth = contentWidth;
        }
        var  curColCount = Math.floor(contentWidth / columnWidth);
        var newwidth = columnWidth * curColCount;
        var newwidth2 = contentWidth - newwidth;
        var newwidth3 = newwidth2/curColCount;
        var newColWidth = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pinlike_content_class').css("width",newColWidth); // running masonry
        jQuery('#tz_lik_pins_conten_all').masonry({
            itemSelector: '.tz_pinlike_content_class'
        });
    }
    var resizeTimer = null;
    jQuery(window).bind('load resize', function() { // when the browser changes the div tag changes accordingly
    if (resizeTimer) clearTimeout(resizeTimer);
    resizeTimer = setTimeout("tz_init("+"<?php echo $this->width_pin; ?>)", 100);
    });


    jQuery(document).ready(function(){

        tz_init(<?php echo $this->width_columns; ?>); //call functon tz_init

        jQuery('#tz_lik_pins_conten_all').masonry({
            itemSelector: '.tz_pinlike_content_class'
        });
        jQuery('.tz_repinlike').click(function(){
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin',
                type: 'post',
                data:{
                id_conten: jQuery(this).attr('data-option-id')
                }
            }).success(function(data){
            if(data!="0"){

                jQuery('#tz_repin_more_warp_form').html(data);
                jQuery('#tz_repin_more_warp').fadeIn();
                jQuery('#tz_repin_more_warp_form_img img').load(function(){
                var height_div = jQuery('#tz_repin_more_warp_form').height();
                var height_warp = jQuery('#tz_repin_more_warp').height();
                if(height_div >= height_warp){
                jQuery('#tz_repin_more_warp_form').css({ "height":"80%" });
                jQuery('#tz_repin_more_warp_form').animate({top:'6%'},500);
                }else if(height_div < height_warp){
                jQuery('#tz_repin_more_warp_form').animate({top:'6%'},500);
                }
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
                jQuery('#tz_repin_img_delete, #tz_repin_more_warp_2').click(function(){
                jQuery('#tz_repin_more_warp_form').animate({top:'-100%'},500);
                jQuery('#tz_repin_more_warp').fadeOut(1000);
                });
            }else{
                window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
            }

            jQuery('#tz_repin_button').click(function(){
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
                url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin_insert&Itemid=<?php echo JRequest::getVar('Itemid');?>',
                type: 'post',
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

                jQuery('#tz_repin_more_warp_form').animate({top:'-100%'},600);
                jQuery('#tz_repinlike_more_notice').animate({bottom:'60%'},900);
                jQuery('#tz_repinlike_more_notice').animate({"opacity":"hide"},2800, function(){
                jQuery('#tz_repin_more_warp').fadeOut(1000);
                });


                });
                });

            });

        });
        // more pins



        jQuery('.tz_like_pin').toggle(function(){
            jQuery(this).css("background","#c0c0c0");
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?></span>');
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
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?></span>');
            jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unlike',
            type: 'post',
            data:{
            id_conten: jQuery(this).attr('data-option-id')
            }
            }).success(function(data){
            if(data =='f'){
            window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
            }
            });
        });
        jQuery('.tz_unlike_pin').toggle(function(){
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



        jQuery('.tz_pinlike_content_class').mouseenter(function(){
            jQuery(this).find(".tz_pin_comsPins").addClass("Tz_plaza");
            jQuery(this).find(".tz_pin_c").addClass("Tz_plaza_c")

        }).mouseleave(function(){

            jQuery(".tz_pin_comsPins").removeClass("Tz_plaza");
            jQuery(".tz_pin_c").removeClass("Tz_plaza_c");

        });

        <?php if(empty($this->sosanhuser)){ ?>;
            jQuery('.tz_pinlike_content_class').live("mouseenter",function(){
            jQuery(".tz_pin_comsPins").removeClass("Tz_plaza");
            });
            jQuery('.tz_pin_conmments').click(function(){
            window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
            });

        <?php }
        ?>

        jQuery('.tz_pin_conmments').toggle(function(){
            jQuery(".Tz_plaza").css("display","block");
            jQuery('#tz_lik_pins_conten_all').masonry({
            itemSelector: '.tz_pinlike_content_class'
        });
        },function(){

            jQuery(".Tz_plaza").css("display","none");
            jQuery('#tz_lik_pins_conten_all').masonry({
            itemSelector: '.tz_pinlike_content_class'
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
        jQuery(".Tz_plaza_c").html(" <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?> " + getData.count_number );
        jQuery(".Tz_plaza textarea").attr("value","");
        jQuery(".Tz_plaza .tz_pin_comsPins_content ul").append(getData.contents);
        jQuery('#tz_lik_pins_conten_all').masonry({
        itemSelector: '.tz_pinlike_content_class'
        });

        });
        }
        });


    });
</script>

<div id="tz_pinboard_warp">
    <?php echo $this->loadtemplate('menu'); ?>
    <div class="cler"></div>
</div>
<div id="tz_likepin_warp_conten_pins">
    <div id="tz_lik_pins_conten_all">
    <?php
    if(isset($this->PinLike) && !empty($this->PinLike)){
    foreach($this->PinLike as $Like){

    ?>
        <div class="tz_pinlike_content_class">
        <div class="tz_thumbnaillike thumbnail">
        <?php
        $img_size = $this->img_size;
        $img_type = JFile::getExt($Like->poro_img);
        $img_type_replaca = str_replace(".$img_type","_$img_size.$img_type",$Like->poro_img);
        ?>
        <a class="tz_a_center" <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Like->content_id)); ?>" <?php }  ?> rel="nofollow">
        <img  data-option-id-img="<?php echo $Like->content_id; ?>" <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> src="<?php echo JUri::root().'/'.$img_type_replaca ?>">
        </a>

        <a <?php if($this->type_detail =='0'){ ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Like->content_id)); ?>" <?php }  ?> rel="nofollow">
        <h6 <?php if($this->type_detail =='1'){ ?> class="tz_more_pin" <?php } ?> data-option-id-img="<?php echo $Like->content_id; ?>">
        <?php echo $Like->conten_title; ?>
        </h6>
        </a>
        <p>
        <span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>: <?php echo $Like->number_like->num_like; ?></span>
        <span class="tz_pin_c"><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>: <?php echo $Like->number_comment->count_l; ?></span>
        </p>
        <p>
        <?php
        if(isset($Like->website) && !empty($Like->website)){
        ?>
        <a class="tz_pinlike_content_class_2_web" href="<?php echo $Like->website; ?>" target="_blank" rel="nofollow">

        <?php
        echo $Like->website;
        ?>
        </a>
        <?php
        } else if(isset($Like->user_name) && !empty($Like->user_name)){
        ?>
        <a class="tz_pinlike_content_class_2_web" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($Like->id_user)); ?>" target="_blank" rel="nofollow">

        <?php    echo $Like->user_name; ?>
        </a>
        <?php
        }else{
        ?>
        <a class="tz_pinlike_content_class_2_web" href="#">
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_USER_BY'); ?>
        </a>
        <?php
        }
        ?>
        </p>
        <div class="tz_buttom_pinslike">
        <a class="tz_buttom_repinlike tz_repinlike"  data-option-id="<?php echo $Like->content_id; ?>" >
        <span>
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
        </span>
        </a>
        <?php
        if($Like->id_user == $this->sosanhuser ){
        ?>
        <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute('',$Like->content_id)) ?>" class="tz_buttom_repinlike " rel="nofollow">
        <span>
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>
        </span>
        </a>
        <?php } else{ ?>
        <?php
        if($Like->checl_l['p'] =='0'  || $Like->checl_l['p']  =='')
        {
        ?>

        <a   class="tz_buttom_repinlike  tz_like_pin" data-text-like="tz_like" data-option-id="<?php echo $Like->content_id; ?>">
        <span>

        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE') ?>

        </span>
        </a>
        <?php
        } else   if($Like->checl_l['p']  =='1' ){
        ?>

        <a style="background: #c0c0c0"  class="tz_buttom_repinlike  tz_unlike_pin" data-text-like="tz_unlike" data-option-id="<?php echo $Like->content_id; ?>">
        <span>
        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE') ?>
        </span>
        </a>
        <?php
        }
        ?>
        <?php } ?>


        <a class="tz_buttom_repinlike tz_pin_conmments" data-option-id-img="<?php echo $Like->content_id; ?>">
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
        <form method="index.php?option=com_tz_pinboard">
        <input type="hidden" class="tz_hd_id_pin" value="<?php  echo $Like->content_id; ?>">
        <textarea class="tz_commnet_add_pin" maxlength="<?php echo $this->Limit_comment;  ?>" style="width: 64%" placeholder="<?php echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); ?>"></textarea>
        <p class="tz_comment_erroc_p"></p>
        <?php if(isset($this->sosanhuser) && !empty($this->sosanhuser)){ ?>
        <input class="tz_bt_pin_add" type="button" name="tz_bt_pin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADD_COMMENT'); ?>">
        <?php } else{
        ?>
        <span class="tz_commnet_sp"><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LOGGED_IN'); ?></span>
        <?php
        }?>
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
    if(!isset($this->PinLike) || empty($this->PinLike)){
    ?>
    <div class="tz_not_followers">
    <span class="tz_not_fol_sp">
    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES_NOT_DS'); ?>
    </span>
    </div>
    <?php } ?>
    <div class="pagination pagination-toolbar ">

    <?php  echo $this -> PaginationLike -> getPagesLinks();?>
    </div>
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
<div id="tz_repinlike_more_notice">
<p>
<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN'); ?>
</p>
</div>

</div>



