<?php
/**
 * @package     YOOtheme Pro UIkit Template Overrides
 * @copyright   Copyright (C) 2024 Your Name. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;

class pkg_yootheme_uikit_overridesInstallerScript extends InstallerScript
{
    /**
     * Minimum PHP version required
     *
     * @var    string
     */
    protected $minimumPhp = '7.4.0';

    /**
     * Minimum Joomla version required
     *
     * @var    string
     */
    protected $minimumJoomla = '4.0.0';

    /**
     * List of required extensions
     *
     * @var    array
     */
    protected $requirementsList = [
        'yootheme' => [
            'type' => 'template',
            'name' => 'yootheme',
            'minVersion' => '3.0.0'
        ]
    ];

    /**
     * Function called before extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    public function preflight($type, $parent)
    {
        if (!parent::preflight($type, $parent)) {
            return false;
        }

        // Check if YOOtheme Pro is installed
        if (!$this->checkRequirements()) {
            $app = Factory::getApplication();
            $app->enqueueMessage('This package requires YOOtheme Pro template to be installed.', 'error');
            return false;
        }

        return true;
    }

    /**
     * Function called after extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    public function postflight($type, $parent)
    {
        if ($type === 'install' || $type === 'update') {
            $app = Factory::getApplication();
            $app->enqueueMessage('YOOtheme Pro UIkit template overrides have been successfully installed.', 'success');
        }

        return true;
    }

    /**
     * Check if all requirements are met
     *
     * @return  boolean  True on success
     */
    private function checkRequirements()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__template_styles')
            ->where($db->quoteName('template') . ' = ' . $db->quote('yootheme'));

        $db->setQuery($query);
        $result = $db->loadObject();

        return !empty($result);
    }
}
