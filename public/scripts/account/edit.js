const passwordContainer = document.getElementById("modify_password");
const editButton = document.getElementById("button_id");

editButton.addEventListener("click", () => {
	editButton.style.display = "none";

	passwordContainer.style.display = "block";
});
