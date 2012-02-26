<?php

if (!defined('APPLICATION'))
    exit();
/**
 * Skeleton Controller for new applications.
 *
 * Repace 'Skeleton' with your app's short name wherever you see it.
 *
 * @package Skeleton
 */
define('PATH_GEN', PATH_UPLOADS . '/html/generated');

/**
 * A brief description of the controller.
 *
 * Your app will automatically be able to find any models from your app when you instantiate them.
 * You can also access the UserModel and RoleModel (in Dashboard) from anywhere in the framework.
 *
 * @since 1.0
 * @package Skeleton
 */
class InfoController extends FancyPagesController {

    /** @var array List of objects to prep. They will be available as $this->$Name. */
    public $Uses = array('Form', 'InfoPagesModel');
    public static $Category;
    public static $CategoryID = 0;
    public static $Page;
    public static $PageID;
    public $PageData;

    public function __construct() {
	parent::__construct();
    }

    public function Initialize() {
	parent::Initialize();

	// There are 4 delivery types used by Render().
	// DELIVERY_TYPE_ALL is the default and indicates an entire page view.
	if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
	    $this->Head = new HeadModule($this);
	    $this->Head->AddTag('meta', array(
		'name' => 'description',
		'content' => "X"
	    ));
	}
	if ($this->Head) {
	    $this->AddJsFile('jquery.js');
	    $this->AddJsFile('css_browser_selector.js');
	    $this->AddJsFile('jquery.livequery.js');
	    $this->AddJsFile('jquery.form.js');
	    $this->AddJsFile('jquery.popup.js');
	    $this->AddJsFile('jquery.gardenhandleajaxform.js');
	    $this->AddJsFile('global.js');
	    $this->AddCssFile('style.css');
	    $this->AddCssFile('custom.css');

	    $this->AddCssFile('info.css');
	    $this->AddJsFile('info.js');
	    $this->AddCssFile('widgetchoices.css');
	    $this->AddJsFile('widgetchoices.js');
	    $this->AddCssFile('editor.css');
	}
    }

    /**
     * Renders custom page based on requested url
     * @param type $Args the url arguments, variable not actually referenced.
     */
    public function Index($Args) {

	$CategorySlug = getValue(0, $this->RequestArgs, "default");
	$Page = getValue(1, $this->RequestArgs, "default");

	$this->AddModule('InfoHeadModule');
	$this->AddModule('InfoPanelModule');

	$this->Categories = $this->InfoPagesModel->GetAll();

	// there are three important variables to set
	// the static category and page, and the _PageData
	self::$Category = $CategorySlug;
	self::$Page = $Page;

	// Check Admin permissions. <-------------------------------------------
	$Session = Gdn::Session();
	$permissions = $Session->User->Permissions;
	$this->admin = preg_match('/Garden.Settings.Manage/', $permissions);

	/* ------- Before showing anything else, make sure data exists in the db ------ */

	if ($this->InfoPagesModel->GetCatCount() > 0) {


	    // There are pages in the db. Check if one was requested. <-------------
	    if ($CategorySlug !== "default") { // if category was requested
		if ($Page !== "default") { // if page was requested
		    // set the data
		    $PageData = $this->InfoPagesModel->GetBySlug($Page);
		    $this->PageData = $PageData;
		    // check if in the right category
		    $ParentID = $PageData->RelatedID;
		    $ParentData = $this->InfoPagesModel->GetSingle($ParentID);
		    if ($ParentData->Slug != $CategorySlug) {
			// find the parent category and redirect
			Redirect('/info/' . $Parent->Slug . DS . $CategorySlug);
		    }
		    $this->ViewPath = PATH_GEN . DS . $PageData->Slug . '.php';
		    self::$CategoryID = $ParentData->PageID;
		} else { // page was not requested, only category
		    // Set up data to verify cateogory
		    $PageData = $this->InfoPagesModel->GetBySlug($CategorySlug);
		    $this->PageData = $PageData;
		    $Type = $PageData->Type;
		    // check to see what type of page this is supposed to be
		    switch ($Type) {
			case 1: // page, no parent
			    // set view to page
			    $this->ViewPath = PATH_GEN . DS . $CategorySlug . '.php';
			    break;
			case 2: // category, has children
			    //$Default = $this->InfoPagesModel->GetWhere('');
			    // set view to page
			    $this->ViewPath = PATH_GEN . DS . $CategorySlug . '.php';
			    self::$CategoryID = $PageData->PageID;
			    break;
			case 3: // page, has parent
			    // find the parent category and redirect
			    $Parent = $this->InfoPagesModel->GetSingle($PageData->RelatedID);
			    Redirect('/info/' . $Parent->Slug . DS . $CategorySlug);
			    break;
			default:
			    // throw error
			    $this->View = 'notfound';

			    // category has no page, but a default page
			    //$Child = $this->InfoPagesModel->GetSingle($CategorySlug);
			    //$this->ViewPath = PATH_GEN.DS.$Child.'.php';
			    break;
		    }
		} // end request check <----------------------------------------
		// check if file exists <---------------------------------------
		if (file_exists($this->ViewPath)) {

		    $this->View = 'empty';
		} else { // the file does not exist <---------------------------
		    $this->View = 'notfound';
		}
	    } else { // no page requested <-------------------------------------
		// check to see if a default page has been configured, if not, default
		$DefaultPage = C('FancyPages.Default.Page', 'defaultpage');
		if ($DeafultPage != "defaultpage") {
		    $DefaultData = $this->InfoPagesModel->GetBySlug($DefaultPage);
		    $this->PageData = $DefaultData;
		    $DefaultID = $DefaultData->PageID;
		    self::$CategoryID = $DefaultID;
		    $this->ViewPath = PATH_GEN . DS . $DefaultPage . '.php';
		    if (!file_exists($this->ViewPath)) {
			$this->ViewPath = PATH_APPLICATIONS . '/fancypages/views/info/defaultpage.php';
		    } else {
			
		    }
		}

		$this->View = 'empty';
	    }
	    /* ---------------- No Categories exist in the database ----------------------- */
	} else { // No Pages in DB <--------------------------------------------
	    $DefaultPage = C('FancyPages.Default.Page', 'defaultpage');
	    if ($DeafultPage != "defaultpage") {
		$DefaultData = $this->InfoPagesModel->GetBySlug($DefaultPage);
		$this->PageData = $DefaultData;
		$DefaultID = $DefaultData->PageID;
		self::$CategoryID = $DefaultID;
	    }
	    $this->ViewPath = PATH_GEN . DS . $DefaultPage . '.php';
	    $this->View = 'empty';
	}
	$this->Title(T($this->PageData->Title));

	$this->Head->Title($this->Head->Title());

	$this->Render();
    }

}
