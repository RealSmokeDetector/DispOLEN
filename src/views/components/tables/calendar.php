<?php
	use App\Utils\Date;

	$datenow = new Date();
	$offsetDayOfWeak = $datenow->getOffsetWeek() - 1;
	$currentDate = 1;
?>

<div class="calendar_container">
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
			<?php if ( $offsetDayOfWeak > 0) { ?>
				<td colspan="<?= $offsetDayOfWeak ?>"></td>
			<?php } ?>

			<?php do { ?>
					<td><?= $currentDate ?></td>
					<?php if (($currentDate + $offsetDayOfWeak) % 7 === 0) { ?>
			</tr>
			<tr>
				<?php }
					$currentDate++;
				} while ($currentDate <= $datenow->getNbDayMonth());

				if (($offsetDayOfWeak + $currentDate -1) % 7 !== 0) { ?>
					<td colspan=" <?= 7 - (($offsetDayOfWeak + $currentDate - 1) % 7) ?>"></td>
				<?php } ?>
			</tr>
		</tbody>
	</table>
</div>
