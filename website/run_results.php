<?php include('header.php') ?>
<?php
	$job_number = $_GET['ID'];
	$filename = 'job_config/job_'.$job_number.'.json';
	$tsv = 'output_tsv/job_'.$job_number.'.tsv';
	$json = file_get_contents($filename);
	$job = json_decode($json,true);
	$training_output = 'http://proml.marchese.me/training_output/'.$job_number.'.tsv';
	$promoter_output = 'http://proml.marchese.me/promoter_output/'.$job_number.'.tsv'
?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-md-3 sidebar">
          <div class="">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Job Information</h3>
					</div>
					<div class="panel-body">
						<table class="table table-condensed " id="job_info">
							<tr>
								<td>JOB NUMBER:</td>
								<td><?php echo($job['job_number']); ?></td>
							</tr>
							<tr>
								<td>JOB STATUS:</td>
								<td><?php echo($job['status']); ?></td>
							</tr>
							<tr>
								<td>SUBMITTER:</td>
								<td><?php echo($job['submitter_name']); ?></td>
							</tr>
							<tr>
								<td>STUDY NAME:</td>
								<td><?php echo($job['study_name']); ?></td>
							</tr>
							<tr>
								<td>RUN START:</td>
								<td><?php echo($job['run_start']); ?></td>
							</tr>
							<tr>
								<td>RUN END:</td>
								<td><?php echo($job['run_end']); ?></td>
							</tr>
							<tr>
								<td>EXPIRATION:</td>
								<td><?php echo($job['run_expiration']); ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="">
				<div class="panel panel-primary hidden-print">
					<div class="panel-heading">
						<h3 class="panel-title">Download Results</h3>
					</div>
					<div class="panel-body">
					<?php if($job['run_expiration'] == 'pretrained') { ?>
						<a href="/job_config/job_<?php echo($job_number)?>.json" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Run JSON</a>
						<a href="/promoter_sequences/<?php echo($job_number)?>.fasta" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Sequence Input</a>
						<a href="/promoter_activities/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Activity Input</a>
						<a href="/training_output/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Loss Function Output</a>
						<a href="/promoter_output/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Predictions</a>
					<?php } else { ?>
						<a href="/job_config/job_<?php echo($job_number)?>.json" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Run JSON</a>
						<a href="/training_promoter_sequences/<?php echo($job_number)?>.fasta" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Training Promoter Sequence Input</a>
						<a href="/training_promoter_activities/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Training Promoter Activity Input</a>
						<a href="/training_flanking_sequences/<?php echo($job_number)?>.fasta" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Training Flanking Sequence Input</a>
						<a href="/promoter_sequences/<?php echo($job_number)?>.fasta" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Sequence Input</a>
						<a href="/promoter_activities/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Activity Input</a>
						<a href="/training_output/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Loss Function Output</a>
						<a href="/promoter_output/<?php echo($job_number)?>.tsv" class="btn btn-default btn-block btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Promoter Predictions</a>
					<?php } ?>
					</div>
				</div>
			</div>
        </div>
        <div class="col-xs-12 col-md-9 col-md-offset-3 main">
          <h1 class="page-header">Run Results</h1>
          
          <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Training Data Loss</h3>
  </div>
  <div class="panel-body">
  <div id="training_graph" class="panel-body" style="width: 100%; height: 600px;" ></div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Promoter Regulatory Effects</h3>
  </div>
  <div class="panel-body">
  <div id="promoter_graph" class="panel-body" style="width: 100%; height: 600px;" ></div>
  </div>
</div>
          
        </div>
      </div>
    </div>

<?php include('footer.php'); ?>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>




var training_graph = Plotly.d3.tsv("<?php echo($training_output); ?>", function(data) 
{
	var layout = {
    title: 'Training Data Loss',
    showlegend: false,
    xaxis: {
    title: 'Loss'
  	},
  	yaxis: {
    title: 'Epoch'
  	}
};

	var xarr = [], yarr = [];

	for (var i=0; i<data.length; i++) {
		row = data[i];
		xarr.push( row['epoch'] );
		yarr.push( row['loss'] );
	}
	var trace1 = 
	{
	  x: xarr,
	  y: yarr,
	  type: 'line',
	  marker: {
	    color: 'rgb(233, 84, 32)',
	    opacity: 0.6,
	    text: xarr,
	    line: {
	      color: 'rgb(211, 70, 21)',
	      width: 1.5
	    }
	  }
	};
	data = [trace1];

	Plotly.newPlot('training_graph', data, layout, {displaylogo: false, showLink: false});
});

var promoter_graph = Plotly.d3.tsv("<?php echo($promoter_output); ?>", function(data) 
{
	var layout = {
    title: 'Promoter Regulator Effect',
    showlegend: false,
    xaxis: {
    title: 'Promoter'
  	},
  	yaxis: {
    title: 'Regulatory Effect'
  	}
};

	var xarr = [], yarr = [];

	for (var i=0; i<data.length; i++) {
		row = data[i];
		xarr.push( row['epoch'] );
		yarr.push( row['loss'] );
	}
	var trace1 = 
	{
	  x: xarr,
	  y: yarr,
	  type: 'bar',
	  marker: {
	    color: 'rgb(233, 84, 32)',
	    opacity: 0.6,
	    text: xarr,
	    line: {
	      color: 'rgb(211, 70, 21)',
	      width: 1.5
	    }
	  }
	};
	data = [trace1];

	Plotly.newPlot('promoter_graph', data, layout, {displaylogo: false, showLink: true});
});


</script>
<style>
	.btn{
		text-align: left;
	}
