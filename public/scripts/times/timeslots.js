const heightDiv = 306;
const containersTimeslots = document.querySelectorAll("#availabilities_container");
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const calendarWeek = document.querySelectorAll("#calendar tbody tr");
const uid = document.getElementById("timeslots_tile").dataset.uid;

if (containersTimeslots.length === 1) {
	calendarDays.forEach(day => {
		if (!day.classList.contains("off")) {
			day.addEventListener("click", async function(event) {
				dateTimeslot.innerText = event.target.dataset.date;
				let reservationDates = await callApi("/api/reservation" , "post", {
					"uid": uid,
					"date_start": event.target.dataset.date
				});

				const timeslots = document.querySelectorAll(".availability_reserved");

				timeslots.forEach((value) => {
					value.style.height = 0;
				});

				if (!reservationDates.error) {
					reservationDates.forEach((value, index) => {
						if (timeslots[index]) {
							updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslots[index]);
						} else {
							createTimeslot(new Date(value.date_start), new Date(value.date_end), containersTimeslots[0]);
						}
					});
				}
			});
		}
	});
} else if (containersTimeslots.length > 1) {
	calendarWeek.forEach((weekElement) => {
		weekElement.addEventListener("click", (event) => {
			const timeslots = document.querySelectorAll(".availability_reserved");

			timeslots.forEach((value) => {
				value.style.height = 0;
			});
			containersTimeslots.forEach(async (containerTimeslot, i) => {
				let reservationDates = await callApi("/api/reservation" , "post", {
					"uid": uid,
					"date_start": event.currentTarget.children[i].dataset.date
				});

				if (!reservationDates.error) {
					reservationDates.forEach((value, index) => {
						if (timeslots[index]) {
							updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslots[index]);
						} else {
							createTimeslot(new Date(value.date_start), new Date(value.date_end), containerTimeslot);
						}
					});
				}
			});
		});
	});
}

function createTimeslot(dateStart, dateEnd, divTimeslotContainer) {
	const divTimeslot = document.createElement("div");
	divTimeslot.className = "availability_reserved";
	divTimeslot.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	divTimeslot.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8,0,0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
	divTimeslotContainer.append(divTimeslot);
}

function updateTimeslot(dateStart, dateEnd, htmlElement) {
	htmlElement.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	htmlElement.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8, 0, 0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
}
