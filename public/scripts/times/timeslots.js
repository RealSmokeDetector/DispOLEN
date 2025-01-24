// Select all elements with the class "calendar-day"
const calendarDays = document.querySelectorAll("#calendar tbody td");
const dateTimeslot = document.getElementById("timesolt_date");
const uid = document.getElementById("disponibility_timeslots_tile").dataset.uid;
const timeslots = document.querySelectorAll(".time_container");

// Loop through each "calendar-day" element
//dataset()(note pour moi a enlever)
calendarDays.forEach(day => {
	day.addEventListener("click", async function(event) {
		dateTimeslot.innerText = event.target.dataset.date;
		let url = "/api/reservations?uid=" + uid + "&date_start=" + event.target.dataset.date;
		let toto = await callApi(url/* , "post", {
			"uid": uid,
			"date_start": event.target.dataset.date
		} */);
		timeslots.forEach(timeslot => {
			timeslot.children[0]
		});
	});
});

