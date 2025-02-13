const addButton = document.getElementById("add_button");
const groupPopup = document.getElementById("group_popup");
const closePopup = document.getElementById("close_popup");

addButton.addEventListener("click", () => {
	groupPopup.style.display = "flex";
});

document.addEventListener("keydown", (event) => {
	if (event.key === "Escape") {
		groupPopup.style.display = "none";
	}
})

closePopup.addEventListener("click", () => {
	groupPopup.style.display = "none";
});

document.addEventListener("click", (event) => {
	if ((groupPopup.style.display === "flex" && !groupPopup.contains(event.target) && event.target !== addButton) || event.target.className === "blur") {
		groupPopup.style.display = "none";
	}
});
