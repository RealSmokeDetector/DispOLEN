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
		html += "<li class=\"timeslot\" data-time=\"" + date + " " + timeSlot + "\">" + timeSlot + "</li>";
	});
	html += "</ul>";
	timeslotContainer.innerHTML = html;
	disponibility_timeslots_tile.style.display = "block";
	document.querySelectorAll(".timeslot").forEach(timeslot => {
		timeslot.addEventListener("click", function() {
			const selectedtTime = this.getAttribute("data-time");
			if (!startTime) {
				startTime = selectedtTime;
				this.style.backgroundColor = "green";
			}
			else{
				endTime = selectedtTime;
				this.style.backgroundColor = "green";
				saveDisponibility(startTime, endTime);
				//reset timeslot to allow new selection
				startTime = null;
				endTime = null;

			}
		})
	});

// Function to save disponibility
	async function saveDisponibility(startTime, endTime) {
		const userUid = $_SESSION["user"]["uid"];
		if (!userUid || !startTime || !endTime) {
		console.log("Missing data");
		return;
		}

		try {
		await callApi("/disponibility", "POST", {
			uid_user: userUid,
			start_time: startTime,
			end_time: endTime
		});
		alert("Disponibility saved");
		} catch (error) {
		console.error(error);
		alert("An error occurred");
		}
	}
}
