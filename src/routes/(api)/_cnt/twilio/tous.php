<?php

	header('Content-type: text/xml');
	$nojs='ok';
	$__no_json='ok';

	try {
    
		
		if (isset($_REQUEST['PhoneNumber'])) {
	   		$number = htmlspecialchars($_REQUEST['PhoneNumber']);
		}
	
		if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
		    $numberOrClient = "<Number>" . $number . "</Number>";
		}
	
		$__TelDt = GtCntTelDt([ 'bd'=>$__cl_dt->bd, 'id'=>$_POST['PhoneNumber_Id'], 't'=>'enc' ]);
		if(!is_numeric($_POST['SUMR_MdlCnt'])){ $__mdlcnt_dt = GtMdlCntDt([ 'bd'=>$__cl_dt->bd, 'id'=>$_POST['SUMR_MdlCnt'], 't'=>'enc' ]); }
		
		$__CallIn = new CRM_Call([ 'cl'=>$__cl_dt ]);
		$__CallIn->tel = $__TelDt->id;
		$__CallIn->sid = $_POST['CallSid'];
		$__CallIn->appsid = $_POST['ApplicationSid'];
		$__CallIn->apiversion = $_POST['ApiVersion'];
		$__CallIn->caller = $_POST['Caller'];
		$__CallIn->callstatus = $_POST['CallStatus'];
		$__CallIn->phonenumber = $_POST['PhoneNumber'];
		$__CallIn->duration = $_POST['Duration'];
		$__CallIn->callduration = $_POST['CallDuration'];
		
		//-------------- RELACION A OTROS DATOS --------------//
		
			$__CallIn->cnt = $_POST['SUMR_Cnt'];
			$__CallIn->mdlcnt = $__mdlcnt_dt->enc;
		
		//-------------- FIN - RELACION A OTROS DATOS --------------//
		
		$__CallIn->user = $__us_dt->id;
		$__CallIn->userTel = $_POST['SUMR_UserTel'];
		$__CallIn->userDvc = $_POST['SUMR_UserDvc'];
		
		$PrcDt = $__CallIn->Sve();	
				
?>
		<?php if($numberOrClient != ''){ ?>
			<?php 
				if($_POST['SUMR_UserTel'] != ''){ $__UsTelDt = GtUsTelDt(['id'=>$_POST['SUMR_UserTel']]); }
				if($__UsTelDt->telc != NULL){ $___tel_call = $__UsTelDt->telc; }else{ $___tel_call = TWL_N_1; }		
			?>
			<Response>	
			    <Dial callerId="<?php echo $___tel_call ?>" record="true">
			    	<?php echo $__TelDt->telc ?>
			    </Dial>
			</Response>
		<?php }else{ ?>	
			<Response>	
		
			</Response>
		<?php } ?>
<?php
		
	} catch (Exception $e) {
		
	    echo $e->getMessage();
	    
	}

?>