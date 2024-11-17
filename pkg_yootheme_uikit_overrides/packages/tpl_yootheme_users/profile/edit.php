<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\Component\Users\Site\View\Profile\HtmlView $this */

HTMLHelper::_('bootstrap.tooltip', '.hasTooltip');

// Load user_profile plugin language
$lang = $this->getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

?>
<div class="uk-section uk-section-default uk-padding-remove-top">
    <div class="uk-container">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h1 class="uk-heading-medium uk-text-center">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        <?php endif; ?>

        <form id="member-profile" action="<?php echo Route::_('index.php?option=com_users'); ?>" method="post" class="uk-form-stacked" enctype="multipart/form-data">
            <?php 
            // Group fieldsets
            $coreTabs = ['account', 'core'];
            $customTabs = [];
            $paramTabs = [];
            
            foreach ($this->form->getFieldsets() as $group => $fieldset) {
                $fields = $this->form->getFieldset($group);
                if (empty($fields)) continue;
                
                if (in_array($group, $coreTabs)) {
                    $coreTabs[$group] = $fieldset;
                } elseif ($group === 'params') {
                    $paramTabs[$group] = $fieldset;
                } else {
                    $customTabs[$group] = $fieldset;
                }
            }
            ?>

            <div class="uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@m" uk-grid="masonry: true">
                <!-- Core Fields Card -->
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header uk-background-muted uk-padding-small">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <h3 class="uk-card-title uk-margin-remove-bottom">
                                        <span uk-icon="icon: user"></span> <?php echo Text::_('COM_USERS_EDIT_PROFILE'); ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-body uk-padding-small">
                            <?php foreach ($coreTabs as $group => $fieldset) : ?>
                                <?php if (!is_object($fieldset)) continue; ?>
                                <?php $fields = $this->form->getFieldset($group); ?>
                                <fieldset class="uk-fieldset">
                                    <?php foreach ($fields as $field) : ?>
                                        <?php echo str_replace(['control-group', 'control-label', 'controls'], ['uk-margin-small', 'uk-form-label', 'uk-form-controls'], $field->renderField()); ?>
                                    <?php endforeach; ?>
                                </fieldset>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Custom Fields Card -->
                <?php if (!empty($customTabs)) : ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header uk-background-muted uk-padding-small">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">
                                            <span uk-icon="icon: settings"></span> <?php echo Text::_('JGLOBAL_FIELDS'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body uk-padding-small">
                                <?php foreach ($customTabs as $group => $fieldset) : ?>
                                    <fieldset class="uk-fieldset">
                                        <?php $fields = $this->form->getFieldset($group); ?>
                                        <?php if (isset($fieldset->label)) : ?>
                                            <legend class="uk-legend"><?php echo Text::_($fieldset->label); ?></legend>
                                        <?php endif; ?>
                                        <?php foreach ($fields as $field) : ?>
                                            <?php echo str_replace(['control-group', 'control-label', 'controls'], ['uk-margin-small', 'uk-form-label', 'uk-form-controls'], $field->renderField()); ?>
                                        <?php endforeach; ?>
                                    </fieldset>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Parameters Card -->
                <?php if (!empty($paramTabs)) : ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header uk-background-muted uk-padding-small">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">
                                            <span uk-icon="icon: cog"></span> <?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body uk-padding-small">
                                <?php foreach ($paramTabs as $group => $fieldset) : ?>
                                    <fieldset class="uk-fieldset">
                                        <?php $fields = $this->form->getFieldset($group); ?>
                                        <?php foreach ($fields as $field) : ?>
                                            <?php echo str_replace(['control-group', 'control-label', 'controls'], ['uk-margin-small', 'uk-form-label', 'uk-form-controls'], $field->renderField()); ?>
                                        <?php endforeach; ?>
                                    </fieldset>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- MFA Card -->
                <?php if ($this->mfaConfigurationUI) : ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header uk-background-muted uk-padding-small">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">
                                            <span uk-icon="icon: lock"></span> <?php echo Text::_('COM_USERS_PROFILE_MULTIFACTOR_AUTH'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body uk-padding-small">
                                <?php echo $this->mfaConfigurationUI ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="uk-margin-large-top uk-text-center">
                <div class="uk-grid-small uk-flex-middle uk-flex-center" uk-grid>
                    <div>
                        <button type="submit" class="uk-button uk-button-primary" name="task" value="profile.save">
                            <span uk-icon="icon: check"></span> <?php echo Text::_('JSAVE'); ?>
                        </button>
                    </div>
                    <div>
                        <button type="submit" class="uk-button uk-button-danger" name="task" value="profile.cancel" formnovalidate>
                            <span uk-icon="icon: close"></span> <?php echo Text::_('JCANCEL'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="option" value="com_users">
            <?php echo HTMLHelper::_('form.token'); ?>
        </form>
    </div>
</div>
