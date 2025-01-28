<?php

	$offsetDayOfWeak = $date->getOffsetWeek();
	$offsetDayOfWeak = ($offsetDayOfWeak === 0) ? $offsetDayOfWeak + 6 : $offsetDayOfWeak - 1;
	$currentDate = 1;
	$tRow = 0;
?>

<div class="tile calendar" id="calendar">
	<div class="action">
		<button class="button" id="calendar_down"><i class="ri-skip-left-fill"></i></button>
		<p id="date_title"><?= MONTH[$date->month - 1] . " " . $date->year ?></p>
		<button class="button" id="calendar_up"><i class="ri-skip-right-fill"></i></button>
	</div>

	<table>
		<thead>
			<tr>
				<?php foreach (DAYS as $day) { ?>
					<td><?= mb_substr(string: $day, start: 0, length: 3) ?></td>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php for ($i=0; $offsetDayOfWeak > $i; $i++) { ?>
				<td></td>
			<?php } ?>

			<?php do { ?>
				<td data-date="<?= $date->year ?>-<?= $date->month ?>-<?= $currentDate ?>" class="<?= ($currentDate === $date->day) ? " selected" : "" ?>"><?= $currentDate ?></td>
				<?php
					if (($currentDate + $offsetDayOfWeak) % 7 === 0) {
						$tRow++;
				?>
			</tr>
			<tr>
				<?php }
					$currentDate++;
				} while ($currentDate <= $date->getNbDayMonth());
				for ($i = 0; (7 - ($offsetDayOfWeak + $currentDate -1) % 7) > $i; $i++) { ?>
					<td></td>
				<?php }
					$tRow++; ?>
			</tr>
			<?php for ($i = 0; 6 - $tRow > $i; $i++) { ?>
			<tr>
				<?php for ($j = 0; 7 > $j; $j++) { ?>
				<td></td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
