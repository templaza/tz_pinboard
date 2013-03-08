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
        defined('_JEXEC') or die;
    $add = JFactory::getDocument();
    $add -> addStyleSheet('modules/mod_tz_pinboard_search/css/pin.css');

?>
<script type="text/javascript">
    jQuery(document).ready(function(){

            jQuery('#tz_search').keyup(function(){
                   jQuery.ajax({
                       url: "index.php?option=com_tz_pinboard&view=search&task=tz.search",
                       type: "post",
                       data:{
                           title: jQuery("#tz_search").val()
                       }
                   }).success(function(data){
                         if(data){

                            jQuery('#tz_results').css("overflow-y","scroll");
                            jQuery('#tz_results').css("display","block");
                            jQuery('#tz_results').html(data);
                            jQuery('#tz_results ul li').click(function(){
                                    var attr_val =  jQuery(this).attr('data-option-text');
                                    jQuery('#tz_search').attr('value',attr_val);
                                jQuery('#tz_results').slideUp(200);
                            });
                             jQuery('#tz_results ul li').hover(function(){
                                 jQuery(this).css({"background":"#D4D4D4","cursor":"pointer"});
                             },function(){
                                 jQuery(this).css("background","");
                             })
                         }

                           });
            });
        jQuery(document).keydown(function(e){

       			if(e.keyCode==27){
                       jQuery('#tz_results').slideUp(200);
       			}
       		});
        jQuery('body').click(function(){

                                   jQuery('#tz_results').slideUp(200);

        })
        jQuery('#tz_submit').click(function(){

            var check = jQuery('#tz_search').val();

            if(check ==""){
                alert("<?php echo JText::_('MOD_TZ_PINBOARD_EMPTY'); ?>");
                jQuery('#tz_search').focus();
                return false;
            }
        });

    });
</script>


<div id="Tz_pinboard">
     <div id="tz_from">
            <form method="post" action="<?php echo JRoute::_('index.php');?>">
                    <input autocomplete="off"  id="tz_search" type="text" name="tz_search" value="" placeholder="<?php echo JText::_('MOD_TZ_PINBOARD_SEARCH'); ?>">
                    <input id="tz_submit" type="submit" name="submit" value="Search">
                    <input type="hidden" name="option" value="com_tz_pinboard" />
                    <input type="hidden" name="view" value="search" />
            </form>
     </div>
     <div id="tz_results">
            
     </div>
    <div class="cler"></div>
</div>