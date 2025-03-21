<?php
	use App\Configs\Path;
	use App\Utils\Lang;
	use App\Utils\System;
?>

<select class="lang_selection" id="lang_selection">

<?php
	foreach (System::getFiles(path: Path::PUBLIC . "/langs") as $file) {
		$file = str_replace(search: ".json", replace: "", subject: $file);
		if ($file === USER_LANG) {
			echo "<option value=\"" . $file . "\" selected>" . Lang::nameFormat(name: $file) . "</option>";
		} else {
			echo "<option value=\"" . $file . "\">" . Lang::nameFormat(name: $file) . "</option>";
		}
	}
?>

</select>
