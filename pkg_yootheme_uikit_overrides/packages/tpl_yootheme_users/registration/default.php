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

/** @var \Joomla\Component\Users\Site\View\Registration\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

// Add style to hide the meter
$wa->addInlineStyle('
    meter[data-password-strength] {
        display: none !important;
    }
');

// Get Joomla's password rules
$params = Joomla\CMS\Component\ComponentHelper::getParams('com_users');
$minimumLength = $params->get('minimum_length', 12);
$minimumIntegers = $params->get('minimum_integers', 0);
$minimumSymbols = $params->get('minimum_symbols', 0);
$minimumUppercase = $params->get('minimum_uppercase', 0);
$minimumLowercase = $params->get('minimum_lowercase', 0);

// Pass the rules to JavaScript
$wa->addInlineScript('
    var passwordRules = {
        minimumLength: ' . $minimumLength . ',
        minimumIntegers: ' . $minimumIntegers . ',
        minimumSymbols: ' . $minimumSymbols . ',
        minimumUppercase: ' . $minimumUppercase . ',
        minimumLowercase: ' . $minimumLowercase . '
    };
');

// Update the JavaScript to handle both elements
$wa->addInlineScript('
    document.addEventListener("DOMContentLoaded", function() {
        var passwordInput = document.querySelector("#jform_password1");
        var strengthMeter = document.querySelector("meter[data-password-strength]");
        var progressBar = document.querySelector("#password-strength");
        
        if (!passwordInput || !strengthMeter || !progressBar) return;

        function countCharacters(str, pattern) {
            var matches = str.match(pattern);
            return matches ? matches.length : 0;
        }

        function updateStrength(password) {
            if (!password) {
                strengthMeter.value = 0;
                progressBar.value = 0;
                progressBar.className = "uk-progress uk-progress-danger";
                return;
            }

            var score = 0;
            var requirements = 0;
            
            if (passwordRules.minimumLength > 0) requirements++;
            if (passwordRules.minimumIntegers > 0) requirements++;
            if (passwordRules.minimumSymbols > 0) requirements++;
            if (passwordRules.minimumUppercase > 0) requirements++;
            if (passwordRules.minimumLowercase > 0) requirements++;
            
            if (requirements === 0) {
                requirements = 1;
                if (password.length > 0) score++;
            } else {
                if (passwordRules.minimumLength > 0 && password.length >= passwordRules.minimumLength) score++;
                if (passwordRules.minimumIntegers > 0 && countCharacters(password, /[0-9]/g) >= passwordRules.minimumIntegers) score++;
                if (passwordRules.minimumSymbols > 0 && countCharacters(password, /[^A-Za-z0-9]/g) >= passwordRules.minimumSymbols) score++;
                if (passwordRules.minimumUppercase > 0 && countCharacters(password, /[A-Z]/g) >= passwordRules.minimumUppercase) score++;
                if (passwordRules.minimumLowercase > 0 && countCharacters(password, /[a-z]/g) >= passwordRules.minimumLowercase) score++;
            }
            
            var percent = Math.floor((score / requirements) * 100);
            strengthMeter.value = percent;
            progressBar.value = percent;

            // Reset classes and add new ones
            progressBar.className = "uk-progress";
            if (percent > 80) {
                progressBar.classList.add("uk-progress-success");
            } else if (percent > 40) {
                progressBar.classList.add("uk-progress-warning");
            } else {
                progressBar.classList.add("uk-progress-danger");
            }
        }

        passwordInput.addEventListener("input", function() {
            updateStrength(this.value);
        });

        // Initial update
        updateStrength(passwordInput.value);
    });
');
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
                    <span uk-icon="icon: user"></span> <?php echo Text::_('COM_USERS_REGISTRATION_TITLE') ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-alert uk-alert-primary">
                    <?php echo Text::_('COM_USERS_REGISTRATION_DESC') ?>
                </div>

                <form id="member-registration" 
                      action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" 
                      method="post" 
                      class="uk-form-stacked" 
                      enctype="multipart/form-data">

                    <?php // Iterate through the form fieldsets and display each one. ?>
                    <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                        <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                        <?php if (count($fields)) : ?>
                            <fieldset class="uk-fieldset uk-margin-medium">
                                <?php if (isset($fieldset->label)) : ?>
                                    <legend class="uk-legend uk-text-emphasis"><?php echo Text::_($fieldset->label); ?></legend>
                                <?php endif; ?>
                                <?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
                                    <p class="uk-text-meta"><?php echo $this->escape(Text::_($fieldset->description)); ?></p>
                                <?php endif; ?>
                                <?php foreach ($fields as $field) : ?>
                                    <?php if (!$field->hidden) : ?>
                                        <div class="uk-margin">
                                            <?php echo $field->renderField(['class' => 'uk-margin']); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </fieldset>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($this->form->getField('password1')) : ?>
                        <div class="uk-margin">
                            <label class="uk-form-label"><?php echo Text::_('COM_USERS_REGISTRATION_PASSWORD_STRENGTH'); ?></label>
                            <progress id="password-strength" class="uk-progress" value="0" max="100"></progress>
                        </div>
                    <?php endif; ?>

                    <div class="uk-margin-medium-top">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                            <span uk-icon="icon: user"></span> <?php echo Text::_('JREGISTER'); ?>
                        </button>
                    </div>

                    <div class="uk-margin uk-text-center">
                        <a class="uk-button uk-button-link" href="<?php echo Route::_('index.php?option=com_users&view=login'); ?>">
                            <span uk-icon="icon: arrow-left"></span> <?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
                        </a>
                    </div>

                    <input type="hidden" name="option" value="com_users">
                    <input type="hidden" name="task" value="registration.register">
                    <?php echo HTMLHelper::_('form.token'); ?>
                </form>
            </div>
        </div>
    </div>
</div>
