let buttonPhone = document.getElementById("phone_button");
let navBar = document.getElementsByTagName("nav")[0];
if (isElementExist(navBar)) {
	buttonPhone.addEventListener("click", () => {
		if (buttonPhone.children[0].classList.contains("ri-menu-line")) {
			buttonPhone.children[0].className = "ri-close-circle-line";
			navBar.style = "position: relative; height: fit-content;";

			for (let i = 0; i < navBar.childElementCount; i++ ) {
				if (navBar.children[i].classList.contains("item")) {
					navBar.children[i].style.display = "flex";
				}
			}

		} else {
			buttonPhone.children[0].className = "ri-menu-line";
			navBar.removeAttribute("style");
			
			for (let i = 0; i < navBar.childElementCount; i++ ) {
				console.log(navBar.children[i]);
				if (navBar.children[i].classList.contains("item")) {
					navBar.children[i].removeAttribute("style");
				}
			}
		}
	});
}
