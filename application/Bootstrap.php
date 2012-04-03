<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewHelpers()
	{
		$oView = new Zend_View();
		$oView->addHelperPath( APPLICATION_PATH . "/views/helpers", "Application_View_Helper" );		

		$oViewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$oViewRenderer->setView($oView);
		Zend_Controller_Action_HelperBroker::addHelper($oViewRenderer);

		return $oView;
	}

	/** Execute _initDoctrine function to initialize Doctrine.
	 *
	 */
	protected function _initDoctrine()
	{
		$this->getApplication()->getAutoloader()
						->pushAutoloader(array('Doctrine', 'autoload'));
    			spl_autoload_register(array('Doctrine', 'modelsAutoload'));

		// Get all doctrine options from application.ini
		$asDoctrineConfig = $this->getOption('doctrine');

		date_default_timezone_set("Asia/Kolkata");
		
		// Create instance of  Doctrine_Manager
		$oManager = Doctrine_Manager::getInstance();
		$oManager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
		$oManager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true); //Auto load model table classes.
		$oManager->setAttribute(Doctrine::ATTR_MODEL_LOADING, $asDoctrineConfig['model_autoloading']);

		// Load models 
        	Doctrine_Core::loadModels($asDoctrineConfig['models_path']);

		// Connection with database
        	$oConn = Doctrine_Manager::connection($asDoctrineConfig['dsn'],'doctrine');
		$oConn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
		
		return $oConn;
	}
	
	/*
	 * For get request of front controller
	 */
	protected function _initRequest()
	{
		$this->bootstrap('frontController');
		$front = $this->getResource('frontController');
		$request = $front->getRequest();
	    	if (null === $front->getRequest()) {
		    $request = new Zend_Controller_Request_Http();
		    $front->setRequest($request);
		}
	    	return $request;
	}	
	
	/*
	 * For Autoload Modules 
	 */
	protected function _initAutoload()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('PluginEx_');
		$autoloader->suppressNotFoundWarnings(true);

		$this->_front = $this->getResource('FrontController');
		$oRouter = $this->_front->getRouter();

		// Assigning request object
		$oRequest = new Zend_Controller_Request_Http();
		$oRouter->route($oRequest);

		// Get Modulename
		$ssModuleName = $oRequest->getModuleName();

		$loader = new Zend_Loader_Autoloader_Resource(array(
		    'basePath'  => APPLICATION_PATH . '/modules/' . $ssModuleName,
		    'namespace' => ucfirst($ssModuleName),
		));

		$loader->addResourceType('form', 'forms', 'Form')
		    ->addResourceType('model', 'models', 'Model');
		return $loader;

	}
	
	/**
	* Execute _initConstants.
	*/
	protected function _initConstants()
	{
		$registry = Zend_Registry::getInstance();
		$registry->constants = new Zend_Config( $this->getApplication()->getOption('constants') );
	}
	
	protected function _initLocale()  
	{
		// Assigning request object
		$oRequest = new Zend_Controller_Request_Http();
		
		//Creating Language Namespace
	    $session = new Zend_Session_Namespace('language');
	    
	    //Fetch Default Language From Database Table
	    $amLangDefault = Doctrine::getTable('Model_Language')->getDefaultLanguage();
	    
	    //Set Default Language in Local Variable 
	    $ssLan = $amLangDefault['lang'];
	   	
	   	//Check if Session Variable Not Created then Create
		if(!isset($session->ssSesLan))
		{
			$session->__set('ssSesLan',$ssLan);
			$ssLan = $session->__get('ssSesLan');
		} 
		else{
			//get session variable to pass in Local
			$ssLan = $session->__get('ssSesLan');
		}
		$oLocale = new Zend_Locale($ssLan);
		
		// register it so that it can be used all over the website
		Zend_Registry::set('Zend_Locale', $oLocale);
		
	}
	
	/*
	 Execute _initTranslate
	* Set Translation on Locale (Language ie. en-fr)
	* 
	*/
	protected function _initTranslate()
	{
		// Get Locale
		$ssLocale = Zend_Registry::get('Zend_Locale');

		// Set up and load the translations (there are my custom translations for my app)
		$oTranslate = new Zend_Translate(
		                array(
		                    'adapter' => 'array',
		                    'content' => APPLICATION_PATH . '/languages/' . $ssLocale . '.php',
		                    'locale' => $ssLocale)
		);
			
		// Set Default Translator in form
     	Zend_Form::setDefaultTranslator($oTranslate);

		// Save it for later
		Zend_Registry::set('Zend_Translate', $oTranslate);
	}
	
	protected function _initNavigation()
	{
	    $this->bootstrap('layout');
	    $layout = $this->getResource('layout');
	    $view = $layout->getView();
	    $config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml');
	 
	    $navigation = new Zend_Navigation($config);
	    $view->navigation($navigation);
	}
}