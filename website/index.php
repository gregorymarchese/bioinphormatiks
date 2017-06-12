<?php include('header.php') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 main">
            <div class="jumbotron">
                <h1>Welcome to proML</h1>

                <p>proML is a tool that applies convolutional machine learning to predict the transcriptional regulatory effects of a promoter sequence.</p>
            </div>
        </div>
    </div>

    <div class="row equal">
        <div class="col-sm-12 col-md-3 main">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Run Job</h3>
                </div>

                <div class="panel-body">
                    <p class="text-center"><span class="glyphicon glyphicon-tasks large-icon" aria-hidden="true"></span</p>

                    <h3 class="text-left">Run your data against our prediction model</h3>
                </div>

                <div class="panel-footer">
                    <center>
                        <a class="btn btn-primary btn-xl" href="/run_job.php">Run Your Job</a>
                    </center>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-3 main">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Results</h3>
                </div>

                <div class="panel-body">
                    <p class="text-center"><span class="glyphicon glyphicon-cloud-download large-icon" aria-hidden="true"></span</p>

                    <h3 class="text-left">View your past proML job results on our server</h3>
                </div>

                <div class="panel-footer">
                    <center>
                        <a class="btn btn-primary btn-xl" href="/results.php">View Past Results</a>
                    </center>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-3 main">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Our Study Results</h3>
                </div>

                <div class="panel-body">
                    <p class="text-center"><span class="glyphicon glyphicon-briefcase large-icon" aria-hidden="true"></span></p>

                    <h3 class="text-left">Results from our studies of machine learning in transcriptional regulatory effects of a promoter sequence.</h3>
                </div>

                <div class="panel-footer">
                    <center>
                        <a class="btn btn-primary btn-xl" href="/our_study.php">Read Our Research</a>
                    </center>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-3 main">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Help</h3>
                </div>

                <div class="panel-body">
                    <p class="text-center"><span class="glyphicon glyphicon-question-sign large-icon" aria-hidden="true"></span></p>

                    <h3 class="text-left">Understand what we do, and how we do it</h3>
                </div>

                <div class="panel-footer">
                    <center>
                        <a class="btn btn-primary btn-xl" href="/help.php">Get Help</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>
<script>
$( document ).ready(function()
	{
		evenPanels();
	});
</script>