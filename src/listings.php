<?php
require_once 'resources/_master-list.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">
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

<div id="search-section" class="row col-sm-3">

<!--start of search -->
 <div class="row search">
  
  <div class="event-googlemap">
      <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDVcWjAzc8aXs_gKWgmqn0duBFAcrFzyqs&q=<?= str_replace(' ', '+', $e['address'] . "," . $e['postcode'] . "," . $e['country']); ?>"></iframe>
  </div>
  
  <div class="event-search-title">
  	<div class="form-group">
  		<input type="text" class="form-control" id="inputEventTitle" placeholder="Event Title">
	</div>
  </div>
  
  <div class="event-search-location">
  	<div class="form-group">
		<select class="form-control" id="select">
          <option>Location</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
    </div>
  </div>
  
  <div class="event-search-date">
  	<div class="col-lg-6" style="padding-left:0px;">
        <select class="form-control" id="select">
          <option>Month</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
    </div>
        
   <div class="col-lg-6" style="padding-right:0px;">
        <select class="form-control" id="select">
          <option>Year</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
  </div>
 </div>
  
 
	<div class="event-search-rating">
  		<div class="form-group">
     		<select class="form-control" id="select">
          		<option>Rating</option>
          		<option>5 Stars</option>
          		<option>4 Stars</option>
          		<option>3 Stars</option>
          		<option>2 Stars</option>
          		<option>1 Star</option>
        	</select>
 		</div>
</div>
 </div>
<!--End of search -->

</div>

    <div id="listings-section" class="row col-sm-7">
        <div class="row">
            <h3>Listing: Hackathons in London</h3>
        </div>

        <?php
				$recent = Events::getHomepageContent();
				foreach ($recent as $e) {
        ?>
        <div class="row body">

            <div class="event-photo col-sm-6">

                <div class="event-info listing">

                    <div class="event-logo">
                        <a href="/event/<?= $e['event_id']; ?>"><img src="images/logos/<?= $e['logo_file']; ?>"></a>
                    </div>


                </div>

            </div>


            <div class="event-right col-sm-6">
                <div class="event-feedback listing">
                    <div class="event-summary">
                        <h3><a href="/event/<?= $e['event_id']; ?>"><?= $e['title']; ?></a></h3>
                        <h5><i class="fa fa-calendar"></i> <?php $startStr = date('jS M', strtotime($e['start']));
                            $endStr = date('jS M', strtotime($e['end']));
                            if ($startStr == $endStr) {
                            echo strtoupper($startStr);
                            } else {
                            echo strtoupper($startStr . ' - ' . $endStr);
                            }?></h5>
                        <h5>
                            <i class="fa fa-clock-o"></i> <?= strtoupper(date('gA', strtotime($e['start'])) . ' - ' . date('gA', strtotime($e['end']))); ?>
                        </h5>
                        <h5><i class="fa fa-map-marker"></i> <?= strtoupper($e['city'] . ' ' . $e['country']); ?></h5>
                    </div>

                    <div class="feedback-rating">
                        <?php
                        $average = Responses::getAverageScoreByEventId($e['event_id']);
                        $total = Responses::getCountByEventId($e['event_id']);
                        ?>
                        <p>
                            <span class="stars"><?= Utils::getStarString($average); ?></span>
                            <span style="color:darkgray; font-weight:bold;">(<?= $total; ?>)</span> <br/>
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
    </div>

    
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
