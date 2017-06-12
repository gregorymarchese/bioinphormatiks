<?php
	include('functions.php');
	$job_number = $_GET['ID'];
	$filename = 'job_config/job_'.$job_number.'.json';
	$json = file_get_contents($filename);
	$job = json_decode($json,true);
	
	$content = 'Your job status has updated';
	switch ($_GET['STATUS'])
	{
	    case 'not_found':
			$content = 'Your job has not been submitted to the proML cluster.';
			break;
		case 'data_upload':
			$content = 'Your job data is being uploaded from the user.';
			break;
		case 'queued':
			$content = 'Your job has been submitted for processing.';
			break;
		case 'model_train':
			$content = 'Your job is currently training model.';
			break;
		case 'job_execute':
			$content = 'Your job is executing against trained model.';
			break;
		case 'closing':
			$content = 'Your job data is being written to storage.';
			break;
		case 'complete':
			$content = 'Your job results are available.';
			break;
		case 'failed':
			$content = 'Your job did not complete successfully.';
			break;
		default:
			$content = 'Your job status is inconclusive.';
			break;
	}
	
	$body = 'Hi '.$job['submitter_name'].',<br /><br />'.$content;
	
	if (sendMail($job['email'], 'proML job Status: '. $_GET['STATUS'], $body))
	{
		echo ('True');
	}
	else
	{
		echo ('False');
	}
	
?>