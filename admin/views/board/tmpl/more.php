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
                       <?php echo JText::_('Id board'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                   <span>
                        <?php echo $this->More->id_b; ?>
                   </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>
                        <?php echo JText::_('Title'); ?>
                    </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <span>
                        <?php echo $this->More->title_b; ?>
                    </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>
                        <?php echo JText::_('Alias'); ?>
                    </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <span class="tz_pinboard_top_li_right">
                        <?php
                        if (isset($this->More->alias_b)) {
                            echo $this->More->alias_b;
                        } else {
                            echo "None";
                        }
                        ?>
                    </span>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>      <?php echo JText::_('created_time'); ?> </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php echo $this->More->created_time_b; ?>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>      <?php echo JText::_('State'); ?> </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php
                    if ($this->More->state_b == 1) {
                        echo "pubslic";
                    } else {
                        echo "Unpublic";
                    }
                    ?>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>      <?php echo JText::_('modified_time'); ?> </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php echo $this->More->modified_time_b; ?>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                   <span>
                       <?php echo JText::_('catid'); ?>
                   </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php echo $this->More->catid_b; ?>
                </li>
                <div class="cler"></div>
                <li class="tz_pinboard_top_li_left">
                    <span>      <?php echo JText::_('Name User'); ?> </span>
                </li>
                <li class="tz_pinboard_top_li_right">
                    <?php echo $this->More->name_b; ?>
                </li>
                <div class="cler"></div>


            </ul>
        </div>
        <div class="cler"></div>
        <div id="tz_pinboar_bottom">
            <ul>

                <li>
                <span>
                    <?php echo JText::_('description'); ?>
                </span>

                    <p>
                        <?php echo $this->More->description_b; ?>
                    </p>
                </li>

            </ul>
        </div>
        <input type="hidden" name="option" value="com_tz_pinboard">
        <input type="hidden" name="view" value="board">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="boxchecked" value="0">
    </form>
</div>