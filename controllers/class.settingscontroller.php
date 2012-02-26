<?php

if (!defined('APPLICATION'))
    exit();
define('PATH_GEN', PATH_UPLOADS . '/html/generated');

class SettingsController extends Gdn_Controller {

    /**
     * Models to include.
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $Uses = array('Database', 'Form', 'InfoPagesModel');

    public function PrepareController() {
	//$this->AddCssFile('info.css');
	//$this->AddJsFile('info.js');
	$this->AddJsFile('dashboard.js');
	$this->AddJsFile('sharedfunctions.js');
    }

    /**
     * Switch MasterView to admin. Include JS, CSS used by all methods.
     *
     * Always called by dispatcher before controller's requested method.
     *
     * @since 2.0.0
     * @access public
     */
    public function Initialize() {
	// Set up head
	$this->Head = new HeadModule($this);
	$this->AddJsFile('jquery.js');
	$this->AddJsFile('jquery.livequery.js');
	$this->AddJsFile('jquery.form.js');
	$this->AddJsFile('jquery.popup.js');
	$this->AddJsFile('jquery.gardenhandleajaxform.js');
	$this->AddJsFile('global.js');
	$this->AddCssFile('settings.css');
	$this->AddCssFile('widgetchoices.css');
	$this->AddJsFile('info.js');
	$this->AddJsFile('widgetchoices.js');

	if (in_array($this->ControllerName, array('profilecontroller', 'activitycontroller'))) {
	    $this->AddCssFile('style.css');
	} else {
	    $this->AddCssFile('admin.css');
	}

	// Change master view
	$this->MasterView = 'admin';
	parent::Initialize();
    }

    /**
     * Alias for ManageCategories method.
     *
     * @since 1.0
     * @access public
     */
    public function Index() {
	$this->View = 'managecategories';
	$this->ManageCategories();
    }
    
    /**
     * View Method displaying an overview of the website content. 
     */
    public function ContentOverview() {
	
    }

    /**
     * View Method for rendering page configuration settings
     *
     * @since 1.0
     * @access public
     */
    public function ManageCategories() {
	// Check permission
	//$this->Permission('Gallery.Items.Manage');
	$this->PrepareController();
	$this->AddJsFile('jquery-ui-1.8.16.custom.min.js');
	//$this->AddJsFile('jquery.event.drag.min.js');
	$this->AddJsFile('dashboard.js');

	// Set up head
	$this->AddSideMenu('info/settings/managecategories');
	//$this->AddJsFile('categories.js');
	//$this->AddJsFile('jquery.ui.packed.js');
	//$this->AddJsFile('js/library/jquery.alphanumeric.js');
	//$this->AddJsFile('js/library/nestedSortable.1.2.1/jquery-ui-1.8.2.custom.min.js');
	//$this->AddJsFile('js/library/nestedSortable.1.2.1/jquery.ui.nestedSortable.js');
	$this->Title(T('Manage Information Pages and Categories'));

	// Get Class Data
	$Pages = $this->InfoPagesModel->GetAll();

	$this->Pages = $Pages;

	// @TODO: set the model
	$this->Form->SetModel($this->GalleriesCategoryModel);

	// If seeing the form for the first time...
	if ($this->Form->AuthenticatedPostBack() === FALSE) {
	    // Apply the config settings to the form.
	} else {
	    if ($this->Form->Save() !== FALSE)
		$this->InformMessage(T("Your settings have been saved."));
	}

	// Render default view
	$this->Render();
    }

    /**
     * Advanced page settings.
     *
     * Allows setting configuration values via form elements.
     *
     * @since 1.0
     * @access public
     */
    public function Configure() {
	// Check permission
	//$this->Permission('Gallery.Items.Manage');
	$this->PrepareController();

	// Load up config options we'll be setting
	$Validation = new Gdn_Validation();
	$ConfigurationModel = new Gdn_ConfigurationModel($Validation);
	$ConfigurationModel->SetField(array(
	    'FancyPages.Default.Page',
	    'FancyPages.TinyMCE.Disable'
	));

	// Set the model on the form.
	$this->Form->SetModel($ConfigurationModel);

	// If seeing the form for the first time...
	if ($this->Form->AuthenticatedPostBack() === FALSE) {
	    // Apply the config settings to the form.
	    $this->Form->SetData($ConfigurationModel->Data);
	} else {
	    // Define some validation rules for the fields being saved
	    $ConfigurationModel->Validation->ApplyRule('FancyPages.Default.Page', 'Required');
	    
	    // Save new settings
	    $Saved = $this->Form->Save();
	    if ($Saved) {
		$this->InformMessage(T("Your changes have been saved."));
	    }
	}

	$this->AddSideMenu('fancypages/settings/configure');
	$this->AddJsFile('settings.js');
	$this->Title(T('Configure Fancy Pages Application'));

	// Render default view (settings/configure.php)
	$this->Render();
    }

