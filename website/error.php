<?php include('header.php') ?>
<?php 
	$error = array(
		"400"=>"Bad Request", 
		"401"=>"Unauthorized", 
		"403"=>"Forbidden",
		"404"=>"Resource Not Found",
		"405"=>"Method Not Allowed",
		"500"=>"Internal Server Error",
		"501"=>"Not Implemented",
		"502"=>"Bad Gateway",
		"503"=>"Service Unavailable",
		"504"=>"Gateway Timeout"
		);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 main">
            <div class="jumbotron">
                <h1>proML </h1>
                <h2>Error <?php echo($_GET['e']); ?>: <?php echo($error[$_GET['e']]); ?></h2>
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