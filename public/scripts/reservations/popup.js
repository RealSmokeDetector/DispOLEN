const addButton = document.getElementById("add_button");
const reservationPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("close_popup");
const dispo = document.getElementById("disponibility");
const studentReservation = document.getElementById("student_reservation_time");
const add = document.getElementById("add_availability");
const startTimePopUp = document.getElementById("start_time");
const endTimePopUp = document.getElementById("end_time");
const slotPopUp = document.getElementById("reservations");
const startHour = slotPopUp.dataset.hour;

	startTimePopUp.value = startHour.toString().padStart(2, '0') + ":00";
	endTimePopUp.value = (parseInt(startHour) + 1).toString().padStart(2, '0') + ":00";
	studentReservation.style.display = "flex";

			const startDate = Date.parse(`${slotPopUp.dataset.day} ${startTimePopUp.value}`) /1000 ;
			const endDate = Date.parse(`${slotPopUp.dataset.day} ${endTimePopUp.value}`) /1000 ;
			const slotsPopUp = document.querySelectorAll("#reservations");

			if (!slotsPopUp || slotsPopUp.length === 0) {
				console.warn("Aucun timeslot trouvé !");
			}

addButton.addEventListener("click", () => {
	reservationPopup.style.display = "flex";
});

document.addEventListener("keydown", (event) => {
	if (event.key === "Escape") {
		reservationPopup.style.display = "none";
	}
})

closePopup.addEventListener("click", () => {
	reservationPopup.style.display = "none";
});

document.addEventListener("click", (event) => {
	if ((reservationPopup.style.display === "flex" && !reservationPopup.contains(event.target) && event.target !== addButton) || event.target.className === "blur") {
		reservationPopup.style.display = "none";
	}
});

if (isElementExist(dispo)){

	dispo.addEventListener("click", () => {
		studentReservation.style.display = "flex";
	});

}

add.addEventListener("click", () => {
	console.log(startDate);
	console.log(endDate);
	console.log(uidUser.value);
	callApi("/api/reservation", "post", {
		"uid": uidUser.value,
		"date_start": startDate,
		"date_end": endDate
	});
});

