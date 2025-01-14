let days = [];
let month = [];

(async () => {
	days = [
		await translate("MAIN_MONDAY"),
		await translate("MAIN_TUESDAY"),
		await translate("MAIN_WEDNESDAY"),
		await translate("MAIN_THURSDAY"),
		await translate("MAIN_FRIDAY"),
		await translate("MAIN_SATURDAY"),
		await translate("MAIN_SUNDAY")
	];
	months = [
		await translate("MAIN_JANUARY"),
		await translate("MAIN_FEBRUARY"),
		await translate("MAIN_MARCH"),
		await translate("MAIN_APRIL"),
		await translate("MAIN_MAY"),
		await translate("MAIN_JUNE"),
		await translate("MAIN_JULY"),
		await translate("MAIN_AUGUST"),
		await translate("MAIN_SEPTEMBER"),
		await translate("MAIN_OCTOBER"),
		await translate("MAIN_NOVEMBER"),
		await translate("MAIN_DECEMBER")
	];
})()

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
			element.textContent = iteration;
			element.dataset.date = date.getFullYear() + "-" + (date.getMonth() + 1)  + "-" + iteration;
			iteration++;
		} else {
			element.textContent = "";
		}
	});
}
