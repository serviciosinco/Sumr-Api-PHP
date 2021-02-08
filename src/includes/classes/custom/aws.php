<?php

use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;
use Aws\Sns\SnsClient;
use Aws\Sns\Exception\SnsException;

use Aws\Rekognition\RekognitionClient;
use Aws\Rekognition\Exception\RekognitionException;
use Aws\Translate\TranslateClient;

use Aws\Sqs\SqsClient;
use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
use Aws\S3\Exception\S3Exception;

use Aws\CloudFront\CloudFrontClient;
use Aws\CloudFront\Exception\CloudFrontException;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;

use Aws\ApiGatewayManagementApi\ApiGatewayManagementApiClient;
use Aws\ApiGatewayManagementApi\Exception\ApiGatewayManagementApiException;

use Aws\CloudWatch\CloudWatchClient;
use Aws\Exception\AwsException;

use Aws\Ec2\Ec2Client;
use Aws\Rds\RdsClient;
use Aws\DynamoDb\DynamoDbClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;



define('AWS_S3_PRVT', 'sumr-private');
define('AWS_S3_PRVT_CFR', 'sumr-private');
define('AWS_S3_WDGT_DATA', 'sumr-wdgt-data');
define('AWS_S3_STORE_DATA', 'sumr-store-data');
define('AWS_S3_RD_DATA', 'sumr-rd-data');
define('AWS_S3_EMAIL', 'sumr-mail');


if(defined('DMN_CLOUD') && DMN_CLOUD=='sumr.cloud'){

	define('AWS_S3_FLE_CFR', 'E18HXMJBJ0TPZ7');
	define('AWS_S3_JS_CFR', 'E3KYO01A0QZM0O');
	define('AWS_S3_CSS_CFR', 'E3C3F2F6GDXFO5');
	define('AWS_S3_BCO_CFR', 'EKIFDJLN3I8H5');
	define('AWS_S3_ANX_CFR', 'E2G0VKZ6P60MGL');
	define('AWS_S3_WDGT_DATA_CFR', 'EAIMTQFA9ZDGJ');
	define('AWS_S3_STORE_DATA_CFR', 'EAIMTQFA9ZDGJ');
	define('AWS_EC2_FRNT_CFR', 'E1O44DXX9R6S4Y');

}elseif(DMN_S=='sumr.co'){

	define('AWS_S3_JS_CFR', 'E21HAKHANEZBI3');
	define('AWS_S3_CSS_CFR', 'EYM3KUOUGH6L2');
	define('AWS_S3_WDGT_DATA_CFR', 'EAIMTQFA9ZDGJ');
	define('AWS_S3_STORE_DATA_CFR', 'E2T27TET7DNPVC');
	define('AWS_S3_RD_DATA_CFR', 'E2QRZPQWLI5J70');
	define('AWS_EC2_FRNT_CFR', 'E1O44DXX9R6S4Y');

}else{

	define('AWS_S3_FLE_CFR', '');
	define('AWS_S3_JS_CFR', 'E18FTSIQEI6OTJ');
	define('AWS_S3_CSS_CFR', 'E29PNCQUCJU23R');
	define('AWS_S3_BCO_CFR', '');
	define('AWS_S3_ANX_CFR', '');
	define('AWS_S3_WDGT_DATA_CFR', 'E3F6PIO7X85PMZ');
	define('AWS_S3_STORE_DATA_CFR', 'E1LTFDSXR0GKRW');
	define('AWS_S3_RD_DATA_CFR', 'E2P2S4J2XE863');

}

class API_CRM_Aws{

	function __construct($p=NULL) {

		if(defined('MACHINE_WRKR') && MACHINE_WRKR == 'ok'){
			ini_set('max_execution_time', 1000);
		}else{
			ini_set('max_execution_time', 300);
		}

		if(!isN($p) && !isN($p['key']) && !isN($p['scrt'])){
			$this->AWS_KEY = $this->AWS_KEY = $p['key'];
			$this->AWS_SCRT = $this->AWS_SCRT = $p['scrt'];
		}else{
			$this->AWS_KEY = AWS_KEY_ID;
			$this->AWS_SCRT = AWS_KEY_ACCESS;
			$this->SNS_PSH_APNS = 'arn:aws:sns:us-east-1:695918955739:app/APNS_SANDBOX/SUMR';
			$this->SNS_PSH_GCM = 'arn:aws:sns:us-east-1:695918955739:app/GCM/SUMR';
		}

		$this->rcnx();
    }

	function __destruct() {

   	}

	function rcnx(){

		if(!isN($this->AWS_KEY) && !isN($this->AWS_SCRT)){
			$this->cnx = SesClient::factory([
								'version'=> 'latest',
								'region' => 'us-east-1',
								'credentials' => [
									'key'    => $this->AWS_KEY,
									'secret' => $this->AWS_SCRT,
								]
							]);
		}

		if(!isN($this->AWS_KEY)){
			$this->awsp = [
					'version'=>'latest',
					'region'=>'us-east-1',
					'credentials' => [
						'key'    => $this->AWS_KEY,
						'secret' => $this->AWS_SCRT,
					]
			];
		}

		if(!isN($this->AWS_KEY)){
			$this->apiwsp = [
					'region'=>'us-east-1',
					'version'=>'2018-11-29',
					'endpoint'=>'https://8kxc7hcho5.execute-api.us-east-1.amazonaws.com/test/@connections',
					'credentials' => [
						'key'    => $this->AWS_KEY,
						'secret' => $this->AWS_SCRT,
					]
			];
		}

		if(!isN($this->AWS_KEY)){
			$this->snswsp = [
					'region'=>'us-east-1',
					'version'=>'latest',
					'credentials' => [
						'key'    => $this->AWS_KEY,
						'secret' => $this->AWS_SCRT,
					]
			];
		}

	    if(!isN( $this->awsp ) && is_array($this->awsp)){
			$this->_rekognition = new RekognitionClient($this->awsp);
			$this->_translate = new TranslateClient($this->awsp);
			$this->_sqs = new SqsClient($this->awsp);
			$this->_s3 = new S3Client($this->awsp);
			$this->_cfr = new CloudFrontClient($this->awsp);
			$this->_cwtch = new CloudWatchClient($this->awsp);
			$this->_ec2 = new EC2Client($this->awsp);
			$this->_rds = new RDSClient($this->awsp);
		}

		if(!isN( $this->apiwsp ) && is_array($this->apiwsp)){
			$this->_gtwy = new ApiGatewayManagementApiClient($this->apiwsp);
		}

		if(!isN( $this->snswsp ) && is_array($this->snswsp)){
			$this->_sns = new SnsClient($this->snswsp);
		}


		if(!isN($this->AWS_KEY) && !isN($this->AWS_SCRT)){
			$this->_dynamo = DynamoDbClient::factory([
								'version'=> 'latest',
								'region' => 'us-east-1',
								'credentials' => [
									'key'    => $this->AWS_KEY,
									'secret' => $this->AWS_SCRT,
								]
							]);
		}

	}

