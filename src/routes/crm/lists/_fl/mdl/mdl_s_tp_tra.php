<?php
if(class_exists('CRM_Cnx')){

	$___Ls->fm->id = 'BxFm'.$___Ls->id_rnd;

    $___Ls->qrys = sprintf("SELECT
                                    * 
                                FROM
                                    "._BdStr(DBM).TB_MDL_S_TP_TRA."
                                    INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlstptra_mdlstp = id_mdlstp
                                    INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstptra_cl = id_cl
                                WHERE
                                    mdlstp_enc = %s AND cl_enc = %s ",

                                    GtSQLVlStr($___Ls->gt->isb, "text"),
                                    GtSQLVlStr(DB_CL_ENC, "text")
                        );
		
    $___Ls->_bld();

?>


<div class="FmTb">



	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

        

    	<?php $___Ls->_bld_f_hdr(); ?>   
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
        <div class="ln_1">

            <div class="Tt_Tb _anm mdlstptra_tt">
                <div class="__hdr_btn">
                    <div class="___edt">
                        <button class="mdlstptra_sve _anm _mny" autocomplete="off">
                            <span class="_anm">Guardar</span>
                        </button>
                    </div>
                </div>
            </div>

	        <div class="col_1">
                <?php echo HTML_inp_hd('mdlstptra_enc', ctjTx($___Ls->ls->rw['mdlstptra_enc'],'in')); ?>
                <?php echo HTML_inp_tx('mdlstptra_tt_dft', TX_TT, ctjTx($___Ls->ls->rw['mdlstptra_tt_dft'],'in'), '', '', ''); ?>
                <?php echo LsTraCol('mdlstptra_col','id_tracol', $___Ls->ls->rw['mdlstptra_col'], '', 1, '', ''); 
                    $CntWb .= JQ_Ls('mdlstptra_col',FM_LS_SLCD); ?>
	        </div>
	        <div class="col_2">
                <?php echo LsUs('mdlstptra_us','id_us', $___Ls->ls->rw['mdlstptra_us'], '', 1); 
				    $CntWb .= JQ_Ls('mdlstptra_us',''); ?>
	        </div>

            <?php 
            
            $CntWb .= " 

                $('.mdlstptra_sve').off('click').click(function(e){
                        
                    e.preventDefault();
                    
                    if(e.target != this){ 	
                            e.stopPropagation(); return false;
                    }else{	
                        		
                        swal({
                            title: '".TX_ETSGR."',
                            text: '".TX_SWAL_SVE."',
                            type: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#64b764',
                            confirmButtonText:'".TX_ACPT."',
                            cancelButtonText: '".TX_CNCLR."',
                            showLoaderOnConfirm: false,
                            closeOnConfirm: true
                        },
                        function(){
                            
                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                url: '".Fl_Rnd(FL_JSON_GN.__t('mdl_s_tp_tra',true))."&id=".$___Ls->gt->isb."',
                                data: $('#{$___Ls->fm->id}').serialize(),
                                beforeSend: function() {
                                    $('#{$___Ls->fm->id}_ld').fadeIn();
                                    $('#{$___Ls->fm->id}_flds').fadeOut();
                                },
                                success: function(d){
                                    if(d.e == 'ok'){
                                        swal('Exitoso!', 'El proceso fue exitoso', 'success');	
                                    }
                                }
                            })
                        });
                    }	
                });
            ";

            ?>

        </div>
      </div>
    </form>
  </div>
</div>

<style>

    .Tt_Tb.mdlstptra_tt{
        border-bottom-width: 0px !important;
        width: calc(100% - 15px);
    }

</style>


<?php } ?> 

