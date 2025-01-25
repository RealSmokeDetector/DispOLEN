// Select all elements with the class "calendar-day"
const heightDiv = 306;
const containerTimeslot = document.getElementById("availabilities_container");
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const uid = document.getElementById("disponibility_timeslots_tile").dataset.uid;

// Loop through each "calendar-day" element
//dataset()(note pour moi a enlever)
calendarDays.forEach(day => {
	day.addEventListener("click", async function(event) {
		dateTimeslot.innerText = event.target.dataset.date;
		let url = "/api/reservations";
		let reservations = await callApi(url , "post", {
			"uid": uid,
			"date_start": event.target.dataset.date
		});

		const timeslots = document.querySelectorAll(".availability_reserved");

		timeslots.forEach((value) => {
			value.style.height = 0;
		});

		await reservations.forEach((value,index) => {
			lastIndex = index;
			if (timeslots[index]) {
				updateTimeslot(new Date(value.date_start), new Date(value.date_end), timeslots[index]);
			} else {
				createTimeslot(value.date_start, value.date_end);
			}
		});
	});
});

function createTimeslot(dateStart, dateEnd, divTimeslot) {
	divTimeslot = document.createElement("div");
	divTimeslot.className = "availability_reserved";
	divTimeslot.style.position = "fixed";
	divTimeslot.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60);
	divTimeslot.style.transform = "translateY" + (((dateStart - new Date(dateStart).setHours(8, 0, 0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px";
}

function updateTimeslot(dateStart, dateEnd, htmlElement) {
	htmlElement.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60);
	htmlElement.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8, 0, 0)) / (60 * 1000)) * heightDiv) / (11 * 60) + "px)";
}