	public function _eml_vrfc($p=NULL){

		$_r['e'] = 'no';

		if(!isN($p['id'])){

			try {

				$__eml_dt = GtEmlDt([ 'id'=>$p['id'], 't'=>'enc' ]);

				if(!isN( $__eml_dt->id )){

					$rs = $this->cnx->sendCustomVerificationEmail([
							    'ConfigurationSetName' => '',
							    'EmailAddress' => $__eml_dt->eml,
							    'TemplateName' => 'PRD_SUMR_Email_Verification',
							]);


					if(!isN( $rs['MessageId'] )){

						$_r['e'] = 'ok';

					}

				}


			} catch (SesException $error) {

				$_r['w'] = 'The email was not sent. Error message: '.$error->getAwsErrorMessage();

			}

		}

		return _jEnc($_r);
	}



	public function _ses_snd_lmt($p=NULL){

		try {

			$result = $this->cnx->getSendQuota([]);

			$_r['lmt'] = $result["Max24HourSend"];
			$_r['snt'] = $result["SentLast24Hours"];
			$_r['avlb'] = $_r['lmt'] - $_r['snt'];

		} catch (SesException $error) {

			$_r['w'] = 'Error message: '.$error->getAwsErrorMessage();

		}

		return _jEnc($_r);
	}



	public function _sms_snd($p=NULL){

		$_r['e'] = 'no';

		if(!isN($this->us_msj) && !isN($this->us_to)){

			try {

				$result_snd = $this->_sns->publish([
										    'Message'=>$this->us_msj,
										    'MessageAttributes' => [
										        'AWS.SNS.SMS.SMSType' => [
										            'DataType' => 'String',
										            'StringValue' => 'Transactional'
										        ]
										    ],
										    'PhoneNumber' => '+'.$this->us_to,
										]);

				if(!isN($result_snd['MessageId'])){

				    $_r['id'] = $result_snd['MessageId'];
				    $_r['e'] = 'ok';

			    }else{
				    $_r['w'] = $result_snd;
			    }

			} catch (SnsException $error) {

			    $_r['w2'] = 'The sms was not sent. Error message: '.$error->getAwsErrorMessage();

			}

		}

		return _jEnc($_r);

	}


	public function _psh_epnt($p=NULL){

		$_r['e'] = 'no';

		if(!isN($p['tkn']) && !isN($p['p'])){

			try {

				if($p['p']=='ios'){ $pltfomraws = $this->SNS_PSH_APNS; }elseif($p['p']=='android'){ $pltfomraws = $this->SNS_PSH_GCM; }

				$result = $this->_sns->createPlatformEndpoint([
				    //'CustomUserData'=>'{"sumr_id":"'.$p['us'].'"}',
				    'PlatformApplicationArn'=>$pltfomraws,
				    'Token'=>$p['tkn'],
				]);

				if(!isN($result['EndpointArn'])){

				    $_r['id'] = $result['EndpointArn'];
				    $_r['e'] = 'ok';

			    }else{
				    $_r['w'] = $result;
			    }

			} catch (SnsException $error) {

			    $_r['w2'] = 'The endpoint was not subscribe. Error message: '.$error->getAwsErrorMessage();

			}

		}

		return _jEnc($_r);

	}


	public function _psh($p=NULL){

		$_r['e'] = 'no';

		if(!isN($p['dvc'])){

			$__dvc = GtUsDvcDt([ 't'=>'enc', 'id'=>$p['dvc'] ]);

			if($__dvc->e == 'ok' && !isN($__dvc->aws->id)){
				$__arn = $__dvc->aws->id;
				$__ptfm = $__dvc->ptfm;
			}

		}else{
			$__arn = $p['arn'];
			$__ptfm = $p['p'];
		}
		//echo h1($__arn);

		if(!isN($__arn) && !isN($__ptfm) && !isN($p['msg'])){

			try {

				if($__ptfm=='ios'){

					$message = json_encode([
							'default'=>'SUMR-default',
							'APNS_SANDBOX'=>json_encode([
								'aps'=>[
									'alert'=>$p['msg'],
									'badge'=>$p['bdg']
								],
								'data'=>$p['data']
							])
					]);

					$result = $this->_sns->publish([
					    'Message'=>$message,
					    'TargetArn'=>$__arn,
					    'MessageStructure'=>'json'
					]);



				}elseif($__ptfm=='android'){

					$message = json_encode([
							'default'=>'SUMR-default',
							'GCM'=>json_encode([
								'notification'=>[
									'body'=>$p['msg'],
									'title'=>$p['tt']
								],
								'data'=>$p['data'],
								'android'=>[
									'priority'=>'normal',
									'ttl'=>'45s'
								]
							])
					]);

					$result = $this->_sns->publish([
					    'Message'=>$message,
					    'TargetArn'=>$__arn,
					    'MessageStructure'=>'json'
					]);


				}

				if(!isN($result['MessageId'])){

				    $_r['id'] = $result['MessageId'];
				    $_r['e'] = 'ok';

			    }else{
				    $_r['w'] = $result;
			    }

			} catch (SnsException $error) {

			    $_r['w2'] = 'The endpoint was not subscribe. Error message: '.$error->getAwsErrorMessage();

			}

		}

		return _jEnc($_r);

	}





