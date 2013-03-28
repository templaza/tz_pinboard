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


$doc = JFactory::getDocument();
$doc->addStyleSheet('components/com_tz_pinboard/css/edit_board.css');
$pth_c = JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.
'com_tz_pinboard'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'category.php';
require_once $pth_c;
jimport('joomla.html');

?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#tz_pinboard_warp_buttom_dl').click(function(){
            jQuery('#tz_pinboard_warp_delete_board').fadeIn();
            jQuery('#tz_pinboard_warp_delete').slideDown(1200);
        });
        //check name board
        jQuery('#boardname').focus(function(){
            var inpName =jQuery('#boardname').attr('value');
            var p_title = document.getElementById("p_create_boardname");
            jQuery('#boardname').keyup(function(){
                var maxName = jQuery('#boardname').attr('maxlength');
                var inpName =jQuery('#boardname').attr('value');
                var countTen =inpName.length;
                var HieuName = maxName - countTen;
                if(HieuName > 0){
                    p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?>" +  HieuName;
                }else {
                    p_title.innerHTML ="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
                }
            });
        });
        jQuery('#boardname').blur(function(){
            var p_title = document.getElementById("p_create_boardname");
            p_title.innerHTML="";
        });

        // ALIAS
        jQuery('#aliasboard').focus(function(){
            var inpName =jQuery('#aliasboard').attr('value');
            var p_title = document.getElementById("p_create_aliasname");
            jQuery('#aliasboard').keyup(function(){
                var maxName = jQuery('#aliasboard').attr('maxlength');
                var inpName =jQuery('#aliasboard').attr('value');
                var countTen =inpName.length;
                var HieuName = maxName - countTen;
                if(HieuName > 0){
                    p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_ALIAS'); ?> "  +  HieuName;
                }else {
                    p_title.innerHTML ="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_ALIAS_0'); ?>";
                }
            });
        });
        jQuery('#aliasboard').blur(function(){
            var p_title = document.getElementById("p_create_aliasname");
            p_title.innerHTML="";
        });


        // check descript
        jQuery('#tz_edit_board_2_textra').focus(function(){
            var inpName =jQuery('#tz_edit_board_2_textra').attr('value');
            var p_title = document.getElementById("p_edit_not_decsipt");
            jQuery('#tz_edit_board_2_textra').keyup(function(){
            var maxName = jQuery('#tz_edit_board_2_textra').attr('maxlength');
            var inpName =jQuery('#tz_edit_board_2_textra').attr('value');
            var countTen =inpName.length;
            var HieuName = maxName - countTen;
            if(HieuName > 0){
                p_title.innerHTML="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?>" +  HieuName;
            }else {
                p_title.innerHTML ="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
            }
            });

        });
        jQuery('#tz_edit_board_2_textra').blur(function(){
            var p_title = document.getElementById("p_edit_not_decsipt");
            p_title.innerHTML="";
        });

        jQuery('#tz_pinboard__edit_submit_1').click(function(){
            var inpName =jQuery('#boardname').attr('value');
            if(inpName ==""){
                alert('<?php echo JText::_("COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE"); ?>');
                jQuery('#boardname').focus();
                return false;
            }
        });
        jQuery('#button_cancel').click(function(){
            jQuery('#tz_pinboard_warp_delete_board').fadeOut();
            jQuery('#tz_pinboard_warp_delete').css('display','none');
        });
    });
</script>
<div id="tz_pinboard_warp_edit">
    <div id="tz_pinboard_warp_edit_herder">
        <img id="tz_pinboard_warp_edit_img" src="<?php echo JUri::root().'/components/com_tz_pinboard/images/edit.png' ?>" >
        <span>
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDIT_BOARD'); ?>
        </span>
        <button id="tz_pinboard_warp_buttom_dl">
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DELETE_BOARD'); ?>
        </button>
    </div>
    <div id="tz_pinboard_warp_edit_content">
        <form action="<?php echo JRoute::_('index.php'); ?>" method="post">
            <div class="tz_edit_board_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_NAME'); ?></label>
                <input id="boardname" maxlength="<?php echo $this->max_text_board; ?>" type="text" name="editname" value= "<?php echo $this->editboard->board;?>" />
                <input type="hidden" name="id_boar" value="<?php echo $this->editboard->id_board; ?>">
                <p id="p_create_boardname"></p>
            </div>
            <div class="tz_edit_board_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_ALIAS'); ?></label>
                <input id="aliasboard" maxlength="<?php echo $this->max_text_board; ?>" type="text" name="aliasboard" value= "<?php echo $this->editboard->alias;?>" />
                <p id="p_create_aliasname"></p>
            </div>
            <div class="tz_edit_board_2">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DESCRIPTION'); ?></label>
                <textarea name="textreaname" maxlength="<?php echo $this->max_text_board_ds; ?>" id="tz_edit_board_2_textra"  style="width: 370px; height: 110px;" ><?php echo $this->editboard->description ;?></textarea>
                <p id="p_edit_not_decsipt"></p>
            </div>
            <div class="tz_edit_board_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_CATEGORY'); ?></label>
                <select name="select_catogory" id="tz_edit_board_1_select" >
                <?php
                    echo JHtml::_('select.options', JHtml::_('category.options', 'com_tz_pinboard'), 'value', 'text',$this->editboard->catid) ;
                ?>
                </select>
            </div>
            <div class="tz_edit_board_1">
                <span>
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_CREATE_DATE'); ?>
                </span>
                <span id="tz_pinboard_warp_edit_content_1_span_last">
                    <?php echo $this->editboard->created_time; ?>
                </span>
                <input type="hidden" name="task" value="tz.update">
            </div>
            <div id="tz_pinboard_warp_edit_content_submit">
                <input id="tz_edit_board_sb" type="submit" name="submit_edit" value="Save Settings">
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </form>
    </div>
    <div id="tz_pinboard_warp_delete_board">
        <div id="tz_pinboard_delete_1">
        </div>
        <div id="tz_pinboard_warp_delete">
            <?php if($this->editboard->check->count_id =='0'){  ?>
                <p class="tz_pinboard_delete__p">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_DATELETE_BOARD'); ?>
                </p>
                <button id="button_cancel">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_CANCEL'); ?>
                </button>
                <a  href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.delete&id_board='.$this->editboard->id_board);?>" rel="nofollow">
                    <button id="button_delete">

                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DELETE_BOARD'); ?>

                    </button>
                </a>
            <?php
                }else{
            ?>
                <p class="tz_pinboard_delete_p_2">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_BOARD_DELETE'); ?>
                </p>
                <button id="button_cancel">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_CANCEL'); ?>
                </button>
            <?php
            } ?>
        </div>
    </div>
</div>


