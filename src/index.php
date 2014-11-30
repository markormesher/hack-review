<?php
require_once 'resources/_master-list.php';
?><!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>HackReview</title>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="/css/site.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"></a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<form class="navbar-form navbar-right">
					<btn class="btn btn-grey">SIGN UP</btn>
				</form>
				<form id="search" class="navbar-form navbar-left">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input type="text" class="form-control col-lg-12" placeholder="Search&hellip;">
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="container body-content">
			<div id="top-event" class="row">
				<div class="event-photo eventheader" style="background-image: url('/images/banners/unituhack.jpg');">
					<div class="event-info col-sm-6">
						<div class="row">
							<div class="event-logo col-sm-4">
								<img src="/images/logos/unituhack.png">
							</div>
							<div class="event-summary col-sm-7">
								<h2><em>Featured:</em>&nbsp;&nbsp;UNITU&nbsp;HACK</h2>
								<h5><i class="fa fa-calendar"></i> 8TH NOV</h5>
								<h5><i class="fa fa-clock-o"></i> 8AM - 8PM</h5>
								<h5><i class="fa fa-map-marker"></i> LONDON UK</h5>
							</div>
						</div>
					</div>

					<div class="feedback-section col-sm-6">
						<div class="row">
							<div class="dark-overlay"></div>
							<?php
							$average = Responses::getAverageScoreByEventId(2);
							$total = Responses::getCountByEventId(2);
							$breakdown = Responses::getAverageQuestionScoreByEventId(2);
							?>
							<div class="event-feedback header">
								<div class="feedback-rating">
									<p>
										<span class="stars" style="font-size:200%;"><?= Utils::getStarString($average); ?></span>
										<span class="feedback-count">(<?= $total; ?>)</span>
									</p>
								</div>
								<div class="feedback-rating">
									<table class="feedback-summary">
										<?php
										for ($i = 0; $i < count($breakdown); $i += 2) {
											$q1 = Questions::getById($breakdown[$i]['question_id']);
											$q2 = Questions::getById($breakdown[$i + 1]['question_id']);
											echo('<tr><td class="group">' . $q1['summary'] . '</td><td>' . Utils::getStarString($breakdown[$i]['average_score']) . '</td><td class="pad">&nbsp;</td><td class="group">' . $q2['summary'] . '</td><td>' . Utils::getStarString($breakdown[$i + 1]['average_score']) . '</td></tr>');
										}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div id="listings-section" class="row">
				<div class="row">
					<h3>Recent Hackathons the UK</h3>
				</div>

				<?php
				$recent = Events::getHomepageContent();
				foreach ($recent as $e) {
					?>
					<div class="row body">
						<div class="event-photo col-sm-6">
							<div class="event-info col-sm-6">
								<br/>
								<div class="event-logo">
									<a href="/event/<?= $e['event_id']; ?>"><img src="images/logos/<?= $e['logo_file']; ?>"></a>
								</div>
							</div>
							<div class="event-summary col-sm-6">
								<h3><?= $e['title']; ?></h3>
								<h5>
									<i class="fa fa-calendar"></i> <?php
									$startStr = date('jS M', strtotime($e['start']));
									$endStr = date('jS M', strtotime($e['end']));
									if ($startStr == $endStr) {
										echo strtoupper($startStr);
									} else {
										echo strtoupper($startStr . ' - ' . $endStr);
									}
									?>
								</h5>
								<h5>
									<i class="fa fa-clock-o"></i> <?= strtoupper(date('gA', strtotime($e['start'])) . ' - ' . date('gA', strtotime($e['end']))); ?>
								</h5>
								<h5>
									<i class="fa fa-map-marker"></i> <?= strtoupper($e['city'] . ' ' . $e['country']); ?>
								</h5>
							</div>
						</div>

						<div class="event-right col-sm-6">
							<div class="event-feedback">
								<div class="feedback-rating">
									<?php
									$average = Responses::getAverageScoreByEventId($e['event_id']);
									$total = Responses::getCountByEventId($e['event_id']);
									?>
									<p>
										<strong class="feedback-info">Overall Score:</strong><br/>
										<span class="stars" style="font-size:300%;"><?= Utils::getStarString($average); ?></span>
										<span class="feedback-count">(<?= $total; ?>)</span> <br/>
										<a href="/event/<?=$e['event_id']; ?>" class="feedback-info">&raquo; Detailed Feedback</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
				?>

			</div>
		</div>

		<div class="row text-center" style="margin-bottom:150px;">
			<button class="btn btn-lg btn-danger">SEE MORE HACKATHONS</button>
		</div>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>
