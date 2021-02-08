<?php 

	$nojs = 'ok';
	$__no_json='ok';
	header('Content-type: text/xml; charset=utf-8'); 
	
	$__sid = Php_Ls_Cln($_POST['CallSid']);
	$__ctel = Php_Ls_Cln($_GET['PhoneNumber_Id']);
	$__dgts = Php_Ls_Cln($_POST['Digits']);
	
	$__clid = Php_Ls_Cln($_GET['SUMR_Cl']);
	$__utel = Php_Ls_Cln($_GET['SUMR_UserTel']);
	
	$__host_all = CRM_CLL.'mydvc/';
	$__get_all = "SUMR_Cl=".$__clid."&SUMR_UserTel=".$__utel."&PhoneNumber_Id=".$__ctel;
	
?>
<?php if($__p4_o == 'agent'){ ?>
	<Response>
	    <Gather timeout="10" numDigits="1" method="POST" action="<?php echo $__host_all .'accept/?'. htmlspecialchars($__get_all) ?>">
	        <Say language="es" voice="woman">Conectando desde CRM. Oprime el numero unoo para continuar</Say>
	    </Gather>
	</Response>	
<?php }elseif($__p4_o == 'accept'){ ?>	
	<?php			
		if($__utel != ''){ $__UsTelDt = GtUsTelDt(['id'=>$__utel]); }
		if($__UsTelDt->telc != NULL){ $___tel_call = $__UsTelDt->telc; }else{ $___tel_call = TWL_N_1; }	
		if($__ctel != ''){ $__TelDt = GtCntTelDt([ 'bd'=>$__cl_dt->bd, 'id'=>$__ctel, 't'=>'enc']); }
	?>
	<Response>
		<?php if($__dgts != ''){ ?>
		<Dial callerId="<?php echo $___tel_call ?>" timeout="20" record="true">
			<Number><?php echo $__TelDt->telc ?></Number>
		</Dial>	
		<?php } ?>
	</Response>	
<?php } ?>	