	public function _img_lbl_trnsl($p=NULL){

	 	/*
	 	$__lng = GtLngLs();

		if(!isN($p['lng'])){ $___lng_src = $p['lng']; }else{ $___lng_src = 'auto'; }

		try {

			foreach($__lng->ls as $_lng_k=>$_lng_v){

			    $_r_trnsl = $this->_translate->translateText([
			        'SourceLanguageCode' => $___lng_src,
			        'TargetLanguageCode' => $_lng_v->cod_aws,
			        'Text' => $p['v'],
			    ]);

				$___lbls[ $_lng_v->cod ] = $_r_trnsl['TranslatedText'];
		    }

		    $_r['ls'] = $___lbls;
		    $_r['tot'] = count($___lbls);

		}catch (AwsException $e) {

		    $_r['w'] = $e->getMessage();

		}


		return _jEnc($_r);
		*/

	}


	public function _imgattr($p=NULL){
		/*
	    $fle_img = $p['fle'];
	    $fle_img_o = $p['fle_o'];

	    $fp_image = fopen($fle_img, 'r');
	    $fp_image_r = fread($fp_image, filesize($fle_img));
	    fclose($fp_image);

	    //$_r_faces = $rekognition->DetectFaces([ 'Image'=>[ 'Bytes'=>$fp_image_r ], 'Attributes'=>['ALL'] ]);

	    try {

		    $_r_faces = $this->_rekognition->IndexFaces([
				'CollectionId'=>'sumr',
				'Image'=>[
		        	'Bytes'=>$fp_image_r,
				],
				'ExternalImageId'=>$p['id'],
				'DetectionAttributes'=>['ALL'],
				'QualityFilter'=>'AUTO' //NONE
			]);

		} catch (RekognitionException $e) {

	    		$_r['w'] = $e->getMessage();
	    		$_r['w_c'] = $e->getAwsErrorCode();

		}catch (AwsException $e) {

		    $_r['w'] = $e->getMessage();

		}

		//if(!isN($_r_faces['FaceRecords'])){

		try {

			$_r_label = $this->_rekognition->DetectLabels([ 'Image'=>[ 'Bytes'=>$fp_image_r ], 'Attributes'=>['ALL'] ]);

		} catch (RekognitionException $e) {

	    		$_r['w'] = $e->getMessage();
	    		$_r['w_c'] = $e->getAwsErrorCode();

		}catch (AwsException $e) {

		    $_r['w'] = $e->getMessage();

		}


		$___r_face = _jEnc($_r_faces['FaceRecords']);
		$___r_lbl = _jEnc($_r_label['Labels']);

		$_r['fces']['tot'] = count($_r_faces['FaceRecords']);
		$_r['lbl']['tot'] = count($_r_label['Labels']);



		if($_r['fces']['tot'] > 0){


			//--------- Info on TH BG file ---------//
			$fp_image_sze = getimagesize($fle_img);
			$fp_image_sze_width = $fp_image_sze[0];
			$fp_image_sze_height = $fp_image_sze[1];

			//--------- Info on original file ---------//
			$fp_image_o_sze = getimagesize($fle_img_o);
			$fp_image_o_sze_width = $fp_image_o_sze[0];
			$fp_image_o_sze_height = $fp_image_o_sze[1];


			foreach($___r_face as $face_k=>$face_v){

				//--------- Dimension on TH BG file ---------//
				$__left = number_format( $face_v->Face->BoundingBox->Left * $fp_image_sze_width , 0, '.', '');
				$__top = number_format( $face_v->Face->BoundingBox->Top * $fp_image_sze_height , 0, '.', '');
				$__width = number_format( $face_v->Face->BoundingBox->Width * $fp_image_sze_width , 0, '.', '');
				$__height = number_format( $face_v->Face->BoundingBox->Height * $fp_image_sze_height , 0, '.', '');

				//--------- Dimension on TH BG file ---------//
				$__left_o = number_format( $face_v->Face->BoundingBox->Left * $fp_image_o_sze_width , 0, '.', '');
				$__top_o = number_format( $face_v->Face->BoundingBox->Top * $fp_image_o_sze_height , 0, '.', '');
				$__width_o = number_format( $face_v->Face->BoundingBox->Width * $fp_image_o_sze_width , 0, '.', '');
				$__height_o = number_format( $face_v->Face->BoundingBox->Height * $fp_image_o_sze_height , 0, '.', '');


				$_fce_id = $face_v->Face->FaceId;

				$_fce_ls[ $_fce_id ]['cut']['left'] = $__left_o;
				$_fce_ls[ $_fce_id ]['cut']['top'] = $__top_o;
				$_fce_ls[ $_fce_id ]['cut']['width'] = $__width_o;
				$_fce_ls[ $_fce_id ]['cut']['height'] = $__height_o;

				$_fce_ls[ $_fce_id ]['d'] = $face_v->FaceDetail;

				$__divs_faces .= '<div class="bounding" style="position:absolute; left:'.$__left.'px; top:'.$__top.'px; width:'.$__width.'px; height:'.$__height.'px;"></div>';

				foreach($face_v->FaceDetail->Landmarks as $_lndmrk_k=>$_lndmrk_v){
					if($_lndmrk_v->Type == 'eyeLeft' || $_lndmrk_v->Type == 'eyeRight' || $_lndmrk_v->Type == 'mouthLeft' || $_lndmrk_v->Type == 'mouthRight' || $_lndmrk_v->Type == 'nose'){
						$__l_left = number_format( ($_lndmrk_v->X * $fp_image_sze_width) - 2 , 0, '.', '');
						$__l_top = number_format( ($_lndmrk_v->Y * $fp_image_sze_height) - 2 , 0, '.', '');
						$__divs_faces .= '<div class="landmark" style="position:absolute; left:'.$__l_left.'px; top:'.$__l_top.'px;"></div>';
					}
				}

			}

			$_r['fces']['ls'] = $_fce_ls; // List
			$_r['fces']['shp'] = $__divs_faces; // Div Shapes
		}


		if($_r['lbl']['tot'] > 0){

			$__lng = GtLngLs();

			foreach($___r_lbl as $label_k=>$label_v){

				$__id_lbl = enCad($label_v->Name);
				$__cnfd_lbl = $label_v->Confidence;

				try {


					foreach($__lng->ls as $_lng_k=>$_lng_v){

						if($_lng_v->cod == 'es'){

						    $_r_trnsl = $this->_translate->translateText([
						        'SourceLanguageCode' => 'en',
						        'TargetLanguageCode' => $_lng_v->cod_aws,
						        'Text' => $label_v->Name,
						    ]);

							$___lbls[$__id_lbl]['lng'][ $_lng_v->cod ] = $_r_trnsl['TranslatedText'];
							$___lbls[$__id_lbl]['cnfd'] = $__cnfd_lbl;

						}

				    }

				    // Closed temporally

					$___lbls[$__id_lbl]['lng'][ 'en' ] = $label_v->Name;
					$___lbls[$__id_lbl]['cnfd'] = $__cnfd_lbl;


				}catch (AwsException $e) {

				    $_r['w'] = $e->getMessage();

				}

				//$___lbls .= li( Strn($_r_trnsl['SourceLanguageCode'].' -> '.$___r_v->Name.': ').$___r_v->Confidence.ul($___lbls_lng) );

			}

			$_r['lbl']['ls'] = $___lbls;
		}

		//}

		return _jEnc($_r);

		*/

	}


