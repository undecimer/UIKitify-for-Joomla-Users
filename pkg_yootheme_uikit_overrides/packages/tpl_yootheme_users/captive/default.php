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
use Joomla\Component\Users\Site\Model\CaptiveModel;
use Joomla\Component\Users\Site\View\Captive\HtmlView;
use Joomla\Utilities\ArrayHelper;

/**
 * @var HtmlView     $this  View object
 * @var CaptiveModel $model The model
 */
$model = $this->getModel();

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

$this->document->getWebAssetManager()
    ->useScript('webcomponent.field-user')
    ->useScript('com_users.two-factor-focus');

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
                    <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_USER_MULTIFACTOR_AUTH'); ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <?php if (!empty($this->title)) : ?>
                    <div class="uk-alert uk-alert-primary" uk-alert>
                        <h4 class="uk-margin-remove">
                            <?php echo $this->escape($this->title); ?>
                        </h4>
                    </div>
                <?php endif; ?>

                <?php if (!empty($this->renderOptions['help'])) : ?>
                    <div class="uk-alert uk-alert-primary" uk-alert>
                        <?php echo $this->renderOptions['help']; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($this->renderOptions['pre_message'])) : ?>
                    <div class="uk-margin">
                        <?php echo $this->renderOptions['pre_message']; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo Route::_('index.php?option=com_users&task=captive.validate&record_id=' . $this->record->id); ?>"
                      method="post"
                      id="com-users-captive-form"
                      class="uk-form-stacked">

                    <div class="uk-margin">
                        <?php echo $this->renderOptions['field']; ?>
                    </div>

                    <?php if (!empty($this->renderOptions['post_message'])) : ?>
                        <div class="uk-margin">
                            <?php echo $this->renderOptions['post_message']; ?>
                        </div>
                    <?php endif; ?>

                    <div class="uk-margin-medium-top">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                            <span uk-icon="icon: check"></span>
                            <?php echo Text::_('COM_USERS_MFA_VALIDATE'); ?>
                        </button>
                    </div>

                    <?php if (!empty($this->allowEntryBatching)): ?>
                        <div class="uk-margin uk-text-center">
                            <a class="uk-button uk-button-link" href="<?php echo Route::_('index.php?option=com_users&view=captive&task=select'); ?>">
                                <span uk-icon="icon: refresh"></span>
                                <?php echo Text::_('COM_USERS_MFA_USE_DIFFERENT_METHOD'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="returnurl" value="<?php echo $this->escape($this->returnURL); ?>">
                    <?php echo HTMLHelper::_('form.token'); ?>
                </form>
            </div>
        </div>
    </div>
</div>
