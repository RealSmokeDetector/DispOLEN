const stateElement = document.getElementById("state");
const reasonElement = document.getElementById("reason");
const typeElement = document.getElementById("type");
const commentElement = document.getElementById("comment");
const formElement = document.getElementById("formReservation");

const editButton = document.getElementById("buttonId");

editButton.addEventListener("click", () => {
	updateReservation();
})

function updateReservation() {
	let stateSelectElement = document.getElementById("stateSelect");
	stateSelectElement.style.display = "inline-block";

	let reasonSelectElement = document.getElementById("reasonSelect");
	reasonSelectElement.style.display = "inline-block";

	let typeSelectElement = document.getElementById("typeSelect");
	typeSelectElement.style.display = "inline-block";

	let inputCommentElement = document.createElement("input");
	inputCommentElement.name = "comment"
	inputCommentElement.value = commentElement.textContent;

	let submitButton = document.createElement("button")
	submitButton.type = "submit";
	submitButton.id = "submitUpdateReservation";
	submitButton.className = "button";
	submitButton.textContent = "Submit";

	stateElement.replaceWith(stateSelectElement);
	reasonElement.replaceWith(reasonSelectElement);
	typeElement.replaceWith(typeSelectElement);
	commentElement.replaceWith(inputCommentElement);

	editButton.remove();

	formElement.appendChild(submitButton);
}

