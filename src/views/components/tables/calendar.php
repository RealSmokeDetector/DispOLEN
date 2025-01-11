<?php
	use App\Utils\Date;

	$datenow = new Date();
	$offsetDayOfWeak = $datenow->getOffsetWeek() - 1;
	$currentDate = 1;
?>

<div class="tile calendar_container">
	<table>
		<caption><button><</button> <?= MONTH[$datenow->month - 1] . " " . $datenow->year ?><button>></button></caption>
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
			</tr>
			<tr>
				<?php }
					$currentDate++;
				} while ($currentDate <= $datenow->getNbDayMonth());
				for ($i = 0; (7 - ($offsetDayOfWeak + $currentDate -1) % 7) > $i; $i++) { ?>
					<td></td>
				<?php } ?>
			</tr>
		</tbody>
	</table>
</div>
