<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'cntrc_nm';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	
	$___Ls->edit->big = 'ok';
	$___Ls->img->dir = DMN_FLE_CNTRC;
	
	$___Ls->_strt();	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNTRC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "FROM ".TB_CNTRC." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	}
	
	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="90%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="90%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cntrc_nm'],'in'),40,'Pt', true); ?></td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb">
	  <div id="<?php  echo DV_GNR_FM ?>">                                        
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <div class="ln_1">
				<div class="col_1">
					<?php echo HTML_inp_tx('cntrc_nm', TX_NM, ctjTx($___Ls->dt->rw['cntrc_nm'],'in'), FMRQD); ?>
				</div>
				<div class="col_2">
				    <?php echo HTML_inp_tx('cntrc_vrs', "Versiones", ctjTx($___Ls->dt->rw['cntrc_vrs'],'in'), FMRQD); ?>
				</div>
			
				<div class="ls_sheet">
					<div class="new"></div>
					<ul id="sortable1" class="connectedSortable"></ul>
				</div>
				
				<div class="dtd"></div>
			</div>
						
			
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } 
	
	$CntJV .= "
	
		$(function() {
		    $('#sortable1').sortable({
			    
			    update: function( event, ui ){
					var _id = $(this).attr('id');
					var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'rel' });
					
					_Rqu({ 
						t:'cntrc', 
						d:'frst',
						_ord: idsInOrder,
						_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
						_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
					});

				},
			    
		        cursor: 'pointer',
		        connectWith: '.connectedSortable'
		    }).disableSelection();
		});
	
		var SUMR_Dsh_Fm = {
							mdltpfm:{},
							
						};
	
		function ClSet(p){

			if( !isN(p) ){ 
				 
				if( !isN(p.cntr.sht) ){ 
					SUMR_Dsh_Fm.mdltpfm['frst'] = p.cntr.frst;
					SUMR_Dsh_Fm.mdltpfm['ls'] = p.cntr.sht.ls;
					SUMR_Dsh_Fm.mdltpfm['tot'] = p.cntr.sht.tot;
				}
				
				if( !isN(p.sht) ){
					SUMR_Dsh_Fm.mdltpfm['sht'] = p.sht;	
					SUMR_Dsh_Fm.mdltpfm['tot_s'] = p.sht.tot;
				}

				ClGrpAre_Html();

			}
		}
		
		function ClGrpAre_Html(){
			
			
			if(SUMR_Dsh_Fm.mdltpfm['tot'] > 0){
				
				$(  '.ls_sheet ul' ).html('');
				$('.dtd' ).html('');
				
				var i = 1;

				$.each(SUMR_Dsh_Fm.mdltpfm['ls'], function(k, v) {
					
					$('.ls_sheet ul').append('<li id=\"itm_'+v.enc+'\" rel=\"'+v.enc+'\" class=\"ui-state-default sheet\">'+(i++)+'</li>');
				});

				if(SUMR_Dsh_Fm.mdltpfm['tot_s'] > 0){

					$('.dtd').append('
						<div class=\"btns\">
							<div rel=\"'+SUMR_Dsh_Fm.mdltpfm['sht'].enc+'\" class=\"edit\"></div>
							<div rel=\"'+SUMR_Dsh_Fm.mdltpfm['sht'].enc+'\" class=\"eli\"></div>
						</div>
						<div class=\"page\">'+SUMR_Dsh_Fm.mdltpfm['sht'].html+'</div>');	

				}

				if(!isN(SUMR_Dsh_Fm.mdltpfm['frst'])){
					$('.dtd' ).html('
						<div class=\"btns\">
							<div rel=\"'+SUMR_Dsh_Fm.mdltpfm['frst'].enc+'\" class=\"edit\"></div>
							<div rel=\"'+SUMR_Dsh_Fm.mdltpfm['frst'].enc+'\" class=\"eli\"></div>
						</div>
						<div class=\"page\">'+SUMR_Dsh_Fm.mdltpfm['frst'].html+'</div>');	
				}
			}
			
			Dom_Rbld();
			
		}
	
		_Rqu({ 
			t:'cntrc', 
			d:'frst',
			_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
			_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
		});
		
		function Dom_Rbld(){
			$('.sheet').off('click').click(function(){
				
				var _id = $(this).attr('rel'); 
				
				_Rqu({ 
					t:'cntrc',
					d:'sht', 
					_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
					_id_sht : _id,
					_cl:function(_r){ 
						if(!isN(_r)){	
							ClSet(_r); 
							$('#itm_'+_id).addClass('ok');	
							
						} 
					} 
				});	
			});
			
			$('.new').off('click').click(function(){
				
				_Rqu({ 
					t:'cntrc',
					d:'new', 
					_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
					_cl:function(_r){ 
						if(!isN(_r)){ 
							if(!isN(_r)){ ClSet(_r); } 
						} 
					} 
				});	
			});
			
			$('.edit').off('click').click(function(){
				
				var _id = $(this).attr('rel'); 
				
				_Rqu({ 
					t:'cntrc', 
					_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
					_id_sht : _id,
					_cl:function(_r){ 
						if(!isN(_r)){ Html(_r); } 
					} 
				});
			});
			
			$('.eli').off('click').click(function(){

				var _id = $(this).attr('rel'); 

				swal({
						
					title: '".TX_ETSGR."',
					text: '".TX_DLTFLD."',
					type: 'info',
					showCancelButton: true,
					cancelButtonText: '".TX_CNCLR."',
					confirmButtonText: '".TX_YESDLT."',
					confirmButtonColor: '#64b764',
					closeOnConfirm: true,
					
				},	
				function(){			
					
				
					_Rqu({ 
						t:'cntrc', 
						d:'eli',
						_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
						_id_sht : _id,
						_cl:function(_r){ 
							if(!isN(_r)){ ClSet(_r); } 
						} 
					});	
				});
			});
		}	
	
		function Html(p){
			
			$('.dtd' ).html('');
			$('.dtd' ).html('<div class=\"_lnddt _anm\">
				<div class=\"_bx\">
					<div class=\"_left _anm\">
						<textarea class=\"_smr_nte\"></textarea>
					</div>
					<div class=\"_right _anm\">
						<div class=\"_hd\">
							<div class=\"btn_pnl\"></div>
						</div>
						<div class=\"_lnddt\">
							<ul></ul>
						</div>
					</div>
				</div>
				<div>
					".GtSisTagCnctLs(['id'=>'EcTagList'])->html."		
				</div>
				<div class=\"_btn\">
					<div class=\"_btn_sve_cntrc _anm\" rel=\"'+p.sht.enc+'\">".TXBT_GRDR."</div>
				</div>
				
			</div>');
			
			 SUMR_Main.ld.f.html(function(){ SUMR_Ec.f.tags({ id:'#EcTagList li' }); });
			
			var keys = {};
			
			/*$('._lnddt ._bx ._smr_nte').summernote('destroy');*/
			
			if(!isN(p.sht.html)){
				var _html = p.sht.html;
			}else{
				var _html = '';	
			}

			$('._lnddt ._bx ._smr_nte').html(_html);
		
			/*$('._lnddt ._bx ._smr_nte').summernote({
				
				placeholder: '".TX_INGCTN."',
				height: 1054,
				tabsize: 1,
		       	dialogsInBody: true,
		        enterHtml: '<br><br>',
		        emptyPara: '<div style=\'border:1px solid red\'></div>',
		        formatPara: '<br>',
		        lang: 'es-ES',
		        
		        toolbar: [
			        ['color', ['color']],
					['fontsize', ['fontsize']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['para', ['ul', 'ol', 'paragraph', 'height']],
					['insert', ['hr', 'link', 'unlink', 'table']]
				],
				
				fontSizes: ['8', '10', '11', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36'],
				
		        popover: {
				    air: [
					  ['color', ['color']],
					  ['fontsize', ['fontsize']],
				      ['font', ['bold', 'italic', 'underline', 'clear']],
				      ['para', ['ul', 'ol', 'paragraph', 'height']],
				      ['insert', ['hr', 'link', 'unlink', 'table']]
				    ]
				},
				insertTableMaxSize: {
				  col: 20,
				  row: 20
				},
				codemirror: {
				    theme: 'monokai'
				},
				callbacks: {
					onInit: function() {
						$(this).summernote('code', _html );
				    },
				    onPaste: function(e) {
						_cpyhtml_snd({
					     	id:'._lnddt ._bx ._smr_nte',
					     	s:function(d){
						 		if(d.e == 'ok'){
						     		$('._ovr ._lnd_mod_ovr ._smr_nte').summernote('code', 'aaa');
								 	$('._ovr ._lnd_mod_ovr ._smr_nte').summernote('code', 'eee');
							 	}
					     	},
					     	sw:function(d){
						     	
					     	}
				     	});
				    },
				    onChange: function(e) {
					
				    },
				    onKeyup: function(e) {
				    	keys['key'+e.keyCode] = 'no';
				    },
				    onKeydown: function(e) {
						keys['key'+e.keyCode] = 'ok';
					    	
				    	var _k13 = keys['key'+13];
					    var _k16 = keys['key'+16];
					      
					    if( _k13 == 'ok' && _k16 == 'ok' ){
						    
					    }else if(_k13 == 'ok'){
						    swal('¡Recuerda!', 'Utiliza (Shift+Enter) para insertar saltos de línea', 'info');
					    }
				    }
				}
				
			});	*/
			
			$('._lnddt ._btn ._btn_sve_cntrc').off('click').click(function(){
					
				if(!isN( $('._smr_nte').val().trim() )){
						
					var _tp = $(this).attr('rel');	
					
					swal({
						
					  title: '".TX_ETSGR."',
					  text: '".TX_SWAL_SVE."',
					  type: 'info',
					  showCancelButton: true,
					  cancelButtonText: '".TX_CNCLR."',
					  confirmButtonText: '".TXBT_GRDR."',
					  confirmButtonColor: '#64b764',
					  closeOnConfirm: false,
					  showLoaderOnConfirm: true,
					  closeOnConfirm: false,
					
					},
					
					function(isConfirm){
						
						if (isConfirm) {

							_Rqu({ 
								t:'cntrc', 
								d:'edt',
								_id_cntrc : '".$___Ls->dt->rw['id_cntrc']."',
								_sgm_vle:$('._smr_nte').val(),
								_id_sht : _tp,
								_cl:function(_r){ 
									if(!isN(_r)){ 
										if(!isN(_r)){ 
	
											ClSet(_r);
	
											swal({
												title: 'Super!',
												text: 'El texto fue procesado exitosamente',
												type: 'success',
												timer: 2000,
												showConfirmButton: false
											});

										} 
									} 
								} 
							});

						}else{
							
							swal.close();
							
						}
						
					});
					
				}
				
			});
		}
	";
	
?>
<style>
	.ls_sheet{width: 85px;display: inline-block}
	.ls_sheet ul{ list-style-type: none; }
	.ls_sheet ul .sheet{width: 100%;height: 50px;border: 1px solid #cacaca;margin: 10px 0;border-radius: 6px;cursor: pointer;text-align: right;padding: 4px 6px;color: #ababab;}
	.dtd{ height:100%;width: 80%; display: inline-block; vertical-align: top}
	.dtd ._lnddt{ height:100%;width: 216mm; display: block; margin: 0 auto;}
	._lnddt ._btn{ width: 50%; height: 60px; display: block; margin-top: 6%!important; margin: auto; text-align: center; position: sticky; left: 0; bottom: 5px; background-color:#e4e9eb; padding: 10px 15px; border-radius: 0px 0px 25px 25px; -moz-border-radius: 0px 0px 20px 20px; -webkit-border-radius: 0px 0px 20px 20px; }
	._lnddt ._btn ._btn_sve_cntrc{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_sve.svg'); }
	._lnddt ._btn ._btn_his_cntrc{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_his.svg'); }
	/*._lnddt ._btn ._btn_rmv_cntrc{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_rmv.svg'); }*/
	._lnddt ._btn div{ width: 45%; border: 1px solid #929aa0; display: inline-block; background-repeat: no-repeat!important; text-align: center; cursor: pointer; border-radius: 11px; -moz-border-radius: 11px; -webkit-border-radius: 11px; font-family: Economica; text-transform: uppercase; font-weight: 500; padding: 6px 10px 6px 50px; background-position: left -10px center; background-color: transparent; color: #7a8486; }
	._lnddt ._btn div:hover{ background-position: left -5px center; color: #343c3e; }
	._lnddt ._bx{ display: block; position: relative; padding-bottom: 60px; }
	._lnddt ._bx ._left .note-editable.panel-body{ height: 250px; }
	._lnddt ._bx ._left .note-editor.note-frame.panel.panel-default{ display: block!important; margin: auto!important; width: 85%!important; margin-top: 3%!important; }
	._lnddt ._bx ._left .note-editor.note-frame.panel.panel-default .note-statusbar{ height: 25px; }
	._lnddt ._bx ._right { background: #545657; width: 0%; height: 100%; position: absolute; top: 0%; right: 0%; }
	._lnddt ._bx ._right._opn { width:60%; }
	._lnddt ._bx ._right._opn > div{ display: block!important; width: 100%; }
	._lnddt ._bx ._right._opn ._hd{ border: 1px solid #c3c5c6; height: 10%; }
	._lnddt ._bx ._right._opn ._hd .btn_pnl{ display: inline-block; background-image: url("<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_btn_right.svg"); width: 30px; height: 30px; background-size: 100% auto; background-repeat: no-repeat; display: block; cursor: pointer; margin-top: 5px; margin-left: 10px; }
	._lnddt ._bx ._right._opn ._hd .btn_pnl:Hover{ opacity: 0.7; }
	._lnddt ._bx ._right._opn ._lnddt{ height: 90%; overflo	w: scroll; border: 1px solid #c3c5c6;  }
	._lnddt ._bx ._right._opn ._lnddt ul{ list-style: none; padding: 0; margin: 20px 0 0 0; }
	._lnddt ._bx ._right._opn ._lnddt ul li{ border-bottom: 1px dotted #7a7a7a; width: 90%; margin-left: auto; margin-right: auto; display: block; color: #ffffff; padding-top: 10px;  padding-bottom: 10px; }
	._lnddt ._bx ._right._opn ._lnddt ul li .us{ width: 30px; height: 30px; background-repeat: no-repeat; background-position: center center; display: inline-block; background-size: cover; }
	._lnddt ._bx ._right._opn ._lnddt ul li .bx{ display: inline-block; padding-left: 10px; }
	._lnddt ._bx ._right._opn ._lnddt ul li button{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_txt_his_rstr.svg); width: 30px; height: 30px; background-color: transparent; background-position: center center; background-size: 70% auto; display: inline-block; float: right; border: none; background-repeat: no-repeat; opacity: 0.7; }
	._lnddt ._bx ._right._opn ._lnddt ul li button:Hover{ background-size: 100% auto; opacity: 1; }
	
	.note-editor.note-frame .note-statusbar .note-resizebar .note-icon-bar{ height: 1px; }
	.page{border: 1px solid white;background: white;box-shadow: 0 0.5mm 2mm rgba(0,0,0,.3);margin: 5mm auto;width: 216mm;height: 290mm;padding: 10mm;overflow: hidden}
    .page::before {content: ' ';display: block;background-image: url(<?php echo DMN_FLE_CNTRC.$___Ls->dt->rw['cntrc_lgo']; ?>);background-repeat: no-repeat;background-position: right center;background-size: auto 100%;height: 60px;margin-bottom: 40px;}
	.sheet.ok{ background-color: #cacaca; }
	.new{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg);width: 100%;background-position: center;background-repeat: no-repeat;height: 25px;}
    .btns{ width: 216mm; margin: 0 auto; position: relative; }
    .edit{ cursor: pointer;  position: absolute;width: 50px;height: 50px;background-color: #e4e4e4;top: -5px;right: -20px;border-radius: 35px;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>edit.svg);background-position: center;background-repeat: no-repeat;background-size: 50% auto;}
    .edit:hover{ background-color: #b1b1b1 }
    
    .eli{ cursor: pointer;  position: absolute;width: 50px;height: 50px;background-color: #e4e4e4;top: 50px;right: -20px;border-radius: 35px;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);background-position: center;background-repeat: no-repeat;background-size: 50% auto;}
    .eli:hover{ background-color: #b1b1b1 }
    
</style>

