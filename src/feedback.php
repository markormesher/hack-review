<?php
require_once 'resources/_master-list.php';
$responseId = $_GET['r'];
$questions = Questions::getByResponseId($responseId);
$status = Responses::getStatusById($responseId);
$event = Events::getByResponseId($responseId);

// handle form
$formSent = false;
$formError = false;
if (isset($_POST) && isset($_POST['sent']) && $status == 'open') {
	$output = array();
	foreach ($_POST as $key => $value) {
		if (substr($key, 0, 1) == 'q') {
			if (is_numeric($value) && ($value < 0 || $value > 5)) {
				$formError = true;
				break;
			}
			$id = substr($key, 1);
			$output[$id] = $value;
		}
	}
	if (!$formError) {
		$formSent = true;
		Responses::send($responseId, $output);
	}
}
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $event == null ? 'Error' : $event['title']; ?></title>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="/css/site.css" rel="stylesheet">
		<link href="/css/five-star.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-default" style="margin-bottom: 15px;">
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

		<div class="body-content container">
			<div id="logo-section" class="row">

			</div>

			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 well">
					<?php
					if ($formError) {
						echo('<p class="text-danger">All star ratings must be completed.</p>');
					}
					if ($formSent) {
						echo('<p class="text-success">Thank you for your feedback!</p>');
					} elseif ($questions == null) {
						echo('<p class="text-danger">Invalid access key.</p>');
					} elseif ($status == 'closed') {
						echo('<p class="text-danger">Sorry, access links are single-use only.</p>');
					}
					else {
					?>
					<form class="form-horizontal" action="/r/<?= $responseId; ?>" method="post">
						<input type="hidden" name="sent" value="1"/>
						<fieldset>
							<legend>Give feedback for <?= $event['title']; ?></legend>
							<?php
							$blockingForDemo = true;
							if (substr($responseId, 0, 4) == 'oxhk' && $blockingForDemo) {
								echo('<p class="text-info">Submissions for OxHack will open soon! Be patient...</p>');
							} else {
								foreach ($questions as $q) {
									switch ($q['type']) {
										case '5star':
											echo('<div class="form-group col-md-12">
											<label class="control-label">' . $q['text'] . '</label>
											<div class="margin-top-10">
											<input type="hidden" name="q' . $q['question_id'] . '" class="replace-five-star" value="-1" />
											</div>
											</div>');
											break;

										case 'longtext':
											echo('<div class="form-group col-md-12">
											<label class="control-label">' . $q['text'] . '</label>
											<textarea class="form-control" rows="3" name="q' . $q['question_id'] . '"></textarea>
											</div>');
											break;

										case 'shorttext':
											echo('<div class="form-group col-md-12">
											<label class="control-label">' . $q['text'] . '</label>
											<input type="text" class="form-control" name="q' . $q['question_id'] . '" />
											</div>');
											break;
									}
								}

								echo('<div class="form-group col-md-12 margin-top-20"><button type="submit" class="btn btn-success btn-lg btn-block">Submit Review</button></div>');
							}
							}
							?>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.js"></script>
		<script type="text/javascript" src="/js/five-star.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				FiveStar.init();
			});
		</script>
	</body>
</html>
