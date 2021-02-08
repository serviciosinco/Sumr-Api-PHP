<?php $___ses_chk = new CRM_SES(); //$___ses_chk->__ck_cln([ 'dstry'=>'ok' ]); ?>
<div class="BxLgout">
<script type="text/javascript"> 


function removeCookies() {
    var res = document.cookie;
    var multiple = res.split(";");
    for(var i = 0; i < multiple.length; i++) {
       var key = multiple[i].split("=");
       document.cookie = key[0]+" =; expires = Thu, 01 Jan 1970 00:00:00 UTC";
    }
 }
         
         
function ClsBx(){ 
	removeCookies();

	if(window.location.href.indexOf('?') > -1) {
       var urlsep='';
    }else{
	    var urlsep='?';
    }
	
	__sis_rfrsh({ d:'<?php echo DMN_CRM; ?>' });
}

SUMR_Main.anm.shwLd({ id:'_m_ldr' });

</script>
	<?php echo h1(TX_SES_FN) ?>

    <div class="cnt2">
    	<input type="button" name="cancelar" id="cancelar" value="iniciar sesión" class="can" onclick="javascript:ClsBx();"/>
	</div>
</div>