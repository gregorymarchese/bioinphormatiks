<?php include('header.php') ?>
<?php
	$job_number = $_GET['ID'];
	$filename = 'job_config/job_'.$job_number.'.json';
	$json = file_get_contents($filename);
	$job = json_decode($json,true);
	$js_filename = 'http://'.$_SERVER['HTTP_HOST'].'/'.$filename;
	$results_url = 'http://'.$_SERVER['HTTP_HOST'].'/run_results.php?ID='.$job_number;

?>
<style>
#title
{
	position: absolute;
	text-align: center;
	top: 50%;
	left: 50%;
	-webkit-transform: translate3d(-50%,-50%,0);
	transform: translate3d(-50%,-50%,0);
}
</style>

<div class="container-fluid">
	<div class="well" id='title'>
<h1><b>EXECUTING JOB: </b><?php echo($job['job_number']); ?></h1>
<hr />
<h3 id="status"></h3>
</div>

<canvas id="canvas"></canvas>
</div>
<?php include('footer.php') ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'></script>
<script src='js/nw.js'></script>
<script>
function loadJSON()
{
    $(function() {
        $.getJSON("<?php echo($js_filename); ?>",
        function(json)
        {
	        $( "#status" ).html(json.status);
	        console.log(json.status)
	        if(json.status == 'complete')
	        {
		        window.location = '<?php echo($results_url); ?>';
	        }
        });
    });
}
jQuery(document).ready(function() {
	loadJSON();
    setInterval(loadJSON, 5*1000);
} );

</script>