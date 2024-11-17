<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Users\Site\View\Captive\HtmlView;

/** @var HtmlView $this */

HTMLHelper::_('behavior.keepalive');

$shownMethods = [];

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
                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_MFA_SELECT_PAGE_HEAD'); ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-alert uk-alert-primary" uk-alert>
                    <p><?php echo Text::_('COM_USERS_LBL_SELECT_INSTRUCTIONS'); ?></p>
                </div>

                <div class="uk-margin">
                    <?php foreach ($this->records as $record) : ?>
                        <?php
                        if (!array_key_exists($record->method, $this->mfaMethods) && ($record->method != 'backupcodes')) {
                            continue;
                        }

                        $allowEntryBatching = isset($this->mfaMethods[$record->method]) ? $this->mfaMethods[$record->method]['allowEntryBatching'] : false;

                        if ($this->allowEntryBatching) {
                            if ($allowEntryBatching && in_array($record->method, $shownMethods)) {
                                continue;
                            }
                            $shownMethods[] = $record->method;
                        }

                        $methodName = $this->getModel()->translateMethodName($record->method);
                        ?>
                        <div class="uk-card uk-card-small uk-card-default uk-margin">
                            <div class="uk-card-body">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <?php if (!empty($this->mfaMethods[$record->method]['image'])) : ?>
                                        <div class="uk-width-auto">
                                            <img src="<?php echo Uri::root() . $this->mfaMethods[$record->method]['image'] ?>"
                                                 alt="<?php echo $this->escape($methodName) ?>"
                                                 style="height: 2em">
                                        </div>
                                    <?php endif; ?>
                                    <div class="uk-width-expand">
                                        <h4 class="uk-card-title uk-margin-remove">
                                            <?php if ($this->allowEntryBatching) : ?>
                                                <?php echo $methodName ?>
                                            <?php else: ?>
                                                <?php echo $this->escape($record->title) ?>
                                            <?php endif; ?>
                                        </h4>
                                        <?php if (!$this->allowEntryBatching && !empty($record->last_used)) : ?>
                                            <p class="uk-text-meta uk-margin-remove">
                                                <?php echo Text::sprintf('COM_USERS_MFA_LAST_USED', $record->last_used) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="uk-width-auto">
                                        <a href="<?php echo Route::_('index.php?option=com_users&view=captive&record_id=' . $record->id); ?>"
                                           class="uk-button uk-button-primary">
                                            <span uk-icon="icon: check"></span>
                                            <?php echo Text::_('COM_USERS_MFA_USE_THIS_METHOD'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
