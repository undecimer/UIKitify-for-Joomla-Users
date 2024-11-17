<?php

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');

// Disable extra button styling
if (isset($extraButtons)) {
    $assets = Factory::getApplication()->getDocument()->getWebAssetManager();
    if ($assets->assetExists('style', 'plg_system_webauthn.button')) {
        $assets->disableAsset('style', 'plg_system_webauthn.button');
    }
}

?>
<div class="mod-login">
    <?php if ($module->showtitle) : ?>
        <h3 class="uk-h4 uk-margin-small"><?php echo $module->title; ?></h3>
    <?php endif; ?>

    <form id="login-form-<?= $module->id; ?>" action="<?= Route::_('index.php', true, $params->get('usesecure')) ?>" method="post">
        <?php if ($params->get('pretext')) : ?>
            <div class="uk-text-meta uk-margin-small">
                <?= $params->get('pretext') ?>
            </div>
        <?php endif ?>

        <div class="uk-margin-small">
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-form-small" type="text" name="username" 
                       autocomplete="username" 
                       placeholder="<?= Text::_('MOD_LOGIN_VALUE_USERNAME') ?>" 
                       aria-label="<?= Text::_('MOD_LOGIN_VALUE_USERNAME') ?>">
            </div>
        </div>

        <div class="uk-margin-small">
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-form-small" type="password" name="password" 
                       autocomplete="current-password"
                       placeholder="<?= Text::_('JGLOBAL_PASSWORD') ?>" 
                       aria-label="<?= Text::_('JGLOBAL_PASSWORD') ?>">
            </div>
        </div>

        <?php if (isset($twofactormethods) && count($twofactormethods) > 1) : ?>
            <div class="uk-margin-small">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: key"></span>
                    <input class="uk-input uk-form-small" type="text" name="secretkey" 
                           tabindex="0"
                           placeholder="<?= Text::_('JGLOBAL_SECRETKEY') ?>" 
                           aria-label="<?= Text::_('JGLOBAL_SECRETKEY') ?>">
                </div>
            </div>
        <?php endif ?>

        <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
            <div class="uk-margin-small">
                <label class="uk-flex uk-flex-middle">
                    <input class="uk-checkbox uk-margin-small-right" type="checkbox" name="remember" value="yes" checked>
                    <small><?= Text::_('MOD_LOGIN_REMEMBER_ME') ?></small>
                </label>
            </div>
        <?php endif ?>

        <?php if (isset($extraButtons)) : ?>
            <?php foreach ($extraButtons as $button) :
                $dataAttributeKeys = array_filter(array_keys($button), fn($key) => str_starts_with($key, 'data-'));
                ?>
                <div class="uk-margin-small">
                    <button type="button" 
                            class="uk-button uk-button-secondary uk-button-small uk-width-1-1 <?= $button['class'] ?>"
                            <?php foreach ($dataAttributeKeys as $key) : ?>
                                <?= $key ?>="<?= $button[$key] ?>"
                            <?php endforeach; ?>
                            <?php if ($button['onclick']) : ?>
                                onclick="<?= $button['onclick'] ?>"
                            <?php endif; ?>
                            title="<?= Text::_($button['label']) ?>"
                            id="<?= $button['id'] ?>">
                        <?php if (!empty($button['icon'])) : ?>
                            <span class="<?= $button['icon'] ?>"></span>
                        <?php elseif (!empty($button['image'])) : ?>
                            <?= $button['image']; ?>
                        <?php elseif (!empty($button['svg'])) : ?>
                            <?= $button['svg']; ?>
                        <?php endif; ?>
                        <?= Text::_($button['label']) ?>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="uk-margin-small">
            <button class="uk-button uk-button-primary uk-button-small uk-width-1-1" type="submit" name="Submit">
                <span uk-icon="icon: sign-in"></span>
                <?= Text::_('JLOGIN') ?>
            </button>
        </div>

        <div class="uk-margin-small">
            <ul class="uk-list uk-list-collapse uk-margin-remove">
                <li>
                    <a class="uk-link-muted uk-text-small" href="<?= Route::_('index.php?option=com_users&view=reset') ?>">
                        <span uk-icon="icon: refresh; ratio: 0.8"></span>
                        <?= Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD') ?>
                    </a>
                </li>
                <li>
                    <a class="uk-link-muted uk-text-small" href="<?= Route::_('index.php?option=com_users&view=remind') ?>">
                        <span uk-icon="icon: question; ratio: 0.8"></span>
                        <?= Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME') ?>
                    </a>
                </li>
                <?php $usersConfig = ComponentHelper::getParams('com_users') ?>
                <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                    <li>
                        <a class="uk-link-muted uk-text-small" href="<?= Route::_('index.php?option=com_users&view=registration') ?>">
                            <span uk-icon="icon: plus-circle; ratio: 0.8"></span>
                            <?= Text::_('MOD_LOGIN_REGISTER') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>

        <?php if ($params->get('posttext')) : ?>
            <div class="uk-text-meta uk-text-small uk-margin-small-top">
                <?= $params->get('posttext') ?>
            </div>
        <?php endif ?>

        <input type="hidden" name="option" value="com_users">
        <input type="hidden" name="task" value="user.login">
        <input type="hidden" name="return" value="<?= $return ?>">
        <?= HTMLHelper::_('form.token') ?>
    </form>
</div>
