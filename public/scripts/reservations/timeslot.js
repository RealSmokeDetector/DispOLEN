const reservationTime = document.getElementById("reservation_time");
const reservationTimeStudent = document.getElementById("student_reservation_time");
const slots = document.querySelectorAll("#reservations");
const startTime = document.getElementById("start_time");
const endTime = document.getElementById("end_time");
const uidUser = document.getElementById("uid_user");
const validate = document.getElementById("add_availability");

if (
	isElementExist(reservationTime)
	|| isElementExist(reservationTimeStudent)
) {
	slots.forEach(slot => {
		if (isElementExist(reservationTime)) {
			slot.classList.add("availability_teacher");
		}

		if (isElementExist(reservationTimeStudent)) {
			slot.classList.add("availability_student");
		}

		slot.addEventListener("click", () => {
			const startHour = slot.dataset.hour;

			startTime.value = startHour.toString().padStart(2, '0') + ":00"; // Format HH:mm;
			endTime.value = (parseInt(startHour) + 1).toString().padStart(2, '0') + ":00";
			if (isElementExist(reservationTime)) {
				reservationTime.style.display = "flex";
			}

			const startDate = Date.parse(`${slot.dataset.day} ${startTime.value}`) /1000 ;
			const endDate = Date.parse(`${slot.dataset.day} ${endTime.value}`) /1000 ;

			validate.addEventListener("click", () => {
				callApi("/api/reservation", "put", {
					"uid_user": uidUser.value,
					"date_start": startDate,
					"date_end": endDate
				});
			});
		});
	});
}
