<?php
/**
 * @package PrSafetyBase WEB
 *
 * APPLICATION-WIDE CONFIGURATION SETTINGS
 *
 * This file contains application-wide configuration settings.  The settings
 * here will be the same regardless of the machine on which the app is running.
 *
 * This configuration should be added to version control.
 *
 * No settings should be added to this file that would need to be changed
 * on a per-machine basic (ie local, staging or production).  Any
 * machine-specific settings should be added to _machine_config.php
 */

/**
 * APPLICATION ROOT DIRECTORY
 * If the application doesn't detect this correctly then it can be set explicitly
 */
if (!GlobalConfig::$APP_ROOT) GlobalConfig::$APP_ROOT = realpath("./");

/**
 * check is needed to ensure asp_tags is not enabled
 */
if (ini_get('asp_tags')) 
	die('<h3>Server Configuration Problem: asp_tags is enabled, but is not compatible with Savant.</h3>'
	. '<p>You can disable asp_tags in .htaccess, php.ini or generate your app with another template engine such as Smarty.</p>');

/**
 * INCLUDE PATH
 * Adjust the include path as necessary so PHP can locate required libraries
 */
set_include_path(
		GlobalConfig::$APP_ROOT . '/libs/' . PATH_SEPARATOR .
		'phar://' . GlobalConfig::$APP_ROOT . '/libs/phreeze-3.3.8.phar' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/libs/phreeze/' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/vendor/phreeze/phreeze/libs/' . PATH_SEPARATOR .
		get_include_path()
);

/**
 * COMPOSER AUTOLOADER
 * Uncomment if Composer is being used to manage dependencies
 */
// $loader = require 'vendor/autoload.php';
// $loader->setUseIncludePath(true);

/**
 * SESSION CLASSES
 * Any classes that will be stored in the session can be added here
 * and will be pre-loaded on every page
 */
require_once "App/User.php";

/**
 * RENDER ENGINE
 * You can use any template system that implements
 * IRenderEngine for the view layer.  Phreeze provides pre-built
 * implementations for Smarty, Savant and plain PHP.
 */
require_once 'verysimple/Phreeze/SavantRenderEngine.php';
GlobalConfig::$TEMPLATE_ENGINE = 'SavantRenderEngine';
GlobalConfig::$TEMPLATE_PATH = GlobalConfig::$APP_ROOT . '/templates/';

/**
 * ROUTE MAP
 * The route map connects URLs to Controller+Method and additionally maps the
 * wildcards to a named parameter so that they are accessible inside the
 * Controller without having to parse the URL for parameters such as IDs
 */
