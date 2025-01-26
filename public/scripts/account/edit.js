const passwordElement = document.querySelectorAll("#password");
const saveButton = document.getElementById("save_button");

const editButton = document.getElementById("button_id");

editButton.addEventListener("click", () => {
	updateUser();
})

function updateUser() {
	passwordElement.forEach(password => {
		password.style.display = "block";
	})

	saveButton.style.display = "block";
	editButton.style.display = "none";
}
