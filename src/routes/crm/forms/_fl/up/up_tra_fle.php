<?php 
    $__t = Php_Ls_Cln($_POST['_t']);
    $_mdl_cnt = Php_Ls_Cln($_GET['mdl_cnt']);

	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'UplNwB'.$__id_rnd;
?>

<div id="UplImg_Bx" class="UplFleNw">
    <form id="<?php echo $__id_upld_nw ?>" method="post" class="UplNwB" action="<?php echo PRC_UPLD_GN.__t('up_tra_fle',true) ?>" enctype="multipart/form-data">
        <div id="<?php echo $__id_drop ?>" class="_drop">   
            <div class="_bar"></div>
            <?php echo TX_ARRTRAQ ?><br>
            <?php echo Spn(TX_FLE_SUP.' ( jpg, jpeg, pdf, png, gif, doc, docx, xls, xlsx)' ); ?>    
            <a><?php echo TX_EXPLR ?></a>
            <input type="file" name="upl[]" multiple />
            <input ide="_id" name="_id" type="hidden" value="<?php echo $_i; ?>" />
            <input ide="_mdl_cnt" name="_mdl_cnt" type="hidden" value="<?php echo $_mdl_cnt; ?>" />
            <input name="MM_update_fle" type="hidden" value="FleUplNw" />
        </div>
        <ul></ul>
    </form>
</div> 
    
<?php $CntWb .= "

    SUMR_Main.upl.init({
        btn:{ id:'$__id_drop' }, 
        fm:'$__id_upld_nw',
        cbck:(e,t)=>{
            if(!isN(t.result) && !isN(t.result.attch)){
                for(let k in t.result.attch){
                    var v = t.result.attch[k];
                    SUMR_Tra.mdlcnt.attch.add( v );
                }
                SUMR_Tra.mdlcnt.attch.bld({ glst:'ok' });
            }
            
            setTimeout(function(){
                SUMR_Main.pnl.f.shw();
            }, 2000);
        },
        cw:()=>{
        
        }
    });

"; 
    
?>

<style>

    ._icn{ background-position: center;background-size: 40% auto;background-repeat: no-repeat;width: 400px;height: 180px;margin: 20px auto;background-image: url(); }

</style>