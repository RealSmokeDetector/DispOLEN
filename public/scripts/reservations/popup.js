const editButton = document.getElementById("idButton");
const reservationPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("closePopup");

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

// Close the popup by clicking outside it
document.addEventListener("click", (event) => {
	if (reservationPopup.style.display === "flex" && !reservationPopup.contains(event.target) && event.target !== editButton) {
		reservationPopup.style.display = "none";
	}
});
