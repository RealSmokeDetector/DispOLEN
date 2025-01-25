const stateElement = document.getElementById("state_display");
const stateValueElement = document.getElementById("state_value")
const reasonElement = document.getElementById("reason");
const typeElement = document.getElementById("type");
const commentElement = document.getElementById("comment");
const formElement = document.getElementById("formReservation");
const noComment = document.getElementById("no_comment");
const stateButtons = document.querySelectorAll("#state");

const editButton = document.getElementById("buttonId");

let url = new URL(window.location.href);
let params = url.searchParams;

let stateValue;
stateButtons.forEach(button => {
	button.addEventListener("click", () => {
		callApi("/api/reservation/states", "post", {
			"reservation_uid": params.get("reservation"),
			"state": button.dataset.state
		});
		stateButtons.forEach(async newButton => {
			newButton.style.display = "none";
			switch (button.dataset.state) {
				case "1":
					stateElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "2":
					console.log("ptn")
					if (newButton.dataset.state == 4) {
						newButton.style.display = "inline-block";
					}
					editButton.style.display = "block";
					stateElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "3":
					stateElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "4":
					stateElement.textContent = await stateFormat(button.dataset.state);
					editButton.style.display = "none";
					break;
			}
		});
	})
});

async function stateFormat(id) {
	switch(id) {
		case "1":
			return await translate("MAIN_STATE_PENDING")
		case "2":
			return await translate("MAIN_STATE_ACCEPTED")
		case "3":
			return await translate("MAIN_STATE_REFUSED")
		case "4":
			return await translate("MAIN_STATE_CANCELED")
	}
}

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

	let submitButton = document.createElement("button")
	submitButton.type = "submit";
	submitButton.id = "submitUpdateReservation";
	submitButton.name = "submitAllForm"
	submitButton.className = "button";
	submitButton.textContent = "Submit";

	let inputStateElement = document.createElement("input");
	inputStateElement.type = "hidden";
	inputStateElement.name = "state";
	inputStateElement.value = stateValueElement.dataset.state;

	if (isElementExist(noComment)) {
		noComment.remove();
	}

	reasonElement.replaceWith(reasonSelectElement);
	typeElement.replaceWith(typeSelectElement);
	commentElement.replaceWith(inputCommentElement);

	formElement.appendChild(inputStateElement);
	formElement.appendChild(submitButton);

	editButton.style.display = "none";

	stateButtons.forEach(button => {
		button.style.display = "none";
	})

	formElement.appendChild(submitButton);
}

