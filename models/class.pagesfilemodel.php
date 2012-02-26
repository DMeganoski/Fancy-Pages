<?php if (!defined('APPLICATION'))
	exit();
/**
 * Unstable, unused class.
 * An attempt to utilize the garden core functionality instead of re-writing it,
 * probably much worse.
 * TODO Clean this crap up
 * 
 */
Class PagesFileModel extends Gdn_FileSystem {

	public function GeneratePage($HTML, $PageSlug) {

		$FilePath = PATH_UPLOADS.DS."html/generated/".$PageSlug.".php";

		try {
			$this->SaveFile($FilePath, "<? if (!defined('APPLICATION')) exit(); ?> ".$HTML);
			$Return = "Success";
		} catch(Exception $ex) {
			$Return = $ex;
		}
		/* ---- My Custom Version, keep in case of export from vanilla
		// create new file
		$temp = fopen(PATH_UPLOADS.DS."html/generated/".$PageSlug.".php","wb");
		// write contents
		fwrite($temp,"<? if (!defined('APPLICATION')) exit(); ?> ".$HTML);
		// close file
		fclose($temp);
		 *
		 */

   }

	private function _ReadPage($PageID) {

		if (Gdn::Session()->IsValid()) {
			$Page = $this->InfoPagesModel->GetSingle($PageID);
			$FilePath = PATH_UPLOADS.DS."html/generated/".$Page->Slug.'.php';

			if (file_exists($FilePath)) {
			   $Contents = file_get_contents($FilePath);
			}
			// remove if (!defined... from string
			$Return = substr($Contents, 43);
			return $Return;
		}
   }

}