    /**
     * Configures navigation sidebar in Dashboard.
     *
     * @since 1.0
     * @access public
     *
     * @param $CurrentUrl Path to current location in dashboard.
     */
    public function AddSideMenu($CurrentUrl) {
	// Only add to the assets if this is not a view-only request
	if ($this->_DeliveryType == DELIVERY_TYPE_ALL) {
	    $SideMenu = new SideMenuModule($this);
	    $SideMenu->HtmlId = 'Info';
	    $SideMenu->HighlightRoute($CurrentUrl);
	    $SideMenu->Sort = C('Garden.DashboardMenu.Sort');
	    $this->EventArguments['SideMenu'] = &$SideMenu;
	    $this->FireEvent('GetAppSettingsMenuItems');
	    $this->AddModule($SideMenu, 'Panel');
	}
    }

    /**
     * Sorting display order of categories.
     *
     * Accessed by ajax so its default is to only output true/false.
     *
     * @since 2.0.0
     * @access public

      public function SortCategories() {
      // Check permission
      $this->Permission('Vanilla.Categories.Manage');

      // Set delivery type to true/false
      $this->_DeliveryType = DELIVERY_TYPE_BOOL;
      $TransientKey = GetIncomingValue('TransientKey');
      if (Gdn::Session()->ValidateTransientKey($TransientKey)) {
      $TreeArray = GetValue('TreeArray', $_POST);
      $this->InfoPagesModel->SaveTree($TreeArray);
      }

      // Renders true/false rather than template
      $this->Render();
      }
     *
     */

