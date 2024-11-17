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
?>
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xsmall">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted">
                <h3 class="uk-card-title uk-margin-remove">
                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_MFA_LIST_PAGE_HEAD'); ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-alert <?php echo $this->mfaActive ? 'uk-alert-success' : 'uk-alert-warning'; ?>" uk-alert>
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">
                            <span uk-icon="icon: <?php echo $this->mfaActive ? 'check' : 'warning'; ?>"></span>
                            <?php echo Text::_('COM_USERS_MFA_LIST_STATUS_' . ($this->mfaActive ? 'ON' : 'OFF')); ?>
                        </div>
                        <?php if ($this->mfaActive) : ?>
                            <div class="uk-width-auto">
                                <a href="<?php echo Route::_('index.php?option=com_users&task=methods.disable&' . Factory::getApplication()->getFormToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id); ?>"
                                   class="uk-button uk-button-danger uk-button-small">
                                    <span uk-icon="icon: trash"></span>
                                    <?php echo Text::_('COM_USERS_MFA_LIST_REMOVEALL'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!count($this->methods)) : ?>
                    <div class="uk-alert uk-alert-primary" uk-alert>
                        <span uk-icon="icon: info"></span>
                        <?php echo Text::_('COM_USERS_MFA_LIST_INSTRUCTIONS'); ?>
                    </div>
                <?php elseif ($this->isMandatoryMFASetup) : ?>
                    <div class="uk-alert uk-alert-primary" uk-alert>
                        <h4 class="uk-margin-remove-bottom">
                            <?php echo Text::_('COM_USERS_MFA_MANDATORY_NOTICE_HEAD'); ?>
                        </h4>
                        <p class="uk-margin-small-top">
                            <?php echo Text::_('COM_USERS_MFA_MANDATORY_NOTICE_BODY'); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if ($this->methods) : ?>
                    <div class="uk-margin-medium-top">
                        <?php foreach ($this->methods as $method) : ?>
                            <div class="uk-card uk-card-small uk-card-default uk-margin">
                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <?php if (!empty($method->image)) : ?>
                                            <div class="uk-width-auto">
                                                <img src="<?php echo $method->image; ?>" 
                                                     alt="<?php echo $this->escape($method->name); ?>"
                                                     class="uk-preserve-width"
                                                     style="height: 32px;">
                                            </div>
                                        <?php endif; ?>
                                        <div class="uk-width-expand">
                                            <h4 class="uk-card-title uk-margin-remove">
                                                <?php echo $this->escape($method->name); ?>
                                            </h4>
                                            <?php if (!empty($method->last_used)) : ?>
                                                <p class="uk-text-meta uk-margin-remove">
                                                    <?php echo Text::sprintf('COM_USERS_MFA_LBL_LASTUSED', $method->last_used); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="uk-width-auto">
                                            <div class="uk-button-group">
                                                <?php if ($method->canEdit) : ?>
                                                    <a href="<?php echo Route::_('index.php?option=com_users&task=method.edit&id=' . $method->id . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                                                       class="uk-button uk-button-primary uk-button-small">
                                                        <span uk-icon="icon: pencil"></span>
                                                        <?php echo Text::_('JACTION_EDIT'); ?>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($method->canDelete) : ?>
                                                    <a href="<?php echo Route::_('index.php?option=com_users&task=method.delete&id=' . $method->id . '&' . Factory::getApplication()->getFormToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                                                       class="uk-button uk-button-danger uk-button-small">
                                                        <span uk-icon="icon: trash"></span>
                                                        <?php echo Text::_('JACTION_DELETE'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->canAddNewMethod) : ?>
                    <div class="uk-margin-medium-top uk-text-center">
                        <a href="<?php echo Route::_('index.php?option=com_users&task=methods.regenerateBackupCodes&' . Factory::getApplication()->getFormToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                           class="uk-button uk-button-default">
                            <span uk-icon="icon: refresh"></span>
                            <?php echo Text::_('COM_USERS_MFA_BACKUPCODES_REGENERATE'); ?>
                        </a>

                        <a href="<?php echo Route::_('index.php?option=com_users&view=method&task=add' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '')); ?>"
                           class="uk-button uk-button-primary">
                            <span uk-icon="icon: plus"></span>
                            <?php echo Text::_('COM_USERS_MFA_ADD_AUTHENTICATOR'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
