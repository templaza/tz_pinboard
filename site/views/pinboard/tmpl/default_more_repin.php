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

?>

<img id="tz_repin_img_delete" src="<?php echo JUri::root() . "/components/com_tz_pinboard/images/delete_board.png" ?>"
     alt="">
<div id="tz_repin_more_warp_form_img">
    <?php
    $img_size = $this->img_size;
    $img_type = JFile::getExt($this->repin->poro_img);
    if ($img_type == 'gif') {
        $img_type_replaca = $this->repin->poro_img;
    } else {
        $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $this->repin->poro_img);
    }

    ?>
    <img src="<?php echo JUri::root() . "/" . $img_type_replaca; ?>">
</div>
<form action="" method="post">
    <div class="tz_repin_more_warp_form_div">
        <select id="tz_repin_select" name="tz_repin_select">
            <?php

            if (isset($this->Showboardd) && !empty($this->Showboardd)) :
                foreach ($this->Showboardd as $board_s) :
                    ?>
                    <option
                        value="<?php echo $board_s->id; ?>" <?php if ($board_s->id == $this->repin->category_id) { ?> selected="true" <?php } ?>>
                        <?php echo $board_s->title; ?>
                    </option>
                <?php
                endforeach;
            else :
                ?>
                <option value=""></option>
            <?php
            endif;
            ?>
        </select>
    </div>
    <div class="tz_repin_more_warp_form_div">
        <?php
        $price = new JRegistry($this->repin->c_attribs);
        ?>
        <input type="text" maxlength="<?php echo $this->max_title; ?>" name="tz_repin_title" id="tz_repin_title"
               value="<?php echo $this->repin->conten_title; ?>">

        <p id="tz_repin_more_title"></p>
        <input type="hidden" name="tz_repin_website" id="tz_repin_website" value="<?php echo $this->repin->website; ?>">
        <input type="hidden" name="tz_repin_img" id="tz_repin_img" value="<?php echo $this->repin->poro_img; ?>">
        <input type="hidden" name="tz_user_id" id="tz_user_id" value="<?php echo $this->repin->id_user; ?>">
        <input type="hidden" name="tz_user_name" id="tz_user_name" value="<?php echo $this->repin->name_user; ?>">
        <input type="hidden" name="tz_content_alias" id="tz_content_alias"
               value="<?php echo $this->repin->content_alias; ?>">
        <input type="hidden" name="tz_content_access" id="tz_content_access"
               value="<?php echo $this->repin->content_access; ?>">
        <input type="hidden" name="tz_repin_price" id="tz_repin_price" value="<?php echo $price->get('price'); ?>">
        <input type="hidden" name="tz_repin_video" id="tz_repin_video" value="<?php echo $this->repin->poro_video; ?>">
        <input type="hidden" name="tz_content_tag" id="tz_content_tag" value="<?php if (isset($this->repin->tags)) {
            foreach ($this->repin->tags as $tag) {
                echo $tag->tagid . ",";
            }
        }
        ?>">
    </div>
    <div class="tz_repin_more_warp_form_div">
        <textarea maxlength="<?php echo $this->max_introtext; ?>" id="tz_repin_introtext"
                  style="width: 98%; height: 60px"><?php echo strip_tags($this->repin->content_introtext); ?></textarea>

        <p id="tz_repin_more_descript"></p>
    </div>
    <div class="tz_repin_more_warp_form_div">
        <input id="tz_repin_button" class="btn btn-large" type="button" name="repin_button"
               value="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>">

        <p id="tz_repin_tile"></p>
    </div>
</form>
