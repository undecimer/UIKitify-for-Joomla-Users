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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Users\Site\View\Method\HtmlView;
use Joomla\Utilities\ArrayHelper;

/** @var  HtmlView  $this */

$cancelURL = Route::_('index.php?option=com_users&task=methods.display&user_id=' . $this->user->id);

if (!empty($this->returnURL)) {
    $cancelURL = $this->escape(base64_decode($this->returnURL));
}

$recordId     = (int) $this->record->id ?? 0;
$method       = $this->record->method ?? $this->getModel()->getState('method');
$userId       = (int) $this->user->id ?? 0;
$headingLevel = 2;
$hideSubmit   = !$this->renderOptions['show_submit'] && !$this->isEditExisting
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
                                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_MFA_EDIT_METHOD'); ?>
                                </h3>
                            </div>
                            <?php if (!empty($this->renderOptions['help_url'])) : ?>
                                <div>
                                    <a href="<?php echo $this->renderOptions['help_url'] ?>" class="uk-icon-button" uk-icon="icon: question" target="_blank"></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="uk-card-body uk-padding-small">
                        <form action="<?php echo Route::_(sprintf("index.php?option=com_users&task=method.save&id=%d&method=%s&user_id=%d", $recordId, $method, $userId)) ?>"
                            class="uk-form-stacked" id="com-users-method-edit" method="post">
                            <?php echo HTMLHelper::_('form.token') ?>
                            <?php if (!empty($this->returnURL)) : ?>
                                <input type="hidden" name="returnurl" value="<?php echo $this->escape($this->returnURL) ?>">
                            <?php endif; ?>

                            <?php if (!empty($this->renderOptions['hidden_data'])) : ?>
                                <?php foreach ($this->renderOptions['hidden_data'] as $key => $value) : ?>
                                    <input type="hidden" name="<?php echo $this->escape($key) ?>" value="<?php echo $this->escape($value) ?>">
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($this->title)) : ?>
                                <h<?php echo $headingLevel ?> class="uk-heading-small uk-text-center">
                                    <?php echo $this->title; ?>
                                </h<?php echo $headingLevel ?>>
                            <?php endif; ?>

                            <?php if (!empty($this->renderOptions['pre_message'])) : ?>
                                <div class="uk-alert uk-alert-primary">
                                    <?php echo $this->renderOptions['pre_message'] ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($this->renderOptions['tabular_data'])) : ?>
                                <div class="uk-overflow-auto">
                                    <table class="uk-table uk-table-small uk-table-striped">
                                        <?php foreach ($this->renderOptions['tabular_data'] as $cell) : ?>
                                            <tr>
                                                <th scope="row" width="25%"><?php echo $cell[0] ?></th>
                                                <td><?php echo $cell[1] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <div class="uk-margin <?php echo $this->renderOptions['input_type'] === 'hidden' ? 'uk-hidden' : '' ?>">
                                <?php if ($this->renderOptions['label']) : ?>
                                    <label class="uk-form-label" for="com-users-method-code">
                                        <?php echo $this->renderOptions['label']; ?>
                                    </label>
                                <?php endif; ?>

                                <div class="uk-form-controls">
                                    <?php if ($this->renderOptions['input_type'] === 'custom') : ?>
                                        <?php echo $this->renderOptions['html']; ?>
                                    <?php else : ?>
                                        <input type="<?php echo $this->renderOptions['input_type'] ?>"
                                            name="code"
                                            class="uk-input"
                                            id="com-users-method-code"
                                            value="<?php echo $this->escape($this->renderOptions['input_value']) ?>"
                                            <?php echo $this->renderOptions['placeholder'] ? 'placeholder="' . $this->escape($this->renderOptions['placeholder']) . '"' : '' ?>
                                            <?php echo !empty($this->renderOptions['regex']) ? 'pattern="' . $this->escape($this->renderOptions['regex']) . '"' : '' ?>
                                        >
                                    <?php endif; ?>

                                    <?php if ($this->renderOptions['input_type'] !== 'custom' && $this->renderOptions['help']) : ?>
                                        <div class="uk-text-meta uk-margin-small-top">
                                            <?php echo $this->renderOptions['help']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!empty($this->renderOptions['post_message'])) : ?>
                                <div class="uk-alert uk-alert-primary">
                                    <?php echo $this->renderOptions['post_message'] ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!$hideSubmit) : ?>
                                <div class="uk-margin-medium-top uk-text-center">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        <span uk-icon="icon: check"></span>
                                        <?php echo Text::_('JSAVE') ?>
                                    </button>

                                    <a href="<?php echo $cancelURL ?>" class="uk-button uk-button-default">
                                        <span uk-icon="icon: close"></span>
                                        <?php echo Text::_('JCANCEL') ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
