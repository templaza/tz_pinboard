<?php

# TZ Pinboard Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

#-------------------------------------------------------------------------*/
    defined("_JEXEC") or die;

    $doc = &JFactory::getDocument();
    $doc->addStyleSheet('modules/mod_tz_pinboard_add/css/tz_add.css');
    $doc->addStyleSheet('modules/mod_tz_pinboard_add/css/anythingslider.css');
    $doc -> addCustomTag('<script type="text/javascript" src="modules/mod_tz_pinboard_add/js/jquery.anythingslider.js"></script>');

?>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#add_button_pin_board').click(function(){
        jQuery('#tz_pinboard_add_warp').fadeIn();
        jQuery('#tz_pinboard_add').css("display","block");
        jQuery('#tz_pinboard_add').animate({top:'25%'},500);
        jQuery('#tz_pinboard_add_name_img').click(function(){
            jQuery('#tz_pinboard_add').animate({top:'-60%'},600);
            jQuery('#tz_pinboard_add_warp').fadeOut();
        });
    });
    jQuery("#add_button_pin_err").click(function(){
        alert("<?php echo JText::_('MOD_TZ_PINBOARD_LOGIN'); ?>");
    window.location="<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
    });
    jQuery('#tz_pinboard_add_pin_wed').hover(function(){ // css  hover
        jQuery('.tz_pinboard_add_pin_webiste_wed').animate({bottom:'0%'},150);
    }, function(){
        jQuery('.tz_pinboard_add_pin_webiste_wed').animate({bottom:'-100%'},15);
    });
    jQuery('#tz_pinboard_add_pin_local').hover(function(){
        jQuery('.tz_pinboard_add_pin_webiste_upload').animate({bottom:'0%'},150);
    }, function(){
        jQuery('.tz_pinboard_add_pin_webiste_upload').animate({bottom:'-100%'},15);
    });
    jQuery('#tz_pinboard_add_pin_creboa').hover(function(){
        jQuery('.tz_pinboard_add_pin_webiste_board').animate({bottom:'0%'},150);
    }, function(){
        jQuery('.tz_pinboard_add_pin_webiste_board').animate({bottom:'-100%'},15);
    }); // over hover


    jQuery('#tz_pinboard_add_pin_wed').click(function(){
        jQuery('#tz_pin_add_url_pin').css("display","block");
        jQuery('#tz_pinboard_add').animate({top:'-60%'},600,function(){
            jQuery(this).css("display","none");
        });
        jQuery('#tz_pin_add_url_pin').animate({bottom:'50%'},500);
    });
    jQuery('#tz_pin_url_img').click(function(){
        jQuery('#tz_pin_add_url_pin').animate({bottom:'-100%'},600,function(){
            jQuery('#tz_pin_add_url_pin').css("display","none");
        });
        jQuery('#tz_pin_url_content_2').css("display","none");
        jQuery('#tz_pinboard_add_warp').fadeOut();
    });