	public function _cllc_sch($p=NULL){

		/*
		if(!isN($p['cid'])){

			$_r_searchsame = $this->_rekognition->SearchFaces([
		       'CollectionId'=>'sumr',
		       'FaceId'=>$p['cid']
			]);

			$_r['ls'] = $_r_searchsame['FaceMatches'];
			$_r['tot'] = count($_r_searchsame['FaceMatches']);

			return _jEnc($_r);
		}
		*/

	}





	public function _sqs_msg($p=NULL){

		if(SUMR_ENV == 'prd'){

			$__mpth = 'https://sqs.us-east-1.amazonaws.com/695918955739/';

			if($p['t']=='node'){
				$__m_url = 'Sumr-Prd-NodeJS';
			}elseif($p['t']=='bck'){
				$__m_url = 'Sumr-Prd-Bck';
			}

		}elseif(SUMR_ENV == 'dev' || Dvlpr()){

			$__mpth = 'https://sqs.us-east-1.amazonaws.com/695918955739/';

			if($p['t']=='node'){
				$__m_url = 'Sumr-Prd-NodeJS';
			}elseif($p['t']=='bck'){
				$__m_url = 'Sumr-Prd-Bck';
			}

		}

		$params['DelaySeconds'] = 0;
		$params['MessageBody'] = $p['msg'];
		$params['QueueUrl'] = $__mpth.$__m_url;

		if(!isN($p['attr'])){ $params['MessageAttributes'] = $p['attr']; }

		try {

		    $result = $this->_sqs->sendMessage($params);

		    if(!isN( $result['MessageId'] )){

				$_r['e'] = 'ok';
				$_r['id'] = $result['MessageId'];

			}

		} catch (AwsException $e) {

		    $_r['w'] = $e->getMessage();

		}

		return _jEnc($_r);

	}




	public function _s3_put($p=NULL){

		$bsve = [];
		$allw = 'ok';

		if($p['b']=='prvt'){
			$_bck = AWS_S3_PRVT;
			$_mdir = S3_PRVT_DIR;
		}elseif($p['b']=='eml'){
			$_bck = AWS_S3_EMAIL;
			$_mdir = S3_PRVT_DIR;
		}elseif($p['b']=='fle'){
			$_bck = AWS_S3_FLE;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='bco'){
			$_bck = AWS_S3_BCO;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='anx'){
			$_bck = AWS_S3_ANX;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='js'){
			$_bck = AWS_S3_JS;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='css'){
			$_bck = AWS_S3_CSS;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='wdgt'){
			$_bck = AWS_S3_WDGT_DATA;
			$_mdir = S3_PRVT_DIR;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='store'){
			$_bck = AWS_S3_STORE_DATA;
			$_mdir = S3_PRVT_DIR;
			$bsve['ACL'] = 'public-read';
		}elseif($p['b']=='rd'){
			$_bck = AWS_S3_RD_DATA;
			$_mdir = S3_PRVT_DIR;
			$bsve['ACL'] = 'public-read';
		}

		$___noallw = ['__MACOSX', '../'];
		$___frstc = substr($p['fle'], 0, 1);

		foreach($___noallw as $___noallw_k=>$___noallw_v){
			if (strpos($p['fle'], $___noallw_v) !== false){
				$allw = 'no';
				$_r['w'] = 'No allowed '.$___noallw_v; break;
			}
		}

		if($___frstc=='/'){ $allw = 'no'; $_r['w'] = 'Has slash at start '.$p['fle']; }

		if(!isN($_bck) && ( !isN($p['fle']) || !isN($p['cbdy'])) && $allw == 'ok'){

			try {

				if(!isN($_mdir)){ $_mdirp = $_mdir.'/'; }

				$bsve['Bucket'] = $_bck;
				$bsve['Key'] = $_mdirp.$p['fle'];
				$bsve['CacheControl'] = 'max-age=31536000'; // 1 Year Cache

				if(!isN($p['ctp'])){
					if($p['ctp'] == 'image/svg'){ $p['ctp'] = 'image/svg+xml'; }
					if($p['utf8'] == 'ok'){ $_utf8= '; charset=utf-8'; }
					$bsve['ContentType'] = $p['ctp'].$_utf8;
				}

				if(SUMR_ENV == 'prd' || SUMR_ENV == 'dev'){

					try {

						$bsve = stream_context_create([
						    's3'=>[
						        'ACL'=>$bsve['ACL'],
								'ContentType'=>$p['ctp'].$_utf8,
								'CacheControl'=>'max-age=31536000', // 1 Year Cache
								'Metadata'=>[
									'X-Powered-By'=>'Servicios.in',
									'ETag'=>'SUMR-'.enCad(E_TAG)
								]
							]
						]);

						//print_r($bsve);

						$this->_s3->registerStreamWrapper();

						if(!isN($p['src'])){
							$__fsrce = file_get_contents($p['src']);
						}elseif(!isN($p['cbdy'])){
							$__fsrce = $p['cbdy'];
						}

						$_r['s3']['src'] = $p['src'];
						$_r['s3']['sve'] = $__ftsve = 's3://'.$_bck.'/'.$_mdirp.$p['fle'];

						$fp = fopen($__ftsve, 'w', 0, $bsve);

						if( fwrite($fp, $__fsrce) ){
							$_r['e'] = 'ok';
							fclose($fp);
						}else{
							$_r['w'] = 'Can not create it from - '.$p['src'].' - AWS on '.$__ftsve;
							$_r['w_m'] = error_get_last();
						}

					} catch (AwsException $e) {

				        $_r['w'] = $e->getMessage();

				    }

				}else{

					try {

						if(!isN($p['src'])){
							$bsve['SourceFile'] = $p['src'];
						}elseif(!isN($p['cbdy'])){
							$bsve['Body'] = $p['cbdy'];
						}

						$sve = $this->_s3->putObject($bsve);

						if(!isN($sve['ObjectURL'])){
							$_r['e'] = 'ok';
						}

					} catch (AwsException $e) {

				        $_r['w'] = $e->getMessage();

				    }

				}

				$_r['exst'] = $_f_exst = $this->_s3->doesObjectExist($_bck, $_mdirp.$p['fle']);

				if($p['cfr'] == 'ok' && $_f_exst){
					$_r['cfr'] = $this->_cfr_clr([ 'b'=>$p['b'], 'fle'=>/*$_mdirp.*/$p['fle'], 'all'=>'ok', 'is_f'=>'ok' ]);
				}

			} catch (AwsException $e) {

			    $_r['w'] = $e->getMessage();

			}

		}


		return _jEnc($_r);

	}




