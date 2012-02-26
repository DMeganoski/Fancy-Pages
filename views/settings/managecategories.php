<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();
?>
<div class="Help Aside">
   <?php
   echo '<h2>', T('Need More Help?'), '</h2>';
   echo '<ul>';
   echo '<li>Online Documentation Coming Soon.</li>';
   echo '<li>In the meantime, refer to the included README</li>';
   echo '</ul>';
   ?>
</div>
<h1><?php echo T('Manage Pages'); ?></h1>
<div class="Info">
   <?php echo T('This is where you manage your fancy pages.', 'This is where you manage your fancy pages. Existing pages are listed below.'); ?>
</div>
<div class="FilterMenu"><?php
	  echo Anchor(T('Create New Page'), 'fancypages/settings/add/page', 'SmallButton');
	  echo Anchor(T('Upload HTML File'), 'fancypages/settings/uploadpage', 'SmallButton');
?></div>
<?php
   ?>
   <div class="Help Aside">
      <?php
      echo '<h2>', T('Did You Know?'), '</h2>';
      echo '<ul>';
      echo '<li>', sprintf(T('You can make your default Fancy Page your homepage.', 'You can make your default Fancy Page your homepage <a href="%s">here</a>.'), Url('/dashboard/settings/homepage')), '</li>';
      echo '<li>', T('Drag and drop the categories below to nest them (sorting to be added).'), '</li>';
      echo '</ul>';
      ?>
   </div>
   <h1 class="ClearRight"><?php
      echo T('Existing Categories and Pages');
   ?></h1>
   <?php
   //echo $this->Form->Open();
   //echo $this->Form->Errors();
   echo "<form method='post' action='/fancypages/settings/managepages'>";
   echo '<ol class="Pages">';
   echo '</ol>';
   echo "</form>";
