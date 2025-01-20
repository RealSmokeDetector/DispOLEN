// Select all elements with the class "calendar-day"
const calendarDays = document.querySelectorAll("#calendar tbody td");

// Loop through each "calendar-day" element
//dataset()(note pour moi a enlever)
calendarDays.forEach(day => {
	day.addEventListener("click", async function(event) {
		console.log(event.target.dataset.date);
		document.getElementById("timesolt_date").innerText = event.target.dataset.date;
		let url = "/api/reservations?uid=" + document.getElementById("disponibility_timeslots_tile").dataset.uid + "&date_start=" + event.target.dataset.date
		let toto = await callApi(url);
		console.log(await toto);
	});
});