	public function _s3_get($p=NULL){

		$_r['e'] = 'no';

		if($p['b']=='prvt'){
			$_bck = AWS_S3_PRVT;
			$_mdir = S3_PRVT_DIR.'/';
		}elseif($p['b']=='eml'){
			$_bck = AWS_S3_EMAIL;
			$_mdir = S3_PRVT_DIR.'/';
		}elseif($p['b']=='fle'){
			$_bck = AWS_S3_FLE;
		}elseif($p['b']=='bco'){
			$_bck = AWS_S3_BCO;
		}elseif($p['b']=='anx'){
			$_bck = AWS_S3_ANX;
		}elseif($p['b']=='js'){
			$_bck = AWS_S3_JS;
		}elseif($p['b']=='css'){
			$_bck = AWS_S3_CSS;
		}

		if(!isN($_bck) && !isN($p['fle'])){

			try {

				$__pth = $_mdir.$p['fle'];

				//-------------- Create Folder if not exists --------------//

					$__flrd = dirname($__pth);
					$__flrdt = explode('/', $__flrd);

					if(PHP_VERSION > 6){
						$___ppr = dirname(__FILE__, 5);
					}else{
						$___ppr = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
					}

					if($p['b']=='bco'){
						$___tmp = $___ppr.'/'.DIR_TMP_BCO;
					}else{
						$___tmp = $___ppr.'/'.DIR_TMP_FLE;
					}

					if(!isN($__flrdt)){
						foreach($__flrdt as $_f_k=>$_f_v){
							$__fldr = !isN($__fldr) ? $__fldr.'/'.$_f_v : $_f_v.'/';
							if (!file_exists($___tmp.$__fldr)){ //echo 'Create Folder '.$___tmp.$__fldr;
							    mkdir($___tmp.$__fldr, 0777, true);
							}
						}
					}

				//-------------- Process Data --------------//


					if($p['lcl']=='ok'){

						if(SUMR_ENV == 'prd' || SUMR_ENV == 'dev'){ //-------------- If Machine is AWS

							$_r['srv'] = 'aws';

							$exst = $this->_s3->doesObjectExist($_bck, $__pth);

							$_r['exst'] = $exst;

							try {

								if($exst){

									$_r['uri'] = 's3://'.$_bck.'/'.$__pth;

									if(!file_exists($___tmp.$__pth) || $p['upd'] == 'ok'){

										$this->_s3->registerStreamWrapper();

										if(file_put_contents($___tmp.$__pth, file_get_contents($_r['uri']))){
											$_r['e'] = 'ok';
										}else{
											$_r['e'] = error_get_last();
										}

									}else{

										$_r['e'] = 'ok';
										$_r['w'] = 'file_exists';

									}

									if(file_exists($___tmp.$__pth)){
										$_r['tmp'] = $___tmp.$__pth;
										if($p['gcnt']=='ok'){ $_r['html'] = file_get_contents($___tmp.$__pth, true); }
									}

								}else{

									$_r['w'] = $_bck.' not exists '.$__pth;

								}

							} catch (AwsException $e) {

								$_r['w'] = $e->getMessage();

							}

						}else{ //-------------- If Machine is Not AWS


							$rsl = $this->_s3->getObject([ 'Bucket'=>$_bck, 'Key'=>$__pth /*, 'SaveAs'=>$___tmp.$p['fle']*/ ]);
							$body = $rsl->get('Body');

							if(!isN($body)){

								if(file_exists($___tmp.$__pth)){

									$_r['e'] = 'ok';
									$_r['tmp'] = $___tmp.$__pth;

								}else{

									$fp = fopen($___tmp.$__pth, 'w');

									if( fwrite($fp, $body) ){

										$_r['e'] = 'ok';
										$_r['tmp'] = $___tmp.$__pth;
										fclose($fp);

									}else{

										$_r['w'] = 'Can not create it from AWS';

									}

								}

							}

						}

					}else{

						$exst = $this->_s3->doesObjectExist($_bck, $__pth);

						if($exst){

							if($p['gcnt']=='ok'){ //echo '$_bck:'.$_bck; echo '$__pth:'.$__pth;

								$rsl = $this->_s3->getObject([ 'Bucket'=>$_bck, 'Key'=>$__pth /*, 'SaveAs'=>$___tmp.$p['fle']*/ ]);
								$body = $rsl['Body']->getContents();

								if(!isN( $body )){
									$_r['e'] = 'ok';
									$_r['html'] = $body;
									$_r['type'] = $rsl['ContentType'];
								}

							}else{

								$rqu_attr = [];
								$rqu_attr['Bucket'] = $_bck;
								$rqu_attr['Key'] = $__pth;
								if(!isN($p['fdwn'])){ $rqu_attr['ResponseContentDisposition'] = 'attachment; filename='.$p['fdwn']; }

								$cmd = $this->_s3->getCommand('GetObject', $rqu_attr);
								$request = $this->_s3->createPresignedRequest($cmd, '+5 minutes');

								if(!isN( $request->getUri() )){
									$_r['e'] = 'ok';
									$_r['uri'] = (string) $request->getUri();
								}

							}

						}else{

							$_r['w'] = 'Object '.$__pth.' Not Exists';

						}

					}


			} catch (AwsException $e) {

			    $_r['w'] = $e->getMessage();

			}

		}else{

			 $_r['w'] = 'no fle url';

		}


		return _jEnc($_r);

	}




