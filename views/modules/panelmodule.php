<?php if (!defined('APPLICATION'))
	exit();
if ($this->admin) {
		?><a href ="/fancypages/settings/add" Class ="BigButton">New Page</a>
		<a href ="/fancypages/settings/managecategories" Class ="BigButton">Manage Pages</a><?
	}
?><div class="Box">
	<h4><? echo T('Pages') ?></h4>
	<ul class="PanelInfo PanelAboutCategories"><?
	foreach($this->Pages as $Category) {
		$Slug = $Category->Slug;
		$ShortTitle = $Category->ShortTitle;
		if($Slug == InfoController::$Category) {
			$CSS = "Active";
		} else {
			$CSS = "Depth";
		}
		?><li class="<? echo $CSS ?>">
			<a href="/info/<? echo $this->Parent->Slug."/".$Slug; ?>"><? echo $ShortTitle ?></a><?
		?></li><?
	}
?></ul></div>