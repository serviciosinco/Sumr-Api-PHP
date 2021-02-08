<?php 
	$__i = Php_Ls_Cln($_POST['__i']);
	$__t = Php_Ls_Cln($_POST['_t']);
	$__box = Php_Ls_Cln($_POST['__box']);
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;

?>

<div id="UplImg_Bx" class="UplImg_Bx" <?php if($row_Dt_Rg[$ImNm] != ''){ ?> style="display:none;" <?php } ?>>

   	<form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.__t('up_anx',true) ?>" enctype="multipart/form-data">
	        
	    <div>    
	        <div id="<?php echo $__id_drop ?>" class="_drop ok _anm">
	            
	            <div class="_bar"></div>
	            <?php echo TX_ARRTRAQ ?><br>
	            <span class="tp_doc"></span>
	            	<?php

				        echo Spn(TX_FLE_SUP.' (JPG, PDF)');
 
			        ?>   
			        
	            <a><?php echo TX_EXPLR ?></a>
	            <input type="file" name="upl" multiple />
	            <input id="id_appl" name="id_appl" type="hidden" value="<?php echo $__i; ?>" />
	            <input id="id_tp" name="id_tp" type="hidden" value="" />
	            <input id="___cl" name="___cl" type="hidden" value="<?php echo $__cl->enc ?>" />
	            <input name="MM_update_fle" type="hidden" value="FleUplNw" />
	            	            
	            
	        </div>
	        
	        <?php $l = __Ls(['k'=>'ls_anx', 'id'=>'cntapplanx_attr', 'va'=>'' , 'ph'=>TX_DC_TP]); ?>
	        <?php echo $l->html; $CntWb .= $l->js; ?>
	        
	        <div class="ls_anx _anm">
		        <ul class="itms_anx"> </ul>
	        </div>
        </div>
        <ul class="anx_ing"></ul>
    </form>
</div> 

<style>
	
	#UplImg_Bx{min-height:300px;text-align:center;width:100%;margin:0 auto;border:4px dashed #bbb}
	#UplImg_Bx .UplNwB{width:100%;background-color:#fff;position:relative}
	#UplImg_Bx ._drop.ok{background-color:#e8e8e8;border:0!important;width:100%;display:inline-block}
	#UplImg_Bx .ls_anx.ok{width:33%;display:inline-block}
	#UplImg_Bx .ls_anx{width:33%;display:inline-block;vertical-align:top;margin-left:50px}
	#UplImg_Bx .ls_anx li{cursor:pointer;height:40px!important;color:#9e9e9e!important;padding:10px!important;margin:10px 0}
	#UplImg_Bx .UplNwB .ls_anx ul{border:0}
	#UplImg_Bx .UplNwB .ls_anx ul li.on span{width:15px;height:100%;display:inline-block;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>check-mark.svg);top:0;right:5px}
	#UplImg_Bx .UplNwB .ls_anx ul li.off span{width:15px;height:100%;display:inline-block;background-image:none;top:0;right:5px}
	#UplImg_Bx .UplNwB ul{border:0!important}
	#UplImg_Bx .ls_anx li{cursor:pointer;height:40px!important;color:#5f5656!important;padding:10px!important;margin:10px 0;border:2px dashed #d8d8d8!important;border-radius:4px;background-color:#f3f3f3!important;background-image:none!important}
	#UplImg_Bx .ls_anx li:hover{background-color:#d8d8d8!important}

</style>

<?php $CntWb .= "
    SUMR_Main.upl.init({ 
		btn:{
			id:'$__id_drop',
			cbck:()=>{
				if( isN( $('#cntapplanx_attr').val() ) ){
					swal('Error', 'Porfavor selecciona el tipo de documento a subir.', 'error'); 	   
				}else{
					$(this).parent().find('input').click();
				}
			}
		}, 
		fm:'$__id_upld_nw',
		cbck:()=>{
			_ldCnt({ u:SUMR_Main.url['__ld_".$__box."'].lnk, c:SUMR_Main.url['__ld_".$__box."'].box });
		}
	});
	
"; 

?>