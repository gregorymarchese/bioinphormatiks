<?php
	include('functions.php');
	$job_number = getJobNumber();
	$job_config = 'job_config/job_'.$job_number.'.json';
	
	$submitter = $_POST['submitter_name'];
	$email = $_POST['email'];
	$study = $_POST['study_name'];
	$run_start_time = getTimeStamp();

	$res = array(
		'job_number'=>$job_number,
		'submitter_name' => $submitter,
		'email' => $email,
		'study_name' => $study,
		'status'=>'data_upload',
		'run_start' => $run_start_time,
		'run_end' => '',
		'run_expiration' => date('Y-m-d H:i:s', strtotime("+7 day", strtotime($run_start_time))),
		'job_type' => 'pretrained',
		);
	file_put_contents($job_config , json_encode($res));
	
	$ps_status = False;
	

	$promoter_sequences = 'promoter_sequences/'.$job_number.'.fasta';
	if(!empty($_FILES['rp']['name']))
	{
	    if(copy($_FILES['rp']['tmp_name'], $promoter_sequences))
	    {
		    $ps_status = True;
		}
	    else
	    {
			$ps_status = False;
	    }
  	}
  	

  	
  	if($ps_status)
  	{
  		$res = array(
		'job_number'=>$job_number,
		'submitter_name' => $submitter,
		'email' => $email,
		'study_name' => $study,
		'status'=>'queued',
		'run_start' => $run_start_time,
		'run_end' => '',
		'run_expiration' => date('Y-m-d H:i:s', strtotime("+7 day", strtotime($run_start_time))),
		);
		
		file_put_contents($job_config , json_encode($res));
		$flanking_sequences = 'config/pretrained_flanking_seqs.fasta';
 		$command = 'load_data.py -j '.$job_number.' -f '.$flanking_sequences.' -t '.$promoter_sequences;
		exec('nohup python3 '.$command.' > terminal_output/'.$job_number.'.txt 2>&1 &');
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/interstitial.php?ID='.$job_number);
  	}
  	else
  	{
  		$res = array(
		'job_number'=>$job_number,
		'submitter_name' => $submitter,
		'email' => $email,
		'study_name' => $study,
		'status'=>'failed',
		'run_start' => $run_start_time,
		'run_end' => '',
		'run_expiration' => date('Y-m-d H:i:s', strtotime("+7 day", strtotime($run_start_time))),
		);
		file_put_contents($job_config , json_encode($res));
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/interstitial.php?ID='.$job_number);
  	}
  
  
	
?>