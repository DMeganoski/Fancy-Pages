<?php if (!defined('APPLICATION')) exit(); // Make sure this file can't get accessed directly
// Use this file to do any database changes for your application.

if (!isset($Drop))
   $Drop = FALSE; // Safe default - Set to TRUE to drop the table if it already exists.

if (!isset($Explicit))
   $Explicit = FALSE; // Safe default - Set to TRUE to remove all other columns from table.

$Database = Gdn::Database();
$SQL = $Database->SQL(); // To run queries.
$Construct = $Database->Structure(); // To modify and add database tables.
$Validation = new Gdn_Validation(); // To validate permissions (if necessary).

$Construct->Table('InfoPages')
	->PrimaryKey('PageID')
	->Column('ShortTitle', 'varchar(20)')
	->Column('Title', 'varchar(50)')
	->Column('Slug', 'varchar(50)')
	->Column('Description', 'varchar(100)', TRUE)
	->Column('Visible', 'tinyint(1)', 1)
	// switch type, what do we do with you?
	->Column('Type', 'int(3)', 1)
	->Column('RelatedID', 'int', -1)
	->Column('HTML', 'text', TRUE)
	->Set($Explicit, $Drop); // If you omit $Explicit and $Drop they default to false.

$Construct->Table('Widget')
	->PrimaryKey('WidgetID')
	->Column('Title', 'varchar(50)')
	->Column('Description', 'varchar(100)', TRUE)
	->Column('HasConfigFile', 'tinyint(1)', 0)
	->Column('Config', 'text', TRUE)
	->Set($Explicit, $Drop);



