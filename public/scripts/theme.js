/**
 * Get local settings
 *
 * @returns
 */
function calculateSettingAsThemeString({localStorageTheme, systemSettingDark}) {
	if (localStorageTheme !== null) {
		return localStorageTheme;
	}

	if (systemSettingDark.matches) {
		return "dark";
	}

	return "light";
}

/**
 * Update theme button
 *
 * @returns
 */
async function updateButton({isDark}) {
	const icon = isDark ? "ri-sun-fill" : "ri-moon-fill";

	let button = document.getElementById("theme_button");

	if (isElementExist(button)) {
		button.children[0].className = icon;
	}
}

/**
 * Set theme
 *
 * @returns
 */
function updateThemeOnHtmlEl({theme}) {
	document.querySelector("html").setAttribute("data-theme", theme);
}

const button = document.getElementById("theme_button");
const localStorageTheme = localStorage.getItem("theme");
const systemSettingDark = window.matchMedia("(prefers-color-scheme: dark)");

let currentThemeSetting = calculateSettingAsThemeString({localStorageTheme, systemSettingDark});

updateButton({isDark: currentThemeSetting === "dark"});
updateThemeOnHtmlEl({theme: currentThemeSetting});

if (isElementExist(button)) {
	button.addEventListener("click", () => {
		const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

		localStorage.setItem("theme", newTheme);
		updateButton({isDark: newTheme === "dark"});
		updateThemeOnHtmlEl({theme: newTheme});

		currentThemeSetting = newTheme;
	});

	button.addEventListener("auxclick", async (e) => {
		if (e.button === 1) {
			document.body.style.backgroundImage = 'url("/images/notsuspiciousatall.jpg")';

			await confetti({
				particleCount: 50,
				origin: {
					y: 0
				},
				spread: 1000,
				scalar: 10,
				shapes: ["emoji"],
				shapeOptions: {
					emoji: {
						value: ["🦄", "🌈", "✨"],
					},
				},
			});

			const main = document.getElementsByTagName("main")[0];

			main.after(document.getElementById("confetti"));

			for (let i = 0; i < 50; i++) {
				let particle = document.createElement("span");
				particle.setAttribute("class", "particle");
				main.appendChild(particle);
			}

			function rand(min, max) {
				return Math.floor(Math.random() * (max - min + 1)) + min;
			}

			Array.from(document.getElementsByClassName('particle')).forEach(element => {
				setInterval(() => {
					element.style.left = rand(0, 100) + "%";
					element.style.top = rand(0, 100) + "%";
					let size = rand(3, 5);
					element.style.height = size + "px";
					element.style.width = size + "px";
					element.style.transform = "rotate(" + rand(0, 90) + "deg)";
				}, 150)
			});
		}
	})
}
