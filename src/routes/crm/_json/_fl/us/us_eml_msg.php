<?php 
use App\GmailEmail;

$client_id = '716813558474-jpfi9sg9kagtkmb7gfmcguerglv7blrm.apps.googleusercontent.com';
$client_secret = 'qy3P0LxY5iC3sEAGSMn06T04';
$redirect_uri = DMN_OAUTH.'google/';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setAccessType('offline');
$client->setRedirectUri($redirect_uri);
$client->addScope("https://mail.google.com/");
$client->addScope("https://www.googleapis.com/auth/gmail.readonly");
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');

$authUrl = $client->createAuthUrl();

$__code = Php_Ls_Cln($_GET['code']);
$__cl = Php_Ls_Cln($_GET['_cl']);
$__us = Php_Ls_Cln($_GET['_us']);
$__eml = Php_Ls_Cln($_GET['_eml']);

//-------------- --------------//
	
	if($__cl != ''){ $_SESSION['oauth_cl'] = $__cl; $_rdrc = 'ok'; }
	if($__us != ''){ $_SESSION['oauth_us'] = $__us; $_rdrc = 'ok'; }
	if($__eml != ''){ $_SESSION['oauth_eml'] = $__eml; $_rdrc = 'ok'; }	  
	   
	if($_rdrc == 'ok'){ 
	  header("Location: /google/?".Gn_Rnd(20) );
	  die();
	}
	
	if(isset($_SESSION['oauth_cl']) && isset($_SESSION['oauth_us'])){
		$__cl = GtClDt($_SESSION['oauth_cl'], 'enc');
		$__us = GtUsDt($_SESSION['oauth_us'], 'enc');
		$__ustkn = _gapi_tkn_chk([ 'cl'=>$__cl->id, 'us'=>$__us->id ]);
	}
	
//-------------- --------------//


if ($__ustkn->cod != NULL) {

	
	try{
		
	  	$client->setAccessToken( $__ustkn->cod->cod );
	  	
	  	
	 	if($client->isAccessTokenExpired()){ 
		 	echo h1('TOKEN EXPIRED'); 
		 	header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
		}
	 	
		
	  
	  	$gmail = new Google_Service_Gmail($client);
		$box = $gmail->users->getProfile('me');
		
		echo h2('GMAIL');

	} catch (Exception $e) {
	    echo $e->getMessage();
	}
	
	
	try{
	   		
	   		$list = $gmail->users_messages->listUsersMessages('me', ['maxResults' => 10]);
	   		
	
	        foreach ($list as $mlist) {
	
	            $message_id = $mlist->id;	            
	            
	            $single_message = $gmail->users_messages->get('me', $message_id);
	            
	            $message_snippet = $single_message->snippet;
	            $headers = $single_message->getPayload()->getHeaders();
	            
	            //print_r($headers);
	            
				foreach($headers as $single){
		            if ($single->getName() == 'Subject') {
		                $message_subject = $single->getValue();
		            }elseif($single->getName() == 'Reply-To') {
		                $message_rplyto = str_replace('"', '', $single->getValue());
		            }elseif($single->getName() == 'Date') {
		                $message_date = $single->getValue();
		                $message_date = date('M jS Y h:i A', strtotime($message_date));
		            }elseif($single->getName() == 'From') {
		                $message_sender = $single->getValue();
		                $message_sender = str_replace('"', '', $message_sender);
		            }
		        }

	            
	            
	            
	            echo 	h1('Sender:'.$message_sender).
	            		h2('Subject:'.$message_subject).
	            		$message_date.HTML_BR.
	            		$message_id.HTML_BR.
	            		'Reply to:'.$message_rplyto.HTML_BR.	
	            		$message_snippet.HTML_BR.HTML_BR;
	            
				$payload = $single_message->getPayload();
	            
	            $parts = $payload->getParts(); //print_r($payload);

	            echo HTML_BR.HTML_BR.HTML_BR;
	            
	        }
	
	        if ($list->getNextPageToken() != null) {
	            $pageToken = $list->getNextPageToken();
	            $list = $gmail->users_messages->listUsersMessages('me', ['pageToken' => $pageToken, 'maxResults' => 1000]);
	        } else {
	            break;
	        }
	    
	} catch (Exception $e) {
	    echo $e->getMessage();
	}

  
  
} else {
	
	echo h2('No session');	
	
}

if (strpos($client_id, "googleusercontent") == false) {
	echo missingClientSecretsWarning();
	exit;
}

?>