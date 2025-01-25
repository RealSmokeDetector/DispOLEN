const editButton = document.getElementById("edit_button");
const userPopup = document.getElementById("reservation_popup");
const closePopup = document.getElementById("close_popup");

editButton.addEventListener("click", () => {
	addReservation();
});

function addReservation() {
	userPopup.style.display = "flex";
}

document.addEventListener("keydown", function (event) {
	if (event.key === "Escape") {
		userPopup.style.display = "none";
	}
})

closePopup.addEventListener("click", () => {
	userPopup.style.display = "none";
});

document.addEventListener("click", (event) => {
	if ((userPopup.style.display === "flex" && !userPopup.contains(event.target) && event.target !== editButton) || event.target.className === "blur") {
		userPopup.style.display = "none";
	}
});
