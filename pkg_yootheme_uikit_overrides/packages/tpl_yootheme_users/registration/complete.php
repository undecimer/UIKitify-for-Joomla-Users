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

/** @var \Joomla\Component\Users\Site\View\Registration\HtmlView $this */
?>
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xsmall">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h1 class="uk-heading-medium uk-text-center">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        <?php endif; ?>

        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted">
                <h3 class="uk-card-title uk-margin-remove">
                    <span uk-icon="icon: check"></span> <?php echo Text::_('COM_USERS_REGISTRATION_COMPLETE_TITLE'); ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <?php if ($this->params->get('registration_complete_activate')) : ?>
                    <div class="uk-alert uk-alert-success" uk-alert>
                        <span uk-icon="icon: mail"></span>
                        <?php echo Text::_('COM_USERS_REGISTRATION_ACTIVATE_SUCCESS'); ?>
                    </div>
                <?php elseif ($this->params->get('registration_complete_verify')) : ?>
                    <div class="uk-alert uk-alert-success" uk-alert>
                        <span uk-icon="icon: mail"></span>
                        <?php echo Text::_('COM_USERS_REGISTRATION_VERIFY_SUCCESS'); ?>
                    </div>
                <?php else : ?>
                    <div class="uk-alert uk-alert-success" uk-alert>
                        <span uk-icon="icon: check"></span>
                        <?php echo Text::_('COM_USERS_REGISTRATION_COMPLETE_SUCCESS'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->params->get('registration_complete_activate')) : ?>
                    <div class="uk-margin">
                        <p class="uk-text-emphasis">
                            <span uk-icon="icon: info"></span>
                            <?php echo Text::_('COM_USERS_REGISTRATION_VERIFY_DESC'); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-card-footer uk-text-center">
                <a class="uk-button uk-button-primary" href="<?php echo Route::_('index.php?option=com_users&view=login'); ?>">
                    <span uk-icon="icon: sign-in"></span>
                    <?php echo Text::_('COM_USERS_LOGIN_TITLE'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
