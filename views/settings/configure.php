<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>
<h1><?php echo T('Pages Configuration'); ?></h1>
<ul>
    <li><?
	echo $this->Form->Label('Default Information Page', 'FancyPages.Default.Page');
        echo $this->Form->TextBox('FancyPages.Default.Page');
    ?></li>
    <li><?
	echo $this->Form->Label('Disable the TinyMCE WYSIWYG HTML Editor?', 'FancyPages.TinyMCE.Disable');
	echo $this->Form->CheckBox('FancyPages.TinyMCE.Disable', array('value' => '1'));
    ?></li>
    <li><?
    echo $this->Form->Close('Save');
    ?></li>
</ul>
