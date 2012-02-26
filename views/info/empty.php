<?php if (!defined('APPLICATION'))
	exit();
echo '<div id="FancyPage">';
if($this->admin) {
	echo '<div class="EditButtons">
		<span class="SettingsButton">
		<ul class="SettingsButtons">
		<li>
		<a href="/fancypages/settings/editpage/'.$this->PageData->Slug.'" class="EditButton">Edit</a>
		</li>
		<li>
		<a href="/fancypages/settingsdeletepage/'.$this->PageData->Slug.'" class="DeleteButton">Delete</a>
		</li>
		</ul>
		</span>
	</div>';
}

include($this->ViewPath);
echo '</div>';