<?php
	include('functions.php');
	$job_number = getJobNumber();
	$job_config = 'job_config/job_'.$job_number.'.json';
	
	$submitter = $_POST['submitter_name'];
	$email = $_POST['email'];
	$study = $_POST['study_name'];
	$epochs = $_POST['epochs'];
	$run_start_time = getTimeStamp();

	$res = array(
		'job_number'=>$job_number,
		'submitter_name' => $submitter,
		'email' => $email,
		'study_name' => $study,
		'epochs' => $epochs,
		'status'=>'data_upload',
		'run_start' => $run_start_time,
		'run_end' => '',
		'run_expiration' => date('Y-m-d H:i:s', strtotime("+7 day", strtotime($run_start_time))),
		'job_type' => 'untrained',
		);
	file_put_contents($job_config , json_encode($res));
	
	$tp_status = False;
	$ta_status = False;
	$fs_status = False;
	$ps_status = False;
	$pa_status = False;
	

	$training_promoters = 'training_promoter_sequences/'.$job_number.'.fasta';
	if(!empty($_FILES['training_promoters']['name']))
	{
	    if(copy($_FILES['training_promoters']['tmp_name'], $training_promoters))
	    {
		    $tp_status = True;
		}
	    else
	    {
			$tp_status = False;
	    }
  	}
  	
  	
  	
  	$training_activities = 'training_promoter_activities/'.$job_number.'.tsv';
	if(!empty($_FILES['training_activities']['name']))
	{
	    if(copy($_FILES['training_activities']['tmp_name'], $training_activities))
	    {
		    $ta_status = True;
		}
	    else
	    {
			$ta_status = False;
	    }
  	}

  	$flanking_sequences = 'training_flanking_sequences/'.$job_number.'.fasta';
	if(!empty($_FILES['flanking_sequences']['name']))
	{
	    if(copy($_FILES['flanking_sequences']['tmp_name'], $flanking_sequences))
	    {
		    $fs_status = True;
		}
	    else
	    {
			$fs_status = False;
	    }
  	}  	
  	
  	
  	
  	
  	$promoter_sequences = 'promoter_sequences/'.$job_number.'.fasta';
	if(!empty($_FILES['run_promoters']['name']))
	{
	    if(copy($_FILES['run_promoters']['tmp_name'], $promoter_sequences))
	    {
		    $ps_status = True;
		}
	    else
	    {
			$ps_status = False;
	    }
  	}
  	
  	
  	
  	
  	
  	
  	$promoter_activities = 'promoter_activities/'.$job_number.'.tsv';
  	if(!empty($_FILES['run_activities']['name']))
	{
	    if(copy($_FILES['run_activities']['tmp_name'], $promoter_activities))
	    {
		    $pa_status = True;
		}
	    else
	    {
			$pa_status = False;
	    }
  	}
  	

  	
  	if($tp_status && $ta_status && $fs_status && $ps_status && $pa_status)
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
		$command = 'load_data.py -j '.$job_number.' -i '.$training_promoters.' -f '.$flanking_sequences.' -a '.$promoter_activities.' -t '.$promoter_sequences.' -y '.$training_activities.' -e '. $epochs;
		exec('nohup python3 '.$command.' > /dev/null 2>&1 &');
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