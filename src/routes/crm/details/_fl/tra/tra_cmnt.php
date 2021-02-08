<?php 
if(!isN($___Dt->gt->i)){
      
	$_dt_tra = GtTraCmntDt([ 'id'=>$___Dt->gt->i, 't'=>'enc' ]);
	
?>
<div class="Dsh_Tra_Cmnt">
    <h1>
        <div class="_icn_cmnt" style="background-image:url(<?php echo $_dt_tra->us->img; ?>)"></div>
        <?php echo $_dt_tra->us->nm.' '.$_dt_tra->us->ap ?> <span>dijo...</span>
    </h1>
    <div class="txt"><?php echo $_dt_tra->tt; ?></div>  	
</div>
<?php } ?>