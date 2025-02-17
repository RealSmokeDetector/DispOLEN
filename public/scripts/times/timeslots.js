const heightDiv = 306;
const containersTimeslots = document.querySelectorAll("#availabilities_container");
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const calendarWeek = document.querySelectorAll("#calendar tbody tr");
const uid = document.getElementById("timeslots_tile").dataset.uid;
const format = new Intl.DateTimeFormat(getCookie("LANG").replace("_", "-"), {day: "2-digit", month: "2-digit", year: "numeric"});

if (containersTimeslots.length === 1) {
	calendarDays.forEach(day => {
		if (!day.classList.contains("off")) {
			day.addEventListener("click", async function(event) {
				if (event.currentTarget.classList.contains("off")) {
					return;
				}
				dateTimeslot.innerText = format.format(new Date(event.target.dataset.date));
				let reservationDates = await callApi("/api/reservation" , "post", {
					"uid": uid,
					"date_start": event.target.dataset.date
				});

				let disponibilityDates = await callApi("/api/disponibility" , "post", {
					"uid": uid,
					"date_start": event.target.dataset.date
				});

				const timeslotsReservation = document.querySelectorAll(".availability_reserved");
				const timeslotsDisponibilities = document.querySelectorAll(".disponibility");

				timeslotsReservation.forEach((value) => {
					value.style.height = 0;
				});
				timeslotsDisponibilities.forEach((value)=> {
					value.style.height = 0;
				});

				if (!reservationDates.error) {
					reservationDates.forEach((value, index) => {
						if (timeslotsReservation[index]) {
							updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslotsReservation[index]);
						} else {
							createTimeslot(new Date(value.date_start), new Date(value.date_end), containersTimeslots[0]);
						}
					});
				}

				if (!disponibilityDates.error) {
					disponibilityDates.forEach((value, index) => {
						if (timeslotsDisponibilities[index]) {
							updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslotsDisponibilities[index]);
						} else {
							createTimeslot(new Date(value.date_start), new Date(value.date_end), containersTimeslots[0], "disponibility");
						}
					});
				}
			});
		}
	});
} else if (containersTimeslots.length > 1) {
	calendarWeek.forEach((weekElement) => {
		weekElement.addEventListener("click", (event) => {
			let timeslotsReservation = document.querySelectorAll(".availability_reserved");
			let timeslotsDisponibilities = document.querySelectorAll(".disponibility");

			timeslotsReservation.forEach((value) => {
				value.style.height = 0;
			});
			timeslotsDisponibilities.forEach((value)=> {
				value.style.height = 0;
			});

			let liste = [event.currentTarget.children[0].dataset.date, event.currentTarget.children[event.currentTarget.children.length - 1].dataset.date];
			if (!liste.includes(undefined)) {
				containersTimeslots.forEach(async (containerTimeslot, i) => {
					let timeslotsReservation = containerTimeslot.querySelectorAll(".availability_reserved");
					let timeslotsDisponibilities = containerTimeslot.querySelectorAll(".disponibility");
					let date = event.currentTarget.children[i].dataset.date;
					let reservationDates = await callApi("/api/reservation" , "post", {
						"uid": uid,
						"date_start": date
					});

					let disponibilityDates = await callApi("/api/disponibility" , "post", {
						"uid": uid,
						"date_start": date
					});
					if (!reservationDates.error) {
						reservationDates.forEach((value, index) => {

							if (timeslotsReservation[index]) {

								updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslotsReservation[index]);
							} else {
								createTimeslot(new Date(value.date_start), new Date(value.date_end), containerTimeslot);
							}
						});
					}

					if (!disponibilityDates.error) {
						disponibilityDates.forEach((value, index) => {
							if (timeslotsDisponibilities[index]) {
								updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslotsDisponibilities[index]);
							} else {
								createTimeslot(new Date(value.date_start), new Date(value.date_end), containerTimeslot, "disponibility");
							}
						});
					}
				});
			}
		});
	});
}

function createTimeslot(dateStart, dateEnd, divTimeslotContainer, classe = "availability_reserved") {
	const divTimeslot = document.createElement("div");
	divTimeslot.className = classe;
	divTimeslot.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	divTimeslot.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8,0,0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
	divTimeslotContainer.append(divTimeslot);
}

function updateTimeslot(dateStart, dateEnd, htmlElement) {
	htmlElement.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	htmlElement.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8, 0, 0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
}
