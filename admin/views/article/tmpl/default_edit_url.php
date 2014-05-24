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
<ul id="slider">
    <?php
    if (isset($this->hienthi_img)) :
        foreach ($this->hienthi_img as $row_img) :?>
            <li>
                <img src="<?php echo $row_img; ?>">
            </li>

        <?php
        endforeach;
    endif;
    ?>
</ul>