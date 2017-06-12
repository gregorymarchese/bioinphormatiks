<?php include('header.php');  include_once('functions.php')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 main">
            <div class="page-header">
                <h1>Run Job <small>get your results</small></h1>
            </div>

            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >Option 1: Use Pre-Trained Model & Run Job </a></h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
	                        <form action="pretrained_exec.php" method="post" enctype="multipart/form-data" class="form-horizontal">
								<div class="panel panel-default">
			                    <div class="panel-heading">Job Information</div>
		                        <div class="panel-body">
								<div class="form-group">
									<label for="submitter" class="col-sm-3 control-label">Submitter:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="submitter" placeholder="Name" name="submitter_name">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-3 control-label">Email:</label>
									<div class="col-sm-9">
										<input type="email" class="form-control" id="email" placeholder="Email" name="email">
									</div>
								</div>
								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Study Name:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="study" placeholder="Name" name="study_name">
									</div>
								</div>
		                        </div>
		                        </div>
		                        
		                        <div class="panel panel-default">
			                    <div class="panel-heading">Job Files</div>
		                        <div class="panel-body">
  								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Promoter Sequences (FASTA):</label>
									<div class="col-sm-9">
										<input type="file" id="rp" name="rp" class="form-control">
  									</div>
  								</div>
  					
  								</div>
  								</div>
  								
  								<br />
								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-9">
										<button type="submit" class="btn btn-primary btn-block" id="upl_button">Input & Run Job</button>
  									</div>
  								</div>
	                        </form>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true">Option 2: Train Our Model & Run Job</a></h4>
                    </div>

                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
	                        <form action="train_exec.php" method="post" enctype="multipart/form-data" class="form-horizontal">
		                        <div class="panel panel-default">
			                    <div class="panel-heading">Job Information</div>
		                        <div class="panel-body">
								<div class="form-group">
									<label for="submitter" class="col-sm-3 control-label">Submitter:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="submitter" placeholder="Name" name="submitter_name">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-3 control-label">Email:</label>
									<div class="col-sm-9">
										<input type="email" class="form-control" id="email" placeholder="Email" name="email">
									</div>
								</div>
								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Study Name:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="study" placeholder="Name" name="study_name">
									</div>
								</div>
		                        </div>
		                        </div>
		                        
		                        
		                        <div class="panel panel-default">
			                    <div class="panel-heading">Job Variables</div>
		                        <div class="panel-body">

								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Training Epochs:</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" id="epochs" placeholder="0" name="epochs">
									</div>
								</div>
								</div>
		                        </div>
		                        
		                        <div class="panel panel-default">
			                    <div class="panel-heading">Job Files</div>
		                        <div class="panel-body">
								
								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Training Sequences (FASTA):</label>
									<div class="col-sm-9">
										<input type="file" id="upl" name="training_promoters" class="form-control">
  									</div>
  								</div>
  								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Training Activities (TSV):</label>
									<div class="col-sm-9">
										<input type="file" id="upl" name="training_activities" class="form-control">
  									</div>
  								</div>
  								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Flanking Sequences (FASTA):</label>
									<div class="col-sm-9">
										<input type="file" id="upl" name="flanking_sequences" class="form-control" />
  									</div>
  								</div>
  								
								
								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Promoter Sequences (FASTA):</label>
									<div class="col-sm-9">
										<input type="file" id="upl" name="run_promoters" class="form-control">
  									</div>
  								</div>
  								
  								<div class="form-group">
									<label for="job" class="col-sm-3 control-label">Promoter Activities (TSV):</label>
									<div class="col-sm-9">
										<input type="file" id="upl" name="run_activities" class="form-control">
  									</div>
  								</div>
  								</div>
		                        </div>
  								
  								
  								
  								<br />
  								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-9">
										<button type="submit" class="btn btn-primary btn-block" id="upl_button">Upload & Run Job</button>
  									</div>
  								</div>
  								
  							<form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">FASTA Upload Status</h4>
      </div>
      <div class="modal-body"><center>
	      	<p class="text-center">
		      <span class="glyphicon glyphicon-ok large-icon hidden" aria-hidden="true" id="result_good"></span>
		      <span class="glyphicon glyphicon-remove large-icon hidden" aria-hidden="true" id="result_bad"></span>
			  <img src="images/load.gif" id="result_progress" />	      
			</p>
        <div class="upload-icon pull-center"></div>
        <h1 id="status_text"></h1></center>
      </div>
    </div>
  </div>
</div>