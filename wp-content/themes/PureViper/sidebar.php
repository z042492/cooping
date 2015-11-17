<?php

if (is_page()) {
	echo "<ul id=\"pagemenu\">";
	pure_pagemenu();
	echo "</ul>";
}
else {
	echo "<div id=\"nostick\">";

	if (is_dynamic_sidebar()) {
		dynamic_sidebar("侧边栏[不固定部分]");
	}

	echo "</div><div id=\"stick\">";

	if (is_dynamic_sidebar()) {
		dynamic_sidebar("侧边栏[固定部分]");
	}

	echo "</div>";
}

?>
