const stateTitleElement = document.getElementById("state_title");
const reasonTitleElement = document.getElementById("reason_title");
const typeTitleElement = document.getElementById("type_title");

const commentElement = document.getElementById("comment_value");
const noCommentElement = document.getElementById("no_comment_title");

const stateButtons = document.querySelectorAll("#state");
const editButton = document.getElementById("edit_button");
const submitButton = document.getElementById("submit_button")

const reservationDetailsElement = document.getElementById("reservation_details_container");
const dateTitleElement = document.getElementById("date_title");

const typeEditElement = document.getElementById("type_edit");
const reasonEditElement = document.getElementById("reason_edit");

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
					stateTitleElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "2": // Accepted
					if (newButton.dataset.state == 4) {
						newButton.style.display = "inline-block";
					}
					editButton.style.display = "block";
					stateTitleElement.dataset.state = 2;
					stateTitleElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "3":
					stateTitleElement.textContent = await stateFormat(button.dataset.state);
					break;
				case "4":
					stateTitleElement.textContent = await stateFormat(button.dataset.state);
					editButton.style.display = "none";
					break;
			}
		});
	})
});

async function stateFormat(id) {
	switch(id) {
		case "1":
			return await translate("MAIN_STATE_PENDING");
		case "2":
			return await translate("MAIN_STATE_ACCEPTED");
		case "3":
			return await translate("MAIN_STATE_REFUSED");
		case "4":
			return await translate("MAIN_STATE_CANCELED");
		default:
			return "";
	}
}

async function reasonFormat(id) {
	switch(id) {
		case "1":
			return await translate("MAIN_REASON_REVIEW_1");
		case "2":
			return await translate("MAIN_REASON_REVIEW_2");
		case "3":
			return await translate("MAIN_REASON_PRESENTATION");
		case "4":
			return await translate("MAIN_REASON_PROGRESS");
		case "5":
			return await translate("MAIN_OTHER");
		default:
			return "";
	}
}

async function typeFormat(id) {
	switch(id) {
		case "1":
			return await translate("MAIN_TYPE_VISIT");
		case "2":
			return await translate("MAIN_TYPE_FACE_TO_FACE");
		case "3":
			return await translate("MAIN_TYPE_PHONE");
		case "4":
			return await translate("MAIN_TYPE_VIDEO_DISCORD");
		case "5":
			return await translate("MAIN_TYPE_VIDEO_TEAMS");
		default:
			return "";
	}
}

editButton.addEventListener("click", displayEdit);

function displayEdit() {
	reasonEditElement.style.display = "block";
	typeEditElement.style.display = "block";

	let inputCommentElement = document.createElement("input");
	inputCommentElement.name = "comment";
	inputCommentElement.value = commentElement.textContent.slice(1, -1);
	inputCommentElement.id = "edit_comment";

	let inputStateElement = document.createElement("input");
	inputStateElement.type = "hidden";
	inputStateElement.name = "state";
	inputStateElement.id = "state_value";
	inputStateElement.value = stateTitleElement.dataset.state;

	submitButton.style.display = "flex";

	if (isElementExist(noCommentElement)) {
		noCommentElement.remove();
	}

	reasonTitleElement.style.display = "none";
	typeTitleElement.style.display = "none";
	commentElement.style.display = "none";

	dateTitleElement.after(reasonEditElement);
	dateTitleElement.after(typeEditElement);

	reservationDetailsElement.append(inputCommentElement);
	reservationDetailsElement.append(inputStateElement);
	reservationDetailsElement.append(submitButton);

	editButton.style.display = "none";

	stateButtons.forEach(button => {
		button.style.display = "none";
	});

	editButton.removeEventListener("click", displayEdit);

	submitButton.addEventListener("click", submitEdit);
}

async function submitEdit() {
	await callApi("/api/reservation/details", "put", {
		"uid_reservation": params.get("reservation"),
		"id_type": typeEditElement.value,
		"id_reason": reasonEditElement.value,
		"id_state": stateTitleElement.dataset.state,
		"comment": document.getElementById("edit_comment").value
	});

	reasonTitleElement.textContent = await reasonFormat(reasonEditElement.value);
	typeTitleElement.textContent = await reasonFormat(typeEditElement.value);
	commentElement.textContent = document.getElementById("edit_comment").value;

	if (stateTitleElement.dataset.state == 2) {
		stateButtons.forEach(async button => {
			if (button.dataset.state == 4) {
				button.style.display = "block";
			}
		});
	}

	reasonTitleElement.style.display = "block";
	typeTitleElement.style.display = "block";
	commentElement.style.display = "block";

	reasonEditElement.remove();
	typeEditElement.remove();
	document.getElementById("edit_comment").remove();
	document.getElementById("state_value").remove();

	submitButton.removeEventListener("click", submitEdit);
	editButton.addEventListener("click", displayEdit);

	submitButton.style.display = "none";
	editButton.style.display = "block";
}
