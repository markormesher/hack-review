<?php
require_once 'resources/_master-list.php';
?><!DOCTYPE html>
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
        <a class="navbar-brand" href="#">Brand</a>
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
                $responseId = $_GET['r'];
                $questions = Questions::getByResponseId($responseId);
                $event = Events::getByResponseId($responseId);
                if ($questions == null) {
                ?>
                <p class="text-danger">Invalid access key.</p>
                <?php
                } else {
                ?>
            <form class="form-horizontal">
                <fieldset>
                    <legend>Give feedback for <?=$event['title']; ?></legend>
           <?php
                foreach($questions as $q) {
                    switch ($q['type']) {
                        case '5star':
                            echo('<div class="form-group col-md-12">
                        <label class="control-label">' . $q['text'] . '</label>

                        <p class=margin-top-10></label><span class="star-os">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                        </p>
                    </div>');
                            break;

                    case 'longtext':
                        echo('<div class="form-group col-md-12">
                    <label class="control-label">' . $q['text'] . '</label>
                    <textarea class="form-control" rows="3" id="textArea"></textarea>
                </div>');
                        break;

                case 'shorttext':
                    echo('<div class="form-group col-md-12">
                <label class="control-label">' . $q['text'] . '</label>
                <input type="text" class="form-control">
            </div>');
                    break;
                    }
                }
                    echo('<div class="form-group col-md-12 margin-top-20">
                        <a href="#" class="btn btn-success btn-lg btn-block">Submit Review</a>
                    </div>');
                }
            ?>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>

<script type="text/javascript">


</script>

</body>
</html>
