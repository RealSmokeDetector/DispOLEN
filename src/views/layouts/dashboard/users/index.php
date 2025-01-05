<?php
	use App\Configs\Path;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
?>

<div class="user_container">
	<?php
		foreach (ApplicationData::getUsers() as $user) {
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
