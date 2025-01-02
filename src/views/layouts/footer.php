<?php
	use App\Utils\GitHub;
?>

</main>
	<footer>
		<a href="https://github.com/RealSmokeDetector" target="_blank">RealSmokeDetector <i class="ri-external-link-line"></i></a>
		<span>-</span>
		<a href="https://github.com/RealSmokeDetector/DispOLEN" target="_blank"><?= APP_NAME ?> <i class="ri-calendar-check-line"></i></a>
		<span>|</span>
		<a href="https://github.com/RealSmokeDetector/DispOLEN/tree/<?= GitHub::getCommit() ?>" target="_blank"><i class="ri-github-fill"></i> <?= GitHub::getBranch() . " #" . substr(string: GitHub::getCommit(), offset: 0, length: 7) ?></a>
	</footer>
</body>
</html>
