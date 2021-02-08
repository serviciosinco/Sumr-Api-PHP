<?php 
	$_i = Php_Ls_Cln($_GET['_i']);
	$__i = Php_Ls_Cln($_GET['__i']);

	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_drop = 'drop'.$__id_rnd;
	$__id_upld_nw = 'Upl_Db'.$__id_rnd;
?>

<div class="Upl_Db" style="display:none;">
    <form id="<?php echo $__id_upld_nw ?>" method="post" class="Upl_Db" action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPLDB ?>" enctype="multipart/form-data">
        <div id="<?php echo $__id_drop ?>" class="_drop">
            <div class="_bar"></div>
            <?php echo TX_ARRTRAQ ?><br><?php echo Spn(TX_SPRTFL);  ?>
            <a>Explorar</a>
            <input type="file" name="upl" multiple />
            <?php if($_i != ''){ ?>
                <input ide="_id" name="_id" type="hidden" value="<?php echo $_i; ?>" />
            <?php } ?>
            <input id="__tup" name="__tup" type="hidden" value="<?php echo $__t ?>" />
            <?php if($__t == 'ec_lsts_up' || $__t == 'snd_ec_lsts_up'){ ?>
                <input id="__ec_lsts_rlc" name="__ec_lsts_rlc" type="hidden" value="<?php echo $__i ?>" />
            <?php }elseif($__t == 'snd_sms_cmpg_up' || $__t == 'sms_cmpg_up'){ ?>               
                <input id="__sms_cmpg_rlc" name="__sms_cmpg_rlc" type="hidden" value="<?php echo $__i ?>" />
            <?php } ?>
            <input name="MM_update_fle" type="hidden" value="FleUpDb" />
        </div>
    </form>
</div>
<?php 

    if($__t == 'snd_ec_lsts_up'){

    }else{
        $_onload = '$.colorbox.close();';
    }

    $CntWb .= "

        $('.Upl_Db').fadeIn();

        SUMR_Main.upl.init({
            btn:{ id:'$__id_drop' }, 
            fm:'$__id_upld_nw',
            cbck:(e,t)=>{

                $('#{$__id_upld_nw}').fadeOut('slow', function(){ 
                                    
                    var _tme = '',
                        _opt = { 
                            u:'".Fl_Rnd(FL_UP_GN.__t($__t,true)).ADM_LNK_DT."'+t.result.enc,  
                            pop:'ok', 
                            pnl:{
                                e:'ok',
                                s:'l',
                                tp:'h'
                            },
                            cls:'_fll',
                            scrl:'ok',
                            _cl:function(){
                                if(!isN(SUMR_Main.cbxGo)){ 
                                    /*SUMR_Main.cbxGo();*/
                                }
                            }
                        };
                    
                    
                    if( $('#colorbox').css('display') == 'block' ){
                        _opt.pnl = {
                            e:'ok',
                            s:'l',
                            tp:'h',
                            sw:'ok'
                        };

                        _tme = 100;
                    }else{
                        {$_onload}
                        _tme = 600;
                    }

                    setTimeout(()=>{ _ldCnt( _opt ); }, _tme);

                });

            }
        });
    ";
?>