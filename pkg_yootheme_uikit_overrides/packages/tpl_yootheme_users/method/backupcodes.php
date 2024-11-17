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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Users\Site\View\Method\HtmlView;

/** @var  HtmlView $this */

HTMLHelper::_('bootstrap.tooltip', '.hasTooltip');

$cancelURL = Route::_('index.php?option=com_users&task=methods.display&user_id=' . $this->user->id);

if (!empty($this->returnURL)) {
    $cancelURL = $this->escape(base64_decode($this->returnURL));
}

if ($this->record->method != 'backupcodes') {
    throw new RuntimeException(Text::_('JERROR_ALERTNOAUTHOR'), 403);
}

?>

<div class="uk-section uk-section-default">
    <div class="uk-container">
        <div class="uk-grid uk-flex uk-flex-center" uk-grid>
            <div class="uk-width-1-1 uk-width-2-3@s uk-width-1-2@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header uk-background-muted uk-padding-small">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">
                                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_USER_BACKUPCODES') ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-body uk-padding-small">
                        <div class="uk-alert uk-alert-primary">
                            <?php echo Text::_('COM_USERS_USER_BACKUPCODES_DESC') ?>
                        </div>

                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-small uk-table-divider uk-table-middle uk-margin-medium">
                                <?php for ($i = 0; $i < (count($this->backupCodes) / 2); $i++) : ?>
                                    <tr>
                                        <td class="uk-width-1-2">
                                            <?php if (!empty($this->backupCodes[2 * $i])) : ?>
                                                <div class="uk-flex uk-flex-middle">
                                                    <span class="uk-margin-small-right" aria-hidden="true" uk-icon="icon: key"></span>
                                                    <code class="uk-text-emphasis"><?php echo $this->backupCodes[2 * $i] ?></code>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="uk-width-1-2">
                                            <?php if (!empty($this->backupCodes[1 + 2 * $i])) : ?>
                                                <div class="uk-flex uk-flex-middle">
                                                    <span class="uk-margin-small-right" aria-hidden="true" uk-icon="icon: key"></span>
                                                    <code class="uk-text-emphasis"><?php echo $this->backupCodes[1 + 2 * $i] ?></code>
                                                </div>
                                            <?php endif ;?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </div>

                        <div class="uk-alert uk-alert-warning">
                            <?php echo Text::_('COM_USERS_MFA_BACKUPCODES_RESET_INFO'); ?>
                        </div>

                        <div class="uk-margin-medium-top uk-text-center">
                            <a class="uk-button uk-button-danger uk-margin-small-right" 
                               href="<?php echo Route::_(sprintf("index.php?option=com_users&task=method.regenerateBackupCodes&user_id=%s&%s=1%s", 
                                    $this->user->id, 
                                    Factory::getApplication()->getFormToken(), 
                                    empty($this->returnURL) ? '' : '&returnurl=' . $this->returnURL)) ?>">
                                <span uk-icon="icon: refresh"></span>
                                <?php echo Text::_('COM_USERS_MFA_BACKUPCODES_RESET'); ?>
                            </a>

                            <a href="<?php echo $cancelURL ?>" class="uk-button uk-button-default">
                                <span uk-icon="icon: close"></span>
                                <?php echo Text::_('JCANCEL'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
