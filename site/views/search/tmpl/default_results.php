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
?>
<ul>
    <li>
        <strong><?php echo count($this->list) . "  ";
            echo JText::_('COM_TZ_PINBOARD_RESULTS'); ?></strong>
    </li>
    <?php
    if (isset($this->list)) {

        foreach ($this->list as $item) {
            ?>

            <li data-option-text=" <?php echo $item->title; ?>">
                <?php
                $img_size = $this->imgs;
                $img_type = JFile::getExt($item->imge);
                if ($img_type == 'gif') {
                    $img_type_replaca = $item->imge;
                } else {
                    $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $item->imge);
                }
                ?>
                <img src="<?php echo JUri::root() . '/' . $img_type_replaca ?>">

                    <span>
                        <?php echo $item->title; ?>
                    </span>

                <div class="cler"></div>
            </li>
        <?php
        }
    }
    ?>
</ul>
