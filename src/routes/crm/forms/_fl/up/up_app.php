<?php 
	$__i = Php_Ls_Cln($_GET['__i']);
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;
?>

<div class="UplFleNw">
    <form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.__t('up_app',true) ?>" enctype="multipart/form-data">
        <div id="<?php echo $__id_drop ?>" class="_drop">
            <div class="_bar"></div>
            <?php echo TX_ARRTRAQ ?><br><?php echo Spn(TX_ARCHZIP);  ?>
            <a><?php echo TX_EXPLR ?></a>
            <input type="file" name="upl" multiple />
            <input ide="_id" name="_id" type="hidden" value="<?php echo $__i; ?>" />
            <input name="MM_update_fle" type="hidden" value="FleUplNw" />
        </div>
        <ul></ul>
    </form>
</div> 
<?php $CntWb .= "SUMR_Main.upl.init({ btn:{ id:'$__id_drop' }, fm:'$__id_upld_nw' });"; ?>