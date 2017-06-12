<?php

function randomString($length = 12)
{
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;  for ($i = 0; $i < $length; $i++)
	{
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
function getTimeStamp()
{
	return date('Y-m-d H:i:s');
}


function getPageName()
{
	$title = ucwords(str_replace("_"," ",basename(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1), '.php')));
	if($title == "Index"){$title = "Welcome";}
	return $title;
}

function getJobNumber($increment = true)
{
	$job_number = file_get_contents('config/current_job_number.var');
	if($increment)
	{
		$new_job_number = $job_number + 1;
		file_put_contents('config/current_job_number.var', $new_job_number);
	}
	return $job_number;
}

function sendMail($email, $subject, $content)
{
	$body ='
<!DOCTYPE html>
<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>UCSD Pre-Dental Society Online Store</title>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background-color: #efefef">
    	<div id="wrapper" dir="ltr" style="background-color: #efefef; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr>
<td align="center" valign="top">

                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 3px !important;">
<tr>
<td align="center" valign="top">
                                    <!-- Header -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #e95420; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;"><tr>
<td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                            	<img src="http://proml.marchese.me/images/logo-w-s.png" alt="" style="border: none; display: inline; font-size: 14px; font-weight: bold; height: auto; line-height: 100%; outline: none; text-decoration: none; text-transform: capitalize;">
                                            </td>
                                        </tr></table>
<!-- End Header -->
</td>
                            </tr>
<tr>
<td align="center" valign="top">
                                    <!-- Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body"><tr>
<td valign="top" id="body_content" style="background-color: #fdfdfd;">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%"><tr>
<td valign="top" style="padding: 48px;">
                                                            <div id="body_content_inner" style="color: #737373; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
<p style="margin: 0 0 16px;"><h2 style="color: #e95420; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; line-height: 130%; margin: 16px 0 8px; text-align: left;">
	
	'.$content.'</p>

															</div>
														</td>
                                                    </tr>
                                                    </table>
<!-- End Content -->
</td>
                                        </tr></table>
<!-- End Body -->
</td>
                            </tr>
<tr>
<td align="center" valign="top">
                                    <!-- Footer -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer"><tr>

                                        </tr></table>
<!-- End Footer -->
</td>
                            </tr>
</table>
</td>
                </tr></table>
</div>
    </body>
</html>';

	$headers  = 'From: proML Updates<proml@proml.marchese.me>'. "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	if(@mail($email,$subject,$body, $headers))
	{
		return True;
	}
	else
	{
		return False;
	}
}

?>