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

/** @var \Joomla\Component\Users\Site\View\Profile\HtmlView $this */

?>
<div class="uk-section uk-section-default uk-padding-remove-top">
    <div class="uk-container uk-container-expand">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h1 class="uk-heading-bullet uk-margin-medium-bottom">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        <?php endif; ?>

        <?php echo $this->loadTemplate('core'); ?>

        <div class="uk-margin-large-top">
            <?php 
            $showProfileTabs = false;
            if (isset($this->data->params) && is_object($this->data->params)) {
                $showProfileTabs = $this->data->params->get('show_profile_tabs', 1);
            }
            $hasParams = count($this->form->getFieldset('params')) > 0;
            
            // Check for custom fields
            $fieldsets = $this->form->getFieldsets();
            unset($fieldsets['core']);
            unset($fieldsets['params']);
            $hasCustomFields = !empty($fieldsets);

            if ($hasCustomFields || $hasParams) :
            ?>
                <?php if ($showProfileTabs) : ?>
                    <ul class="uk-tab" uk-tab="connect: #profile-tabs; animation: uk-animation-fade">
                        <?php if ($hasCustomFields) : ?>
                            <li class="uk-active"><a href="#"><?php echo Text::_('COM_USERS_PROFILE_CUSTOM_LEGEND'); ?></a></li>
                        <?php endif; ?>
                        <?php if ($hasParams) : ?>
                            <li<?php echo !$hasCustomFields ? ' class="uk-active"' : ''; ?>><a href="#"><?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></a></li>
                        <?php endif; ?>
                    </ul>

                    <ul id="profile-tabs" class="uk-switcher uk-margin">
                        <?php if ($hasCustomFields) : ?>
                            <li>
                                <?php echo $this->loadTemplate('custom'); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($hasParams) : ?>
                            <li>
                                <?php echo $this->loadTemplate('params'); ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php else : ?>
                    <?php if ($hasCustomFields) : ?>
                        <div class="uk-margin-large">
                            <?php echo $this->loadTemplate('custom'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($hasParams) : ?>
                        <div class="uk-margin-large">
                            <?php echo $this->loadTemplate('params'); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>