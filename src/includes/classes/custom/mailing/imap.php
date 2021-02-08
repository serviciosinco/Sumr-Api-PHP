<?php

	use Ddeboer\Imap\Server;
	use Ddeboer\Imap\SearchExpression;
	use Ddeboer\Imap\Search\Email\To;
	use Ddeboer\Imap\Search\Text\Body;
	use Ddeboer\Imap\Search\RawExpression;

	class CRM_Imap extends CRM_Eml {

		private $server=NULL;
		private $port=NULL;
		private $ssl=NULL;
		private $cert=NULL;
		private $user=NULL;
		private $pssw=NULL;
		private $lbl=NULL;
		private $otrhd=NULL;

		function __construct() {
			parent::__construct();
	    }

		function __destruct() {
	    	parent::__destruct();

			if(!isN($this->cnx)){ $this->cnx->close(); }

	    	if(!isN($this->imap)){
				imap_gc($this->imap, IMAP_GC_ELT);
				imap_close($this->imap);
			}
	   	}

	    public function _txdcde($str=NULL) {
		    if(!isN($str) && isset($str)){
				if(!is_array($str)){
					return iconv_mime_decode($str,0,"UTF-8");
				}else{
					return $str;
				}
			}else{
				return $str;
			}
		}

	    public function _cnctU($p=NULL){

			$this->server_lbl = NULL;

			if(	trim($this->eml->id) != trim($this->c_eml) ||
				(isN($this->c_eml) || isN($this->eml->id))
			){

				if(!isN($this->cnx)){ $this->cnx->close(); $this->cnx = NULL; }else{ $this->cnx = NULL; }

				$this->mbox = NULL;
				$this->server_in = NULL;
				$this->server_in_port = '993';
				$this->server_user = NULL;
				$this->server_pass = NULL;
				$this->server_ssl = 'ssl';
				$this->server_cert = 'imap/ssl/novalidate-cert';
				$this->eml = GtEmlDt([ 'id'=>$this->c_eml, 'pss'=>'ok' ]);

				$this->cnx_sme = 'no';



			}else{

				$this->cnx_sme = 'ok';

			}

			if(!isN($this->eml->id)){

				if(!isN($this->eml->in->srv)){ $this->server_in = $this->eml->in->srv; }
				if(!isN($this->eml->in->prt)){ $this->server_in_port = $this->eml->in->prt; }

				if(!isN($this->eml->user)){ $this->server_user=$this->eml->user; }
				if(!isN($this->eml->pass)){ $this->server_pass=$this->eml->pass; }

				if(!isN($this->c_ssl)){ $this->server_ssl=$this->c_ssl; }
				if(!isN($this->c_cert)){ $this->server_cert=$this->c_cert; }

				if(!isN($this->box)){
					$this->server_lbl = /*imap_utf7_encode(*/ $this->box /*)*/;
				}

			}else{

				echo $this->_auto->li( 'No eml $this->eml->id' );

			}

	    }

	    public function _cnct($p=NULL){

			$_e = 'no';
			$this->_cnctU();

			echo $this->_auto->li( 'Lets try connect to email ('.$this->server_user.') ' );

			if(isN($this->cnx) && !isN($this->server_in) && !isN($this->server_user) && !isN($this->server_pass)){

				$try=1;

				while($try<5){

					try{

						$this->tmp_camilo['try'][] = $try;
						echo $this->_auto->li( 'All the information to connect is completed -> Try ('.$try.')' );

						imap_timeout(IMAP_OPENTIMEOUT, 20);
						imap_timeout(IMAP_READTIMEOUT, 20);
						imap_timeout(IMAP_WRITETIMEOUT, 20);
						imap_timeout(IMAP_CLOSETIMEOUT);

						$server = new Server($this->server_in, $this->server_in_port, $this->server_cert);
						$this->cnx = $server->authenticate($this->server_user, $this->server_pass);

						$this->tmp_camilo['mbox'][] = $this->server_lbl;

						if($this->cnx){
							$_e='ok';
							if(!isN($this->server_lbl)){ $this->mbox = $this->cnx->getMailbox( $this->server_lbl ); }
							echo $this->_auto->scss( 'Connected to email ('.$this->server_user.') ' );
							break;
						}else{
							echo $this->_auto->err( 'Problem To Connect Mail ('.$this->server_user.') on Box ('.$this->server_lbl.') ' );
						}

					}catch(Exception $e) {

						$__r['w'] = $e->getMessage();
						$try++;

						echo $this->_auto->err( 'Lets try in '.($try) .' seconds ' );
						sleep( $try );

					}

				}

				if(!isN($__r['w'])){ echo $this->_auto->err( $__r['w'] ); }

			}else{

				if($this->cnx_sme == 'ok'){

					echo $this->_auto->li( 'Is the same connection, so you can reuse it' );
					if(!isN($this->server_lbl)){ $this->mbox = $this->cnx->getMailbox( $this->server_lbl ); }

				}else{

					//$this->cnx = false;

					$this->_auto->err('No Data for Connect ('.$this->server_user.') on Box ('.$this->server_lbl.') ');

					if(isN($this->server_in)){ echo $this->_auto->err('$this->server_in empty'); }
					if(isN($this->server_user)){ echo $this->_auto->err('$this->server_user empty'); }
					if(isN($this->server_pass)){ echo $this->_auto->err('$this->server_pass empty'); }
					if(isN($this->server_lbl)){ echo $this->_auto->err('$this->server_lbl empty'); }

					if($this->c_eml->onl == 1 && $this->_Url->nodata != 'ok'){

						/*$this->Upd_Eml_Fld([
								't'=>'eml',
								'id'=>$this->c_eml->enc,
								'fld'=>[[
									'k'=>'eml_onl',
									'v'=>2
								]]
							]);*/

					}

				}

			}

			$__r['e'] = $_e;
			return _jEnc($__r);

	    }

	    private function _labels_o($p=NULL){

			$_id = $p['id'];

			switch ($_id) {
			    case 'INBOX':
			        $r['ord'] = 1; $r['cls'] = 'inbx'; break;
			    case 'INBOX.Drafts':
			        $r['ord'] = 2; $r['cls'] = 'dfrt'; break;
			    case 'INBOX.Sent':
			        $r['ord'] = 3; $r['cls'] = 'snt'; break;
			}

			if(isN($r['cls'])){
				if (strpos($_id, 'Sent') !== false) {
					$r['cls'] = 'snt';
				}elseif (strpos($_id, 'INBOX') !== false) {
					$r['cls'] = 'inbx';
				}
			}

			if($_id != 'INBOX'){
				$_split = explode('.', $_id);
				if(count($_split)<2){ $_split = explode('/', $_id); }
				$_id = strtoupper($_split[1]);
			}

			$r['nm'] = (defined('GA_'.$_id)?_Cns('GA_'.$_id):$_id );

			return _jEnc($r);
		}

	    public function _fldr(){

		    $this->_cnct();

		    if(!isN($this->cnx)){

			    $mailboxes = $this->cnx->getMailboxes();

				if(count($mailboxes) > 0){

					$r['e'] = 'ok';
					$i = 1;
					$i_c = 1;

					foreach ($mailboxes as $mailbox){

						try{

							echo $this->_auto->li('Name:'.$mailbox->getName());
							//echo $this->_auto->li('Encoded Name:'.$mailbox->getEncodedName());
							//echo $this->_auto->li('Full Encoded Name:'.$mailbox->getFullEncodedName());

							//------------ GET LAST ID - START ------------//

								if($mailbox->count() > 0){

									$search = new SearchExpression();
									$search->addCondition( new RawExpression('ALL') );
									$__sch = $mailbox->getMessages($search); //echo 'ALLLL:'.PHP_EOL; print_r($__sch); echo PHP_EOL.PHP_EOL.PHP_EOL;

									$search2 = new SearchExpression();
									$search2->addCondition( new RawExpression('RECENT') );
									$__sch2 = $mailbox->getMessages($search2); //echo 'NEW:'.PHP_EOL; print_r( $__sch2 ); echo PHP_EOL.PHP_EOL.PHP_EOL;

									if($mailbox->count() > 0){
										$__luid = $__sch[ ( $mailbox->count() - 1 ) ];
									}

									//echo '$__sch[0]'; print_r($__sch[0]);									//echo '$__luid:'; print_r($__luid);


								}

							//------------ GET LAST ID - END ------------//

							if($mailbox->getAttributes() & \LATT_NOSELECT){ echo $this->_auto->li('No attributes, so continue'); continue; }

							$__m = $this->_labels_o([ 'id'=>$mailbox->getName() ]);
							if($__m->ord != ''){ $i = $__m->ord; }else{ $i++; }
							$r['ls'][$i_c]['id'] = $mailbox->getName();
							$r['ls'][$i_c]['nm'] = $mailbox->getName();
							$r['ls'][$i_c]['ord'] = $__m->ord;
							$r['ls'][$i_c]['cls'] = $__m->cls;
							$r['ls'][$i_c]['tot'] = $mailbox->count();
							$r['ls'][$i_c]['luid'] = $__luid;

							$i++;
							$i_c++;

						}catch(Exception $e){

							echo $this->_auto->err($e->getMessage());

						}

					}

					ksort($r['ls']);

				}

		    }else{

			    $r['e'] = 'no';

		    }

			return _jEnc($r);

		}


		public function _snt($p=NULL){

			$r['sveto'] = $this->server_lbl;

		    $this->_cnct();

		    if(!isN($this->cnx) && !isN($this->mbox)){

				$_prc = $this->mbox->addMessage($p['mime'], '\\Seen');

				if($_prc){
					$r['e'] = 'ok';
				}else{
					$r['w'] = $_prc;
				}

		    }else{

				$r['e'] = 'no';
				if(isN($this->cnx)){ $r['w'][] =  '$this->cnx is empty'; }
				if(isN($this->mbox)){ $r['w'][] =  '$this->mbox is empty'; }

				$r['tmp_vs'][] = $this->eml->id;
				$r['tmp_vs'][] = $this->c_eml;
				$r['tmp_csme'][] = $this->cnx_sme;
				$r['tmp_csme']['tmp_camilo'] = $this->tmp_camilo;

				$r['tmp_srv']['in'] = $this->server_in;
				$r['tmp_srv']['prt'] = $this->server_in_port;
				$r['tmp_srv']['cert'] = $this->server_cert;
				$r['tmp_srv']['user'] = $this->server_user;
				$r['tmp_srv']['user'] = $this->server_user;

		    }

		    return _jEnc($r);
		}



		public function _thrd_cln($p=NULL){
			$_r = str_replace(['<','>'], '', $p['v']);
			return $_r;
		}


		public function _thrd_get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {

		    if(!isN($uid)){

			    if (!$structure) {
			        $structure = imap_fetchstructure($imap, $uid, FT_UID);
			    }

			    if ($structure){

			        if ($mimetype == $this->_thrd_mime($structure)) {
			            if (!$partNumber) {
			                $partNumber = 1;
			            }
			            $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
			            switch ($structure->encoding) {
			                case 3: return imap_base64($text);
			                case 4: return imap_qprint($text);
			                default: return $text;
			           }
			       	}

			        if ($structure->type == 1) {
			            foreach ($structure->parts as $index => $subStruct) {
			                $prefix = "";
			                if ($partNumber) {
			                    $prefix = $partNumber . ".";
			                }
			                $data = $this->_thrd_get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
			                if ($data) {
			                    return $data;
			                }
			            }
			        }
			    }
		    }
		    return false;
		}

		public function _thrd_mime($structure) {
		    $primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

		    if ($structure->subtype) {
		       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		    }
		    return "TEXT/PLAIN";
		}


		public function _thrd_bdy($imap, $uid) {

			$body = $this->_thrd_get_part($imap, $uid, "TEXT/HTML");

			if(isN($body)) {
		        $body = $this->_thrd_get_part($imap, $uid, "TEXT/PLAIN");
			}

			if(isN($body)) {
				$body = imap_fetchbody($imap, $uid, "1");
			}

			if(isN($body)) {
				$body = imap_fetchbody($imap, $uid, "1.2");
			}

		    return $body;
		}


		public function _attch($p) {

			$attch=['ls'=>[],'tot'=>0];

			$this->_cnct();

			if(!isN($this->cnx) && !isN( $this->mbox )){

				/*echo 'BOXATTR:'.print_r($this->mbox->getAttributes(), true).PHP_EOL;
				echo 'ID:'.$p['id'].PHP_EOL;
				echo 'EML:'.$this->c_eml->id.PHP_EOL;
				echo 'BOXID:'.$this->box.PHP_EOL;
				echo 'MBOX:'.$this->server_lbl.PHP_EOL;
				echo 'MBOX(Class) Name:'.$this->mbox->getName().PHP_EOL;
				echo 'MBOX(Class) TOT:'.$this->mbox->count().PHP_EOL;*/

				$message = $this->mbox->getMessage( $p['id'] );

				if( !isN($message->getId()) ){

					//echo 'Subject:'.$message->getSubject().PHP_EOL;

					$attachments = $message->getAttachments();

					//echo 'Total attachments:'.count($attachments).PHP_EOL;

					foreach ($attachments as $attachment){

						//print_r( $attachment );

						//print_r( $attachment->getDecodedContent() );

						/*file_put_contents(
							'/var/www/.sumr_fle/' . $attachment->getFilename(),
							$attachment->getDecodedContent()
						);*/


						if(!isN($attachment->getFilename()) && substr($attachment->getFilename(),0,1) != '.'){

							$_id = str_replace(['<','>'],'',$attachment->getStructure()->id);
							//if(isN($_id)){ print_r($attachment); }

							$_ob = [
								'id'=>$_id,
								'type'=>$attachment->getType(),
								'subtype'=>strtolower($part->subtype),
								'filename'=>$attachment->getFilename(),
								'size'=>$attachment->getSize(),
								'content'=>$attachment->getDecodedContent(),
								'embed'=>$attachment->isEmbeddedMessage()?1:2,
							];

						}

						if(!isN($_ob)){
							array_push($attch['ls'], $_ob);
							$attch['tot']++;
						}

					}

				}

			}

			return $attch;

		}


		public function _cln_hdr($p=NULL){

			if(!isN($p['t'])){
				if($p['t']=='v'){

					$s = ['<','>'];
					$v = str_replace($s,'', $p['v'] );

					if($p['to_a'] == 'ok'){ // Si hay espacios se divide en arrays a partir del espacio
						if(strpos( $v, ' ' ) !== false){
							$_e = explode(' ', $v);
							$v = array();
							foreach($_e as $_go_v){
								if( strpos( $_go_v, '@' ) !== false ) {
									array_push($v, $this->_txdcde($_go_v));
								}
							}
							$v = $v;
						}else{
							$r = [ $v ];
							$v = $r;
						}
					}

				}elseif($p['t']=='k'){
					$s = [' '];
					$v = str_replace($s,'_',$p['v']);
					$v = strtolower($v);
				}
			}

			return $v;

		}

		public function _hdr($p=NULL){

			if(!isN($p['id'])){

				$this->_cnct();

				if(!isN($this->cnx) && !isN( $this->mbox )){

					$message = $this->mbox->getMessage( $p['id'] );

					if(!isN( $message->getId() )){

						if(!isN( $message->getHeaders() )){
							foreach($message->getHeaders() as $_hdr_k=>$_hdr_v){

								if($_hdr_k == 'in_reply_to' && $_hdr_v == 'false'){ continue; }
								if(in_array($_hdr_k, ['from','to','cc','bcc','reply_to','sender','referencess'] )){ continue; }

								if(in_array($_hdr_k, ['unseen','recent','flagged','answered','deleted','draft'] )){
									if($_hdr_v==1){ $_hdr_v='true'; }else{ $_hdr_v='false'; }
								}

								$r['ls'][$_hdr_k] = $_hdr_v;
								$r['tot']++;

							}
						}

					}

				}

			}

		    return _jEnc($r);

		}


		public function _unq_id($p=NULL){

			//-------------- LIMPIA ID - START --------------//

				if(!isN($p['v'])){
					if( strpos( $p['v'], '@' ) !== false ) {
						$_ex = explode('@', $p['v']);
						$v = $_ex[0];
					}else{
						$v = $p['v'];
					}
				}else{
					$v = $p;
				}

				return $v;

			//-------------- LIMPIA ID - END --------------//

		}

		public function _addr_c($p=NULL){

			$_str = $p[0]; // Real

			if ( preg_match('/\s/', $_str->mailbox) ){
				$__frg = explode(' ', $_str->mailbox);
				$__frgc = count($__frg);
			    $__usr = $__frg[ ($__frgc-1) ];
			}else{
			    $__usr = $_str->mailbox;
			}

			return $__usr . "@" . $_str->host;
		}

		public function _msg($p=NULL){

		    $r['e'] = 'no';
			$lmt = !isN($p['lmt'])?$p['lmt']:50;

		    try{

			    $this->_cnct();

				if(!isN($this->cnx) && !isN($this->mbox) && !isN($p['maxuid'])){

					$tot = $this->mbox->count();
					if($tot < 1000){ $lmt=500; }

					//echo '------------------TOT------------------'.PHP_EOL;
					//echo $tot.PHP_EOL.PHP_EOL.PHP_EOL;

					if(!isN($p['nxt'])){
						$__uid = $p['nxt'];
						$__str = $__uid.':'.($__uid+$lmt);
					}elseif(!isN($p['from']) && !isN($p['to'])){
						$__str = $p['from'].':'.$p['to'];
						$__schmre = 'no';
					}else{
						$__str = '1:'.$lmt;
					}

					$msgs = $this->mbox->getMessageSequence($__str);

					echo $this->_auto->li( 'getMessageSequence:'.$__str );

					if($msgs->count() == 0 && isN( $p['nxt'] ) && $__schmre != 'no'){ // If not search trough first 1:50, search all with count UID
						$msgs = $this->mbox->getMessageSequence("1:".$tot);
					}

					//echo $this->_auto->li( '$msgs->count()---------------->'.$msgs->count() );

					if($msgs->count() == 0 && isN($p['nxt']) && $__schmre != 'no'){ // If not search trough all range, search all

						$search = new SearchExpression();
						$search->addCondition( new RawExpression('ALL') );
						$__sch = $this->mbox->getMessages($search);

						$__str = $__sch[0].':'.($__sch[0]+$lmt);
						$msgs = $this->mbox->getMessageSequence($__str);

					}elseif($msgs->count() == 0 && !isN($p['nxt']) && $__schmre != 'no'){ // Try to jump another close number of message

						//echo '$this->mbox-------------------'.print_r($this->mbox, true).PHP_EOL.PHP_EOL;

						$search = new SearchExpression();
						$search->addCondition( new RawExpression('ALL') );
						$__sch = $this->mbox->getMessages($search);

						//------------ TEMPO TO SHOW LISTS GET IT FORCED - START ------------//

							// foreach ($__sch as $__sch_message_k=>$__sch_message_v){
							// 	echo '('. $__sch[ ( $this->mbox->count() - 1 ) ] .') '.$__sch_message_v->getNumber().' -> '.$p['nxt'].' -> '.count($__sch).PHP_EOL;
							// }

						//------------ TEMPO TO SHOW LISTS GET IT FORCED - END ------------//

						foreach ($__sch as $__sch_message){
							if($__sch_message->getNumber() > $p['nxt']){
								$_new_nxt=$__sch_message->getNumber();
								break;
							}
							//echo $__sch_message->getNumber().' -> '.$p['nxt'].PHP_EOL;
						}

						if(!isN($_new_nxt)){
							$__str = $_new_nxt.':'.($_new_nxt+$lmt);
							$msgs = $this->mbox->getMessageSequence($__str);
						}

					}elseif($msgs->count() == 0){ // Try with last uid of box

						echo $this->_auto->li('$this->mbox---------E X C E P T I O N----------');
						echo $this->_auto->li('$__str:'.$__str);
						echo $this->_auto->li('$msgs->count():'.$msgs->count());
						echo $this->_auto->li('$p[nxt]:'.$p['nxt']);

					}

					$r['sqnc'] = $__str;

					if($msgs && $msgs->count() > 0){

						$r['tot']['b'] = $tot;
						$r['tot']['s'] = $msgs->count();
						$r['ls'] = [];
						$eid=0;

						foreach($msgs as $msgs_k=>$msgs_v){

							if(!isN( $msgs_v->getId() )){

								//-------------- BUILD MESSAGE ALL - START --------------//

									$_ob_msg = [
										'id'=>$msgs_v->getId(), // ID del mensaje
										'no'=>$msgs_v->getNumber(), // ID del mensajeç
										'date'=>$msgs_v->getDate(), // Fecha
										'sbj'=>$msgs_v->getSubject(), // Asunto
										//'ref'=>$msgs_v->getReferences(), // Asunto
										'hattch'=>$msgs_v->hasAttachments() // Has Attachments
									];

								//-------------- HEADERS --------------//

									if(!isN( $msgs_v->getHeaders() )){
										foreach($msgs_v->getHeaders() as $_hdr_k=>$_hdr_v){
											if(!in_array($_hdr_k, ['from','to','cc','bcc','reply_to','sender'] )){
												if(in_array($_hdr_k, ['unseen','recent','flagged','answered','deleted','draft'] )){
													if($_hdr_v==1){ $_hdr_v='true'; }else{ $_hdr_v='false'; }
												}
												$_ob_msg['attr'][$_hdr_k] = $_hdr_v;
											}
										}
										if(!isN($_ob_msg['attr']['maildate'])){ $_ob_msg['datem'] = $_ob_msg['attr']['maildate']; }
									}

								//-------------- REFERENCES --------------//

									if(!isN( $msgs_v->getReferences() )){
										foreach($msgs_v->getReferences() as $_ref_k=>$_ref_v){

											if((strpos($_ref_v, ',') !== false)){

												$separate = explode(",", $_ref_v);

												if(count($separate)==1){
													$separate = explode(' ',$_ref_v);
												}

												if(count($separate)>1){
													foreach($separate as $separate_k=>$separate_v){
														if( strlen( trim($separate_v) ) > 5 ){
															$_ob_msg['ref'][] = trim($separate_v);
														}
													}
												}else{
													if( strlen( trim($_ref_v) ) > 5 ){
														$_ob_msg['ref'][] = trim($_ref_v);
													}
												}

											}else{
												if(!isN($_ref_v)){
													$_ob_msg['ref'][] = $_ref_v;
												}
											}

										}
									}

								//-------------- FROM --------------//

									if(!isN( $msgs_v->getFrom() )){
										$_from = $msgs_v->getFrom();
										if(filter_var($_from->getAddress(), FILTER_VALIDATE_EMAIL)){
											$_ob_msg['from'][] = [
												'nm'=>$_from->getName(),
												'eml'=>$_from->getAddress()
											];
										}
									}

								//-------------- REPLY TO --------------//

									if(!isN( $msgs_v->getReplyTo() )){
										foreach($msgs_v->getReplyTo() as $_rplyto_k=>$_rplyto_v){
											if(filter_var($_rplyto_v->getAddress(), FILTER_VALIDATE_EMAIL)){
												$_ob_msg['rply'][] = [
													'nm'=>$_rplyto_v->getName(),
													'eml'=>$_rplyto_v->getAddress()
												];
											}
										}
									}

								//-------------- TO --------------//

									if(!isN( $msgs_v->getTo() )){
										foreach($msgs_v->getTo() as $_to_k=>$_to_v){
											if(filter_var($_to_v->getAddress(), FILTER_VALIDATE_EMAIL)){
												$_ob_msg['to'][] = [
													'nm'=>$_to_v->getName(),
													'eml'=>$_to_v->getAddress()
												];
											}
										}
									}

								//-------------- CC --------------//

									if(!isN( $msgs_v->getCc() )){
										foreach($msgs_v->getCc() as $_cc_k=>$_cc_v){
											if(filter_var($_cc_v->getAddress(), FILTER_VALIDATE_EMAIL)){
												$_ob_msg['cc'][] = [
													'nm'=>$_cc_v->getName(),
													'eml'=>$_cc_v->getAddress()
												];
											}
										}
									}

								//-------------- BCC --------------//

									if(!isN( $msgs_v->getBcc() )){
										foreach($msgs_v->getBcc() as $_bcc_k=>$_bcc_v){
											if(filter_var($_bcc_v->getAddress(), FILTER_VALIDATE_EMAIL)){
												$_ob_msg['bcc'][] = [
													'nm'=>$_bcc_v->getName(),
													'eml'=>$_bcc_v->getAddress()
												];
											}
										}
									}

								//-------------- ATTACHMENTS --------------//

									if(!isN( $msgs_v->getAttachments() )){
										foreach($msgs_v->getAttachments() as $_attch_k=>$_attch_v){
											if(!isN($_attch_v->getFilename()) && substr($_attch_v->getFilename(),0,1) != '.'){
												$_ob_msg['attch'][] = [
													'nm'=>$_attch_v->getFilename()
												];
											}
										}
									}


								//-------------- BUILD --------------//

									array_push($r['ls'], $_ob_msg);
									$r['luid'] = $msgs_v->getNumber();

									$eid++;

							}

						}

						//-------------- IF LAST UID IS SAME TO START INCREASE --------------//

						if(	$r['luid'] == $__uid &&
							($__uid+$lmt) > $__uid &&
							($__uid+$lmt) <= $p['maxuid']
						){
							$r['luid'] = $__uid+$lmt;
						}

					}else{

						//echo 'No messages (0) on request so have to increase next record ---------------->'.$__str.PHP_EOL;

						if(
							$msgs->count() == 0 &&
							($__uid+$lmt) <= $p['maxuid']
						){
							$r['luid'] = $__uid+$lmt;
						}

						if(!isN( imap_last_error() )){
							$r['w'] = imap_last_error();
						}else{
							$r['tot']['s'] = 0;
							if(!isN($msgs_e)){ $r['w'] = $msgs_e; }
						}

					}

				}else{

					if(isN($this->cnx)){ echo $this->_auto->err('('.$this->c_eml.'-'.$this->eml->id.') $this->cnx empty '); }
					if(isN($this->mbox)){ echo $this->_auto->err('('.$this->c_eml.'-'.$this->eml->id.') $this->mbox empty '.print_r($this->mbox, true)); }
					//echo compress_code( print_r( $this->eml, true ) );
					if(isN($this->server_in)){ echo $this->_auto->err('$this->server_in empty'); }
					if(isN($this->server_user)){ echo $this->_auto->err('$this->server_user empty'); }
					if(isN($this->server_pass)){ echo $this->_auto->err('$this->server_pass empty'); }
					if(isN($this->server_lbl)){ echo $this->_auto->err('$this->server_lbl empty'); }


					if(!isN(imap_last_error())){ echo $this->_auto->err( imap_last_error() ); }

					$r['w'] = imap_last_error();
					$r['m'] = 'Imap connection false';

				}

			}catch(Exception $e){
			    $r['w'] = $e->getMessage();
			}

			return _jEnc($r);
		}




	    public function _msg_html($p=NULL){

			$r['e'] = 'no';

		    try{

				$this->_cnct();

				if(!isN($this->cnx) && !isN($this->mbox) && !isN($p['id'])){

				//-------------- BODY MESSAGE CODIFICATION --------------//

					$message = $this->mbox->getMessage( $p['id'] );
					$r['html'] = $message->getBodyHtml();
					$r['plain'] = $message->getBodyText();

					if(!isN($r)){
						return $r;
					}else{
						$r['w'] = 'No content on html body';
					}

				//-------------- RETURN RESPONSE --------------//

				}elseif(isN($p['id'])){
					$r['w'] = 'No get id';
				}else{
					$r['w'] = imap_last_error();
					$r['p'] = $this->_Url;
					$r['m'] = 'Imap connection false';
				}

			}catch(Exception $e){
			    $r['w'] = $e->getMessage();
			}

			return _jEnc($r);
		}



    }
?>