GlobalConfig::$ROUTE_MAP = array(

	// default controller when no route specified
	'GET:' => array('route' => 'Default.Home'),
		
	// example authentication routes
	'GET:loginform' => array('route' => 'Login.LoginForm'),
	'POST:login' => array('route' => 'Login.Login'),
	'GET:logout' => array('route' => 'Login.Logout'),
		
	// SafDepartment
	'GET:safdepartments' => array('route' => 'SafDepartment.ListView'),
	'GET:safdepartment/(:num)' => array('route' => 'SafDepartment.SingleView', 'params' => array('id' => 1)),
	'GET:api/safdepartments' => array('route' => 'SafDepartment.Query'),
	'POST:api/safdepartment' => array('route' => 'SafDepartment.Create'),
	'GET:api/safdepartment/(:num)' => array('route' => 'SafDepartment.Read', 'params' => array('id' => 2)),
	'PUT:api/safdepartment/(:num)' => array('route' => 'SafDepartment.Update', 'params' => array('id' => 2)),
	'DELETE:api/safdepartment/(:num)' => array('route' => 'SafDepartment.Delete', 'params' => array('id' => 2)),
		
	// SafDepartmentDetail
	'GET:safdepartmentdetails' => array('route' => 'SafDepartmentDetail.ListView'),
	'GET:safdepartmentdetail/(:num)' => array('route' => 'SafDepartmentDetail.SingleView', 'params' => array('id' => 1)),
	'GET:api/safdepartmentdetails' => array('route' => 'SafDepartmentDetail.Query'),
	'POST:api/safdepartmentdetail' => array('route' => 'SafDepartmentDetail.Create'),
	'GET:api/safdepartmentdetail/(:num)' => array('route' => 'SafDepartmentDetail.Read', 'params' => array('id' => 2)),
	'PUT:api/safdepartmentdetail/(:num)' => array('route' => 'SafDepartmentDetail.Update', 'params' => array('id' => 2)),
	'DELETE:api/safdepartmentdetail/(:num)' => array('route' => 'SafDepartmentDetail.Delete', 'params' => array('id' => 2)),
		
	// SafHuman
	'GET:safhumans' => array('route' => 'SafHuman.ListView'),
	'GET:safhuman/(:num)' => array('route' => 'SafHuman.SingleView', 'params' => array('id' => 1)),
	'GET:api/safhumans' => array('route' => 'SafHuman.Query'),
	'POST:api/safhuman' => array('route' => 'SafHuman.Create'),
	'GET:api/safhuman/(:num)' => array('route' => 'SafHuman.Read', 'params' => array('id' => 2)),
	'PUT:api/safhuman/(:num)' => array('route' => 'SafHuman.Update', 'params' => array('id' => 2)),
	'DELETE:api/safhuman/(:num)' => array('route' => 'SafHuman.Delete', 'params' => array('id' => 2)),
		
	// SafMultimedia
	'GET:safmultimedias' => array('route' => 'SafMultimedia.ListView'),
	'GET:safmultimedia/(:num)' => array('route' => 'SafMultimedia.SingleView', 'params' => array('id' => 1)),
	'GET:api/safmultimedias' => array('route' => 'SafMultimedia.Query'),
	'POST:api/safmultimedia' => array('route' => 'SafMultimedia.Create'),
	'GET:api/safmultimedia/(:num)' => array('route' => 'SafMultimedia.Read', 'params' => array('id' => 2)),
	'PUT:api/safmultimedia/(:num)' => array('route' => 'SafMultimedia.Update', 'params' => array('id' => 2)),
	'DELETE:api/safmultimedia/(:num)' => array('route' => 'SafMultimedia.Delete', 'params' => array('id' => 2)),
		
	// SafReport
	'GET:report' => array('route' => 'SafReport.Index'),
	'GET:report/(:num)' => array('route' => 'SafReport.SingleView', 'params' => array('id' => 1)),
	'GET:api/safreports' => array('route' => 'SafReport.Query'),
    'GET:gg' => array('route' => 'SafReport.ListReports'),
	'POST:api/safreport' => array('route' => 'SafReport.Create'),
	'GET:api/report/(:num)' => array('route' => 'SafReport.Read', 'params' => array('id' => 2)),
	'PUT:api/safreport/(:num)' => array('route' => 'SafReport.Update', 'params' => array('id' => 2)),
	'DELETE:api/safreport/(:num)' => array('route' => 'SafReport.Delete', 'params' => array('id' => 2)),
		
	// SafRole
	'GET:safroles' => array('route' => 'SafRole.ListView'),
	'GET:safrole/(:num)' => array('route' => 'SafRole.SingleView', 'params' => array('id' => 1)),
	'GET:api/safroles' => array('route' => 'SafRole.Query'),
	'POST:api/safrole' => array('route' => 'SafRole.Create'),
	'GET:api/safrole/(:num)' => array('route' => 'SafRole.Read', 'params' => array('id' => 2)),
	'PUT:api/safrole/(:num)' => array('route' => 'SafRole.Update', 'params' => array('id' => 2)),
	'DELETE:api/safrole/(:num)' => array('route' => 'SafRole.Delete', 'params' => array('id' => 2)),
		
	// SafWorker
	'GET:safworkers' => array('route' => 'SafWorker.ListView'),
	'GET:safworker/(:num)' => array('route' => 'SafWorker.SingleView', 'params' => array('id' => 1)),
	'GET:api/safworkers' => array('route' => 'SafWorker.Query'),
	'POST:api/safworker' => array('route' => 'SafWorker.Create'),
	'POST:api/registerWorker' => array('route' => 'SafWorker.RegisterWorker'),
	'GET:api/safworker/(:num)' => array('route' => 'SafWorker.Read', 'params' => array('id' => 2)),
	'PUT:api/safworker/(:num)' => array('route' => 'SafWorker.Update', 'params' => array('id' => 2)),
	'DELETE:api/safworker/(:num)' => array('route' => 'SafWorker.Delete', 'params' => array('id' => 2)),

	// catch any broken API urls
	'GET:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'PUT:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'POST:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'DELETE:api/(:any)' => array('route' => 'Default.ErrorApi404')
);

/**
 * FETCHING STRATEGY
 * You may uncomment any of the lines below to specify always eager fetching.
 * Alternatively, you can copy/paste to a specific page for one-time eager fetching
 * If you paste into a controller method, replace $G_PHREEZER with $this->Phreezer
 */
?>