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

?>
<div class="uk-card uk-card-primary uk-card-hover uk-light">
    <div class="uk-card-body">
        <div class="uk-grid-medium uk-flex-middle uk-text-center uk-text-left@s" uk-grid>
            <div class="uk-width-1-1 uk-width-auto@s">
                <div class="uk-border-circle uk-background-muted uk-flex uk-flex-center uk-flex-middle uk-margin-auto" style="width: 150px; height: 150px;">
                    <span uk-icon="icon: user; ratio: 4"></span>
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-expand@s">
                <h2 class="uk-card-title uk-margin-remove-bottom"><?php echo $this->escape($this->data->name); ?></h2>
                <p class="uk-text-meta uk-margin-remove-top">@<?php echo $this->escape($this->data->username); ?></p>
                
                <div class="uk-margin-medium-top">
                    <dl class="uk-description-list">
                        <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-grid-small" uk-grid>
                            <div>
                                <dt><span uk-icon="icon: calendar"></span> <?php echo Text::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></dt>
                                <dd><?php echo HTMLHelper::_('date', $this->data->registerDate, Text::_('DATE_FORMAT_LC1')); ?></dd>
                            </div>
                            <div>
                                <dt><span uk-icon="icon: history"></span> <?php echo Text::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></dt>
                                <dd>
                                    <?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>
                                        <?php echo HTMLHelper::_('date', $this->data->lastvisitDate, Text::_('DATE_FORMAT_LC1')); ?>
                                    <?php else : ?>
                                        <?php echo Text::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>
                                    <?php endif; ?>
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <?php if ($this->getCurrentUser()->id == $this->data->id) : ?>
            <div class="uk-margin-medium-top uk-text-center">
                <a class="uk-button uk-button-secondary" href="<?php echo Route::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
                    <span uk-icon="icon: file-edit"></span>
                    <?php echo Text::_('COM_USERS_EDIT_PROFILE'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
