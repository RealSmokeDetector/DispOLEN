const stateElement = document.getElementById("state_display");
const stateValueElement = document.getElementById("state_value")
const reasonElement = document.getElementById("reason");
const typeElement = document.getElementById("type");
const commentElement = document.getElementById("comment");
const noComment = document.getElementById("no_comment");
const stateButtons = document.querySelectorAll("#state");
const divInitElement = document.getElementById("reservation_details_container");
const submitButton = document.getElementById("submit")

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
				case "2": // Accepted
					if (newButton.dataset.state == 4) {
						newButton.style.display = "inline-block";
					}
					editButton.style.display = "block";
					stateValueElement.dataset.state = 2;
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
	inputCommentElement.id = "commentInput";
	inputCommentElement.value = commentElement.textContent.slice(1, -1);

	let inputStateElement = document.createElement("input");
	inputStateElement.type = "hidden";
	inputStateElement.name = "state";
	inputStateElement.value = stateValueElement.dataset.state;

	submitButton.style.display = "flex";

	if (isElementExist(noComment)) {
		noComment.remove();
	}

	// reasonElement.style.display = "none";
	// divElement.appendChild(reasonSelectElement);
	reasonElement.replaceWith(reasonSelectElement);
	typeElement.replaceWith(typeSelectElement);
	commentElement.replaceWith(inputCommentElement);

	divInitElement.appendChild(inputStateElement);
	divInitElement.appendChild(submitButton);

	editButton.style.display = "none";

	stateButtons.forEach(button => {
		button.style.display = "none";
	});

	submitButton.addEventListener("click", () => {
		submit();
	});

	function submit() {
		callApi("/api/reservation/details", "put", {
			"uid_reservation": params.get("reservation"),
			"id_type": document.getElementById("typeSelect").value,
			"id_reason": document.getElementById("reasonSelect").value,
			"id_state": document.getElementById("state_value").dataset.state,
			"comment": document.getElementById("commentInput").value
		});
	}
}
