<?php include('header.php');  include_once('functions.php')?>

    <div class="container-fluid">
      	<div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li role="presentation" class=""><a href="#about" id="about" aria-controls="home" role="tab" data-toggle="tab">About ProML</a></li>
            <li role="presentation" class=""><a href="#references" id="references" aria-controls="home" role="tab" data-toggle="tab">References</a></li>
            <li role="presentation" class=""><a href="#interpret" id="interpret" aria-controls="home" role="tab" data-toggle="tab">Interpret ProML Codes</a></li>
          </ul>
         
        </div>

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="page-header">
  <h1>Help <small id="help_section">introduction</small></h1></div>

                <div id="help_content">
                  
                </div>
              
</div>
        </div>
      </div>
    </div>

<?php include('footer.php') ?>
<script>
    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
    {
	   $('#help_section').text($(e.target).text().toLowerCase());
	   res = 'help_content/'.concat($(e.target).attr("href").replace('#','').toLowerCase().concat('.html'));
	   $('#help_content').load(res,function(){}).fadeIn("slow");
	   document.title = 'proML - Help - '.concat($(e.target).text())
	   window.location.hash = $(e.target).attr("href")
	});
	$( document ).ready(function()
	{
		hashParse();
		
	});
	
	$(window).on('hashchange', function() {
		hashParse();
	});
	
	function hashParse()
	{
		hash = window.location.hash
		if (hash == '')
		{
			hash = '#introduction';
		}
		$('#help_section').text($(hash).text());
		$("ul.nav-sidebar li").removeClass('active')
		$(hash).closest("li").addClass('active');
		res = 'help_content/'.concat(hash).replace('#','').toLowerCase().concat('.html');
		$('#help_content').load(res,function(){}).fadeIn("slow"); 
		document.title = 'proML - Help - '.concat($(hash).text())
	}

</script>

