<?php if (!defined('APPLICATION')) exit(); // Make sure this file can't get accessed directly
/**
 * The hooks file for the Fancy Pages application
 */
class FancyPagesHooks implements Gdn_IPlugin {

	/**
	 * Adds an option to set the homepage to the Fancy Pages applicaiton.
	 * Since it uses a fire event that doesn't exist yet, we'll leave it disabled.
	 * @param type $Sender
	 *
	public function SettingsController_AfterDashboardHomeOptions_Handler(&$Sender) {

		echo "<a href='/info' class='info'>Fancy Pages Home</a>";

   }
	*/

	/**
	 * Adds the js and css files to the entire dashboard (for the menu image)
	 * @param type $Sender
	 */
	public function SettingsController_Render_Before(&$Sender) {
		$Sender->AddJsFile('/applications/fancypages/js/dashboard.js');
		$Sender->AddCssFile('/applications/fancypages/design/settings.css');

	}

	/**
	 * Add the dashboard menu options
	 * @param type $Sender
	 */
	public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
      $Menu = &$Sender->EventArguments['SideMenu'];
	  $Menu->AddItem('Info', T('Fancy Pages'));
      $Menu->AddLink('Info', T('Manage Pages'), 'fancypages/settings/managepages', 'Garden.Settings.Manage');
      $Menu->AddLink('Info', T('Add New Page'), 'fancypages/settings/add', 'Garden.Settings.Manage');
      $Menu->AddLink('Info', T('Configuration'), 'fancypages/settings/configure', 'Garden.Settings.Manage');

	  //$Sender->AddModule('PanelModule');
   }

   /**
    * Add the main menu link
    * @param type $Sender
    */
	public function Base_Render_Before($Sender) {
		if ($Sender->Menu) {
			$Sender->Menu->AddLink('Info', T('Info'),
					'/info', FALSE, array('class' => 'Information', 'Standard' => TRUE));

		}
	}

	/**
	 * Special function automatically run upon clicking 'Enable' on your application.
	 */
	public function Setup() {

		$Database = Gdn::Database();
		$Config = Gdn::Factory(Gdn::AliasConfig);
		$Drop = C('Info.Version') === FALSE ? TRUE : FALSE;
		$Explicit = TRUE;
		// You need to manually include structure.php here for it to get run at install.
		include(PATH_APPLICATIONS . DS . 'fancypages' . DS . 'settings' . DS . 'structure.php');

		// Stores a value in the config to indicate it has previously been installed.
		// You can use if(C('Skeleton.Setup', FALSE)) to test whether to repeat part of your setup.
		SaveToConfig('Info.Setup', TRUE);
	}

	/**
	 * Special function automatically run upon clicking 'Disable' on your application.
	 */
	public function OnDisable() {
      // Optional. Delete this if you don't need it.
	}

	/**
	 * Special function automatically run upon clicking 'Remove' on your application.
	 */
	public function CleanUp() {
		// Optional. Delete this if you don't need it.
	}
}