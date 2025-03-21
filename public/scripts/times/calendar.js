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

const date = new Date();
let dateSelected = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
let offSet = 0;

const calendarUp = document.getElementById("calendar_up");
const calendarDown = document.getElementById("calendar_down");
const dateTitle = document.getElementById("date_title");

calendarUp.addEventListener("click", () => {
	changeCalendar(1);
})

calendarDown.addEventListener("click", () => {
	changeCalendar(-1);
})

document.querySelectorAll("#calendar button").forEach((element) => {
	element.addEventListener("click", () => {
		document.querySelectorAll("#calendar tbody td").forEach((element) => {
			element.dataset.date === dateSelected ? element.classList.add("selected") : element.classList.remove("selected")
		});
	});
});

document.querySelectorAll("#calendar tbody td").forEach((element) => {
	if (!element.classList.contains("off")) {
		element.addEventListener("click", (event) => {
			if (event.currentTarget.classList.contains("off")) {
				return;
			}
			document.querySelectorAll(".selected").forEach((element) => {
				element.classList.remove("selected");
			});
			event.target.classList.add("selected");
			dateSelected = event.target.dataset.date;
		});
	}
})

/**
 * Change calendar mounth
 *
 * @param {int} scale
 *
 * @return {void}
 */
async function changeCalendar(scale) {
	date.setMonth(date.getMonth() + scale);
	offSet += scale;

	let offDays = await callApi("/api/date/offdays", "POST", {"year": date.getFullYear()});

	dateTitle.textContent = months[date.getMonth()] + " " + date.getFullYear();
	const DateMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
	const firstDateOfMonth = new Date(date.getFullYear(), date.getMonth() , 1).getDay();

	let iteration = 1;
	document.querySelectorAll("#calendar tbody td").forEach((element, index) => {
		let offSetDayOfWeek = (firstDateOfMonth === 0) ? firstDateOfMonth + 6 : firstDateOfMonth - 1;

		if (index >= offSetDayOfWeek && iteration <= DateMonth) {
			element.textContent = iteration;
			element.dataset.date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + iteration;
			element.classList.remove("off");

			let dayOfWeek = new Date(date.getFullYear(), date.getMonth(), iteration).getDay();
			if (
				offDays.includes(date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + iteration)
				|| (dayOfWeek === 0 || dayOfWeek === 6)
			) {
				element.classList.add("off");
			}

			iteration++;
		} else {
			element.textContent = "";
		}
	});
}
