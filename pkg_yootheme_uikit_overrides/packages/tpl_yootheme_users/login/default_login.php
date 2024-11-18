<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

$usersConfig = ComponentHelper::getParams('com_users');

?>
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xsmall">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h1 class="uk-heading-medium uk-text-center">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        <?php endif; ?>

        <?php if (($this->params->get('logindescription_show') == 1 && trim($this->params->get('login_description', ''))) || $this->params->get('login_image') != '') : ?>
            <div class="uk-margin-medium-bottom">
                <?php if ($this->params->get('logindescription_show') == 1) : ?>
                    <div class="uk-text-center uk-margin"><?php echo $this->params->get('login_description'); ?></div>
                <?php endif; ?>

                <?php if ($this->params->get('login_image') != '') : ?>
                    <?php echo HTMLHelper::_('image', $this->params->get('login_image'), empty($this->params->get('login_image_alt')) && empty($this->params->get('login_image_alt_empty')) ? false : $this->params->get('login_image_alt'), ['class' => 'uk-width-medium uk-align-center']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-background-muted">
                <h3 class="uk-card-title uk-margin-remove">
                    <span uk-icon="icon: sign-in"></span> <?php echo Text::_('JLOGIN') ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <form action="<?php echo Route::_('index.php?option=com_users&task=user.login', true, $usersConfig->get('usesecure', 0)); ?>" 
                      method="post" 
                      class="uk-form-stacked" 
                      id="com-users-login__form">

                    <fieldset class="uk-fieldset">
                        <?php echo $this->form->renderFieldset('credentials', ['class' => 'uk-margin']); ?>

                        <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
                            <div class="uk-margin">
                                <label class="uk-form-label">
                                    <input class="uk-checkbox" id="remember" type="checkbox" name="remember" value="yes">
                                    <span class="uk-text-small uk-margin-small-left"><?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?></span>
                                </label>
                            </div>
                        <?php endif; ?>

                        <div class="uk-margin-medium-top">
                            <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                                <span uk-icon="icon: sign-in"></span> <?php echo Text::_('JLOGIN'); ?>
                            </button>
                        </div>

                        <?php foreach ($this->extraButtons as $button) :
                            $dataAttributeKeys = array_filter(array_keys($button), function ($key) {
                                return substr($key, 0, 5) == 'data-';
                            });
                        ?>
                            <div class="uk-margin">
                                <button type="button"
                                        class="uk-button uk-button-secondary uk-width-1-1 <?php echo $button['class'] ?? '' ?>"
                                        <?php foreach ($dataAttributeKeys as $key) : ?>
                                            <?php echo $key ?>="<?php echo $button[$key] ?>"
                                        <?php endforeach; ?>
                                        <?php if ($button['onclick']) : ?>
                                        onclick="<?php echo $button['onclick'] ?>"
                                        <?php endif; ?>
                                        title="<?php echo Text::_($button['label']) ?>"
                                        id="<?php echo $button['id'] ?>"
                                >
                                    <?php if (!empty($button['icon'])) : ?>
                                        <span class="<?php echo $button['icon'] ?>"></span>
                                    <?php elseif (!empty($button['image'])) : ?>
                                        <?php echo HTMLHelper::_('image', $button['image'], Text::_($button['tooltip'])); ?>
                                    <?php endif; ?>
                                    <?php echo Text::_($button['label']) ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
                        <input type="hidden" name="return" value="<?php echo base64_encode($return); ?>">
                        <?php echo HTMLHelper::_('form.token'); ?>
                    </fieldset>
                </form>
            </div>

            <div class="uk-card-footer uk-background-muted uk-text-center">
                <div class="uk-child-width-auto uk-grid-small uk-flex-center" uk-grid>
                    <div>
                        <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>" class="uk-button uk-button-link">
                            <span uk-icon="icon: unlock"></span> <?php echo Text::_('COM_USERS_LOGIN_RESET'); ?>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>" class="uk-button uk-button-link">
                            <span uk-icon="icon: question"></span> <?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?>
                        </a>
                    </div>
                    <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                        <div>
                            <a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>" class="uk-button uk-button-link">
                                <span uk-icon="icon: user"></span> <?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
