<?php

if (!defined('APPLICATION'))
    exit();  // Make sure this file can't get accessed directly
/**
 * Model pertaining to Table:
 * Gdn_InfoPages
 * @property Columns:
 * Title, varchar 50, not null, the title of the category or page
 * Slug, varchar 50, not null, the uri of the page
 * Descripton, varchar 100, null, the meta description of the page
 * Visisble, tinyint 1, 1, whether the page is publicly visible or not
 * Category, tinyint 2, 2, if a category, show its own page or not.
 * ParentID,
 * HTML
 *
 * @author Darryl Meganoski
 * @todo change delete to use ID instead of slug
 */

Class InfoPagesModel extends Gdn_Model {

    public function __construct() {
	parent::__construct('InfoPages');
    }

    public function CategoryQuery() {

	$this->SQL
		->Select('ip.*')
		->From('InfoPages ip');
    }

    public function GetCatCount() {
	return $this->SQL
			->Select('ip.PageID', 'count', 'CountItems')
			->From('InfoPages ip')
			->WhereIn('Type', array(1, 2))
			->Get()->FirstRow()->CountItems;
    }

    public function GetAll() {

	$this->CategoryQuery();
	$Results = $this->SQL->Get();
	return $Results;
    }

    public function GetSingle($ID) {

	$this->CategoryQuery();
	$this->SQL->Where(array('PageID' => $ID));

	$Results = $this->SQL->Get()->FirstRow();

	return $Results;
    }

    public function GetBySlug($Slug) {

	$this->CategoryQuery();
	$this->SQL->Where(array('Slug' => $Slug));

	$Results = $this->SQL->Get()->FirstRow();

	return $Results;
    }

    public function GetCategories() {
	$this->CategoryQuery();
	$this->SQL->WhereIn('Type', array(1, 2));
	$Results = $this->SQL->Get();
	return $Results;
    }

    public function GetSubPages($CategoryID) {
	$this->CategoryQuery();
	$this->SQL->Where('RelatedID', $CategoryID);

	$Results = $this->SQL->Get();
	return $Results;
    }

    public function addNew($Title, $Description) {

	$this->SQL->Insert('InfoPages', array(
	    'Title' => $Title,
	    'Description' => $Description
	));
    }

    public function RemovePage($PageID) {

	$this->SQL->Delete("InfoPages", array('PageID' => $PageID));
    }

    public function SetLayout($ChildID, $ParentID = -1) {

	if ($ParentID > -1) {

	    $this->SQL->Update('InfoPages', array(
		'RelatedID' => $ParentID,
		'Type' => 3
		    ), array('PageID' => $ChildID));

	    $this->SQL - Update('InfoPages', array(
			'Type' => 2
			    ), array('PageID' => $ParentID));
	} else {
	    $this->SQL->Update('InfoPages', array(
		'RelatedID' => $ChildID,
		'Type' => 1
		    ), array('PageID' => $ChildID));
	}
    }

    public function Update($Set, $Where = FALSE) {
	if (!is_array($Set))
	    return NULL;
	$this->DefineSchema();

	$this->SQL->Update('InfoPages')
		->Set($Set);

	if ($Where != FALSE)
	    $this->SQL->Where($Where);

	$this->SQL->Put();
    }

    public function LinkPages($ChildID, $ParentID) {

	$this->Update(array(
	    'RelatedID' => $ParentID,
	    'Type' => 3
		), array('PageID' => $ChildID));

	$this->Update(array(
	    'Type' => 2
		), array('PageID' => $ParentID));
    }

    public function RemoveLink($ChildID, $ParentID) {
	
    }

}
