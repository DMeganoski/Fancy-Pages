<?php if (!defined('APPLICATION'))
	exit();

?><div class="Tabs">
	<ul><?
	if (is_object($this->Categories)) {
		foreach ($this->Categories as $Item) {
			$Slug = $Item->Slug;
			$ShortTitle = $Item->ShortTitle;
			echo '<li class="'.$CSS.'" ><a href ="/info/'.$Slug.'" class="TabLink">'.$ShortTitle.'</a></li>';
			}
		} else {
				echo '<li><a href="" class="TabLink">Default</a></li>';
		}
	?></ul>
	</div>