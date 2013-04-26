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
    require_once JPATH_SITE.'/components/com_tz_pinboard/helpers/route.php';
?>

<script type="text/javascript">

    function ActiviAjax(){
        var str = jQuery('#TZ_Active ul li:eq(0)').attr('id');;
        var str = parseInt(str);
        jQuery.ajax({
            url: "index.php?option=com_tz_pinboard&view=pinboard&task=ActiviAjax",
            type: "post",
            data:{
                id: str
            }
        }).success(function(data){
                        if(data!=""){
                            jQuery(".tz_active_not").css("display","none");
                            jQuery('#TZ_Active ul').prepend(data);
                            jQuery(".tz_view_active").slideDown();
                        }





                });
        setTimeout("ActiviAjax()",5000);
    }
    jQuery(document).ready(function(){
          ActiviAjax();
    });
</script>


    <div id="TZ_Active" class="content">

        <ul>
            <?php
                if(isset($data) && !empty($data)){
                    foreach($data as $row){
                        ?>
                            <li id="<?php echo $row->aid."tz_activi"; ?>">
                                <?php if(isset($row->us_img) && !empty($row->us_img)){  ?>
                                    <img class="TzACtiviImg"     src="<?php echo JUri::root().'/'.$row->us_img; ?>">
                                <?php }else{ ?>
                                    <img  class="TzACtiviImg"   src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
                                <?php }?>
                                <p class="TzActiviContent">
                                    <span class="TzActiviName">
                                        <?php echo $row->u_user; ?>
                                    </span>
                                    <span>
                                        <?php
                                            switch($row->a_active){
                                                case'l':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_LIKE');
                                                    break;
                                                case'ul':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_NOT_LIKE');
                                                    break;
                                                case'r':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_REPIN');
                                                    break;
                                                case'p':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_PIN');
                                                    break;
                                                case'f':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_FOLLOW');
                                                    break;
                                                case'uf':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_UNFOLLOW');
                                                    break;
                                                case'c':
                                                    echo JText::_('MOD_TZ_PINBOARD_ACTIVE_COMMENT');
                                                    break;
                                                default;
                                                    break;
                                            }
                                        ?>

                                    </span>

                                        <?php
                                         if($row->a_active=='f' || $row->a_active=='uf'){
                                             echo "<a href='".JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($row->a_target))."'>".$row->follow."</a>";
                                         }else{
                                             echo "<a href='".JRoute::_('index.php?option=com_tz_pinboard&view=detail&id_pins='.$row->a_target)."'>".$row->p_title."</a>";
                                         }
                                         ?>


                                </p>
                                <div class="cler"></div>
                             </li>
                        <?php
                    }
                }else{
                    echo "<li class='tz_active_not'><span>".JText::_("MOD_TZ_PINBOARD_ACTIVE_NOT_ACTIVE")."<span></li>";
                }
            ?>
        </ul>
    </div>
<script>


    (function(jQuery){
        jQuery(window).load(function(){
            jQuery("#TZ_Active").mCustomScrollbar({
                scrollButtons:{
                    enable:true
                }
            });


        });
    })(jQuery);
</script>