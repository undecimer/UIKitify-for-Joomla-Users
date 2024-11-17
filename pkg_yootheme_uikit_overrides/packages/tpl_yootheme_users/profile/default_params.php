<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\Users\Site\View\Profile\HtmlView $this */

$fields = $this->form->getFieldset('params');
?>
<?php if (!empty($fields)) : ?>
    <div class="uk-panel">
        <h3 class="uk-heading-divider"><?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></h3>
        <dl class="uk-description-list uk-description-list-divider">
            <?php foreach ($fields as $field) : ?>
                <?php if (!$field->hidden) : ?>
                    <dt><?php echo $field->title; ?></dt>
                    <dd>
                        <?php if (is_array($field->value)) : ?>
                            <?php echo implode(', ', array_filter($field->value)); ?>
                        <?php else : ?>
                            <?php echo $field->value ?: Text::_('COM_USERS_PROFILE_VALUE_NOT_FOUND'); ?>
                        <?php endif; ?>
                    </dd>
                <?php endif; ?>
            <?php endforeach; ?>
        </dl>
    </div>
<?php endif; ?>
