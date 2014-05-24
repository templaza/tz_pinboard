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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_tz_pinboard/css/tz_pinboard.css');

?>

<div id="tz_pinboard">
    <form action="index.php?option=com_tz_pinboard" method="post" name="adminForm" id="adminForm">
        <div id="tz_pinboard_top">
            <ul>
                <li class="tz_pinboard_top_li_left">
                   <span>
                       <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_ID'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                   <span>
                      <?php echo $this->More->cm_id; ?>
                   </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>
                        <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_NAME'); ?>
                    </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <span>
                        <?php echo $this->More->u_name; ?>
                    </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                   <span>
                       <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_DATE'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php echo $this->More->cm_date; ?>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>
                        <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_ID_PINS'); ?>
                    </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <span class="tz_pinboard_top_li_right">
                        <?php echo $this->More->cm_idcontent; ?>
                    </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                   <span>
                       <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_IP'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                   <span class="tz_pinboard_top_li_right">
                       <?php echo $this->More->cm_ip; ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_left">
                   <span>
                       <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_STATE_IP'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                   <span class="tz_pinboard_top_li_right">
                       <?php
                       if (isset($this->More->cm_state) && $this->More->cm_state == 1) {
                           echo JText::_('COM_TZ_PINBOARD_COMMENT_PUBLISH');
                       } else {
                           echo JText::_('COM_TZ_PINBOARD_COMMENT_UNPUBLISH');
                       }
                       ?>
                   </span>
                </li>
                <div class="cler"></div>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                     <span>
                         <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_STATE'); ?>
                     </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                     <span class="tz_pinboard_top_li_right">
                         <?php
                         if (isset($this->More->cm_state) && $this->More->cm_state == 1) {
                             echo JText::_('COM_TZ_PINBOARD_COMMENT_PUBLISH');
                         } else {
                             echo JText::_('COM_TZ_PINBOARD_COMMENT_UNPUBLISH');
                         }
                         ?>
                     </span>
                </li>
                <div class="cler"></div>
            </ul>
        </div>
        <div class="cler"></div>
        <div id="tz_pinboar_bottom">
            <ul>

                <li>
                <span>
                    <?php echo JText::_('COM_TZ_PINBOARD_COMMENT_MORE_CONTENT_PINS'); ?>
                </span>

                    <p>
                        <?php echo $this->More->cm_content; ?>
                    </p>
                </li>

            </ul>
        </div>
        <input type="hidden" name="option" value="com_tz_pinboard">
        <input type="hidden" name="view" value="comment">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="boxchecked" value="0">
    </form>
</div>