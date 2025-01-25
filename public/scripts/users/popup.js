const addButton = document.getElementById("add_button");
const userPopup = document.getElementById("user_popup");
const closePopup = document.getElementById("close_popup");

addButton.addEventListener("click", () => {
	addUser();
});

function addUser() {
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
	if ((userPopup.style.display === "flex" && !userPopup.contains(event.target) && event.target !== addButton) || event.target.className === "blur") {
		userPopup.style.display = "none";
	}
});
