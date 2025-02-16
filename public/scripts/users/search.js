const searchInput = document.getElementById("control_panel_search");
const orderSelect = document.getElementById("control_panel_filter");
const userTiles = document.querySelectorAll("#user_tile");

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
		sortedUserTiles.forEach(tile => {
			parent.appendChild(tile);
		});
	});
}
