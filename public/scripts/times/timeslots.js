// Select all elements with the class "calendar-day"
const calendarDays = document.querySelectorAll("#calendar tbody td");

// Loop through each "calendar-day" element
calendarDays.forEach(day => {
	day.addEventListener("click", function() {
		const date = this.getAttribute("data-date");
		window.location.href = `?selected_date=${date}`;
	});
});

