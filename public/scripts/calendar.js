const days = [
	'Monday',
	'Tuesday',
	'Wednesday',
	'Thursday',
	'Friday',
	'Saturday',
	'Sunday'
];
const months = [
	'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December'
];

let buttons = [];
const date = new Date();
let offSetSet = 0;

document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.calendar_container button').forEach((element) => {
		buttons.push(element);
	});

	buttons.forEach((element) => {
		element.addEventListener('click', function(event) {
			console.log(event.target.id);
			switch (event.target.id) {
				case 'calendar_up':
					modifMounth(1);
					changeDateNb();
					break;
				case 'calendar_down':
					modifMounth(-1);
					break;
			}
		});
	});
});

function modifMounth(scale) {
	date.setMonth(date.getMonth() + scale);
	offSetSet += scale;
	changeDate();
}

function changeDate() {
	captionCalendar = document.querySelector('.calendar_container caption');
	console.log("attribute",captionCalendar.getAttribute('data-content'));
	changeDateNb();
	console.log(date);
}

function changeDateNb() {
	document.querySelector( '.calendar_container caption p' ).textContent = months[ date.getMonth() ] + ' ' + date.getFullYear();

	let iteration = 1;
	let NbDateMounth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
	document.querySelectorAll('.calendar_container tbody td').forEach((element, index) => {
		if ( index >= date.getDay() + 1 && iteration <= NbDateMounth ) {
			element.textContent = iteration;
			iteration++;
		} else {
			element.textContent = '';
		}
	});
}
