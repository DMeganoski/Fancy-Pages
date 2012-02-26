<?php if (!defined('APPLICATION'))
	exit();

Class WidgetController extends Gdn_Controller {


	 public $Uses = array('Form', 'InfoPagesModel', 'WidgetModel');

	 public function __construct() {
		parent::__construct();
	}

	public function Initialize() {
		parent::Initialize();

		// There are 4 delivery types used by Render().
		// DELIVERY_TYPE_ALL is the default and indicates an entire page view.
		 if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
         $this->Head = new HeadModule($this);
         $this->Head-> AddTag('meta', array(
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
		}

	}

	public function getWidgets() {

		$Request = Gdn::Request();



		$this->Widgets = $this->WidgetModel->Get();



	}

	// function for parsing xml data and configuring the widget.
	public function parseWidget($widgetName) {

		$Output = "";

		// Parse xml data

		// Get config values from data

		// Include widget template file
		include('');

		// insert data into widget



	}

	public function loadWidgets() {

		$Path = PATH_ROOT.'/widgets/';

		$Files = scandir($Path);

		return json_encode($Files);



	}
}