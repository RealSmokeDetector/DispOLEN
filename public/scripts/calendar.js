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
let offSet = 0;

document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll("#calendar button").forEach((element) => {
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
	offSet += scale;

	document.querySelector("#calendar caption p").textContent = months[date.getMonth()] + " " + date.getFullYear();
	let iteration = 1;
	const DateMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
	const firstDateOfMonth = new Date(date.getFullYear(), date.getMonth() , 1).getDay();

	document.querySelectorAll("#calendar tbody td").forEach((element, index) => {
		let offSetDayOfWeek = (firstDateOfMonth === 0)? firstDateOfMonth + 6 : firstDateOfMonth - 1
		if (index >= offSetDayOfWeek && iteration <= DateMonth) {
			element.textContent = iteration++;
		} else {
			element.textContent = "";
		}
	});
}
