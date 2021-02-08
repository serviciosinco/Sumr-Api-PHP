<?php 
	$__i = Php_Ls_Cln($_POST['__i']);
	$__t = Php_Ls_Cln($_POST['_t']);
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;
?>

<div class="UplFleNw">
	
    <form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.__t('up_rd',true) ?>" enctype="multipart/form-data">
        
        <div id="<?php echo $__id_drop ?>" class="_drop">
            
            <div class="_bar"></div>
            <?php echo TX_ARRTRAQ ?><br>
            
            	<?php
				 			        
		        	if($__t == 'rd_fle'){
			            echo Spn(TX_FLE_SUP.' (.pdf)');
		            }else{ 
			            echo Spn(TX_FLE_SUP.' (JPG, PDF, PNG)'); 
			        }    
		            
		        ?>   
		        
            <a><?php echo TX_EXPLR ?></a>
            <input type="file" name="upl" multiple />
            <input ide="_id" name="_id" type="hidden" value="<?php echo $__i; ?>" />
            <input type="file" name="upl" multiple />
            <input ide="_id_fle" name="_id_fle" type="hidden" value="<?php echo $__i_f; ?>" />
            <input ide="_id_rlc" name="_id_rlc" type="hidden" value="<?php echo $__i; ?>" />
            <input id="__tsim" name="__tsim" type="hidden" value="<?php echo $__t ?>" />
            <input name="MM_update_fle" type="hidden" value="FleUplNw" />
        </div>
        <ul></ul>
    </form>
</div>
<?php $CntWb .= "SUMR_Main.upl.init({ btn:{ id:'$__id_drop' }, fm:'$__id_upld_nw' });"; ?>