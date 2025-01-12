<?php
	use App\Configs\Path;
	use App\Models\Repositories\UserRepository;
	use App\Models\Entities\User;

	$userUid = $_SESSION["user"]["uid"];

	$user = new User($userUid);
	$userRepository = new UserRepository($user);
	$teacherUid = $userRepository->getTutor();
	$teacherDisponibilities = UserRepository::getTeacherDisponibilities($teacherUid);
?>

<div class="index_container">
	<?php require Path::COMPONENTS . "/tables/reservation.php"; ?>
	<?php require Path::COMPONENTS . "/tables/calendar.php"; ?>
	<?php require Path::COMPONENTS . "/tiles/teacher_disponibility_tile.php"; ?>
</div>
