const heightDiv = 306;
const containerTimeslot = document.getElementById("availabilities_container");
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const uid = document.getElementById("timeslots_tile").dataset.uid;

calendarDays.forEach(day => {
	day.addEventListener("click", async function(event) {
		dateTimeslot.innerText = event.target.dataset.date;
		let reservations = await callApi("/api/reservation" , "post", {
			"uid": uid,
			"date_start": event.target.dataset.date
		});

		const timeslots = document.querySelectorAll(".availability_reserved");

		timeslots.forEach((value) => {
			value.style.height = 0;
		});

		await reservations.forEach((value,index) => {
			if (timeslots[index]) {
				updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslots[index]);
			} else {
				createTimeslot(new Date(value.date_start), new Date(value.date_end));
			}
		});
	});
});

function createTimeslot(dateStart, dateEnd) {
	const divTimeslot = document.createElement("div");
	divTimeslot.className = "availability_reserved";
	divTimeslot.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	divTimeslot.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8,0,0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
	containerTimeslot.append(divTimeslot);
}

function updateTimeslot(dateStart, dateEnd, htmlElement) {
	htmlElement.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	htmlElement.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8, 0, 0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
}