/////  upload pin //////////////////////////////
    jQuery('#tz_pinboard_add_pin_local').click(function(){
        jQuery('#tz_pinboard_add').animate({top:'-60%'},600,function(){
            jQuery(this).css("display","none");
        });
        jQuery("#tz_pin_add_upload_pin").css("display","block");
        jQuery('#tz_pin_add_upload_pin').animate({bottom:'50%'},500);
        jQuery('#upload_pin').change(function(){
            jQuery('#tz_pin_add_upload_pin').animate({bottom:'10%'},500);
            jQuery('#tz_pin_upload_content_2').slideDown();
        });
        jQuery('#tz_pin_upload_img').click(function(){
            jQuery('#tz_pin_add_upload_pin').animate({bottom:'-100%'},600,function(){
                jQuery("#tz_pin_add_upload_pin").css("display","none");
            });
            jQuery('#tz_pin_upload_content_2').fadeOut();
            jQuery('#tz_pinboard_add_warp').fadeOut();
        });
    });
    //pin url
    jQuery('#tz_pin_url_button').click(function(){
        var srt3 =/^http(s)?:\/\/(www\.)?([a-zA-Z0-9\_])+\.([a-zA-Z0-9\/]{1,5})+(\.[A-Za-z0-9\/]{1,4})?([a-zA-Z0-9\/\.&=_\+\#\-\?]*)?$/;
        var check_url_img = jQuery('#tz_url_img').val();
        if(check_url_img ==""){
            alert("<?php echo JText::_('MOD_TZ_PINBOARD_CHECK_TITLE'); ?>");
            document.getElementById('tz_url_img').focus();
            return false;
        }else if(srt3.test(check_url_img) == false){
            alert("<?php echo JText::_('MOD_TZ_PINBOARD_CHECK_URL'); ?>");
            document.getElementById('tz_url_img').focus();
            return false;
        }
        jQuery('#tz_pin_loadding').html("<img src='<?php echo JUri::root().'/components/com_tz_pinboard/images/loading-icon.gif'?>' />").fadeIn('fast');
        jQuery.ajax({
            url:'index.php?option=com_tz_pinboard&view=addpinboards&task=add_pin_website&Itemid=<?php echo JRequest::getVar('Itemid'); ?>',
            type: 'post',
            data: {
            link: jQuery('#tz_url_img').val()
            }
        }).success(function(data){
            jQuery('#tz_pin_loadding').fadeOut('fast');
            if(data!=""){
                jQuery('#tz_pin_add_url_pin').animate({bottom:'5%'},500);
                jQuery('#tz_pin_url_content_2').slideDown();
                jQuery('#tz_pin_url_content_2').html(data);
                jQuery('#tz_pin_url_keygord').hover(function(){
                      jQuery('.tz_tootlips').tooltip('show');
                });
                jQuery('#slider').anythingSlider({
                enableArrows        : true,      // if false, arrows will be visible, but not clickable.
                enableNavigation    : false,      // if false, navigation links will still be visible, but not clickable.
                enableStartStop     : false
                });
                jQuery('#tz_pin_url_keygord').focus(function(){
                    jQuery('#tz_pin_url_keygord').keyup(function(){
                        var Max_Text_input = jQuery('#tz_pin_url_keygord').attr('maxlength');
                        var Text_value_input = jQuery('#tz_pin_url_keygord').attr('value');
                        var Den_text_input = Text_value_input.length;
                        var p_title = document.getElementById('tz_url_p_keyword');
                        var HieuText = Max_Text_input - Den_text_input;
                        if(HieuText >0){
                             p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_KEY'); ?>: "+HieuText;
                        }else{
                              p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_KEY_0'); ?>";
                        }
                    });
                });
                jQuery('#tz_pin_url_keygord').blur(function(){
                var p_title = document.getElementById('tz_url_p_keyword');
                p_title.innerHTML=" ";
                });
                jQuery('#tz_pin_url_title').focus(function(){
                    jQuery('#tz_pin_url_title').keyup(function(){
                        var Max_Text_input = jQuery('#tz_pin_url_title').attr('maxlength');
                        var Text_value_input = jQuery('#tz_pin_url_title').attr('value');
                        var Den_text_input = Text_value_input.length;
                        var p_title = document.getElementById('tz_url_p_title');
                        var HieuText = Max_Text_input - Den_text_input;
                        if(HieuText >0){
                            p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_TITLE') ?>: "+HieuText;
                        }else{
                            p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_TITLE') ?>: 0";
                        }
                    });
                });
                jQuery('#tz_pin_url_title').blur(function(){
                    var p_title = document.getElementById('tz_url_p_title');
                    p_title.innerHTML=" ";
                }); // over title


                jQuery('#tz_pin_url_textarea').focus(function(){ // jquery  Descript
                    jQuery('#tz_pin_url_textarea').keyup(function(){
                        var Max_Text_input = jQuery('#tz_pin_url_textarea').attr('maxlength');
                        var Text_value_input = jQuery('#tz_pin_url_textarea').attr('value');
                        var Den_text_input = Text_value_input.length;
                        var p_title = document.getElementById('tz_url_p_textarea');
                        var HieuText = Max_Text_input - Den_text_input;
                        if(HieuText >0){
                            p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION'); ?>: "+HieuText;
                        }else{
                            p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
                        }
                        });
                });
                jQuery('#tz_pin_url_textarea').blur(function(){
                    var p_title = document.getElementById('tz_url_p_textarea');
                    p_title.innerHTML=" ";
                });
                jQuery('#url_a_pin').click(function(){
                    var srcc = jQuery('li.activePage > img').attr("src");
                    jQuery('#img_hidder').attr('value',srcc);
                });
                jQuery('#url_a_pin').click(function(){
                    var Texra = jQuery('#tz_pin_url_textarea').attr('value');
                    var Title = jQuery('#tz_pin_url_title').attr('value');
                    var boards = jQuery("#tz_pin_upload_select").val();
                    if(Title ==""){
                        alert("<?php echo JText::_('MOD_TZ_PINBOARD_CHECK_TITLE'); ?>");
                        jQuery('#tz_pin_url_title').focus();
                        return false;
                    }
                    if(Texra ==""){
                        alert("<?php echo JText::_('MOD_TZ_PINBOARD_CHECK_TITLE'); ?>");
                        jQuery('#tz_pin_url_textarea').focus();
                        return false;
                    }
                    if(boards==""){
                        alert("<?php echo JText::_('MOD_TZ_PINBOARD_ERRO_SELECT'); ?>");
                        jQuery("#tz_pin_upload_select").focus();
                        return false;
                    }
                });
            } else{
            alert("<?php echo JText::_('MOD_TZ_PINBOARD_ERRO_URL'); ?>");
            jQuery('#tz_url_img').focus();
            return false;
            }
        });
    });

    // jquey  create board
    jQuery('#tz_pinboard_add_pin_creboa').click(function(){
        jQuery('#tz_create_board_add').css("display","block");
        jQuery('#tz_pinboard_add').animate({top:'-60%'},400,function(){
            jQuery('#tz_pinboard_add').css("display","none");
        });
        jQuery('#tz_create_board_add').animate({bottom:'3%'},500);
    });
    jQuery('#tz_create_board_imgs').click(function(){
        jQuery('#tz_create_board_add').animate({bottom:'-100%'},600,function(){
        jQuery('#tz_create_board_add').css("display","none");
    });
    jQuery('#tz_pin_url_content_2').css("display","none");
        jQuery('#tz_pinboard_add_warp').fadeOut();
    });
/////////////////////////////////////////////////// check name board
    jQuery('#boardnames').focus(function(){
        var inpName =jQuery('#boardnames').attr('value');
        var p_title = document.getElementById("p_create_name");
        jQuery('#boardnames').keyup(function(){
            var maxName = jQuery('#boardnames').attr('maxlength');
            var inpName =jQuery('#boardnames').attr('value');
            var countTen =inpName.length;
            var HieuName = maxName - countTen;
            if(HieuName > 0){
                p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_BOARD_NAME'); ?>" +  HieuName;
            }else {
                p_title.innerHTML ="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_BOARD_NAME_0') ?>";
            }
            });
    });
    jQuery('#boardnames').blur(function(){
        var p_title = document.getElementById("p_create_name");
        p_title.innerHTML="";
    });

/////////////////////////////////////////////////// check alias
    jQuery('#aliasnames').focus(function(){
        var inpName =jQuery('#aliasnames').attr('value');
        var p_title = document.getElementById("p_aliasname");
        jQuery('#aliasnames').keyup(function(){
            var maxName = jQuery('#aliasnames').attr('maxlength');
            var inpName =jQuery('#aliasnames').attr('value');
            var countTen =inpName.length;
            var HieuName = maxName - countTen;
            if(HieuName > 0){
                p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_BOARD_ALIAS'); ?>" +  HieuName;
            }else {
                p_title.innerHTML ="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_BOARD_ALIAS_0') ?>";
            }
            });
    });
    jQuery('#aliasnames').blur(function(){
        var p_title = document.getElementById("p_aliasname");
        p_title.innerHTML="";
    });

// check descript
    jQuery('#create_board_textra').focus(function(){
        var inpName =jQuery('#create_board_textra').attr('value');
        var p_title = document.getElementById("p_create_decsipts");
        jQuery('#create_board_textra').keyup(function(){
            var maxName = jQuery('#create_board_textra').attr('maxlength');
            var inpName =jQuery('#create_board_textra').attr('value');
            var countTen =inpName.length;
            var HieuName = maxName - countTen;
            if(HieuName > 0){
                p_title.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION'); ?>" +  HieuName;
            }else {
                p_title.innerHTML ="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION_0') ?>";
            }
        });
    });
    jQuery('#create_board_textra').blur(function(){
        var p_title = document.getElementById("p_create_decsipts");
        p_title.innerHTML="";
    });
///// submit
    jQuery('#submitcreate').click(function(){
        var inpName =jQuery('#boardnames').attr('value');
        var pp = document.getElementById("p_create_name");
        var selec = jQuery('#category_boards').attr('value');
        var p_sele = document.getElementById("p_create_select");
        if(inpName ==""){
            pp.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_CHECK_TITLE'); ?>";
            jQuery('#boardnames').focus();
            return false;
        }
        if(selec==''){
        p_sele.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_NOTICE_CATEGORY'); ?>";
            jQuery('#category_boards').focus();
            return false;
        }else{
            p_sele.innerHTML="";
        }
    });
// upload pin local //////////////////////////////////////////////////////
    jQuery('#tz_pin_upload_keyword').focus(function(){
            jQuery('#tz_pin_upload_keyword').keyup(function(){
                var max_text_ky = jQuery('#tz_pin_upload_keyword').attr('maxlength');
                var text_key = jQuery('#tz_pin_upload_keyword').val();
                var dem_text_key = text_key.length;
                var HieuText_key = max_text_ky - dem_text_key;
                var p_key = document.getElementById('tz_p_local_keyword');
            if(HieuText_key > 0){
                p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_KEY'); ?>: "+HieuText_key;
            }else{
                p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_KEY_0'); ?>";
            }
        })
    });
    jQuery('#tz_pin_upload_keyword').blur(function(){
        document.getElementById('tz_p_local_keyword').innerHTML="";
    });
    jQuery('#tz_pin_upload_title').focus(function(){
        jQuery('#tz_pin_upload_title').keyup(function(){
            var max_text_ky = jQuery('#tz_pin_upload_title').attr('maxlength');
            var text_key = jQuery('#tz_pin_upload_title').val();
            var dem_text_key = text_key.length;
            var HieuText_key = max_text_ky - dem_text_key;
            var p_key = document.getElementById('tz_p_title');
            if(HieuText_key > 0){
                p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_TITLE'); ?>: "+HieuText_key;
            }else{
                p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
            }
        });
    });
    jQuery('#tz_pin_upload_title').blur(function(){
        document.getElementById('tz_p_title').innerHTML="";
    });

    jQuery('#tz_pin_pin_textarea').focus(function(){
        jQuery('#tz_pin_pin_textarea').keyup(function(){
            var max_text_ky = jQuery('#tz_pin_pin_textarea').attr('maxlength');
            var text_key = jQuery('#tz_pin_pin_textarea').val();
            var dem_text_key = text_key.length;
            var HieuText_key = max_text_ky - dem_text_key;
            var p_key = document.getElementById('tz_p_textarea');
            if(HieuText_key > 0){
            p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION'); ?>: "+HieuText_key;
            }else{
            p_key.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
            }
        });
    });
    jQuery('#tz_pin_pin_textarea').blur(function(){
        document.getElementById('tz_p_textarea').innerHTML="";
    });

    //  button Pin
    jQuery('#upload_a_pin').click(function(){
        var content_title = jQuery('#tz_pin_upload_title').val();
        var title_p = document.getElementById("tz_p_title");
        var content_textarea = jQuery('#tz_pin_pin_textarea').val();
        var title_textarea = document.getElementById("tz_p_textarea");
        var boards = jQuery("#tz_pin_upload_select").val();
        if(boards==""){
            alert("<?php echo JText::_('MOD_TZ_PINBOARD_ERRO_SELECT'); ?>");
            jQuery("#tz_pin_upload_select").focus();
            return false;
        }
        if(content_title==""){
            title_p.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_LOCAL_TITLE'); ?>";
            jQuery('#pin_add_upload_title_pin_local').focus();
            return false;
            }else{
            title_p.innerHTML="";
        }
        if(content_textarea==""){
            title_textarea.innerHTML="<?php echo JText::_('MOD_TZ_PINBOARD_LOCAL_DESCRIPTION'); ?>";
            jQuery('#tz_pin_pin_textarea').focus();
            return false;
            }else{
            title_textarea.innerHTML="";
        }
    });
});
</script>
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function (e) {
                jQuery('#tz_pin_upload_left_img_load')
                .attr('src', e.target.result)
                .width(160)
                .height(125);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

<?php if(isset($user) && !empty($user)){ ?>
       <button id="add_button_pin_board" class="btn add_pinboard">
               <?php echo JText::_('MOD_TZ_PINBOARD_CLICK_TO_PIN'); ?>
       </button>
<?php  }else{  ?>
        <button id="add_button_pin_err" class="btn add_pinboard">
                  <?php echo JText::_('MOD_TZ_PINBOARD_CLICK_TO_PIN'); ?>
        </button>
<?php } ?>


<div id="tz_pinboard_add_warp">
    <div id="tz_pinboard_full">
    </div>
    <div id="tz_pinboard_add">
        <div id="tz_pinboard_add_name">
            <span>
            <?php echo JText::_("MOD_TZ_PINBOARD_ADD"); ?>
            </span>
            <img id="tz_pinboard_add_name_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/delete_board.png' ?>"/>
        </div>
        <div id="tz_pinboard_add_name_gt">
            <span>
            <?php echo JText::_("MOD_TZ_PINBOARD_ADD_DISCRIPTION"); ?>
            </span>
        </div>
        <div id="tz_pinboard_add_all">
            <ul>
                <li class="tz_pinboard_add_pin_webiste">
                    <a id="tz_pinboard_add_pin_wed" href="#">
                    <img  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/Pins_web.png' ?>"/>
                    <p>
                    <?php echo JText::_("MOD_TZ_PINBOARD_ADD_A_PIN"); ?>
                    </p>
                    <span class="tz_pinboard_add_pin_webiste_wed"></span>
                    </a>
                </li>
                <li class="tz_pinboard_add_pin_webiste">
                    <a id="tz_pinboard_add_pin_local" href="#">
                    <img  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/pin_local.png' ?>"/>
                    <p>
                    <?php echo JText::_("MOD_TZ_PINBOARD_ADD_A_UPLOAD"); ?>
                    </p>
                    <span class="tz_pinboard_add_pin_webiste_upload"></span>
                    </a>
                </li>
                <li class="tz_pinboard_add_pin_webiste">
                    <a id="tz_pinboard_add_pin_creboa" href="#">
                    <img  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/board.png' ?>"/>
                    <p>
                    <?php echo JText::_("MOD_TZ_PINBOARD_CREATE_BOARD"); ?>
                    </p>
                    <span class="tz_pinboard_add_pin_webiste_board"></span>
                     </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="tz_pin_add_upload_pin">
    <?php require JModuleHelper::getLayoutPath('mod_tz_pinboard_add', $params->get('layout', 'default'.'_uploadpin')); ?>
    </div>
    <div id="tz_pin_add_url_pin">
    <?php require JModuleHelper::getLayoutPath('mod_tz_pinboard_add', $params->get('layout', 'default'.'_webpin')); ?>
    </div>
    <div id="tz_create_board_add">
    <?php require JModuleHelper::getLayoutPath('mod_tz_pinboard_add', $params->get('layout', 'default'.'_createboard')); ?>
    </div>
</div>