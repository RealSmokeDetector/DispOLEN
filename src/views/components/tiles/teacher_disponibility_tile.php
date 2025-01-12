<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div class="tile teacher_disponibility_tile" id="teacher_disponibility_tile">
	<h2><?= Lang::translate(key: "TEACHER_DISPONIBILITY_TITLE")?></h2>
	<div id="teacher-disponibility-container">
	<?php if (!empty($teacherDisponibilities)) { ?>
			<ul>
				<?php foreach ($teacherDisponibilities as $disponibility) { ?>
					<li><?= htmlspecialchars($disponibility["date_start"]) ?>-><?= htmlspecialchars($disponibility["date_end"]) ?></li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			<p><?= Lang::translate(key: "NO_DISPONIBILITY_FOUND") ?></p>
		<?php } ?>
	</div>
</div>

