<?php include('header.php'); ?>
<?php 
$jobs = scandir('job_config/');
unset($jobs[1]);
unset($jobs[0]);
?>

    <div class="container-fluid">
      	<div class="row">
        

		<div class="col-sm-12 main">
          <div class="page-header">
  <h1>Job Results <small>all jobs processed</small></h1>
</div>
          <div class="table-responsive">
            <table class="table table-striped table-condensed table-hover" id="results_table">
              <thead>
                <tr>
                  <th>Job Number</th>
                  <th>Config File</th>
                  <th>Results</th>
                </tr>
              </thead>
              <tbody>
			  
			  <?php foreach ($jobs as &$job) { ?>
                <tr>
	                <td><?php 
	                  $suffix = str_replace('job_', '', $job);
	                  $job_number = str_replace('.json', '', $suffix);
	                  echo($job_number); ?>
	                  </td>
                  <td>
	                  <?php echo($job); ?>
                  </td>
                  
                  <td><a class="btn btn-primary btn-xs" href='/run_results.php?ID=<?php echo($job_number); ?>'>Results<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </a></td>
                </tr>
               <?php } ?>
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<?php include('footer.php') ?>;
<script type="text/javascript">
	jQuery(document).ready(function() {
    jQuery('#results_table').DataTable();
} );
	</script>
