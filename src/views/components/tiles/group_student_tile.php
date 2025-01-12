<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;

	$group["uid"] === $selectedGroup ? $display = "flex" : $display = "none";
?>

<div class="tile student_container" id="group" data-uid="<?= $group["uid"] ?>" style="display: <?= $display ?>">
<?php
	if (count(value: $group["users"]) > 0) {
		foreach ($group["users"] as $student) {
			$user = UserRepository::getInformations(uid: $student);
			?>
		<div class="item">
			<p><?= ucfirst(string: $user["name"]) ?></p>
			<p><?= mb_strtoupper(string: $user["surname"]) ?></p>
			<?php if (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::ADMINISTRATOR]))) { ?>
				<button class="button button_secondary" id="delete_user" data-uid="<?= $student ?>" title="<?= Lang::translate(key: "GROUPS_REMOVE_STUDENT") ?>"><i class="ri-eraser-line"></i></button>
			<?php } ?>
		</div>
<?php
		}
	} else {
?>
	<p><?= Lang::translate(key: "GROUPS_NO_USERS") ?></p>
<?php } ?>
</div>