	public function _cfr_clr($p=NULL){

		$_r['e'] = 'no';

		try {

			if($p['b']=='prvt' && defined('AWS_S3_PRVT_CFR')){
				$_dstid = AWS_S3_PRVT_CFR;
			}elseif($p['b']=='fle' && defined('AWS_S3_FLE_CFR')){
				$_dstid = AWS_S3_FLE_CFR;
			}elseif($p['b']=='bco' && defined('AWS_S3_BCO_CFR')){
				$_dstid = AWS_S3_BCO_CFR;
			}elseif($p['b']=='anx' && defined('AWS_S3_ANX_CFR')){
				$_dstid = AWS_S3_ANX_CFR;
			}elseif($p['b']=='js' && defined('AWS_S3_JS_CFR')){
				$_dstid = AWS_S3_JS_CFR;
			}elseif($p['b']=='css' && defined('AWS_S3_CSS_CFR')){
				$_dstid = AWS_S3_CSS_CFR;
			}elseif($p['b']=='frnt' && defined('AWS_EC2_FRNT_CFR')){
				$_dstid = AWS_EC2_FRNT_CFR;
			}elseif($p['b']=='wdgt' && defined('AWS_S3_WDGT_DATA')){
				$_dstid = AWS_S3_WDGT_DATA_CFR;
			}elseif($p['b']=='store' && defined('AWS_S3_STORE_DATA')){
				$_dstid = AWS_S3_STORE_DATA_CFR;
			}elseif($p['b']=='rd' && defined('AWS_S3_RD_DATA')){
				$_dstid = AWS_S3_RD_DATA_CFR;
			}

			$_r['dst'] = $_dstid;
			$_r['bckt'] = $p['b'];

			if(!isN($_dstid)){

				if($p['all']=='ok'){

					if($p['is_f']!='ok'){ $_pask='/'; }else{ $_pask=''; }

		            $__fld = [
		                'Items'=>[ '/'.$p['fle'].$_pask.'*' ],
		                'Quantity'=>1,
					];

					$_r['path'] = '/'.$p['fle'].$_pask.'*';

				}else{

					$__qty=1;
					$__fld = [
		                'Items'=>[ '/'.$p['fle'] ],
		                'Quantity'=>1,
					];

					$_r['path'] = '/'.$p['fle'];

				}

				$params['DistributionId'] = $_dstid;
				$params['InvalidationBatch'] = [
					'CallerReference'=>enCad($p['fle'].'-'.SIS_F_D2),
					'Paths'=>$__fld
				];

			    $result = $this->_cfr->createInvalidation($params);
				$result_a = $result->toArray();
			    $_r['params'] = $params;

		    }else{

				$_r['w'] = 'No Distribution ID';

			}

		    if(!isN( $result['MessageId'] )){

				$_r['e'] = 'ok';
				$_r['id'] = $result['MessageId'];

			}elseif( !isN($result_a['Invalidation']) ){

				$_r['e'] = 'ok';

			}elseif(!isN($result)){

				$_r['r'] = $result;

			}


		} catch (AwsException $e) {

		    $_r['w'] = $e->getMessage();

		}


		return _jEnc($_r);

	}

	public function _cwtch_mtrcs($p=NULL){

		try {


		    $result = $this->_cwtch->listMetrics();

		    foreach($result['Metrics'] as $mtrc_k=>$mtrc_v){
			    echo h2($mtrc_v['Namespace'].' '.Spn( $mtrc_v['MetricName'], 'ok' ));
			    echo h3(print_r($mtrc_v['Dimensions'], true)); echo json_encode($mtrc_v);
		    }


		} catch (AwsException $e) {

		    error_log($e->getMessage());

		}

		$dimensions = [
		    ['Name'=>'EnvironmentName', 'Value'=>'Prd-Bck']
		];

		$memoryResult = $this->_cwtch->getMetricStatistics([
		    'Namespace'  => 'AWS/ElasticBeanstalk',
		    'MetricName' => 'CPUUser',
		    'Dimensions' => $dimensions,
		    'StartTime'  => strtotime('-24 hours'),
		    'EndTime'    => strtotime('now'),
		    'Period'     => 60,
		    'Statistics' => ['Maximum', 'Minimum', 'Average']
		]);

		var_dump($memoryResult);


	}




	public function _cwtch_mtrcs_any($p=NULL){

		try {

			if($p['t']=='rds'){

			    $result = $this->_cwtch->getMetricStatistics([
			        'Namespace' => 'AWS/RDS',
			        'MetricName' => 'CPUUtilization',
			        'StartTime' => strtotime('-1 minute'),
			        'EndTime' => strtotime('now'),
			        'Period' => 3000,
			        'Statistics' => ['Average']
			    ]);

		    }elseif($p['t']=='ec2' || $p['t']=='ec2-ebl'){

				if(!isN($p['instance_id'])){
					$dimensions = [ ['Name'=>'InstanceId', 'Value'=>$p['instance_id'] ] ];
				}elseif(!isN($p['autoscaling_name'])){
					$dimensions = [ ['Name'=>'AutoScalingGroupName', 'Value'=>$p['autoscaling_name'] ] ];
				}

			    $result = $this->_cwtch->getMetricStatistics([
			        'Namespace' => 'AWS/EC2',
			        'MetricName' => 'CPUUtilization',
			        'Dimensions' => $dimensions,
			        'StartTime' => strtotime('-1 minute'),
			        'EndTime' => strtotime('now'),
			        'Period' => 3000,
			        'Statistics' => ['Average']
			    ]);

		    }elseif($p['t']=='ses'){

			    $result = $this->_cwtch->getMetricStatistics([
			        'Namespace' => 'AWS/SES',
			        'MetricName' => 'Bounce',
			        'StartTime' => strtotime('-1 minute'),
			        'EndTime' => strtotime('now'),
			        'Period' => 3000,
			        'Statistics' => ['Average']
			    ]);

		    }

		    $__r['d'] = $result['Datapoints'][0];

		} catch (AwsException $e) {

		    $__r['w'] = $e->getMessage();

		}


		return _jEnc($__r);


	}



