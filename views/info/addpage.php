<?php if (!defined('APPLICATION'))
	exit(); ?>
<!-- Load TinyMCE -->
<script type="text/javascript" src="/applications/fancypages/views/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea#Form_HTML').tinymce({
			// Location of TinyMCE script
			script_url : '/applications/fancypages/views/jscripts/tiny_mce/tiny_mce.js',

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

			// Example content CSS (should be your site CSS)
			content_css : "/applications/fancypages/design/editor.css",

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
</script>
<div id="AddPage">
	<div class="Heading">
		<h1 class="AddPage">Add a new Category and page.</h1>
		<h2>
			You can create a custom page on your Vanilla / Garden web site below.
		</h2>
		<h2>
			The Title will also be the title of the page. (Search Keywords should be kept in Mind.)
		</h2>
		<h1>Some current rules to keep in mind:</h1>
		<ul class="Rules">
			<li class="Rules">You cannot have a page with the same uri as a category, and vice versa.</li>
			<li class="Rules"></li>
			<li class="Rules"></li>
			<li class="Rules"></li>
			<li class="Rules"></li>
			<li class="Rules"></li>
		</ul>
	</div>
	<div class="Form"><?
			echo $this->Form->Open();
			echo $this->Form->Errors();
			?><table id="NewPage">
				<tr>
					<th><? echo $this->Form->Label('Title (Viewed Title)', 'Title'); ?>
					This will be used for the menus, and page title. Search keywords should be kept in mind.</th>
				</tr>
				<tr>
					<td><? echo $this->Form->TextBox('Title'); ?></td>
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
					<td><? echo $this->Form->CheckBox('Visible', 'Make Public?'); ?></td>
				</tr>
				<tr>
					<td><? echo $this->Form->CheckBox('Category', 'New Category?'); ?></td>
				</tr>
				<tr>
					<td><? echo $this->Form->CheckBox('HasPage', 'If Cateogy, Has its own Page?'); ?></td>
				</tr>
			</table><?
/*-------------------------------- HTML Editor -------------------------------*/
			?><div class="HTMLBox">
				<div class="Heading"><h1><a href="javascript:;" onclick="$('#Form_HTML').tinymce().show();return false;" class="Button">Show Editor</a>
				<a href="javascript:;" onclick="$('#Form_HTML').tinymce().hide();return false;" class="Button">Hide Editor</a>
				HTML Editor</h1></div><?
				echo $this->Form->Label('HTML', 'HTML');
				?><br/><br/><?
				echo $this->Form->Label('Widgets', 'Widgets');
				?><div class="WidgetBox">
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
			?></div>
			<input type="reset" name="reset" value="Reset" class="Button"/><?
			echo $this->Form->Close('Save');

	?></div>





	<form method="post" action="http://tinymce.moxiecode.com/dump.php?example=true">

		<!-- Some integration calls -->
		<a href="javascript:;" onclick="$('#Form_HTML').tinymce().show();return false;">[Show]</a>
		<a href="javascript:;" onclick="$('#Form_HTML').tinymce().hide();return false;">[Hide]</a>
		<a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('Bold');return false;">[Bold]</a>
		<a href="javascript:;" onclick="alert($('#Form_HTML').html());return false;">[Get contents]</a>
		<a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getContent());return false;">[Get selected HTML]</a>
		<a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getContent({format : 'text'}));return false;">[Get selected text]</a>
		<a href="javascript:;" onclick="alert($('#Form_HTML').tinymce().selection.getNode().nodeName);return false;">[Get selected element]</a>
		<a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">[Insert HTML]</a>
		<a href="javascript:;" onclick="$('#Form_HTML').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">[Replace selection]</a>

		<br />

</form>
<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>
</div>