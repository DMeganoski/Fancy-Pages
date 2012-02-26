<?php if (!defined('APPLICATION'))
	exit();

Class WidgetModel extends Gdn_Model {

	public function __construct() {
		parent::__construct('Widget');
	}

	public function WidgetQuery() {

		$this->SQL
			->Select('w.*')
			->From('Widget w');
	}

	public function GetWidgets() {

		$this->WidgetQuery();

		$Return = $this->SQL->Get();

		return $Return;


	}

	public function GetSingle($WidgetID) {

		$this->WidgetQuery();
		$this->SQL->Where('WidgetID', $WidgetID);
		$Result = $this->SQL->Get()->FirstRow();

	}

	public function GetWhere($Wheres1, $Wheres2 = "") {

		$this->WidgetQuery();

		if(!is_array($Wheres)) {
			if ($Wheres2 != "")
				$this->Where($Wheres1,$Wheres2);
		} else {
			$this->Where($Wheres1);
		}
		$Result = $this->SQL->Get();

	}
}