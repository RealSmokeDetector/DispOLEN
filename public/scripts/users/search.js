const searchInput = document.getElementById("control_panel_search");
const orderSelect = document.getElementById("control_panel_filter");
let userTiles = document.querySelectorAll("#user_tile");
const controlPanelBefore = document.getElementById("control_panel_before");
const controlPanelAfter = document.getElementById("control_panel_after");
const controlPanelInfo = document.getElementById("control_panel_info");
const nbShow = 10;

if (isElementExist(searchInput)) {
	searchInput.addEventListener("input", () => {
		let search = searchInput.value.toLowerCase();

		userTiles.forEach(tile => {
			let name = tile.children[0].children[0].textContent.toLowerCase();

			tile.style.display = "none";
			if (name.includes(search)) {
				tile.style.display = "block";
			}
		});
	});
}

if (isElementExist(orderSelect)) {
	orderSelect.addEventListener("change", (event) => {
		userTiles = document.querySelectorAll("#user_tile");
		let nbPanelInfo = Number.parseInt(controlPanelInfo.textContent);
		let order = event.currentTarget.value;
		let sortedUserTiles = Array.from(userTiles).sort((firstElement, secondElement) => {
			let firstText = firstElement.children[0].children[0].textContent.toLowerCase();
			let secondText = secondElement.children[0].children[0].textContent.toLowerCase();

			if (order === "a-z") {
				return firstText.localeCompare(secondText);
			} else if (order === "z-a") {
				return secondText.localeCompare(firstText);
			}
		});

		const parent = userTiles[0].parentNode;
		parent.innerHTML = "";
		console.log(nbPanelInfo);
		sortedUserTiles.forEach((tile, index) => {
			console.log(index, tile);
			if (index >= nbShow * (nbPanelInfo - 1)  && index < nbShow * nbPanelInfo) {
				tile.classList.remove("hidden");
			} else {
				tile.classList.add("hidden");
			}
			parent.appendChild(tile);
		});
	});
}

if (isElementExist(controlPanelBefore) && isElementExist(controlPanelAfter)) {
	if (userTiles.length > nbShow) {
		controlPanelBefore.addEventListener("click", () => {
			userTiles = document.querySelectorAll("#user_tile");
			let nbPanelInfo = Number.parseInt(controlPanelInfo.textContent);
			if (controlPanelInfo.textContent > 1) {
				controlPanelInfo.textContent = nbPanelInfo - 1;

				userTiles.forEach((tile, index) => {
				if (index >= nbShow * (nbPanelInfo - 2)  && index < nbShow * (nbPanelInfo - 1)) {
						tile.classList.remove("hidden");
					} else {
						tile.classList.add("hidden");
					}
				});
			}
		});

		controlPanelAfter.addEventListener("click", () => {
			userTiles = document.querySelectorAll("#user_tile");
			let nbPanelInfo = Number.parseInt(controlPanelInfo.textContent);
			if (nbShow * nbPanelInfo < userTiles.length) {
				controlPanelInfo.textContent = nbPanelInfo + 1;

				userTiles.forEach((tile, index) => {
					if (index >= nbShow * nbPanelInfo  && index < nbShow * (nbPanelInfo + 1)) {
						tile.classList.remove("hidden");
					} else {
						tile.classList.add("hidden");
					}
				});
			}
		});
	}
}
