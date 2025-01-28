const nameElement = document.getElementById("name");
const surnameElement = document.getElementById("surname");
const roleElement = document.getElementById("role");
const tutorElement = document.getElementById("tutors");
const tutoredStudentsElement = document.getElementById("tutored_students");
const formElement = document.getElementById("form_user");
const editButton = document.getElementById("button_id");

editButton.addEventListener("click", async () => {
	let inputName = document.createElement("input")
	inputName.type = "text";
	inputName.name = "name";
	inputName.value = nameElement.textContent;

	let inputSurname = document.createElement("input")
	inputSurname.type = "text";
	inputSurname.name = "surname";
	inputSurname.value = surnameElement.textContent;

	let roleSelectElement = document.getElementById("role_select");
	roleSelectElement.style.display = "inline-block";

	let tutorSelectElement = document.getElementById("tutors_select");
	if (isElementExist(tutorSelectElement)) {
		tutorSelectElement.style.display = "inline-block";
	}

	let tutoredStudentsSelectElement = document.getElementById("tutored_students_select");
	if (isElementExist(tutoredStudentsSelectElement)) {
		tutoredStudentsSelectElement.style.display = "inline-block";
	}

	let submitButton = document.createElement("button")
	submitButton.type = "submit";
	submitButton.id = "submitUpdateUser";
	submitButton.className = "button";
	submitButton.textContent = await translate("MAIN_SAVE");

	nameElement.replaceWith(inputName);
	surnameElement.replaceWith(inputSurname);
	roleElement.replaceWith(roleSelectElement);

	if (isElementExist(tutorElement)) {
		tutorElement.replaceWith(tutorSelectElement);
	}

	if (isElementExist(tutoredStudentsElement)) {
		tutoredStudentsElement.replaceWith(tutoredStudentsSelectElement);
	}

	editButton.remove();

	formElement.appendChild(submitButton);
})
