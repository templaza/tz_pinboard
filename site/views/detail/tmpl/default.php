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
$add->addStyleSheet('components/com_tz_pinboard/css/pinboard_more.css');



?>
<script type="text/javascript">

// method check text
function checkText(text, maxtext) {
    var countText = text.length;
    var text = maxtext - countText;
    return text;
}
jQuery(document).ready(function () {
    jQuery(".tz_detail_pins").remove();
    jQuery('#tz_repin_img_delete, #tz_warp_hide').live("click", function () {
        jQuery(".tz_iframe").fadeIn();
        jQuery('#tz_repin_more_warp_form').fadeOut(50);
        jQuery('#tz_repin_more_warp').fadeOut(400, function () {
            jQuery("body").css("overflow-y", "scroll");
        });
    });
    jQuery(".tz-approver").live("click", function () {
        jQuery(".tz-approver").css("display", "none");
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=TzApprover',
            type: "post",
            data: {
                id: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        }).success(function (data) {
                if (data == 1) {

                    jQuery(".tz_detail_notice_app").animate({bottom: "60%"}, 600);
                    jQuery(".tz_detail_notice_app").animate({"opacity": "hide"}, 2800, function () {
                        jQuery(".tz_detail_notice_app").css({
                            "bottom": "-100%",
                            "display": "block"
                        });
                    });
                }
            });
    });
    jQuery('.tz_repin').click(function () { // show light box repin
        jQuery(".tz_iframe").fadeOut();
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin',
            type: 'post',
            data: {
                id_conten: jQuery(this).attr('data-option-id')
            }
        }).success(function (data) {
                data = data.replace(/^\s+|\s+$/g, '');
                if (data != "0") {
                    jQuery("body").css("overflow-y", "hidden");
                    jQuery('#tz_repin_more_warp_form').html(data);
                    jQuery('#tz_repin_more_warp').fadeIn(400);
                    var height = jQuery("#tz_repin_more_warp").height();
                    jQuery('#tz_warp_hide').css("height", height);
                    jQuery('#tz_repin_more_warp_form').fadeIn(50);

                    jQuery('#tz_repin_title').focus(function () { // jquery title
                        jQuery('#tz_repin_title').keyup(function () {
                            var Max_Text_input = jQuery('#tz_repin_title').attr('maxlength');
                            var Text_value_input = jQuery('#tz_repin_title').attr('value');
                            var p_title = document.getElementById('tz_repin_more_title');
                            var Text = checkText(Text_value_input, Max_Text_input);
                            if (Text > 0) {
                                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?> " + Text;
                            } else {
                                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
                            }
                        });
                    });
                    jQuery('#tz_repin_title').blur(function () {
                        var p_title = document.getElementById('tz_repin_more_title');
                        p_title.innerHTML = " ";
                    });// and title
                    jQuery('#tz_repin_introtext').focus(function () { // jquery introtext
                        jQuery('#tz_repin_introtext').keyup(function () {
                            var Max_Text_input = jQuery('#tz_repin_introtext').attr('maxlength');
                            var Text_value_input = jQuery('#tz_repin_introtext').attr('value');
                            var p_title = document.getElementById('tz_repin_more_descript');
                            var TextDs = checkText(Text_value_input, Max_Text_input);
                            if (TextDs > 0) {
                                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?> " + TextDs;
                            } else {
                                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
                            }
                        });
                    });
                    jQuery('#tz_repin_introtext').blur(function () {
                        var p_title = document.getElementById('tz_repin_more_descript');
                        p_title.innerHTML = " ";
                    }); // and introtext

                } else {
                    window.location = urls;
                }
            });
    });

    jQuery("#tz_repin_button").live("click", function () { // start repin
        var Title = jQuery("#tz_repin_title").attr("value");
        var board = jQuery("#tz_repin_select").attr("value");
        if (Title == "") {
            alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_LOCAL_TITLE'); ?>");
            jQuery("#tz_repin_title").focus();
            return false;
        }

        if (board == "") {
            alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_ERRO_SELECT'); ?>");
            jQuery("#tz_repin_select").focus();
            return false;
        }
        document.getElementById("tz_repin_button").disabled = true;
        jQuery.ajax({
            url: "index.php?option=com_tz_pinboard&view=pinboard&task=tz_repin_insert",
            type: "post",
            data: {
                id_usert: jQuery("#tz_user_id").val(),
                tz_user_name: jQuery("#tz_user_name").val(),
                id_category: jQuery("#tz_repin_select").val(),
                img_conten: jQuery("#tz_repin_img").val(),
                websit_conten: jQuery("#tz_repin_website").val(),
                title_content: jQuery("#tz_repin_title").val(),
                introtex_content: jQuery("#tz_repin_introtext").val(),
                tz_content_alias: jQuery("#tz_content_alias").val(),
                tz_content_access: jQuery("#tz_content_access").val(),
                tz_tag: jQuery("#tz_content_tag").val(),
                price: jQuery("#tz_repin_price").val(),
                tz_video: jQuery("#tz_repin_video").val(),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        }).success(function (data) {

                jQuery("#tz_repin_more_warp_form").fadeOut(1000);
                jQuery("#tz_repin_more_notice").animate({bottom: "60%"}, 900);
                jQuery("#tz_repin_more_notice").animate({"opacity": "hide"}, 2800, function () {
                    jQuery("#tz_repin_more_notice").css({
                        "bottom": "-100%",
                        "display": "block"
                    });
                    jQuery("#tz_repin_more_warp").fadeOut(400, function () {
                        jQuery("body").css("overflow-y", "scroll");
                    });
                    jQuery(".tz_iframe").fadeIn();
                });

            });
    });
    jQuery("#tz_comment").live("blur", function () {
        var textra = jQuery('#tz_comment').val();
        document.getElementById('tz_comment_erroc_p').innerHTML = "";
    });
    // add css
    jQuery('.tz_content_cm ul li').live("mouseenter", function () {
        jQuery(this).addClass("Tz_delete");
    });
    jQuery('.tz_content_cm ul li').live("mouseleave", function () {
        jQuery(this).removeClass("Tz_delete");
    }); // and add css

    jQuery('#tz_comment').live("focus", function () {
        var textra = jQuery('#tz_comment').val();
        jQuery('#tz_comment').keyup(function () {
            var Max_Text_input = jQuery('#tz_comment').attr('maxlength');
            var Text_value_input = jQuery('#tz_comment').attr('value');
            var p_title = document.getElementById('tz_comment_erroc_p');
            var TextC = checkText(Text_value_input, Max_Text_input);
            if (TextC > 0) {
                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT'); ?> " + TextC;
            } else {
                p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LIMIT_0'); ?>";
            }
        });
    });
    jQuery("#tz_post_cm").live("click", function () { // ajax comment
        jQuery(this).attr('disabled', true);
        var checkTexs = jQuery("#tz_comment").val();
        if (checkTexs == "") {
            alert("<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>");
            jQuery("#tz_comment").focus();
            return false;

        } else {
            jQuery.ajax({
                url: "index.php?option=com_tz_pinboard&view=detail&task=tz.insert.comment&Itemid=<?php echo JRequest::getVar('Itemid');?>",
                type: "post",
                data: {
                    id_pins: jQuery("#tz_hd_id_pin").val(),
                    content: jQuery("#tz_comment").val(),
                    "<?php echo JSession::getFormToken(); ?>": 1
                }
            }).success(function (data) {
                    var getData = jQuery.parseJSON(data);
                    jQuery("#tz_count_number").html(getData.count_number);
                    jQuery(".tz_content_cm ul").append(getData.contents);

                    jQuery('#tz_comment').attr("value", "");
                    var pages = jQuery("#tz_comment_pt_a").attr("data-optio-id");
                    var pages = parseInt(pages) + 1;
                    jQuery("#tz_comment_pt_a").attr("data-optio-id", pages);
                    jQuery("#tz_post_cm").removeAttr('disabled');
                });
        }
    });
    jQuery(".Tz_delete .tz_comment_delete").live("click", function () {
        jQuery(".Tz_delete").addClass("tz_d");
        jQuery(".tz_notice_detail").fadeIn(10);
        jQuery(".tz_notice_detail").animate({"top": "30%"}, 200);
        jQuery(".tz_detail_canel").click(function () {
            jQuery(".tz_notice_detail").animate({"top": "-100%"}, function () {
                jQuery(".tz_notice_detail").css("display", "none");
                jQuery("li").removeClass("tz_d");
            });
        });

    });
    jQuery(".tz_detail_delete").live("click", function () {
        jQuery.ajax({
            url: "index.php?option=com_tz_pinboard&view=detail&task=tz.delete.comment",
            type: "post",
            data: {
                id: jQuery(".tz_d .tz_comment_delete").attr("data-option-id"),
                id_pins: jQuery(".tz_d .tz_comment_delete").attr('data-option-text')
            }
        }).success(function (data) {
                var getData = jQuery.parseJSON(data);
                jQuery("#tz_count_number").html(getData.count_number);
                jQuery(".tz_d").remove();
                jQuery(".tz_notice_detail").animate({"top": "-100%"}, function () {
                    jQuery(".tz_notice_detail").css("display", "none");
                });
                var pages = jQuery("#tz_comment_pt_a").attr("data-optio-id");
                var pages = parseInt(pages) - 1;
                jQuery("#tz_comment_pt_a").attr("data-optio-id", pages);
            });
    });

    jQuery("#tz_comment_pt_a").live("click", function () {
        jQuery("#tz_page_stop").css("display", "block");
        jQuery('#id_loadding').html("<img src='<?php echo JUri::root().'/components/com_tz_pinboard/images/ajax-comment.gif'?>' />").fadeIn('fast');
        jQuery.ajax({
            url: "index.php?option=com_tz_pinboard&view=detail&task=tz.ajax.pt.cm",
            type: "post",
            data: {
                id_pins: jQuery("#tz_hd_id_pin").val(),
                page: jQuery("#tz_comment_pt_a").attr("data-optio-page"),
                counts: jQuery("#tz_comment_pt_a").attr("data-optio-id")
            }
        }).success(function (data) {
                jQuery('#id_loadding').fadeOut();
                data = data.replace(/^\s+|\s+$/g, '');
                if (data == "") {
                    jQuery("#tz_comment_pt_a").css("display", "none");
                    jQuery(".tz_detail_page").css("display", "none");
                } else {
                    jQuery(".tz_content_cm ul").prepend(data);
                    var pages = jQuery("#tz_comment_pt_a").attr("data-optio-page");
                    var pages = parseInt(pages) + 1;
                    jQuery("#tz_comment_pt_a").attr("data-optio-page", pages);
                }
                jQuery("#tz_page_stop").css("display", "none");
            });
    });

    jQuery('#tz_post_cm_erro').live("click", function () {
        window.location = "<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
    });

    jQuery('.tz_erro_follow').click(function () {
        window.location = "<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
    });
    jQuery('.tz_follow').toggle(function () {
        jQuery(this).addClass('disabled_d');
        jQuery(this).html('<span><?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?></span>');
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.follow',
            type: 'post',
            data: {
                id_user_guest: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        }).success(function () {
            });
    }, function () {
        jQuery(this).removeClass('disabled_d');
        jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
            type: 'post',
            data: {
                id_user_guest: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        });
    });


    jQuery('.tz_unfollow').toggle(function () {
        jQuery(this).removeClass('disabled_d');
        jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.unfollow',
            type: 'post',
            data: {
                id_user_guest: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        });
    }, function () {
        jQuery(this).addClass('disabled_d');
        jQuery(this).html('<span><?php echo JText::_("COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW"); ?></span>');
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=detail&task=tz.pin.follow',
            type: 'post',
            data: {
                id_user_guest: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        });
    });
    var url = "<?php echo JRoute::_("index.php?option=com_users&view=login") ; ?>";
    jQuery(".tz_like_ero").live("click", function () {
        window.location = url;
    });
    jQuery(".tz_like").live("click", function () {
        jQuery(".tz_like").css("display", "none");
        jQuery(".tz_unlike").css("display", "inline-block");
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.like',
            type: 'post',
            data: {
                id_conten: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        });
    });

    jQuery(".tz_unlike").live("click", function () {
        jQuery(".tz_like").css("display", "inline-block");
        jQuery(".tz_unlike").css("display", "none");
        jQuery.ajax({
            url: 'index.php?option=com_tz_pinboard&view=pinboard&task=tz.pin.unlike',
            type: 'post',
            data: {
                id_conten: jQuery(this).attr('data-option-id'),
                "<?php echo JSession::getFormToken(); ?>": 1
            }
        });
    });


});
</script>
<div class="thumbnails" id="tz_detail">
    <?php if (isset($this->show_detail) && $this->show_detail != false) { ?>

        <div class="thumbnail">
            <?php echo $this->loadTemplate('ajaxpins'); ?>
        </div>
    <?php
    }
    ?>

    <div class="tz_detail_notice_app">
        <p>
            <?php echo JText::_('COM_TZ_PINBOARD_DETAIL_NOTICE_APP'); ?>
        </p>
    </div>
</div>
<div id="tz_repin_more_warp" class="row-fluid">
    <div id="tz_warp_hide">

    </div>
    <div id="tz_repin_more_warp_form" class="span5">
    </div>

    <div id="tz_repin_more_notice">
        <p>
            <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_REPIN'); ?>
        </p>
    </div>


</div>
