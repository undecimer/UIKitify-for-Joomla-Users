<?php

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');

?>

<?php if ($type == 'logout') : ?>
<div class="mod-login">
    <?php if ($module->showtitle) : ?>
        <h3 class="uk-h4 uk-margin-small"><?php echo $module->title; ?></h3>
    <?php endif; ?>

    <form action="<?= Route::_('index.php', true, $params->get('usesecure')) ?>" method="post">
        <?php if ($params->get('greeting')) : ?>
            <div class="uk-text-small uk-margin-small">
                <?php if ($params->get('name') == 0) :
                    echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
                else :
                    echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
                endif ?>
            </div>
        <?php endif ?>

        <?php if ($params->get('profilelink', 0)) : ?>
            <div class="uk-margin-small">
                <a class="uk-button uk-button-default uk-button-small uk-width-1-1" href="<?= Route::_('index.php?option=com_users&view=profile') ?>">
                    <span uk-icon="icon: user"></span>
                    <?= Text::_('MOD_LOGIN_PROFILE') ?>
                </a>
            </div>
        <?php endif ?>

        <div class="uk-margin-small">
            <button class="uk-button uk-button-primary uk-button-small uk-width-1-1" type="submit" name="Submit">
                <span uk-icon="icon: sign-out"></span>
                <?= Text::_('JLOGOUT') ?>
            </button>
        </div>

        <input type="hidden" name="option" value="com_users">
        <input type="hidden" name="task" value="user.logout">
        <input type="hidden" name="return" value="<?= $return ?>">
        <?= HTMLHelper::_('form.token') ?>
    </form>
</div>
<?php endif ?>
