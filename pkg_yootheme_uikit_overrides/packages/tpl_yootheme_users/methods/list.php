<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Users\Administrator\Helper\Mfa as MfaHelper;
use Joomla\Component\Users\Site\Model\MethodsModel;
use Joomla\Component\Users\Site\View\Methods\HtmlView;

/** @var HtmlView $this */

/** @var MethodsModel $model */
$model = $this->getModel();

$this->getDocument()->getWebAssetManager()->useScript('com_users.two-factor-list');

HTMLHelper::_('bootstrap.tooltip', '.hasTooltip');

$canAddEdit = MfaHelper::canAddEditMethod($this->user);
$canDelete  = MfaHelper::canDeleteMethod($this->user);
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
                <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                    <?php foreach ($this->methods as $methodName => $method) :
                        $isDefault = $this->defaultMethod == $methodName;
                        $hasActive = count($method['active']);
                    ?>
                        <div>
                            <div class="uk-card uk-card-small uk-card-default <?php echo $hasActive ? 'uk-card-primary' : ''; ?>">
                                <div class="uk-card-header uk-padding-small">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <?php if (!empty($method['image'])) : ?>
                                            <div class="uk-width-auto">
                                                <div class="uk-background-muted uk-padding-small uk-border-rounded">
                                                    <img src="<?php echo Uri::root() . $method['image'] ?>"
                                                         alt="<?php echo $this->escape($method['display']) ?>"
                                                         class="uk-preserve-width"
                                                         style="height: 32px;">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="uk-width-expand">
                                            <h4 class="uk-card-title uk-margin-remove">
                                                <?php echo $method['display']; ?>
                                                <?php if ($isDefault) : ?>
                                                    <span class="uk-label uk-label-success">
                                                        <span uk-icon="icon: star"></span>
                                                        <?php echo Text::_('COM_USERS_MFA_LIST_DEFAULTMETHOD'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-card-body uk-padding-small">
                                    <?php if (!empty($method['shortinfo'])) : ?>
                                        <div class="uk-text-meta uk-margin-small-bottom">
                                            <?php echo $method['shortinfo']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($hasActive) : ?>
                                        <div class="uk-margin-medium-top">
                                            <?php foreach ($method['active'] as $record) : ?>
                                                <div class="uk-card uk-card-small uk-card-default uk-margin">
                                                    <div class="uk-card-body uk-padding-small">
                                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                            <div class="uk-width-expand">
                                                                <?php if ($methodName === 'backupcodes' && $canAddEdit) : ?>
                                                                    <div class="uk-alert uk-alert-primary uk-margin-remove">
                                                                        <span uk-icon="icon: info"></span>
                                                                        <?php echo Text::sprintf('COM_USERS_MFA_BACKUPCODES_PRINT_PROMPT_HEAD', 
                                                                            Route::_('index.php?option=com_users&task=method.edit&id=' . (int) $record->id . 
                                                                            ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . 
                                                                            '&user_id=' . $this->user->id)
                                                                        ); ?>
                                                                    </div>
                                                                <?php else : ?>
                                                                    <h5 class="uk-margin-remove">
                                                                        <?php echo $this->escape($record->title); ?>
                                                                    </h5>
                                                                    <?php if (!empty($record->last_used)) : ?>
                                                                        <p class="uk-text-meta uk-margin-remove">
                                                                            <?php echo Text::sprintf('COM_USERS_MFA_LBL_LASTUSED', $record->last_used); ?>
                                                                        </p>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                <div class="uk-button-group">
                                                                    <?php if ($canAddEdit && $record->canEdit) : ?>
                                                                        <a class="uk-button uk-button-primary uk-button-small"
                                                                           href="<?php echo Route::_('index.php?option=com_users&task=method.edit&id=' . (int) $record->id . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id); ?>">
                                                                            <span uk-icon="icon: pencil"></span>
                                                                            <?php echo Text::_('JACTION_EDIT'); ?>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <?php if ($canDelete && $record->canDelete) : ?>
                                                                        <a class="uk-button uk-button-danger uk-button-small"
                                                                           href="<?php echo Route::_('index.php?option=com_users&task=method.delete&id=' . (int) $record->id . '&' . Factory::getApplication()->getFormToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id); ?>">
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

                                    <?php if ($canAddEdit && (empty($method['active']) || $method['allowMultiple'])) : ?>
                                        <div class="uk-margin-top uk-text-center">
                                            <a href="<?php echo Route::_('index.php?option=com_users&task=method.add&method=' . $this->escape(urlencode($method['name'])) . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id); ?>"
                                               class="uk-button uk-button-primary">
                                                <span uk-icon="icon: plus"></span>
                                                <?php echo Text::_('COM_USERS_MFA_ADD'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