	public function _ec2_list($p=NULL){

		try {

			$result = $this->_ec2->describeInstances();
			$__r = $result['Reservations'];

		} catch (AwsException $e) {

			$__r['w'] = $e->getMessage();

		}

		return _jEnc($__r);

	}


	public function _ec2_trnon($p=NULL){

		try {

			if($p['e'] == 'on'){

				$result = $this->_ec2->startInstances([
					'InstanceIds'=>[ $p['id'] ],
				]);

				$__rsl = _jEnc($result['StartingInstances'][0]);

				if(
					($__rsl->CurrentState->Name == 'pending' && ($__rsl->PreviousState->Name == 'stopped' || $__rsl->PreviousState->Name == 'pending' )) ||
					$__rsl->CurrentState->Name == 'running'
				){
					$__r['e'] = 'ok';
				}

			}elseif($p['e'] == 'off'){

				$result = $this->_ec2->stopInstances([
					'InstanceIds'=>[ $p['id'] ],
				]);

				$__rsl = _jEnc($result['StoppingInstances'][0]);

				if(
					($__rsl->CurrentState->Name == 'stopping' && ($__rsl->PreviousState->Name == 'running' || $__rsl->PreviousState->Name == 'stopping')) ||
					$__rsl->CurrentState->Name == 'stopped'
				){
					$__r['e'] = 'ok';
				}

			}

			$__r['tmp'] = $__rsl;
			$__r['nw_status'] = $__rsl->CurrentState->Name;


		} catch (AwsException $e) {

			$__r['w'] = $e->getMessage();

		}

		return _jEnc($__r);

	}

	public function _ec2_type($p=NULL){
		$type = $this->_ec2->describeInstanceAttribute([ 'Attribute'=>'instanceType', 'InstanceId'=>$p['id'] ]);
		return $type['InstanceType']['Value'];
	}

	public function _ec2_status($p=NULL){
		$status = $this->_ec2->describeInstanceStatus([ 'IncludeAllInstances'=>true, 'InstanceIds' => [ $p['id'] ] ]);
		$status = _jEnc($status['InstanceStatuses'][0]);
		return $status->InstanceState->Name;
	}

	public function _ec2_ctype($p=NULL){ // Change Type

		if(!isN( $p['id'] ) && !isN( $p['tp'] )){

			try {

				$result = $this->_ec2->modifyInstanceAttribute([
					'InstanceId' => $p['id'],
					'InstanceType' => [
						'Value' => $p['tp'],
					],
				]);

			} catch (AwsException $e) {

				$__r['w'] = $e->getMessage();

			}

		}

		return _jEnc($__r);

	}


	public function _ec2_scle($p=NULL){ // Change Type

		$this->_auto = new API_CRM_Auto();
		$__ec2_status = $this->_ec2_status([ 'id'=>$p['id'] ]);

        $__ec2_type = $this->_ec2_type([ 'id'=>$p['id'] ]);

		if(!isN($__ec2_type) && !isN($__ec2_status)){

			echo $this->_auto->li($__ec2_type.' != '.$p['to'].'?????');

			if($__ec2_type != $p['to'] || $__ec2_status == 'stopped'){ // If is not low, change to low machine

				if($__ec2_status == 'running'){

					$__dir_f1 = new DateTime($p['sclr']['f']);
					$__dir_f2 = new DateTime(SIS_F2);
					$__dir_dif = $__dir_f1->diff($__dir_f2);

					if($p['sclr']['e'] != 'ok' || $__dir_dif->format('%i') > 10){
						echo $this->_auto->li('Turn off machine');

						if($__ec2_type != $p['to']){
							$_turnoff = $this->_ec2_trnon([ 'e'=>'off', 'id'=>$p['id'] ]);
						}

						if($_turnoff->e == 'ok'){
							$this->_rsrc_upd([ 'cid'=>$p['id'], 'f'=>'awsrsrc_sclg', 'v'=>1 ]);
							echo $this->_auto->scss('Turn off machine success');
						}
					}

				}else{

					echo $this->_auto->li('Change Machine and Turn On');
					$this->_ec2_ctype([ 'id'=>$p['id'], 'tp'=>$p['to'] ]);
					$_turnon = $this->_ec2_trnon([ 'e'=>'on', 'id'=>$p['id'] ]);
					if($_turnon->e == 'ok'){
						$this->_rsrc_upd([ 'cid'=>$p['id'], 'f'=>'awsrsrc_sclg', 'v'=>2 ]);
						echo $this->_auto->scss('Turn on machine and new IT success');
					}

				}

			}else{

				echo $this->_auto->scss('$__ec2_type empty');

			}

		}else{

			if(isN($__ec2_type)){ echo $this->_auto->err('$__ec2_type empty'); }
			if(!isN($__ec2_status)){ echo $this->_auto->err('$__ec2_status empty'); }

		}

	}




	public function _ec2_save_toff($p=NULL){ // Change Type

		$__ec2_status = $this->_ec2_status([ 'id'=>$p['id'] ]);

		if($__ec2_status == 'running'){ // If is running, turn off
			//echo $this->li('Turn off machine');
			$_turnoff = $this->_ec2_trnon([ 'e'=>'off', 'id'=>$p['id'] ]);
			if($_turnoff->e == 'ok'){
				//echo $this->scss('Turn off machine success');
			}
		}

	}


