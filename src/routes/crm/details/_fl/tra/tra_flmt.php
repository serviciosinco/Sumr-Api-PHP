<?php 
if(!isN($___Dt->gt->i)){
  	
	$_dt_tra = GtTraDt([ 'id'=>$___Dt->gt->i, 't'=>'enc' ]);
	
?>
<div class="Dsh_Tra_FLmt">
  	<section class="_cvr" style="background-color:#fff; margin-top: 45px;"></section>	
  	<div class="f_lmt">	
  		<?php echo SlDt([ 'id'=>'tra_f', 'va'=>$_dt_tra->f, 'rq'=>'no', 'lmt'=>'minDte', 'ph'=>TX_FCHLMT, 'lmt'=>'no', 'cls'=>CLS_CLND ]); ?>
  		<?php echo SlDt([ 'id'=>'tra_h', 'va'=>$_dt_tra->h, 'rq'=>'no', 't'=> 'hr', 'ph'=>TX_HRLMT, 'lmt'=>'no', 'cls'=>CLS_HOUR, 'onS'=>' SUMR_Tra.f.tmeChng(sT); ' ]); ?>
		<?php $l = __Ls([ 'k'=>'sis_tme_rng', 'id'=>'tra_bfr', 'va'=>$_dt_tra->bfr, 'ph'=>TX_RMBR ]); echo $l->html; $CntWb .= $l->js; ?> 
  		<?php echo $___Dt->_ntf_on(); ?>
  	</div>
	<?php $CntWb .= "SUMR_Tra.f.DtDom();"; ?>
</div>
<?php } ?>