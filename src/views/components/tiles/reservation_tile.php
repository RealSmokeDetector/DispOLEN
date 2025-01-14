<?php
	use App\Utils\Lang;
	use App\Configs\Role;
	use App\Models\Entities\User;
	use App\Models\Repositories\UserRepository;
	use App\Models\Entities\Reservation;
	use App\Models\Repositories\ReservationRepository;

	$userConnect = UserRepository::getInformations(uid: $_SESSION["user"]["uid"]);
	$user = new User(uid: $userConnect["uid"]);
	$reservation = new Reservation();
 	$reservation->user = $user;
	$reservationRepo = new ReservationRepository(reservation: $reservation);
?>

<div class="tile reservation_container">
	<h1><?= (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::STUDENT])))? Lang::translate(key: "INDEX_RESERVATION_TITLE_STUDENT"): Lang::translate(key: "INDEX_RESERVATION_TITLE_TEACHER") ?></h1>
	<p><?= Lang::translate(key: "INDEX_RESERVATION_CONTENT") ?></p>

	<div>
		<?php foreach ($reservationRepo->getAllDates(limit: 3) as $element) { ?>
			<div class="row_reservation">
				<p><?= $element["date"] ?></p>
				<a class="link" href="/reservation/details?reservation=<?= $element["uid"] ?>"><?= Lang::translate(key: "MAIN_DETAIL") ?></a>
			</div>
		<?php } ?>

		<a class="link" href="/reservations"><?= Lang::translate(key: "MAIN_SHOW_MORE") ?></a>
	</div>
</div>
