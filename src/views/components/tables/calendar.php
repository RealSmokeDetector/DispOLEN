<?php
	use App\Utils\Date;

	$datenow = new Date();
	$offsetDayOfWeak = $datenow->getOffsetWeek() - 1;
	$currentDate = 1;
	$tRow = 0;
?>

<div class="tile calendar" id="calendar">
	<table>
		<caption><button class="button" id="calendar_down"><i class="ri-skip-left-fill"></i></button><p><?= MONTH[$datenow->month - 1] . " " . $datenow->year ?></p><button class="button" id="calendar_up"><i class="ri-skip-right-fill"></i></button></caption>
		<thead>
			<tr>
				<?php foreach (DAYS as $day) { ?>
					<td><?= mb_substr(string: $day, start: 0, length: 3)?></td>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php for ($i=0;  $offsetDayOfWeak > $i; $i++) { ?>
				<td></td>
			<?php } ?>

			<?php do { ?>
				<td data-date="<?= $datenow->year ?>-<?= $datenow->month ?>-<?= $currentDate ?>" class="calendar-day"><?= $currentDate ?></td>
					<?php if (($currentDate + $offsetDayOfWeak) % 7 === 0) { ?>
						$tRow++; ?>
			</tr>
			<tr>
				<?php }
					$currentDate++;
				} while ($currentDate <= $datenow->getNbDayMonth());
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
