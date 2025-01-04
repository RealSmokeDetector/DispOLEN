<?php

use App\Utils\Lang;
	$days = [
		Lang::translate(key: "MAIN_MONDAY"),
		Lang::translate(key: "MAIN_TUESDAY"),
		Lang::translate(key: "MAIN_WEDNESDAY"),
		Lang::translate(key: "MAIN_THURSDAY"),
		Lang::translate(key: "MAIN_FRIDAY"),
		Lang::translate(key: "MAIN_SATURDAY"),
		Lang::translate(key: "MAIN_SUNDAY")
	];
	$month = [
		LANG::translate(key: "MAIN_JANUARY"),
		LANG::translate(key: "MAIN_FEBRUARY"),
		LANG::translate(key: "MAIN_MARCH"),
		LANG::translate(key: "MAIN_APRIL"),
		LANG::translate(key: "MAIN_MAY"),
		LANG::translate(key: "MAIN_JUNE"),
		LANG::translate(key: "MAIN_JULY"),
		LANG::translate(key: "MAIN_AUGUST"),
		LANG::translate(key: "MAIN_SEPTEMBER"),
		LANG::translate(key: "MAIN_OCTOBER"),
		LANG::translate(key: "MAIN_NOVEMBER"),
		LANG::translate(key: "MAIN_DECEMBER")
	];
	$datenow = getdate(
		timestamp: strtotime(
			datetime: 'first day of',
			baseTimestamp: mktime(
				hour: 0,
				minute: 0,
				second: 0,
				month: date(format: 'n'),
				day: 1,
				year: date(format: 'Y')
			)
		)
	);
	$offsetDayOfWeak = $datenow['wday'];
	$currentDate = 1;
?>

<div class="calendar-container" >
	<table>
		<caption><button><</button> <?= $month[date(format: "n") - 1] . " " . date(format: "Y") ?><button>></button></caption>
		<thead>
			<tr>
				<?php foreach ($days as $day) { ?>
					<td><?= mb_substr(string: $day, start: 0, length: 3)?></td>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php if ( $offsetDayOfWeak > 0) { ?>
					<td colspan="<?= $offsetDayOfWeak - 1 ?>"></td>
				<?php } ?>
				<?php while ($currentDate <= date(format: "t")) {
						echo "<td> $currentDate </td>";
						if (($currentDate + $offsetDayOfWeak-1) % 7 === 0) {
								echo "</tr><tr>";
							}
							$currentDate++;
					}
					if (($offsetDayOfWeak + $currentDate - 1) % 7 !== 0) {
						echo "<td colspan='" . (7 - (($offsetDayOfWeak + $currentDate - 1) % 7)) . "'></td>";
					}
				?>
			</tr>
		</tbody>
	</table>
</div>
