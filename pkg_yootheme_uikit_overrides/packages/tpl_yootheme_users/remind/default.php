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

/** @var \Joomla\Component\Users\Site\View\Remind\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

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
                    <span uk-icon="icon: question"></span> <?php echo Text::_('COM_USERS_REMIND') ?>
                </h3>
            </div>

            <div class="uk-card-body">

                <form id="user-registration" 
                      action="<?php echo Route::_('index.php?option=com_users&task=remind.remind'); ?>" 
                      method="post" 
                      class="uk-form-stacked">

                    <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                        <fieldset class="uk-fieldset">
                            <?php if (isset($fieldset->label)) : ?>
                                <legend class="uk-legend uk-text-emphasis"><?php echo Text::_($fieldset->label); ?></legend>
                            <?php endif; ?>
                            <?php echo $this->form->renderFieldset($fieldset->name); ?>
                        </fieldset>
                    <?php endforeach; ?>
                    
                    <div class="uk-margin-medium-top">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                            <span uk-icon="icon: mail"></span> <?php echo Text::_('JSUBMIT'); ?>
                        </button>
                    </div>

                    <?php echo HTMLHelper::_('form.token'); ?>
                </form>
            </div>

            <div class="uk-card-footer uk-background-muted uk-text-center">
                <a href="<?php echo Route::_('index.php?option=com_users&view=login'); ?>" class="uk-button uk-button-link">
                    <span uk-icon="icon: arrow-left"></span> <?php echo Text::_('COM_USERS_LOGIN_DEFAULT_LABEL'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
