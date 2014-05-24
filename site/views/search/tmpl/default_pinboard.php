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


if (isset($this->Pins)) {
    foreach ($this->Pins as $Pins) {
        ?>
        <div class="tz_pin_all_content">
            <div class="thumbnail tz_pin_content_class">

                <?php if (isset($Pins->c_attribs) && !empty($Pins->c_attribs)) { ?>
                    <p class="tz-detail-price2">
                        <?php
                        $price = new JRegistry($Pins->c_attribs);
                        echo $price->get('price');
                        ?>
                    </p>
                <?php } ?>
                <?php
                $img_size = $this->img_size;
                $img_type = JFile::getExt($Pins->poro_img);
                if ($img_type == 'gif') {
                    $img_type_replaca = $Pins->poro_img;
                } else {
                    $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $Pins->poro_img);
                }

                ?>
                <div class="tz_hover_img">
                    <a class="tz_a_center" <?php if ($this->type_detail == '0') { ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php } ?>
                       rel="nofollow">
                        <img
                            data-option-id-img="<?php echo $Pins->content_id; ?>" <?php if ($this->type_detail == '1') { ?> class="tz_more_pin" <?php } ?>
                            src="<?php echo JUri::root() . '/' . $img_type_replaca ?>">
                    </a>
                    <?php if (isset($Pins->pz_video) && !empty($Pins->pz_video)) { ?>
                        <span class="TzIconVideo" data-option-id-img="<?php echo $Pins->content_id; ?>"></span>
                    <?php } ?>
                    <?php if (isset($this->title_thum) && $this->title_thum == 1) { ?>
                        <a <?php if ($this->type_detail == '0') { ?> href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($Pins->content_id)); ?>" <?php } ?>
                            rel="nofollow">
                            <h6 <?php if ($this->type_detail == '1') { ?> class="tz_more_pin" <?php } ?>
                                data-option-id-img="<?php echo $Pins->content_id; ?>">
                                <?php echo $Pins->conten_title; ?>
                            </h6>
                        </a>
                    <?php } ?>

                </div>
                <?php if (isset($this->count_button) && $this->count_button == 1) { ?>
                    <p>
                        <span
                            class="tz_pin_like"><?php echo $Pins->countL->count_l; ?> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?></span>
                        <span
                            class="tz_pin_comment"><?php echo $Pins->countComment->count_l; ?>  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?></span>
                        <span
                            class="tz_pin_hits"><?php echo $Pins->content_hit; ?>  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_HITS'); ?></span>
                    </p>
                <?php } ?>
                <?php if (isset($Pins->tags) && !empty($Pins->tags) && $this->tag_thum == 1) { ?>
                    <p>
                        <span> <?php echo JText::_('COM_TZ_PINBOARD_TAGS'); ?> </span>
                        <?php
                        foreach ($Pins->tags as $tag) {
                            ?>
                            <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"
                               rel="nofollow">
                                <?php echo "# " . $tag->tagname; ?>
                            </a>
                        <?php
                        }
                        ?>
                    </p>
                <?php } ?>
                <?php if (isset($this->s_button) && $this->s_button == 1) { ?>
                    <div class="tz_button_pins">
                        <a class="tz_button_repin tz_repin" data-option-id="<?php echo $Pins->content_id; ?>">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
                            </span>
                        </a>
                        <span class="tz_pinboard_sp">/</span>
                        <?php
                        if ($Pins->id_user == $this->sosanhuser) {
                            ?>
                            <a class="tz_button_repin "
                               href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute('', $Pins->content_id)); ?>"
                               rel="nofollow">
                            <span>
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>
                            </span>
                            </a>
                            <span class="tz_pinboard_sp">/</span>
                        <?php
                        } else {
                            ?>
                            <a class=" tz_button_repin  <?php if ($Pins->checl_l['p'] == '1') {
                                echo "tz_check_like";
                            } ?> <?php if (empty($this->sosanhuser) || $this->sosanhuser == "0") {
                                echo "tz_like_ero";
                            } else {
                                echo "tz_like";
                            } ?>" data-text-like="tz_like" data-option-id="<?php echo $Pins->content_id; ?>">
                                <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>
                                </span>
                            </a>

                            <a class="tz_button_repin  tz_unlike disabled_d <?php if ($Pins->checl_l['p'] == '0' || $Pins->checl_l['p'] == "") {
                                echo "tz_check_like";
                            } ?> " data-option-id="<?php echo $Pins->content_id; ?>">
                                <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                                </span>
                            </a>

                            <span class="tz_pinboard_sp">/</span>
                        <?php
                        }
                        ?>
                        <a data-option-id-img="<?php echo $Pins->content_id; ?>"
                           class="tz_button_repin  <?php if (empty($this->sosanhuser) || $this->sosanhuser == "0") {
                               echo "tz_pin_conmments_ero";
                           } else {
                               echo "tz_pin_conmments";
                           } ?>">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT'); ?>
                            </span>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($this->s_user) && $this->s_user == 1) { ?>
                    <div class="tzAuthor">
                        <?php if (isset($Pins->user_img) && !empty($Pins->user_img)) { ?>
                            <img class="tz_pin_img_user" src="<?php echo JUri::root() . '/' . $Pins->user_img; ?>">
                        <?php } else { ?>
                            <img class="tz_pin_img_user"
                                 src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                        <?php } ?>

                        <a class="tz_pin_name_user"
                           href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($Pins->id_user)); ?>"
                           rel="nofollow">
                            <?php echo $Pins->user_name; ?>
                            <?php if (isset($Pins->name_user_repin) && !empty($Pins->name_user_repin)) { ?>
                                <strong class="tz_by">
                                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN_BY'); ?>
                                </strong>
                                <?php
                                echo $Pins->name_user_repin;
                            }
                            ?>
                        </a>

                        <div class="cler"></div>
                    </div>
                <?php } ?>
                <div class="tz_pin_comsPins">
                    <?php if (isset($this->s_thumb) && $this->s_thumb == 1) { ?>
                        <div class="tz_pin_comsPins_content">
                            <?php
                            if (isset($Pins->showcomment) && ($Pins->countComment->count_l >= $this->page_com)) {
                                ?>
                                <div class="tz_ajax_page_cm">
                                    <a class="tz_comment_page" data-optio-page="2" data-optio-id="0"
                                       class="btn btn-large btn-block">
                                        <span>
                                            <?php
                                            echo JText::_('COM_TZ_PINBOARD_VIEW_COMMENT');
                                            ?>
                                        </span>
                                    </a>
                                    <span id="id_load_thum"></span>

                                    <div class="cler"></div>
                                    <div class="tz_ajax_page_stop"></div>
                                </div>
                            <?php } ?>
                            <ul>
                                <?php if (isset($Pins->showcomment) && !empty($Pins->showcomment)) {
                                    $count = count($Pins->showcomment);
                                    for ($i = $count - 1; $i >= 0; $i--) {
                                        ?>
                                        <li>
                                            <?php if (isset($Pins->showcomment[$i]->img_user) && !empty($Pins->showcomment[$i]->img_user)) { ?>
                                                <img class="tz_more_conten_comment_imgs"
                                                     src="<?php echo JUri::root() . '/' . $Pins->showcomment[$i]->img_user; ?>">
                                            <?php } else { ?>
                                                <img class="tz_more_conten_comment_imgs"
                                                     src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                                            <?php } ?>

                                            <a rel="nofollow"
                                               href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($Pins->showcomment[$i]->id_user)); ?>">
                                                <p class="tz_more_conten_comment_p_names">
                                                    <?php echo $Pins->showcomment[$i]->user_name; ?>
                                                </p>
                                            </a>

                                            <p class="tz_more_conten_comment_ps">
                                                <?php echo $Pins->showcomment[$i]->content_cm; ?>
                                            </p>
                                            <?php if (isset($this->show_date) && $this->show_date == 1) { ?>
                                                <p class="tz_more_conten_comment_dates">
                                                    <?php echo JText::sprintf("TZ_PINBOARD_TIME_DETAIL", date(JText::_('TZ_PINBOARD_DATE_FOMAT_COMMENT'), strtotime($Pins->showcomment[$i]->dates))) ?>
                                                </p>
                                            <?php } ?>
                                        </li>
                                    <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="tz_pin_comsPins_from">
                        <?php if (isset($this->UserImgLogin->images) && !empty($this->UserImgLogin->images)) { ?>
                            <img class="tz_pin_comsPins_img"
                                 src="<?php echo JUri::root() . '/' . $this->UserImgLogin->images; ?>">
                        <?php } else { ?>
                            <img class="tz_pin_comsPins_img"
                                 src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                        <?php } ?>
                        <img class="tz_pin_comsPins_img"
                             src="<?php echo JUri::root() . '/' . $this->UserImgLogin->images; ?>" alt="">

                        <form method="<?php echo JRoute::_('index.php?option=com_tz_pinboard'); ?>">
                            <input type="hidden" class="tz_hd_id_pin" value="<?php echo $Pins->content_id; ?>">
                            <textarea class="tz_comment_add_pin" maxlength="<?php echo $this->Limit_comment; ?>"
                                      style="width: 64%"
                                      placeholder="<?php echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT'); ?>"></textarea>

                            <p class="tz_comment_erroc_p"></p>
                            <input class="tz_bt_pin_add btn btn-small" type="button" name="tz_bt_pin"
                                   value="<?php echo JText::_('COM_TZ_PINBOARD_ADD_COMMENT'); ?>">

                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php
    }
}
?>
