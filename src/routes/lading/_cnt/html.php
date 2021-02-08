<?php



	if($__owndmn == 'ok'){
		$__c_lnd->html->bse = $_SERVER['HTTP_HOST'];
	}

	//------------------ Redirect Landing to Whatsapp ------------------//

		if(!isN($__whtsp) && isMobile()){
			$__c_lnd->_Add_Hdr(' window.location.href = "https://api.whatsapp.com/send?phone='.$__whtsp.'&text='.$__whtsp_txt.'"; ', ['tag'=>'ok']);
		}

	//------------------ Fix and Print HTML ------------------//

		$___html = $__c_lnd->_bld();

		if($__c_lnd->__dtlnd->opt->cmprs == 'ok'){ ob_start("compress_code"); }

		echo $___html;

?>
<script type="text/javascript">
	var SUMR_Main={slc:{ sch:''}};
	<?php echo compress_code($__c_lnd->_Js()); ?>
</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>sb/lnd/main.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php if($__c_lnd->__dtlnd->opt->cmprs == 'ok'){ ob_end_flush(); } ?>