    /**
     * Method for adding new pages. 
     */
    public function Add() {
	$this->PrepareController();
	//$this->AddCssFile("/applications/fancypages/design/editor.css");

	if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
	    $this->AddSideMenu('/fancypages/settings/add');
	    $Session = Gdn::Session();
	    $permissions = $Session->User->Permissions;
	    $this->admin = preg_match('/Garden.Settings.Manage/', $permissions);

	    if ($this->admin) {
		
		//@TODO: Add option to diable tiny mce in the control panel
		if (!C('FancyPages.TinyMCE.Disable')) {
		    $this->UseEditor = TRUE;
		}

		$this->Form->SetModel($this->InfoPagesModel);

		$this->Form->AddHidden('Type', 1);
		$this->Form->AddHidden('RelatedID', -1);

		if ($this->Form->AuthenticatedPostBack() === FALSE) {
		    
		} else {
		    $FormValues = $this->Form->FormValues();
		    $this->Form->AddHidden('PageID');
		    $HTML = $FormValues['HTML'];
		    $Slug = $FormValues['Slug'];
		    $SlugChecked = strtolower(str_replace(" ", "", $Slug));
		    $this->_GeneratePage($HTML, $SlugChecked);
		    $this->Form->SetFormValue('Slug', $SlugChecked);
		    $this->Form->SetFormValue("HTML", "");
		    if ($this->Form->Save() !== FALSE) {
			$this->StatusMessage = T("Your settings have been saved.");
			Redirect('/info/' . $SlugChecked);
		    } else {
			$this->StatusMessage = T("Oops, changes not saved");
		    }
		}
		if (C('FancyPages.Default.Page') == 'defaultpage')
		    SaveToConfig('FancyPage.Default.Page', $SlugChecked);
		
		$this->Title(T('Create a New Page'));
		$this->Render();
	    }
	}
    }

    /**
     * View Method for editing previously created pages
     * Creates a form based on requested page
     * 
     * @since 1.0
     * @access public
     */
    public function EditPage() {
	// Standard preparations
	$this->PrepareController();
	//$this->AddCssFile("/applications/fancypages/design/editor.css");

	// Check permissions
	$Session = Gdn::Session();
	$permissions = $Session->User->Permissions;
	$this->admin = preg_match('/Garden.Settings.Manage/', $permissions);

	if ($this->admin) {

	    // This tells the view file that we are editing a page,
	    // not creating a new one; since the view is shared.
	    $this->Action = 'edit';

	    //@TODO: Add option to diable tiny mce in the control panel
	    if (!C('FancyPages.TinyMCE.Disable')) {
		$this->UseEditor = TRUE;
	    }

	    // Get the referenced page ID
	    $Page = GetValue(0, $this->RequestArgs, "");

	    // Get data for referenced page
	    $this->_PageData = $this->InfoPagesModel->GetBySlug($Page);
	    $PD = $this->_PageData;
	    
	    // The slug is the uri name you give the page on creation.
	    // It is also the name of the php file the html is stored in.
	    $this->ViewPath = PATH_GEN . DS . $PD->Slug . '.php';
	    $FileContents = $this->_ReadPage($PD->PageID);
	    
	    // Set form model
	    $this->Form->SetModel($this->InfoPagesModel);
	    
	    // Add the hidden fields, otherwise it will not save properly.
	    $this->Form->AddHidden('Type', $PD->Type);
	    $this->Form->AddHidden('RelatedID', $PD->RelatedID);
	    $this->Form->AddHidden('PageID', $PD->PageID);
	    
	    // Set form data
	    $this->Form->SetData($PD);
	    
	    // Inject the HTML into the form, since it is not stored in the DB
	    $this->Form->SetValue("HTML", $FileContents);

	    if ($this->Form->AuthenticatedPostBack() === FALSE) {
		
	    } else {
		// Get the form values to be checked and modified before saving
		$FormValues = $this->Form->FormValues();
		$HTML = $FormValues['HTML'];
		$Slug = $FormValues['Slug'];
		// Make sure the slug doesn't contain spaces
		$SlugChecked = strtolower(str_replace(" ", "", $Slug));
		$this->Form->SetFormValue('Slug', $SlugChecked);
		// Get the HTML from the form and generate a file
		$this->_GeneratePage($HTML, $SlugChecked);
		// Set the form value to empty, so that the data is not stored
		// in the DB
		$this->Form->SetFormValue("HTML", "");
		
		// Save the form
		if ($this->Form->Save() !== FALSE) {
		    $this->StatusMessage = T("Your settings have been saved.");
		    // Redirect to view changes
		    Redirect('/info/' . $SlugChecked);
		} else {
		    $this->StatusMessage = T("Oops, changes not saved");
		}
	    }

	    $this->View = 'add';
	    $this->AddSideMenu('/fancypages/settings/editpage');
	    $this->Title(T('Edit a Current Page'));
	    $this->Render();
	}
    }
    
    public function UploadPage() {
	$this->PrepareController();
	$this->AddSideMenu('/fancypages/settings/uploadpage');
	$this->Render();
    }

    public function DeletePage() {


	$Session = Gdn::Session();
	$permissions = $Session->User->Permissions;
	$this->admin = preg_match('/Garden.Settings.Manage/', $permissions);

	if ($this->admin) {

	    $Page = GetValue(0, $this->RequestArgs, "");

	    $PageData = $this->InfoPagesModel->GetBySlug($Page);

	    $this->InfoPagesModel->RemovePage($PageData->PageID);

	    if (C('FancyPages.Default.Page') == $Page) {
		$Save = array('FancyPages.Default.Page' => 'defaultpage');
		SaveToConfig($Save);
	    }

	    $FilePath = PATH_GEN . DS . $Page . '.php';
	    if (file_exists($FilePath)) {
		fclose($FilePath);
		chmod($FilePath, 0777);
		unlink($FilePath);
		echo "Original File Removed<br/>";
	    } else {
		echo "File already Deleted";
	    }
	}
	//Redirect('/info/');
    }

    /**
     * Method for generating a php file containing the html of the page
     * if(!defined('APPLICATION') already included in html
     * 
     * @since 1.0
     * @access private
     * @param type $HTML
     * @param type $PageSlug
     * @param type $Mode 
     */
    private function _GeneratePage($HTML, $PageSlug, $Mode = 'default') {

	switch ($Mode) {
	    case 'append':
		$temp = fopen(PATH_UPLOADS . DS . "html/generated/" . $PageSlug . ".php", "ab");
		break;
	    case 'default':
		$temp = fopen(PATH_UPLOADS . DS . "html/generated/" . $PageSlug . ".php", "wb");
		break;
	}

	fwrite($temp, "<? if (!defined('APPLICATION')) exit(); ?> " . $HTML);
	fclose($temp);
    }

    /**
     * Method for reading php files previously created through this applicaiton
     * Used for editing the html of pages
     *
     * @param type $PageID the id of the page to get contents of
     * @return type String, The html content from the page, minus the if(!defined...
     */
    private function _ReadPage($PageID) {

	if (Gdn::Session()->IsValid()) {
	    $Page = $this->InfoPagesModel->GetSingle($PageID);
	    $FilePath = PATH_GEN . DS . $Page->Slug . '.php';

	    if (file_exists($FilePath)) {
		chmod($FilePath, 0777);
		$Contents = file_get_contents($FilePath);
	    }
	    // remove if (!defined... from string
	    $Return = substr($Contents, 43);
	    chmod($FilePath, 0604);
	    return $Return;
	}
    }

    /**
     * Method for nesting pages. Called by Ajax Somewhere?
     */
    public function LinkPages() {
	$Request = Gdn::Request();
	$ParentID = $Request->Post('ParentID');
	$ChildID = $Request->Post('ChildID');
	$this->InfoPagesModel->LinkPages($ChildID, $ParentID);
	$CheckedID = $this->InfoPagesModel->GetSingle($ChildID);
	// The type will specify child, or parent
	// let's check to make sure the info was changed
	if ($CheckedID->RelatedID == $ParentID) {
	    $Return = 'true';
	} else {
	    $Return = 'false';
	}
	echo $Return;
    }

    /* --------------------- HTML Return for page layout -------------------------- */

    /**
     * Method for ajax to request currently configured layout for fancy pages
     * 
     * @since 1.0
     * @access public
     * @return HTML view of page layout
     */
    public function GetLayout() {

	// tricky way to include js file, since this is being called by ajax
	echo "<script type ='text/javascript'>";
	//include(PATH_APPLICATIONS.DS.'/fancypages/js/sharedfunctions.js');
	include(PATH_APPLICATIONS . DS . '/fancypages/js/managepages.js');
	echo "</script>";

	// Get Pages Data
	$Pages = $this->InfoPagesModel->GetAll();
	$this->Pages = $Pages;
	$Pages = $this->Pages;
	foreach ($Pages as $Page) {
	    $Type = $Page->Type;
	    $Slug = $Page->Slug;
	    if ($Type < 3) {
		$Title = $Page->Title;

		if ($Page->Visible == '0') {
		    $CSS = 'Secret';
		} else {
		    $CSS = 'Visible';
		}
		echo '<li class="Page Draggable" pageid="' . $Page->PageID . '">';
		echo '<h2><a href="/info/' . $Slug . '">' . $Title . ' (' . T($Slug) . ')</a></h2>';
		echo Anchor(T('Edit Page'), 'fancypages/settings/editpage/' . $Slug, 'SmallButton');
		echo Anchor(T('Delete Page'), 'fancypages/settings/deletepage/' . $Slug, 'SmallButton');
		echo '<blockquote>' . $Page->Description . '</blockquote></li>';
		if ($Type > 1) {
		    $SubPages = $this->InfoPagesModel->GetSubPages($Page->PageID);
		    echo '<li class="SubPageList"><ol class="SubPages">';
		    foreach ($SubPages as $SubPage) {
			$SubTitle = $SubPage->Title;
			$SubSlug = $SubPage->Slug;
			echo '<li class="SubPage Draggable" pageid="' . $SubPage->PageID . '">';
			echo '<h2><a href="/info/' . $Slug . DS . $SubSlug . '">' . $SubTitle . ' (' . T($SubSlug) . ')</a></h2>';
			echo Anchor(T('Edit Page'), 'fancypages/settings/editpage/' . $SubSlug, 'SmallButton');
			echo Anchor(T('Delete Page'), 'fancypages/settings/deletepage/' . $SubSlug, 'SmallButton');
			echo '<blockquote>' . $SubPage->Description . '</blockquote>';
		    }
		    echo '</ol></li>';
		}

		echo '</li>';
	    }
	}
    }

}