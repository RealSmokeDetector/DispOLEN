<?php
	use App\Configs\Path;
?>

<div class="error_container">
	<h1><?= ERROR_CODE ?></h1>

	<p><?= EXCEPTION ?></p>

	<?php
		$backPath = "/";
		include Path::COMPONENTS . "/actions/back_button.php";
	?>
</div>
