<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = _Cns('TX_VD');
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_LRN_VD."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		$_fl = "AND lrnvd_lrn IN(SELECT id_lrn FROM  "._BdStr(DBM).TB_LRN." WHERE lrn_enc = '{$__i}' )";
		$Ls_Whr = "	FROM ".TB_LRN_VD."
					WHERE ".$___Ls->ino." != '' $_fl
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
				   		(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	            <th width="30%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
	            <th width="30%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
	            <th width="10%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
	            <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" width="1%"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
			        <td width="30%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrnvd_tt'],'in'); ?></td>
			        <td width="20%" align="left"><?php echo mBln($___Ls->ls->rw['lrnvd_e']); ?></td>
					<td width="10%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrnvd_fi'],'in'); ?></td>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
		
	}
	$___Ls->_h_ls_nr(); 
} ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	    <div class="ln_1">
		    <div class="col_1">
			    <?php echo HTML_inp_hd('lrnvd_lrn', $__i); ?>
              	<?php echo HTML_inp_tx('lrnvd_tt', TX_TT , ctjTx($___Ls->dt->rw['lrnvd_tt'],'in'), FMRQD); ?>
              	<?php echo HTML_inp_tx('lrnvd_url', TX_URL , ctjTx($___Ls->dt->rw['lrnvd_url'],'in'), FMRQD); ?>  
              	<?php echo OLD_HTML_chck('lrnvd_e', TX_ACTV, $___Ls->dt->rw['lrnvd_e'], 'in'); ?>    
              	<?php echo HTML_textarea('lrnvd_dsc', TX_DSC, ctjTx($___Ls->dt->rw['lrnvd_dsc'],'in'), ''); ?>            
            </div>
            <div class="col_2">
	            <?php 
		            $__Cl = new CRM_Cl();
					$__Rnd = Gn_Rnd(20);
		            $CntJV .= " 
				
						__lnrvd_bx_cl = $('#bx_lnrvd_cl_".$__Rnd."');
						
						function Dom_Rbld(){
					 
							__lnrvd_bx_cl_itm = $('#bx_lnrvd_cl_".$__Rnd." li.itm.lnr_vd');


							__lnrvd_bx_cl_itm.not('.sch').off('click').click(function(){
								$(this).hasClass('on') ? est = 'del' : est = 'in'; 
										
								var _id = $(this).attr('rel');
								_Rqu({ 
									t:'lrn_vd_cl', 
									d:'lrn',
									est: est,
									_cl_enc : _id,
									_id_vd : '".Php_Ls_Cln($___Ls->gt->i)."',
									_bs:function(){ __lnrvd_bx_cl.addClass('_ld'); },
									_cm:function(){ __lnrvd_bx_cl.removeClass('_ld'); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.lrnvd)){
												ClSet(_r);	
											}
		 								}
									} 
						});
							});
	
							SUMR_Main.LsSch({ str:'#lnrvd_sch_".$__Rnd."', ls:__lnrvd_bx_cl_itm });
							
						}
						
						
						
						function Lrnvd_Html(){
	
							__lnrvd_bx_cl.html('');
							__lnrvd_bx_cl.append('<li class=\"sch\">".HTML_inp_tx('lnrvd_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
							
							$.each(lrnvd['ls'], function(k, v) {

								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
								}else{ 
									img=''; 
								}
								
								if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
								
								__lnrvd_bx_cl.append('<li class=\"_anm itm lnr_vd '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
														<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
														<span>'+v.nm+'</span>
													</li>');

							});	
							
							$('#tot_lnrvd_".$__Rnd."').html( lrnvd['tot'] );
							
							Dom_Rbld();
						}
					";
				
		            $CntJV .= "
						function ClSet(p){
							try{
								if( !isN(p) ){
									lrnvd = {};
									if( !isN(p.lrnvd) ){  lrnvd['ls'] = p.lrnvd.ls; lrnvd['tot'] = p.lrnvd.tot; }
									Lrnvd_Html();
								}
							}catch(e) {
								SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
							}
						}		
					";
		            
		            
		            $CntJV .= " 
			            try{
							_Rqu({ 
								t:'lrn_vd_cl', 
								t2:'lnd_vd',
								_id_vd : '".Php_Ls_Cln($___Ls->gt->i)."',
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r)){
											ClSet(_r);
											console.log(_r);
										}
									}
								} 
							});
						}catch(e) {
							SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
						}	
					";
		            
	            ?>
	        	<div class="lnr_vd_fm dsh_cnt lead_data">
			        <div class="_c _c3 _anm _scrl">
				        <?php echo h2(TX_CL); ?>
				        <div class="_wrp">
					    	<ul id="bx_lnrvd_cl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	  
					    </div>
			        </div>  	   
		        </div>    	
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style>

    .lnr_vd_fm{ text-align: center; margin-top: 10px; display: flex; }
	.lnr_vd_fm ._c{ width: 100% !important; }
    .lnr_vd_fm ._c._c1 h2{ text-align: right; } 
    .lnr_vd_fm ._c h2{ text-align: center; }    
    
	.lnr_vd_fm ._c ul .itm {
	    list-style-type: none;
	    margin: 5px 0px;
	    padding: 6px 8px;
	    display: block;
	    font-size: 11px;
	    border-radius: 5px;
	    cursor: pointer;
	    width: 100%;
	    position: relative;
	    overflow: visible;
	    color: white !important;
	    text-overflow: ellipsis;
	    text-transform: lowercase;
	    border: 0px !important;
	}
	.lnr_vd_fm ._c ul .itm.lnr_vd.off {
	    -webkit-filter: grayscale(100%);
	    filter: grayscale(100%);
	    opacity: 0.5;
	}
	.lnr_vd_fm ._c ul .itm.lnr_vd.off:hover {
	    -webkit-filter: grayscale(0%);
	    filter: grayscale(0%);
	    opacity: 1;
	}

    
</style> 
<?php } ?>
<?php } ?>
