<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function Services_FullContact_autoload($className) {
    $library_name = 'Services_FullContact';

    if (substr($className, 0, strlen($library_name)) != $library_name) {
        return false;
    }
    $file = str_replace('_', '/', $className);
    $file = str_replace('Services', '', $file);
    return include dirname(__FILE__) . "/$file.php";
}

spl_autoload_register('Services_FullContact_autoload');

/**
 * This class handles the actually HTTP request to the FullContact endpoint.
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact
{
    const USER_AGENT = 'caseysoftware/fullcontact-php-0.9.0';

    protected $_baseUri = 'https://api.fullcontact.com/';
    protected $_version = 'v2';

    protected $_apiKey = null;

    public $response_obj  = null;
    public $response_code = null;
    public $response_json = null;

    /**
     * The base constructor needs the API key available from here:
     * http://fullcontact.com/getkey
     *
     * @param type $api_key
     */
    public function __construct($api_key)
    {
        $this->_apiKey = $api_key;
    }

    /**
     * This is a pretty close copy of my work on the Contactually PHP library
     *   available here: http://github.com/caseysoftware/contactually-php
     *
     * @author  Keith Casey <contrib@caseysoftware.com>
     * @param   array $params
     * @return  object
     * @throws  Services_FullContact_Exception_NotImplemented
     */
    protected function _execute($params = array())
    {
        if(!in_array($params['method'], $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ .
                    " does not support the [" . $params['method'] . "] method");
        }

        $params['apiKey'] = urlencode($this->_apiKey);

        $fullUrl = $this->_baseUri . $this->_version . $this->_resourceUri .
                '?' . http_build_query($params);

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $fullUrl;
		$CurlRQ->o_uagent_s = true;
		$CurlRQ->out = 'json';
		$rsp = $CurlRQ->_Rq();

		$this->response_json = $rsp->rsl;
        $this->response_code = $rsp->code;
        $this->response_obj  = $this->response_json;


        if ('403' == $this->response_code) {
            throw new Services_FullContact_Exception_NoCredit($this->response_obj->message);
        }

        return $this->response_obj;
    }
}


class API_FullContact{

	private $key = FULLCONTACT_KEY;
	private $host = "https://api.fullcontact.com/v2/";
	private $wbhkurl = FULLCONTACT_WBHK;
	private $webhook = "&webhookBody=json&webhookUrl=";

	public function __construct(){	}

	public function encode_email_address( $email ) {
		$output = '';
		for ($i = 0; $i < strlen($email); $i++) {
			$output .= '&#'.ord($email[$i]).';';
		}
		return $output;
	}


	//Envio de Datos
	public function Get($_p=NULL){

			$__fllestatus = GtSisThrdDt(array('id'=>3));
			$__st = json_decode($__fllestatus->status);

			if($__fllestatus->fa->updt == 'ok' && $__fllestatus->fa->diff < 3){

				if($this->wbhk == 'ok'){ $__wbhk = $this->webhook.urlencode( $this->wbhkurl ); }

				if($this->email != NULL){

					if($__st->m->{'200'}->remain != NULL && $__st->m->{'200'}->remain > 20){

						$this->host_t = 'person.json?email='.$this->email.$__wbhk;
						$this->F_Connect();
						$url = $this->conection.$__f;

					}

				}elseif($this->phone != NULL){

					$this->host_t = 'person.json?phone=+'.$this->phone.$__wbhk;
					$this->F_Connect();
					$url = $this->conection.$__f;

				}elseif($this->domain != NULL){

					if($__st->m->company_200->remain != NULL && $__st->m->company_200->remain > 20){
						$this->host_t = 'company/lookup.json?domain='.urlencode($this->domain);
						$this->F_Connect();
						$url = $this->conection.$__f;
					}

				}elseif($this->disposable != NULL){

					$this->host_t = 'verification/email.json?email='./*$this->encode_email_address(*/$this->disposable/*)*/;
					$this->F_Connect();
					$url = $this->conection.$__f;

				}

			}

			if($url != '' /*&& $this->email == NULL*/ ){

				$headers[] = 'X-FullContact-APIKey:'.$this->key;

				$CurlRQ = new CRM_Out();
				$CurlRQ->url = $url;
				$CurlRQ->o_vrfh = 0;
				$CurlRQ->o_header_http = $headers;
				$CurlRQ->out = 'json';
				$rsp = $CurlRQ->_Rq();

				$__r['c'] = $url;
				$__r['r'] = $rsp->rsl;

				$rtrn = _jEnc($__r);
				if(!isN($rtrn)){ return $rtrn; }

			}


	}


	public function Status($_p=NULL){


			$this->host_t = 'stats.json?period='.date("Y-m");
			$this->F_Connect();
			$url = $this->conection.$__f;


			if($url != ''){

				$headers[] = 'X-FullContact-APIKey:'.$this->key;

				$CurlRQ = new CRM_Out();
				$CurlRQ->url = $url;
				$CurlRQ->o_tmout = 5;
				$CurlRQ->o_vrfh = 0;
				$CurlRQ->o_header_http = $headers;
				$CurlRQ->out = 'json';
				$rsp = $CurlRQ->_Rq();

				$__c_r = $rsp->rsl;
				$__r['r'] = $__c_r;
				$__r['c']['amount'] = $__c_r->planBasePrice;

				foreach($__c_r->metrics as $k=>$v){
					$__r['c']['m'][$v->metricId]['usage'] = $v->usage;
					$__r['c']['m'][$v->metricId]['remain'] = $v->remaining;
				}

				$rtrn = _jEnc($__r);
				if(!isN($rtrn)){ return $rtrn; }

			}
	}

    private function F_Connect(){
   		$this->conection = $this->host.$this->host_t;
    }
}
