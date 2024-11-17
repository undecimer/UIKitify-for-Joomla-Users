<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Prevent direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Users\Site\View\Methods\HtmlView;

/** @var HtmlView $this */

$headingLevel = 2;
?>
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xsmall">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted">
                <h3 class="uk-card-title uk-margin-remove">
                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_USER_MULTIFACTOR_AUTH'); ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-alert uk-alert-primary" uk-alert>
                    <h4 class="uk-margin-remove-bottom">
                        <?php echo Text::_('COM_USERS_MFA_FIRSTTIME_PAGE_HEAD'); ?>
                    </h4>
                    <p class="uk-margin-small-top">
                        <?php echo Text::_('COM_USERS_MFA_FIRSTTIME_PAGE_HEAD_DESC'); ?>
                    </p>
                </div>

                <div class="uk-margin-medium-top">
                    <a href="<?php echo Route::_('index.php?option=com_users&view=method&task=add' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                       class="uk-button uk-button-primary uk-width-1-1">
                        <span uk-icon="icon: plus"></span>
                        <?php echo Text::_('COM_USERS_MFA_ADD_AUTHENTICATOR'); ?>
                    </a>
                </div>

                <?php if (!$this->isMandatoryMFASetup) : ?>
                    <div class="uk-margin uk-text-center">
                        <a href="<?php echo Route::_('index.php?option=com_users&task=methods.doNotShowThisAgain&' . Factory::getApplication()->getFormToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                           class="uk-button uk-button-link">
                            <span uk-icon="icon: close"></span>
                            <?php echo Text::_('COM_USERS_MFA_FIRSTTIME_NOT_NOW'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
