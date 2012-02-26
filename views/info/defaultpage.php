<?php if (!defined('APPLICATION'))
	exit(); ?>

<div id="DefaultPage">
	<div class="Heading"><?
	if($this->admin > 0) {
		?><h1>This is the default page for this application</h1>
		<h2>Regular members see this as an error, 'under construction' page.</h2>
		<h2>You will need to update the default page for this application in the dashboard.</h2><?
	} else {
		?><h1>Woops! Sorry. This area has not been completed</h1>
		<h2>This section is under construction, please check back soon for updates.</h2><?
	}
	?></div>
</div>