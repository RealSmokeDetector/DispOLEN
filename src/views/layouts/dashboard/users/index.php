<?php
	use App\Configs\Path;
	use App\Models\Entities\User;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<h1 class="user_title"><i class="ri-group-line"></i> <?= Lang::translate(key: "DASHBOARD_USERS_TITLE") ?></h1>

<button class="button" id="add_button">+</button>

<div class="user_container">
	<?php
		foreach (ApplicationData::getUsers() as $user) {
			$userE = new User(uid: $user["uid"]);
			$userRepo = new UserRepository(user: $userE);

			$userGroup = UserRepository::getGroup(uid: $user["uid"]);
			$roles = UserRepository::getRoles(uid: $user["uid"]);

			$rolesName = [];
			foreach ($roles as $role) {
				array_push($rolesName, ApplicationData::roleFormat(id: $role));
			}

			include Path::COMPONENTS . "/tiles/user_tile.php";
		}
	?>
</div>
