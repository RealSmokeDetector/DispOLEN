const addButton = document.getElementById("add_button");
const reservationPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("close_popup");
const dispo = document.getElementById("disponibility");
const studentReservation = document.getElementById("student_reservation_time");
const add = document.getElementById("add_reservation");
const startTimePopUp = document.getElementById("selected_start_time");
const endTimePopUp = document.getElementById("selected_end_time");
const slotPopUp = document.getElementById("reservations");
const uidTeacher = document.getElementById("uid_teacher");

if (isElementExist(studentReservation)) {
	studentReservation.style.display = "flex";
}

function getSelectedDate() {
	return slotPopUp.dataset.day;
}

function getFormattedDateTime(date, time) {
	return `${date} ${time}:00`;
}

addButton.addEventListener("click", () => {
	reservationPopup.style.display = "flex";
});

document.addEventListener("keydown", (event) => {
	if (event.key === "Escape") {
		reservationPopup.style.display = "none";
	}
});

closePopup.addEventListener("click", () => {
	reservationPopup.style.display = "none";
});

document.addEventListener("click", (event) => {
	if ((reservationPopup.style.display === "flex" && !reservationPopup.contains(event.target) && event.target !== addButton) || event.target.className === "blur") {
		reservationPopup.style.display = "none";
	}
});

if (dispo) {
	dispo.addEventListener("click", () => {
		studentReservation.style.display = "flex";
	});
}

if (isElementExist(add) && !isElementExist(document.getElementById("reservation_time"))) {
add.addEventListener("click", () => {
	
	let selectedDate = getSelectedDate();
	let selectedStartHour = startTimePopUp.value;
	let selectedEndHour = endTimePopUp.value;

	if (!selectedDate || !selectedStartHour || !selectedEndHour) {
		console.error("Erreur : Données manquantes avant l'envoi !");
		alert("Erreur : Date ou heure non sélectionnée !");
		return;
	}

	let startDate = getFormattedDateTime(selectedDate, selectedStartHour);
	let endDate = getFormattedDateTime(selectedDate, selectedEndHour);

	callApi("/api/reservation", "post", {
		"uid_student": uidUser.value,
		"date_start": startDate,
		"date_end": endDate,
		"uid_teacher": uidTeacher.value
	});
});
}
