const nameElement = document.getElementById("name");
const surnameElement = document.getElementById("surname");
const roleElement = document.getElementById("role");

const editButton = document.getElementById("buttonId");

editButton.addEventListener("click", () => {
	updateUser();
})

function updateUser() {
	let inputName = document.createElement("input")
	inputName.setAttribute("type", "text");
	inputName.setAttribute("name", "name");
	inputName.setAttribute("value", nameElement.textContent);

	let inputSurname = document.createElement("input")
	inputSurname.setAttribute("type", "text");
	inputSurname.setAttribute("name", "surname");
	inputSurname.setAttribute("value", surnameElement.textContent);

	let roleSelectElement = document.getElementById("roleSelect");
    roleSelectElement.style.display = "inline-block";

	nameElement.replaceWith(inputName);
	surnameElement.replaceWith(inputSurname);
	roleElement.replaceWith(roleSelectElement);
}
