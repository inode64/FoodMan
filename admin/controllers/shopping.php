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

/**
 * Shopping controller class.
 *
 * @since  1.6
 */
class FoodManControllerShopping extends FoodManControllerForm
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @throws Exception
	 * @since   3.9.0
	 */
	public function __construct(array $config = array())
	{
		parent::__construct($config);

		$this->registerTask(TASK_SHOPPING_CREATE, 'add');
		$this->registerTask(TASK_SHOPPING_BUY, 'edit');
		$this->registerTask(TASK_SHOPPING_STORE, 'edit');
		$this->registerTask(TASK_SHOPPING_FINISH, 'edit');
	}

	private function SetTask(): void
	{
		$app  = JFactory::getApplication();
		$task = $this->getTask();

		$context = 'com_foodman.edit.shopping.task';
		$app->setUserState($context, $task);

		$listid  = JFactory::getApplication()->input->get('id', '', 'int');
		$context = 'com_foodman.edit.shopping.listid';

		$app->setUserState($context, $listid);
		$layout = $app->input->get('layout', TASK_SHOPPING_EDIT, 'string');

		if (FoodManHelper::DefaultTask($task))
		{
			$layout = 'edit';
		}
		$context = 'com_foodman.edit.shopping.layout';
		$app->setUserState($context, $layout);
		$app->input->set('layout', $layout);
	}

	/**
	 * Method to add a new menu item.
	 *
	 * @return  mixed  True if the record can be added, a JError object if not.
	 *
	 * @since   1.6
	 */
	public function add()
	{
		$this->SetTask();

		return parent::add();
	}

	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key
	 *                           (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   1.6
	 */
	public function edit($key = null, $urlVar = null)
	{
		$this->SetTask();

		return parent::edit();
	}

	/**
	 * Overrides parent save method to check the submitted passwords match.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @throws Exception
	 * @since   3.2
	 */
	public function save($key = null, $urlVar = null)
	{
		$task     = $this->getTask();
		$taskList = JFactory::getApplication()->getUserState('com_foodman.edit.shopping.task');

		$return = parent::save();

		if ($task !== 'apply')
		{
			if (!FoodManHelper::DefaultTask($taskList))
			{
				$this->setRedirect(JRoute::_('index.php?option=com_foodman&view=lists', false));
			}
		}
		if ($task === 'apply' && $taskList === TASK_SHOPPING_FINISH)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_foodman&view=lists', false));
		}

		return $return;
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	public function cancel($key = null)
	{
		$return = parent::cancel($key);

		$task = JFactory::getApplication()->getUserState('com_foodman.edit.shopping.task');
		if (!FoodManHelper::DefaultTask($task))
		{
			$this->setRedirect(JRoute::_('index.php?option=com_foodman&view=lists', false));
		}

		return $return;
	}
}
