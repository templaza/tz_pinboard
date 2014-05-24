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

$url = JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($this->show_detail->content_id), true, -1);
?>


<div class="tz_detail_content">

<?php if (isset($this->type_details) && $this->type_details == 1) : ?>
    <span class="tz_detail_pins"></span>
<?php endif; ?>
<div class="tz-detail-hover">
    <?php if (isset($this->show_detail) && !empty($this->show_detail->pz_video)) : ?>
        <iframe class="tz_iframe" width="100%" height="480"
                src="<?php echo $this->show_detail->pz_video; ?>"
                frameborder="0" allowfullscreen>
        </iframe>
    <?php else : ?>
        <?php
        $img_size = $this->img_size;
        $img_type = JFile::getExt($this->show_detail->poro_img);

        if ($img_type == 'gif') {
            $img_type_replaca = $this->show_detail->poro_img;
        } else {
            $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $this->show_detail->poro_img);

        }

        ?>
        <img class="tz_imgs" src="<?php echo JUri::root() . "/" . $img_type_replaca; ?>">
    <?php endif; ?>
</div>
<?php if (isset($this->show_detail->c_attribs) && !empty($this->show_detail->c_attribs)) : ?>
    <div class="tz-detail-price">
        <?php
        $price = new JRegistry($this->show_detail->c_attribs);
        echo $price->get('price');
        ?>
    </div>

<?php endif; ?>

<div id="tz_detail_user">
    <?php if (isset($this->imgUser) && $this->imgUser == 1) : ?>
        <div class="tz_detail_user_left">
            <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($this->show_detail->id_user)); ?>">
                <?php if (isset($this->show_detail->img_user) && !empty($this->show_detail->img_user)) : ?>
                    <img id="tz_thumbnails_img" src="<?php echo JUri::root() . '/' . $this->show_detail->img_user; ?>">
                <?php else : ?>
                    <img id="tz_thumbnails_img"
                         src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="tz_detail_user_right">
        <?php if (isset($this->show_title) && $this->show_title == 1): ?>
            <h6>
                <?php echo $this->show_detail->conten_title; ?>
            </h6>
        <?php endif; ?>
        <p>
            <?php if (isset($this->show_detail->website) && !empty($this->show_detail->website) && $this->web_d == 1) : ?>
                <span class="tz_web"><?php echo JText::_('COM_TZ_PINBOARD_SOURCE_BY'); ?></span>
                <a target="_blank" href="<?php echo $this->show_detail->website; ?>" rel="nofollow">
                    <?php
                    $arr_web = explode('/', $this->show_detail->website);
                    $arr_web = array_slice($arr_web, 0, $this->text_website);
                    $str_web = implode(" ", $arr_web);
                    $str = str_replace(" ", "/", $str_web);
                    echo $str;
                    ?>
                </a>
            <?php endif; ?>
        </p>
    </div>
    <div class="cler"></div>
</div>
<?php if (isset($this->ds_detail) && $this->ds_detail == 1) : ?>
    <p class="tz_detail_intro">
        <?php echo $this->show_detail->content_introtext; ?>
    </p>
<?php endif; ?>
<?php if (isset($this->show_detail->tags) && !empty($this->show_detail->tags) && $this->show_tags == '1') : ?>
    <p class="tz_show_all">
        <?php
        foreach ($this->show_detail->tags as $tag) :
            ?>
            <a class="tz_detail_tags"
               href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardTagsRoute($tag->tagid)); ?>"
               rel="nofollow">
                <?php echo "#  " . $tag->tagname; ?>
            </a>
        <?php endforeach; ?>
    </p>
<?php
endif;
?>
<p class="tz_show_all">
    <?php if (isset($this->name_b) && $this->name_b) : ?>
        <a class="tz_detail_title_board"
           href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManagetuset2('', $this->show_detail->id_user, $this->show_detail->category_id)); ?>"
           rel="nofollow">
            <?php echo $this->show_detail->boar_title; ?>
        </a>
    <?php endif; ?>
    <?php if (isset($this->date_d) && $this->date_d == 1) : ?>
        <span class="tz_detail_date">
                <?php echo date(JText::_('TZ_PINBOARD_DATE_FOMAT'), strtotime($this->show_detail->c_created)); ?>
            </span>
    <?php endif; ?>

