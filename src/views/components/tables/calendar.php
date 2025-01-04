<?php

	use App\Utils\Lang;
	use App\Utils\Date;

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

	$datenow = new Date();
	$offsetDayOfWeak = $datenow->getOffsetWeek();
	$currentDate = 1;
?>

<div class="calendar-container" >
	<table>
		<caption><button><</button> <?= $month[$datenow->__get(name: "month") - 1] . " " . $datenow->__get(name: "year") ?><button>></button></caption>
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
				<?php do { ?>
						<td><?= $currentDate ?></td>
						<?php if (($currentDate + $offsetDayOfWeak-1) % 7 === 0) { ?>
								</tr><tr>
							<?php }
							$currentDate++;
					} while ($currentDate <= $datenow->getNbDayMonth());
					if (($offsetDayOfWeak + $currentDate -1) % 7 !== 0) {?>
						<td colspan=" <?= 8 - (($offsetDayOfWeak + $currentDate - 1) % 7) ?>"></td>
					<?php }
				?>
			</tr>
		</tbody>
	</table>
</div>
