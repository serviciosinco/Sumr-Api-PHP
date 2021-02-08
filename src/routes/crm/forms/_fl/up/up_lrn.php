<?php 
	$__i = Php_Ls_Cln($_GET['__i']);
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;
	$_frm = Php_Ls_Cln($_GET['_frm']);
?>

<style>
	.ldr_sim{  background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>loader_sim.svg');
		background-size: 100px; background-position: center; cursor: pointer; background-repeat: no-repeat;height: 100px; width: 100px; margin: auto;
		margin-top: 25px;
	}
	.div_ldr_sim{ position: relative; width: 100%; height: 100%; margin-top: -25px;}
	.div_ldr_sim span{ color:#6f6a6a; position: relative; top: 20px; }
	
	.div_ldr_sim{ display: none; }
</style>

<div class="UplFleNw">
        <form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.__t('up_lrn',true) ?>" enctype="multipart/form-data">
            <div id="<?php echo $__id_drop ?>" class="_drop">
                <div class="_bar"></div>	
	                <div class="_all">
	                <?php echo TX_ARRTRAQ ?><br><?php echo Spn(TX_ARCHZIP);  ?>
	                <a><?php echo TX_EXPLR ?></a>
	                <input type="file" name="upl" multiple />
	                <input ide="_id" name="_id" type="hidden" value="<?php echo $__i; ?>" />
	                <input name="MM_update_fle" type="hidden" value="FleUplNw" />
	                <input name="_frm" type="hidden" value="<?php echo $_frm; ?>" />
                </div>
                <div class="div_ldr_sim">
					<span><?php echo TX_SPRVRMIN ?></span>
                	<div class="ldr_sim"></div>
				</div>
            </div>
            <ul></ul>
        </form>
</div> 
<?php 
    $CntWb .= "
            SUMR_Main.upl.init({ 
                btn:{ id:'$__id_drop' }, 
                fm:'$__id_upld_nw',
                cbck:()=>{
                    $('.div_ldr_sim').hide('slow');
                    $('._all').show('slow');
                }
            });
        "; 
?>
