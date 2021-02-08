<?php
if(class_exists('CRM_Cnx')){

    $___eml = new CRM_Eml();
    $___Ls->_strt();

    $Ls_Whr = " FROM "._BdStr(DBT).TB_THRD_EML_BOX." 
                        INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlbox_eml = id_eml
                WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND eml_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
                ORDER BY emlbox_view ASC, emlbox_lbl ASC";
                
    $___Ls->qrys = "
                    SELECT id_emlbox, emlbox_enc, emlbox_lbl, emlbox_view, emlbox_upd, emlbox_jnk, emlbox_out, emlbox_out_sve, emlbox_drf, emlbox_trsh,
                            (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
                    $Ls_Whr"; 

    $___Ls->_bld();
    
?>

<?php if($___Ls->ls->chk=='ok'){ ?>
<?php if(($___Ls->qry->tot > 0)){ ?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg Ls_Rg_EmlBox">
  	<tr>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo 'Ver' ?></th>
        <th width="5%" <?php echo NWRP ?>><?php echo 'Sincronizar' ?></th>
        <?php if(ChckSESS_superadm()){ ?>
            <th width="5%" <?php echo NWRP ?>><?php echo 'Spam' ?></th> 
            <th width="5%" <?php echo NWRP ?>><?php echo 'Borrador' ?></th>
            <th width="5%" <?php echo NWRP ?>><?php echo 'Papelera' ?></th>
        <?php } ?>
        <th width="5%" <?php echo NWRP ?>><?php echo 'Salida' ?></th>
        <th width="5%" <?php echo NWRP ?>><?php echo 'Salida (Guardar)' ?></th>
  	</tr>
	<?php 
	  	
    ?>
    <?php 
    
        do { 	

            $__lbl = $___eml->_box_lbl([ 'id'=>$___Ls->ls->rw['emlbox_lbl'] ]);
    ?>   
  	<tr class="<?php echo $__lbl->cls; if(mBln($___Ls->ls->rw['emlbox_view']) == 'no'){ echo ' off'; } ?>"> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left"><?php echo ShortTx(!isN($__lbl->nm)?$__lbl->nm:ctjTx($___Ls->ls->rw['emlbox_lbl'],'in'),40,'Pt', true); ?></td>
        <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_view'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_view'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_view' ]] ); ?></td>
        <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_upd'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_upd'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_upd' ]] ); ?></td>
        <?php if(ChckSESS_superadm()){ ?>
            <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_jnk'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_jnk'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_jnk' ]] ); ?></td>
            <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_drf'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_drf'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_drf' ]] ); ?></td>
            <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_trsh'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_trsh'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_trsh' ]] ); ?></td>
        <?php } ?>
        <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_out'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_out'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_out' ]] ); ?></td>
        <td width="5%" align="left" nowrap="nowrap"><?php echo OLD_HTML_chck('emlbox_out_sve'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['emlbox_out_sve'], 'in', ['c'=>'emlbox_chk', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik], 'data-cmp'=>'emlbox_out_sve' ]] ); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php       
    $CntJV .= "
    
        $('.emlbox_chk').click(function() {  
            
            if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }  
            var id_chck = $(this).attr('rel');
            var id = $(this).attr('id');
            var cmp = $(this).attr('data-cmp');
            
            swal({ 
                title: '".TX_ETSGR."',              
                text: '".TX_SWAL_SVE."!',  
                type: 'warning',                        
                showCancelButton: true,                 
                confirmButtonClass: 'btn-danger',       
                confirmButtonText: '".TX_YSV."',      
                confirmButtonColor: '#8fb360',          
                cancelButtonText: '".TX_CNCLR."',           
                closeOnConfirm: true 
            },
            function(isConfirm){ 

                if (isConfirm) {
                    
                    _Rqu({ 
                        t:'scl', 
                        _tp:'emlbox_chk',
                        est: est,
                        _id_chck: id_chck,
                        _id: id,
                        _cmp: cmp,
                        _bs:function(){ $('.Ls_Rg_EmlBox tr').addClass('_ld'); },
                        _cm:function(){ $('.Ls_Rg_EmlBox tr').removeClass('_ld'); },
                        _cl:function(_r){
                            if(!isN(_r)){
                                if(_r.e == 'ok'){
                                    
                                }else{
                                    if(est == 'ok'){
                                        $('#'+id).prop('checked',false);
                                    }else{
                                        $('#'+id).prop('checked', true);
                                    }
                                }
                            }
                        } 
                    });

                } else { 

                    if(est == 'ok'){
                        $('#'+id).prop('checked',false);
                    }else{
                        $('#'+id).prop('checked', true);
                    }
                }
            });	    
        });	
    ";
?>
<style>
    .Ls_Rg_EmlBox tr._ld {pointer-events: none;opacity: 0.4;}
    .Ls_Rg_EmlBox tr.off { opacity:0.3; }
</style>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php } ?>