<p class="cler"></p>
</p>
<?php if (isset($this->social) && $this->social == 1) : ?>
    <div class="tz_pinboard_social">
        <div class="TwitterButton">
            <a href="https://twitter.com/share" data-url="<?php echo $url; ?>" class="twitter-share-button"
               data-count="horizontal"<?php //if($this->item->params->get('twitterUsername')): ?>
               data-via="<?php //echo $this->item->params->get('twitterUsername'); ?>"
               data-size="small">
            </a>
            <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
        </div>
        <div class="GooglePlusOneButton">
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-href="<?php echo $url ?>"></div>

            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">
                (function () {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
            </script>
        </div>
        <div class="FacebookButton">
            <div id="fb-root"></div>
            <script type="text/javascript">
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="fb-like" data-send="false" data-width="200" data-show-faces="true"
                 data-layout="button_count" data-href="<?php echo $url; ?>"></div>
        </div>
        <div class="PinterestButton">
            <a href="//www.pinterest.com/pin/create/button/?url=<?php echo urlencode($url); ?>"
               data-pin-do="buttonPin" data-pin-config="beside" data-pin-color="red">
                <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" alt=""/>
            </a>
            <script type="text/javascript">
                (function (d) {
                    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
                    p.type = 'text/javascript';
                    p.async = true;
                    p.src = '//assets.pinterest.com/js/pinit.js';
                    f.parentNode.insertBefore(p, f);
                }(document));
            </script>
        </div>

        <div class="LinkedinButton">
            <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
            <script type="IN/Share" data-url="<?php echo $url; ?>" data-counter="right"></script>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($this->button_d) && $this->button_d == 1) { ?>
    <div class="tz_detail_pl">
<span class="tz_button_repin   tz_repin" data-option-id="<?php echo $this->show_detail->content_id; ?>">
    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_REPIN'); ?>
</span>
        <span class="tz_pinboard_sp">/</span>
        <?php
        if ($this->show_detail->id_user == $this->sosanhuser) {
            ?>
            <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute('', $this->show_detail->content_id)) ?>"
               rel="nofollow">
                <span class="tz_button_repin  "> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?></span>
            </a>

        <?php
        } else {

            ?>
            <span class="tz_button_repin <?php if ($this->show_detail->check_like['p'] == '1') {
                echo "tz_check_like";
            } ?>  <?php if (empty($this->sosanhuser) || $this->sosanhuser == "0") {
                echo "tz_like_ero";
            } else {
                echo "tz_like";
            } ?>" data-text-like="<?php echo $this->show_detail->name_user; ?>"
                  data-option-id="<?php echo $this->show_detail->content_id; ?>">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKE'); ?>
                </span>
            <span
                class="tz_button_repin   disabled_d tz_unlike <?php if ($this->show_detail->check_like['p'] == '0' || $this->show_detail->check_like['p'] == "") {
                    echo "tz_check_like";
                } ?> " data-text-like="<?php echo $this->show_detail->name_user; ?>"
                data-option-id="<?php echo $this->show_detail->content_id; ?>">

                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNLIKE'); ?>
                </span>

        <?php
        }
        ?>

        <?php
        if ($this->show_detail->id_user != $this->sosanhuser) {
            ?>
            <span class="tz_pinboard_sp">/</span>
            <?php
            if ($this->show_detail->follow['f'] == '0' || $this->show_detail->follow['f'] == '') {
                ?>
                <span class="tz_button_repin    <?php if (!isset($this->sosanhuser) || empty($this->sosanhuser)) {
                    echo "tz_erro_follow";
                } else {
                    echo "tz_follow";
                } ?> " data-option-text="<?php echo $this->show_detail->name_user; ?>"
                      data-option-id="<?php echo $this->show_detail->id_user; ?>">
                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>
                    </span>
            <?php
            } else if ($this->show_detail->follow['f'] == '1') {
                ?>
                <span class="tz_button_repin   disabled_d tz_unfollow"
                      data-option-id="<?php echo $this->show_detail->id_user; ?>">
                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>
                    </span>

            <?php
            }

        } ?>

        <?php if (isset($this->show_detail->website) && !empty($this->show_detail->website)) { ?>
            <span class="tz_pinboard_sp">/</span>
            <a target="_blank" href="<?php echo $this->show_detail->website; ?>" rel="nofollow">
                <span class="tz_button_repin"><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_VITSIT_SITE'); ?></span>
            </a>

        <?php
        }
        ?>
        <?php

        if (isset($this->show_detail->c_state) && $this->show_detail->c_state == 0 && $this->checkApp == 'true') {
            ?>
            <span class="tz_pinboard_sp">/</span>
            <span class="tz_button_repin tz-approver tz-detail-app"
                  data-option-id="<?php echo $this->show_detail->content_id; ?>">
                    <?php echo JText::_('COM_TZ_PINBOARD_CHECK_APPROVED') ?>
                </span>
        <?php
        }
        ?>

    </div>
<?php } ?>
<?php if (isset($this->s_detail) && $this->s_detail == 1) { ?>
    <div class="thumbnails tz_content_cm">
        <?php if ((int)$this->page_comment < (int)$this->Demcommnet->number_id) { ?>
            <div class="tz_detail_page">
                <a id="tz_comment_pt_a" data-optio-page="2" data-optio-id="0">
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_LOAD_MORE'); ?>
                </a>
                <span id="id_loadding"> </span>

                <div class="cler"></div>
                <div id="tz_page_stop">
                </div>
            </div>

        <?php } ?>
        <ul>
            <?php echo $this->loadTemplate('comment'); ?>
        </ul>

    </div>

    <div class="thumbnails tz_datail_comment">
        <form>
            <input type="hidden" id="tz_hd_id_pin" value="<?php echo $this->show_detail->content_id; ?>">
            <textarea id="tz_comment" maxlength="<?php echo $this->limit_comment; ?>"
                      placeholder="<?php if (isset($this->sosanhuser) && !empty($this->sosanhuser)) {
                          echo JText::_('COM_TZ_PINBOARD_YOUR_COMMENT');
                      } else {
                          echo JText::_('COM_TZ_PINBOARD_LOGIN_COMMENT');
                      } ?>"></textarea>
            <span id="tz_comment_erroc_p"></span>
            <button type="button" class="btn" id="<?php if (isset($this->sosanhuser) && !empty($this->sosanhuser)) {
                echo "tz_post_cm";
            } else {
                echo "tz_post_cm_erro";
            } ?>"><?php echo JText::_('COM_TZ_PINBOARD_POST_COMMENT'); ?></button>
        </form>

        <div class="cler"></div>
    </div>
<?php } ?>
</div>
<div class="tz_notice_detail">

    <h5><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_YOU_WANT_COMMENT'); ?></h5>

    <div class="tz_delete_option">
        <a class="btn btn-large tz_detail_canel"
           type="button"><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_CANCEL_COMMENT'); ?></a>
        <a class="btn btn-danger btn-large tz_detail_delete"
           type="button"><?php echo JText::_('COM_TZ_PINBOARD_DETAIL_DELETE_COMMENT') ?></a>
    </div>

</div>