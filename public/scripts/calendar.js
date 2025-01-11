const days = [
	"Monday",
	"Tuesday",
	"Wednesday",
	"Thursday",
	"Friday",
	"Saturday",
	"Sunday"
];
const months = [
	"January",
	"February",
	"March",
	"April",
	"May",
	"June",
	"July",
	"August",
	"September",
	"October",
	"November",
	"December"
];

let buttons = [];
const date = new Date();
let offSetSet = 0;

document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll("#calendar button").forEach((element) => {
		buttons.push(element);
	});

	buttons.forEach((element) => {
		element.addEventListener("click", function(event) {
			switch (event.target.id) {
				case "calendar_up":
					changeCalendar(1);
					break;
				case "calendar_down":
					changeCalendar(-1);
					break;
			}
		});
	});
});

/**
 * Change calendar mounth
 *
 * @param {int} scale
 *
 * @return {void}
 */

function changeCalendar(scale) {
	date.setMonth(date.getMonth() + scale);
	offSetSet += scale;

	captionCalendar = document.querySelector("#calendar caption");

	document.querySelector("#calendar caption p").textContent = months[date.getMonth()] + " " + date.getFullYear();

	let iteration = 1;
	let NbDateMounth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
	document.querySelectorAll("#calendar tbody td").forEach((element, index) => {
		if (index >= ((date.getDay() + 1) % 7) && iteration <= NbDateMounth) {
			element.textContent = iteration++;
		} else {
			element.textContent = "";
		}
	});
}
