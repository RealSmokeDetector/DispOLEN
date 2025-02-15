const addButton = document.getElementById("add_button");
const reservationPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("close_popup");
const dispo = document.getElementById("disponibility");
const studentReservation = document.getElementById("student_reservation_time");
const validate = document.getElementById("add_availability");

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

console.log(dispo);

if (isElementExist(dispo)){

	dispo.addEventListener("click", () => {
		studentReservation.style.display = "flex";
	});

}
validate.addEventListener("click", () => {
	callApi("/api/reservation", "put", {
		"uid_user": uidUser.value,
		"date_start": startDate,
		"date_end": endDate
	});
});

