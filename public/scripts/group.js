const groupsButton = document.querySelectorAll("button");
const deleteUserButoon = document.querySelectorAll("#delete_user");
const groupEditButton = document.querySelectorAll("#group_edit");
const groupDeleteButton = document.querySelectorAll("#group_delete");

const groupsContainer = document.querySelectorAll("#group");
const groupsControl = document.querySelectorAll("#group_control");

let url = new URL(window.location.href);
let params = url.searchParams;

if (groupsButton) {
	groupsButton.forEach(element => {
		if (element.hasAttribute("data-group")) {
			element.addEventListener("click", () => {
				params.set("group", element.getAttribute("data-group"));
				url.search = params.toString();
				window.history.pushState({}, "", url);

				groupsContainer.forEach(group => {
					group.style.display = "none";
					if (group.getAttribute("data-uid") == element.getAttribute("data-group")) {
						group.style.display = "flex";
					}
				});

				groupsControl.forEach(group => {
					group.style.display = "none";
					if (group.getAttribute("data-uid") == element.getAttribute("data-group")) {
						group.style.display = "flex";
					}
				});

				groupsButton.forEach(button => {
					if (button.hasAttribute("data-group")) {
						button.className = "button button_secondary";
						if (button.getAttribute("data-group") == element.getAttribute("data-group")) {
							button.className = "button";
						}
					}
				})
			})
		}
	});
}

deleteUserButoon.forEach(element => {
	if (isElementExist(element)) {
		element.addEventListener("click", async () => {
			if (confirm(await translate("GROUPS_REMOVE_STUDENT_CONFIRM"))) {
				await callApi("/api/groups/users", "delete", {
					"group_uid": params.get("group"),
					"user_uid": element.getAttribute("data-uid")
				});

				window.location.reload();
			}
		})
	}
});

groupEditButton.forEach(element => {
	if (isElementExist(element)) {
		element.addEventListener("click", () => {
			if (element.id === "group_edit") {
				let titleElement = element.parentElement.parentElement;

				let input = document.createElement("input");
				input.type = "text";
				input.name = "name";
				input.value = titleElement.textContent.replace(/\s+/g, " ").trim();

				element.children[0].className = "ri-save-2-line";
				element.id = "group_save";
				element.setAttribute("onclick", "save(event, this, \"" + titleElement.getAttribute("data-uid") + "\")");

				element.parentElement.parentElement.children[0].replaceWith(input);

				input.focus();
			}
		});
	}
});

groupDeleteButton.forEach(element => {
	if (isElementExist(element)) {
		element.addEventListener("click", async () => {
			if (confirm(await translate("GROUPS_REMOVE_GROUP_CONFIRM"))) {
				await callApi("/api/groups", "delete", {
					"group_uid": element.parentElement.parentElement.getAttribute("data-uid")
				});

				window.location.reload();
			}
		});
	}
});

async function save(event, element, groupUid) {
	let title = element.parentElement.parentElement.children[0];

	element.children[0].className = "ri-edit-2-line";
	element.id = "group_edit";
	element.removeAttribute("onclick");

	let p = document.createElement("p");
	p.className = "group_name";
	p.textContent = title.value;
	title.replaceWith(p);

	await callApi("/api/groups", "post", {
		"group_uid": groupUid,
		"name": title.value
	});
}