	public function _rsrc_upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p) && !isN($p['f']) && !isN($p['v']) && (!isN($p['id']) || !isN($p['cid']))){

			if(!isN($p['id'])){ $_id=$p['id']; $_f='int'; $_fc='id_awsrsrc'; }
			elseif(!isN($p['cid'])){ $_id=$p['cid']; $_f='text'; $_fc='awsrsrc_id'; }

			$Update = sprintf("UPDATE "._BdStr(DBT).TB_AWS_RSRC." SET ".$p['f']."=%s WHERE {$_fc}=%s",
	                   GtSQLVlStr($p['v'], "text"),
	                   GtSQLVlStr($_id, $_f));

			$Update = $__cnx->_prc($Update);

			if($Update){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}

	public function _rsrc_sclg_chck($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$__qry = sprintf('	SELECT awsrsrc_sclg, awsrsrc_id, awsrsrc_low, awsrsrc_mdm, awsrsrc_hig, awsrsrc_xtrm, awsrsrc_fa
								FROM '._BdStr(DBT).TB_AWS_RSRC.'
								WHERE id_awsrsrc=%s
								LIMIT 1', GtSQLVlStr($p['id'], 'int'));

			$DtRg = $__cnx->_prc($__qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['e'] = 'ok';
					$Vl['cid'] = $row_DtRg['awsrsrc_id'];
					$Vl['sclg'] = mBln($row_DtRg['awsrsrc_sclg']);

					$Vl['low'] = ctjTx($row_DtRg['awsrsrc_low'],'in');
					$Vl['mdm'] = ctjTx($row_DtRg['awsrsrc_mdm'],'in');
					$Vl['hig'] = ctjTx($row_DtRg['awsrsrc_hig'],'in');
					$Vl['xtrm'] = ctjTx($row_DtRg['awsrsrc_xtrm'],'in');

					$Vl['fa'] = $row_DtRg['awsrsrc_fa'];

				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_p->error;
				}
			}else{
				$Vl['w'] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['r'] = 'no';
		}

		return _jEnc($Vl);

	}


    public function _rds_info($p=NULL){
		$type = $this->_rds->describeDBInstances([ 'Attribute'=>'instanceType', 'DBInstanceIdentifier'=>$p['id'] ]);
		$_r['class'] = $type['DBInstances'][0]['DBInstanceClass'];
		$_r['status'] = $type['DBInstances'][0]['DBInstanceStatus'];
		return _jEnc($_r);
	}

	public function _rds_scle($p=NULL){ // Change Type

		$__rds_info = $this->_rds_info([ 'id'=>$p['id'] ]);

        if($__rds_info->class != $p['to'] || $__rds_info->status == 'available'){ // If is not low, change to low machine

			$_rdsmdfy = $this->_rds_mdfy([ 'id'=>$p['id'], 'cls'=>$p['to'] ]);

			if($_rdsmdfy->e == 'ok'){
				echo $this->scss('Modify machine RDS and new IT success');
			}

		}


	}

	public function _rds_save_toff($p=NULL){ // Change Type

		$__rds_info = $this->_rds_info([ 'id'=>$p['id'] ]);

		if($__rds_info->status == 'available'){ // If is running, turn off

			//echo $this->li('Turn off machine');

			$result = $this->_rds->stopDBInstance([
				'DBInstanceIdentifier'=>$p['id']
			]);

			if($result){ echo $this->scss('Turn off RDS success'); }
		}

	}

	public function _rds_mdfy($p=NULL){

		try {

			$result = $this->_rds->modifyDBInstance([
				'DBInstanceIdentifier'=>$p['id'],
				'DBInstanceClass'=>$p['cls'],
				'ApplyImmediately'=>true
			]);

			$__rsl = _jEnc($result['DBInstance'][0]);

			if($__rsl->DBInstanceStatus == 'modifying'){
				$__r['e'] = 'ok';
			}

		} catch (AwsException $e) {

			$__r['w'] = $e->getMessage();

		}

		return _jEnc($__r);

	}


	public function _ses_tmpl($p=NULL){ // Change Type

		$__r['e'] = 'no';

		if(!isN($p['id']) && !isN($p['html']) && !isN($p['sbj'])){

			//----------- Basic Data for AWS -----------//

				$id = $p['id'];
				$html = $p['html'];
				$subject = $p['sbj'];
				$plaintext = $p['ptxt'];
				if(Dvlpr()){
					$name = 'DEV-'.$id;
				}else{
					$name = 'PRD-'.$id;
				}

			//----------- Process Data -----------//

				try{
					$exst = $this->cnx->getTemplate([ 'TemplateName'=>$name ]);
				}catch(AwsException $e){
					$__r['exst_w'] = $e->getMessage();
				}

				if(isN( $exst['Template'] ) && isN( $exst['Template']['TemplateName'] )){

					try {

						$r = $this->cnx->createTemplate([
							'Template' => [
								'HtmlPart'=>$html,
								'SubjectPart'=>$subject,
								'TemplateName'=>$name,
								'TextPart'=>$plaintext,
							]
						]);

						if(!isN($r)){
							$_mtdta = _jEnc($r['@metadata']);
							if($_mtdta->statusCode == 200 && !isN($_mtdta->headers->{'x-amzn-requestid'})){
								$__r['e'] = 'ok';
								$__r['prc'] = 'in';
								$__r['status'] = $_mtdta->statusCode;
								$__r['request'] = $_mtdta->headers->{'x-amzn-requestid'};
							}
						}

					} catch (AwsException $e) {

						$__r['w'] = $e->getMessage();

					}

				}else{

					try {

						$r = $this->cnx->updateTemplate([
							'Template'=>[
								'HtmlPart'=>'Some'.$html,
								'SubjectPart'=>$subject,
								'TemplateName'=>$name,
								'TextPart'=>$plaintext,
							]
						]);

						if(!isN($r)){
							$_mtdta = _jEnc($r['@metadata']);
							if($_mtdta->statusCode == 200 && !isN($_mtdta->headers->{'x-amzn-requestid'})){
								$__r['e'] = 'ok';
								$__r['prc'] = 'upd';
								$__r['status'] = $_mtdta->statusCode;
								$__r['request'] = $_mtdta->headers->{'x-amzn-requestid'};
							}
						}

					} catch (AwsException $e) {

						echo $__r['w'] = $e->getMessage();

					}


				}

		}

		return _jEnc($__r);

	}

}




?>