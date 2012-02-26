<?php
if (!defined('APPLICATION'))
    exit();
// Load the TinyMCE GZip compressor class
require_once(PATH_APPLICATIONS . DS . "fancypages/js/tiny_mce/tiny_mce_gzip.php");
TinyMCE_Compressor::renderTag(array(
    "url" => "/applications/fancypages/js/tiny_mce/tiny_mce_gzip.php",
    "plugins" => "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
    "themes" => "advanced",
    "languages" => "en"
));
// Initialize TinyMCE WYSIWYG Editor, if it is to be used.
// JQuery version to initialize, GZip version for (faster) execution.
if ($this->UseEditor) {
    ?><!-- Load TinyMCE -->
    <script type="text/javascript" src="/applications/fancypages/js/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript">
    	 
        $().ready(function() {
    	$('textarea#Form_HTML').tinymce({
    	    // Location of TinyMCE script
    	    script_url : '/applications/fancypages/js/tiny_mce/tiny_mce_gzip.js',

    	    // General options
    	    theme : "advanced",
    	    plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

    	    // Theme options
    	    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    	    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    	    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    	    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
    	    theme_advanced_toolbar_location : "top",
    	    theme_advanced_toolbar_align : "left",
    	    theme_advanced_statusbar_location : "bottom",
    	    theme_advanced_resizing : true,
    	    theme_advanced_resize_horizontal : false,
    	    theme_advanced_resizing_max_width: $('#FancyPage').css('max-width'),
    	    theme_advanced_resizing_min_width: $('#FancyPage').css('min-width'),

    	    // Example content CSS (should be your site CSS)
    	    content_css : "/applications/fancypages/design/editor.css,/themes/TinsDirect/design/style.css,/themes/TinsDirect/design/custom.css",

    	    // Drop lists for link/image/media/template dialogs
    	    template_external_list_url : "lists/template_list.js",
    	    external_link_list_url : "lists/link_list.js",
    	    external_image_list_url : "lists/image_list.js",
    	    media_external_list_url : "lists/media_list.js",

    	    // Replace values for the template plugin
    	    template_replace_values : {
    		username : "Some User",
    		staffid : "991234"
    	    }
    	});
        });
    </script><?
} // end if editor enabled
?><div class="Help Aside">
    <h2><? echo T('Some Current Rules') . ":" ?></h2>
    <ul>
	<li>Each uri must be unique</li>
    </ul>
</div>
<h1 class="AddPage">Add a Page to Your Web Site
    <a href="/fancypages/settings/managepages/" class="Manage Button">Manage Pages</a><?
if ($this->Action == 'edit') {
    ?><a href="/fancypages/settings/managepages/" class="Manage Button">New Page</a><?
}
?></h1>
<div class="Info">You can create a custom page on your Vanilla / Garden web site below.</div>
<div class="Info">The Full Title will also be the title of the page / window. The Short Title will be how the page is identified in menus.</div>


<div class="Help Aside">
    <h2>More Info</h2>
    <ul>
	<li>You can customize the styles available in the editor below in fancypages/design/editor.css</li>
	<li>You can hide the editor to reveal and edit the html tags</li>
	<li>If enabled, the editor must not be hidden when saving the form</li>
	<li></li>
	<li></li>
    </ul>
</div>
<h1>Edit the page details:</h1>	
<div class="Form"><?
echo $this->Form->Open();
echo $this->Form->Errors();
?><table id="NewPage">
	<tr>
	    <th><? echo $this->Form->Label('Title (Viewed Title)', 'Title'); ?></th>
	</tr>
	<tr>
	    <td><? echo $this->Form->TextBox('Title'); ?></td>
	</tr>
	<tr>
	    <th><? echo $this->Form->Label('Short Title (Menus)', 'ShortTitle'); ?></th>
	</tr>
	<tr>
	    <td><? echo $this->Form->TextBox('ShortTitle'); ?></td>
	</tr>
	<tr>
	    <th><? echo $this->Form->Label('URI', 'Slug'); ?></th>
	</tr>
	<tr>
	    <td class="uri"><?
echo $this->Form->Label('http://.../info/');
echo $this->Form->TextBox('Slug');
?></td>
	</tr>
	<tr>
	    <th><? echo $this->Form->Label('Description', 'Description'); ?></th>
	</tr>
	<tr>
	    <td><? echo $this->Form->TextBox('Description'); ?></td>
	</tr>
	<tr>
	    <td><? echo $this->Form->CheckBox('Visible', 'Make this page/ category public?', array('value' => 1)); ?></td>
	</tr>
    </table><?
/* -------------------------------- HTML Editor ------------------------------- */
?><div class="HTMLBox">
	<div class="Heading">
	    <h1>HTML Editor</h1>
	    <a href="javascript:;" onclick="$('#Form_HTML').tinymce().show();$('div.ButtonWrapper').show();return false;" class="Button">Show Editor</a>
	    <a href="javascript:;" onclick="$('#Form_HTML').tinymce().hide();$('div.ButtonWrapper').hide();return false;" class="Button">Hide Editor</a>
	    <h1>Widgets (Coming Soon)</h1></div>
	<div class="WidgetBox">
	    <ul class="Widgets"><?
// Start widget loop
foreach ($this->Widgets as $Widget) {
    ?><li class="WidgetChoice">
    		    <span>First</span>
    		    <div class="WidgetInfo">
    			First Widget
    		    </div>
    		</li><?
}
?></ul>
	</div><?
echo $this->Form->TextBox('HTML', array('Multiline' => TRUE));
?></div><?
    echo "<div class='ButtonWrapper'>";
    echo $this->Form->Button('Reset', array('type' => 'reset'));
    echo "<div class='CancelSpacer'>";
    echo $this->Form->Close('Save');
    $CancelText = T('Back to Discussions');
    $CancelClass = 'Back';
    $CancelText = T('Cancel');
    $CancelClass = 'Cancel Button';

    echo Anchor($CancelText, '/fancypages/settings/managepages', $CancelClass);
    echo "</div></div>";

    /* Some example integration calls for TinyMCE, useful for reference
      <a href="javascript:;" onclick="$('#Form_HTML').tinymce().show();return false;">[Show]</a>
      <a href="javascript:;" onclick="$('#Form_HTML').tinymce().hide();return false;">[Hide]</a>
      <a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('Bold');return false;">[Bold]</a>
      <a href="javascript:;" onclick="alert($('#Form_HTML').html());return false;">[Get contents]</a>
      <a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getContent());return false;">[Get selected HTML]</a>
      <a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getContent({format : 'text'}));return false;">[Get selected text]</a>
      <a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getNode().nodeName);return false;">[Get selected element]</a>
      <a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">[Insert HTML]</a>
      <a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">[Replace selection]</a>
     */
?></div>
<br />
<script type="text/javascript">
    if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
    }
</script>
</div>
<div id="FancyPage"></div><?