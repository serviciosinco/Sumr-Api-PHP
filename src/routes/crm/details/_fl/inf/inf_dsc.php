<?php
	
	$__report_d = __LsDt(['k'=>'sis_inf', 'id'=>$___Dt->gt->isb, 'tp'=>'enc', 'no_lmt'=>'ok' ]);

?>
<div class="dsh_inf_detail">
	<h1><?php echo Spn('','','_icn','background-image:url('.$__report_d->d->img.');').$__report_d->d->tt; ?></h1>  
	<div class="dsc"><?php echo $__report_d->d->dsc->vl; ?></div>  					
</div>                                                                  
<style>
	
	.dsh_inf_detail *{ background-repeat: no-repeat; font-family: Roboto; }
	.dsh_inf_detail h1{ font-family: Source Sans Pro; text-transform: uppercase; font-size: 40px; display: block; text-align: center; margin-bottom: 50px; font-weight: 200; }
	.dsh_inf_detail h1 span._icn { width: 45px; height: 35px; display: inline-block; margin-bottom: -3px; margin-right: 10px; background-size: auto 90%; background-position: center center; }
	.dsh_inf_detail .dsc{ padding: 20px 10px 20px 10px; font-family: Roboto; font-size: 14px; color: #a19c9c; }
	
</style>
