function evenPanels()
{
    var heights = [];                           // make an array
    $(".panel-body").each(function(){           // copy the height of each
        heights.push($(this).height());         //   element to the array
    });
    heights.sort(function(a, b){return b - a}); // sort the array high to low
    var minh = heights[0];                      // take the highest number    
    $(".panel-body").height(minh);              // and apply that to each element
}
/*

$(function (){

	// To prevent Browsers from opening the file when its dragged and dropped on to the page
	$(document).on('drop dragover', function (e) {
        e.preventDefault();
    }); 
    
    $( "#upl_button" ).click(function(e) {
		fileUpload(e);
	});

	// Add events
	$('input[type=file]').on('change', fileUpload);

	// File uploader function

	function fileUpload(event){  
		$("#status_text").html("<p>"+event.target.value+" uploading...</p>");
		files = event.target.files;
		var data = new FormData();
		var error = 0;
		$('#myModal').modal('show');
	 	if(!error){
		 	var xhr = new XMLHttpRequest();
		 	alert('run');
		 	xhr.open('POST', '/upload.php', true);
		 	xhr.send(data);
		 	xhr.onload = function () {
				if (xhr.status === 200) {
					$("#drop-box").html("<p> File Uploaded. Select more files</p>");
				} else {
					$("#drop-box").html("<p> Error in upload, try again.</p>");
				}
			};
		}
	}

});
*/