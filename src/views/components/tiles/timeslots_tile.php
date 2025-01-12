<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;
?>

<div class="tile disponibility_timeslots_tile" id="disponibility_timeslots_tile" style="display: none;">
	<h1><?= Lang::translate(key: "DISPONIBILITY_TIMESLOTS_TITLE") ?></h1>
	<div id="timeslots_container">
		<?php
			if (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::STUDENT]))) {
				if (!empty($teacherDisponibilities)) {
		?>
				<ul>
					<?php foreach ($teacherDisponibilities as $disponibility) { ?>
						<li><?= htmlspecialchars(string: $disponibility["date_start"]) ?> -> <?= htmlspecialchars(string: $disponibility["date_end"]) ?></li>
					<?php } ?>
				</ul>
				<?php } else { ?>
				<p><?= Lang::translate(key: "NO_DISPONIBILITY_FOUND") ?></p>
		<?php
				}
			}
		?>
	</div>
</div>
