<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * FoodMan list controller class.
 *
 * @since  1.6
 */
class FoodManControllerGroups extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var          string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_FOODMAN_GROUP';

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @throws Exception
	 * @see           JControllerLegacy
	 * @since         1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unfeatured', 'featured');
	}

	/**
	 * Method to toggle the featured setting of a list of groups.
	 *
	 * @return  void
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	public function featured()
	{
		// Check for request forgeries
		$this->checkToken();

		$ids    = $this->input->get('cid', array(), 'array');
		$values = array('featured' => 1, 'unfeatured' => 0);
		$task   = $this->getTask();
		$value  = ArrayHelper::getValue($values, $task, 0, 'int');

		$model   = $this->getModel();
		$message = '';

		if (empty($ids))
		{
			\Joomla\CMS\Factory::getApplication()->enqueueMessage('COM_FOODMAN_GROUP_NO_ITEM_SELECTED', 'error');
		}
		else
		{
			// Publish the items.
			if (!$model->featured($ids, $value))
			{
				\Joomla\CMS\Factory::getApplication()->enqueueMessage($model->getError(), 'warning');
			}

			if ($value == 1)
			{
				$message = JText::plural('COM_FOODMAN_GROUP_N_ITEMS_FEATURED', count($ids));
			}
			else
			{
				$message = JText::plural('COM_FOODMAN_GROUP_N_ITEMS_UNFEATURED', count($ids));
			}
		}

		$this->setRedirect('index.php?option=com_foodman&view=groups', $message);
	}


	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Group', $prefix = 'FoodManModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

}
