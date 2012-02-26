<?php if (!defined('APPLICATION'))
	exit();

Class InfoPanelModule extends Gdn_Module {

	public function __construct(&$Sender = '') {
      parent::__construct($Sender);
   }


   public function AssetTarget() {
      return 'Panel';
   }

   public function ToString() {
      $String = '';
      $Session = Gdn::Session();
	  $permissions = $Session->User->Permissions;
	  $this->admin = preg_match('/Garden.Settings.Manage/',$permissions);
	  $InfoPagesModel = new InfoPagesModel();
	  $ParentID = InfoController::$CategoryID;
	  $this->Pages = $InfoPagesModel->GetWhere(array('Type' => '3', 'RelatedID' => $ParentID));
	  $this->Parent = $InfoPagesModel->GetSingle($ParentID);

      ob_start();

      include_once(PATH_APPLICATIONS.DS.'fancypages/views/modules/panelmodule.php');

      $String = ob_get_contents();
      @ob_end_clean();
      return $String;
   }

}