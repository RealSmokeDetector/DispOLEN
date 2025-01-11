// Select all elements with the class "calendar-day"
const days= document.querySelectorAll(".calendar-day");
const timeslotContainer= document.getElementById("timeslots-container");

// Loop through each "calendar-day" element
days.forEach(day => {
	day.addEventListener("click", function() {
		const date = this.getAttribute("data-date");
		showTimeSlots(date);
	});
});

// Function to generate a list of time slots
function generateTimeSlots() {
	const timeslots = [];
	let startTime = new Date();
	startTime.setHours(8,0,0,0);

	for (let i=0; i<12; i++) {
		const hours = startTime.getHours().toString().padStart(2, "0");
		const minutes = startTime.getMinutes().toString().padStart(2, "0");
		timeslots.push(hours + ":" + minutes);
		startTime.setMinutes(startTime.getMinutes()+30);
	}

	return timeslots;
}

// Function to display time slots for a given date
function showTimeSlots(date) {
	const timeSlots = generateTimeSlots();
	let html = "<ul>";
	timeSlots.forEach(timeSlot => {
		html += "<li>" + timeSlot + "</li>";
	});
	html += "</ul>";
	timeslotContainer.innerHTML = html;
	disponibility_timeslots_tile.style.display = "block";
}

