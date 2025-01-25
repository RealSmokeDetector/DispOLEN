// Select all elements with the class "calendar-day"
const heightDiv = 306;
const containerTimeslot = document.getElementById("availbilities_container");
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const uid = document.getElementById("disponibility_timeslots_tile").dataset.uid;

// Loop through each "calendar-day" element
//dataset()(note pour moi a enlever)
calendarDays.forEach(day => {
	day.addEventListener("click", async function(event) {
		dateTimeslot.innerText = event.target.dataset.date;
		let url = "/api/reservation";
		let reservations = await callApi(url , "post", {
			"uid": uid,
			"date_start": event.target.dataset.date
		} );

		const timeslots = document.querySelectorAll(".availbility_reserved");

		timeslots.forEach((value) =>{
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
	divTimeslot.classList.add("availbility_reserved");
	divTimeslot.style.position = "fixed";
	divTimeslot.style.width = "90px";
	divTimeslot.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60 ) + "px";
	divTimeslot.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8,0,0)) / (60 * 1000)) * heightDiv) / (11 * 60 ) + "px)";
	containerTimeslot.append(divTimeslot);
}

function updateTimeslot(dateStart, dateEnd, htmlElement) {
	htmlElement.style.height = (((dateEnd - dateStart) / 60000) * heightDiv) / (11 * 60) + "px";
	htmlElement.style.transform = "translateY(" + (((dateStart - new Date(dateStart).setHours(8,0,0)) / (60 * 1000)) * heightDiv) / (11 * 60 ) + "px)";
}

