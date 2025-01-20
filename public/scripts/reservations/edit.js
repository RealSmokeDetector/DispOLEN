const stateElement = document.getElementById("state");
const stateValue = stateElement.getAttribute('value');
const reasonElement = document.getElementById("reason");
const typeElement = document.getElementById("type");
const commentElement = document.getElementById("comment");
const formElement = document.getElementById("formReservation");
const noComment = document.getElementById("no_comment");

const editButton = document.getElementById("buttonId");

editButton.addEventListener("click", () => {
	updateReservation();
})

function updateReservation() {
	let reasonSelectElement = document.getElementById("reasonSelect");
	reasonSelectElement.style.display = "inline-block";

	let typeSelectElement = document.getElementById("typeSelect");
	typeSelectElement.style.display = "inline-block";

	let inputCommentElement = document.createElement("input");
	inputCommentElement.name = "comment"
	inputCommentElement.value = commentElement.textContent.slice(1, -1);

	let inputHiddenStateElement = document.createElement("input");
    inputHiddenStateElement.type = "hidden";
    inputHiddenStateElement.name = "state";
    inputHiddenStateElement.value = stateValue;

	let submitButton = document.createElement("button")
	submitButton.type = "submit";
	submitButton.id = "submitUpdateReservation";
	submitButton.name = "submitAllForm"
	submitButton.className = "button";
	submitButton.textContent = "Submit";

	if (isElementExist(noComment)) {
		noComment.remove();
	}

	reasonElement.replaceWith(reasonSelectElement);
	typeElement.replaceWith(typeSelectElement);
	commentElement.replaceWith(inputCommentElement);

	formElement.appendChild(inputHiddenStateElement);
    formElement.appendChild(submitButton);

	editButton.remove();

	formElement.appendChild(submitButton);
}

