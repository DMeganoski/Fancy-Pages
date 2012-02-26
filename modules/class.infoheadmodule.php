<?php if (!defined('APPLICATION'))
	exit();

Class InfoHeadModule extends Gdn_Module {

	public function __construct(&$Sender = '') {
		parent::__construct($Sender);
	}
	public function AssetTarget() {
      return 'Content';
   }

   public function ToString() {
      $String = '';
      $Session = Gdn::Session();
	  $permissions = $Session->User->Permissions;
	  $this->admin = preg_match('/Garden.Settings.Manage/',$permissions);
	  $InfoPagesModel = new InfoPagesModel();
	  $this->Categories = $this->GetCategories();

      ob_start();

      include_once(PATH_APPLICATIONS.DS.'fancypages/views/modules/infoheadmodule.php');

      $String = ob_get_contents();
      @ob_end_clean();
      return $String;
   }

   public function GetCategories() {
	   $InfoPagesModel = new InfoPagesModel();
	   if ($InfoPagesModel->GetCatCount() > 0) {
		   $Categories = $InfoPagesModel->GetCategories();
		   return $Categories;
	   } else {
		   return false;
	   }
   }

}