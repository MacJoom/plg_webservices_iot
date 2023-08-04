<?php
/**
 * Web Services - Picowapi
 *
 * @package    Picowapi
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       Martin KOPP "MacJoom"
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\ApiRouter;
use Joomla\Router\Route;

/**
 * Web Services adapter for com_picowapis.
 *
 * @since  4.0.0
 */
class PlgWebservicesPicowapi extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Registers com_picowapis's API's routes in the application
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function onBeforeApiRoute(&$router)
	{
		$router->createCRUDRoutes(
			'v1/picowapis/picowapis',
			'picowapis',
			['component' => 'com_picowapis']
		);

		$router->createCRUDRoutes(
			'v1/picowapis/categories',
			'categories',
			['component' => 'com_categories', 'extension' => 'com_picowapis']
		);

		$this->createFieldsRoutes($router);

		$this->createContentHistoryRoutes($router);
	}

	/**
	 * Create fields routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createFieldsRoutes(&$router)
	{
		$router->createCRUDRoutes(
			'v1/fields/picowapis/picowapis',
			'fields',
			['component' => 'com_fields', 'context' => 'com_picowapis.picowapis']
		);

		$router->createCRUDRoutes(
			'v1/fields/picowapis/categories',
			'fields',
			['component' => 'com_fields', 'context' => 'com_picowapis.categories']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/picowapis/picowapis',
			'groups',
			['component' => 'com_fields', 'context' => 'com_picowapis.picowapis']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/picowapis/categories',
			'groups',
			['component' => 'com_fields', 'context' => 'com_picowapis.categories']
		);
	}

	/**
	 * Create contenthistory routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createContentHistoryRoutes(&$router)
	{
		$defaults    = [
			'component'  => 'com_contenthistory',
			'type_alias' => 'com_picowapis.picowapi',
			'type_id'    => 1,
		];
		$getDefaults = array_merge(['public' => false], $defaults);

		$routes = [
			new Route(['GET'], 'v1/picowapis/picowapis/:id/contenthistory', 'history.displayList', ['id' => '(\d+)'], $getDefaults),
			new Route(['PATCH'], 'v1/picowapis/picowapis/:id/contenthistory/keep', 'history.keep', ['id' => '(\d+)'], $defaults),
			new Route(['DELETE'], 'v1/picowapis/picowapis/:id/contenthistory', 'history.delete', ['id' => '(\d+)'], $defaults),
		];

		$router->addRoutes($routes);
	}
}
