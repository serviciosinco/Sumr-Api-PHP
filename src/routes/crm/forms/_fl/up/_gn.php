<?php



	 	$___Ls = new CRM_Ls();


	/*if(($_GET['_pop']=='ok')){ $_bxpop = 'ok'; ?>
	 	<div class="pop_cnt">
	 	<?php echo bdiv(['id'=>ICN_LDR_POP]);
	}*/
?>

<div class="__fm">
    <div id="_m_ldr_pop" class="_m_ldr_pop" style="display:none;"></div>
    <div id="_m_ldr_pop_tx" class="_m_ldr_pop_tx" style="display:none;"><?php echo TX_LOADCNT ?></div>
</div>
<?php

	if(ChckSESS_adm() || ChckSESS_usr()){

		if(($__t == 'snd_ec_lsts_up' || $__t == 'ec_lsts_up') || $__t == 'dnc' || $__t == 'sms_cmpg_up' || $__t == 'cnt' || $__t == 'mdl_cnt' || $__t == 'act_cnt_up' || $__t == 'mdl_cnt_tra'){
			include(GL_UP.FM_GN_UP_DB);
		}elseif($__t){

		}

	}else{

		echo SESS_again();

	}

	$CntWb .= "$('.chosen-select').chosen({width: '100%', allow_single_deselect: true});";

	if($___to_inc != ''){ include($___to_inc); }

?>
<?php /*if($_bxpop){ ?></div><?php }*/ ?>