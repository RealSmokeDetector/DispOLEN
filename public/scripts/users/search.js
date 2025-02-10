const searchInput = document.getElementById("control_panel_search");
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
