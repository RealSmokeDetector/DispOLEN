const reservationTime = document.getElementById("reservation_time");
const slots = document.querySelectorAll("#reservations");
const startTime = document.getElementById("start_time");
const endTime = document.getElementById("end_time");
const uidUser = document.getElementById("uid_user").value;
const validate = document.getElementById("add_availability");

slots.forEach(slot => {
	slot.addEventListener("click", () => {
		const startHour = slot.dataset.hour;

		startTime.value = startHour.toString().padStart(2, '0') + ":00"; // Format HH:mm;
		endTime.value = (parseInt(startHour) + 1).toString().padStart(2, '0') + ":00";
		reservationTime.style.display = "flex";

		const startDate = Date.parse(`${slot.dataset.day} ${slot.dataset.hour}:00.000`);
		const endDate = Date.parse(`${slot.dataset.day} ${slot.dataset.hour}:00.000`);

		validate.addEventListener("click", () => {
			callApi("/api/reservation", "put", {
				"uid_user": uidUser,
				"date_start": startDate,
				"date_end": endDate
			});
		});
	});
});
