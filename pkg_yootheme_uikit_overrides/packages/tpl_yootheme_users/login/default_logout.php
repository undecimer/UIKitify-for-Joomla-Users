<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $this */
?>
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xsmall">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h1 class="uk-heading-medium uk-text-center">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        <?php endif; ?>

        <?php if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description', '')) != '') || $this->params->get('logout_image') != '') : ?>
            <div class="uk-margin-medium-bottom">
                <?php if ($this->params->get('logoutdescription_show') == 1) : ?>
                    <div class="uk-text-center uk-margin"><?php echo $this->params->get('logout_description'); ?></div>
                <?php endif; ?>

                <?php if ($this->params->get('logout_image') != '') : ?>
                    <?php echo HTMLHelper::_('image', $this->params->get('logout_image'), empty($this->params->get('logout_image_alt')) && empty($this->params->get('logout_image_alt_empty')) ? false : $this->params->get('logout_image_alt'), ['class' => 'uk-width-medium uk-align-center']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted">
                <h3 class="uk-card-title uk-margin-remove">
                    <span uk-icon="icon: sign-out"></span> <?php echo Text::_('COM_USERS_LOGOUT_TITLE') ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-alert uk-alert-primary">
                    <?php echo Text::_('COM_USERS_LOGOUT_DESC') ?>
                </div>

                <form action="<?php echo Route::_('index.php?option=com_users&task=user.logout'); ?>" 
                      method="post" 
                      class="uk-form-stacked">

                    <div class="uk-margin-medium-top">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                            <span uk-icon="icon: sign-out"></span> <?php echo Text::_('JLOGOUT'); ?>
                        </button>
                    </div>

                    <?php if ($this->params->get('logout_redirect_url')) : ?>
                        <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return', null, ''))); ?>">
                    <?php else : ?>
                        <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_menuitem', $this->form->getValue('return', null, ''))); ?>">
                    <?php endif; ?>
                    <?php echo HTMLHelper::_('form.token'); ?>
                </form>
            </div>
        </div>
    </div>
</div>
