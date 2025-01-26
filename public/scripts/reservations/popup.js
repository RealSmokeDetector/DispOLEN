const editButton = document.getElementById("edit_button");
const reservationPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("close_popup");

editButton.addEventListener("click", () => {
	addReservation();
});

function addReservation() {
	reservationPopup.style.display = "flex";
}

document.addEventListener("keydown", function (event) {
	if (event.key === "Escape") {
		reservationPopup.style.display = "none";
	}
})

closePopup.addEventListener("click", () => {
	reservationPopup.style.display = "none";
});

document.addEventListener("click", (event) => {
	if ((reservationPopup.style.display === "flex" && !reservationPopup.contains(event.target) && event.target !== editButton) || event.target.className === "blur") {
		reservationPopup.style.display = "none";
	}
});
