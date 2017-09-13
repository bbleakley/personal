<?php
/*
include('baseController.php');
$bc = new baseController();

print_r($bc->field_type('customer_list', 'name'));
die();
echo $bc->get_table($table, true);
*/

$general = "⇧⌘P, F1 Show Command Palette
⌘P Quick Open
⇧⌘N New window/instance
⌘W Close window/instance";

$basic_editing = "⌘X Cut line (empty selection)
⌘C Copy line (empty selection)
⌥↓ / ⌥↑ Move line down/up
⇧⌥↓ / ⇧⌥↑ Copy line down/up
⇧⌘K Delete line
⌘Enter / ⇧⌘Enter Insert line below/above
⇧⌘\ Jump to matching bracket
⌘] / ⌘[ Indent/outdent line
Home / End Go to beginning/end of line
⌘↑ / ⌘↓ Go to beginning/end of file
⌃PgUp Scroll line up
⌃PgDown Scroll line down
⌘PgUp /⌘PgDown Scroll page up/down
⇧⌘[ / ⇧⌘] Fold/unfold region
⌘K ⌘[ / ⌘K ⌘] Fold/unfold all subregions
⌘K ⌘0 / ⌘K ⌘J Fold/unfold all regions
⌘K ⌘C Add line comment
⌘K ⌘U Remove line comment
⌘/ Toggle line comment
⇧⌥A Toggle block comment
⌥Z Toggle word wrap";

$multi_cursor = "Alt+Click Insert cursor
⌥⌘↑ Insert cursor above
⌥⌘↓ Insert cursor below
⌘U Undo last cursor operation
⇧⌥I Insert cursor at end of each line selected
⌘I Select current line
⇧⌘L Select all occurrences of current selection
⌘F2 Select all occurrences of current word
⌃⇧⌘→ Expand selection
⌃⇧⌘← Shrink selection
Shift+Alt + drag mouse Column (box) selection
⇧⌥⌘↑ Column (box) selection up
⇧⌥⌘↓ Column (box) selection down
⇧⌥⌘← Column (box) selection left
⇧⌥⌘→ Column (box) selection right
⇧⌥⌘PgUp Column (box) selection page up
⇧⌥⌘PgDown Column (box) selection page down";

$search_replace = "⌘F Find
⌥⌘F Replace
⌘G / ⇧⌘G Find next/previous
⌥Enter Select all occurrences of Find match
⌘D Add selection to next Find match
⌘K ⌘D Move last selection to next Find match";

$rich_languages = "⌃Space Trigger suggestion
⇧⌘Space Trigger parameter hints
Tab Emmet expand abbreviation
⇧⌥F Format document
⌘K ⌘F Format selection
F12 Go to Definition
⌥F12 Peek Definition
⌘K F12 Open Definition to the side
⌘. Quick Fix
⇧F12 Show References
F2 Rename Symbol
⇧⌘. / ⇧⌘, Replace with next/previous value
⌘K ⌘X Trim trailing whitespace
⌘K M Change file language";

$navigation = "⌘T Show all Symbols
⌃G Go to Line...
⌘P Go to File...
⇧⌘O Go to Symbol...
⇧⌘M Show Problems panel
F8 / ⇧F8 Go to next/previous error or warning
⌃⇧Tab Navigate editor group history
⌃- / ⌃⇧- Go back/forward
⌃⇧M Toggle Tab moves focus";

$editor_management = "⌘W Close editor
⌘K F Close folder
⌘\ Split editor
⌘1 / ⌘2 / ⌘3 Focus into 1
st, 2nd, 3rd editor group
⌘K ⌘← / ⌘K ⌘→ Focus into previous/next editor group
⌘K ⇧⌘← / ⌘K ⇧⌘→ Move editor left/right
⌘K ← / ⌘K → Move active editor group";

$file_management = "⌘N New File
⌘O Open File...
⌘S Save
⇧⌘S Save As...
⌥⌘S Save All
⌘W Close
⌘K ⌘W Close All
⇧⌘T Reopen closed editor
⌘K Enter Keep Open
⌃Tab / ⌃⇧Tab Open next / previous
⌘K P Copy path of active file
⌘K R Reveal active file in Explorer
⌘K O Show active file in new window/instance";

$display = "⌃⌘F Toggle full screen
⌥⌘1 Toggle editor layout
⌘= / ⇧⌘- Zoom in/out
⌘B Toggle Sidebar visibility
⇧⌘E Show Explorer / Toggle focus
⇧⌘F Show Search
⌃⇧G Show Git
⇧⌘D Show Debug
⇧⌘X Show Extensions
⇧⌘H Replace in files
⇧⌘J Toggle Search details
⇧⌘C Open new command prompt/terminal
⇧⌘U Show Output panel
⇧⌘V Toggle Markdown preview
⌘K V Open Markdown preview to the side";

$debug = "F9 Toggle breakpoint
F5 Start/Continue
F11 / ⇧F11 Step into/ out
F10 Step over
⇧F5 Stop
⌘K ⌘I Show hover";

$terminal = "⌃` Show integrated terminal
⌃⇧` Create new terminal
unassigned Copy selection
unassigned Paste into active terminal
⌘↑ Scroll up
⌘↓ Scroll down
PgUp Scroll page up
PgDown Scroll page down
⌘Home Scroll to top
⌘End Scroll to bottom";

$sections = array(
	"terminal",
	"debug",
	"display",
	"file_management",
	"editor_management",
	"navigation",
	"rich_languages",
	"search_replace",
	"multi_cursor",
	"basic_editing",
	"general"	
);

$output = "";
foreach( $sections as $section ){
	$output .= "\n\n$" . $section . " = array(";
	$rows = explode("\n", $$section);
	foreach( $rows as $row ){
		$words = explode(" ",$row);
		$output .= "\n\tarray(\"" . $words[0] . "\", \"" . $row . "\"),"; 
	}
	$output .= "\n);";
}

echo $output . "\n\n";
