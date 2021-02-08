<?php 

	$query_BuyLnk = sprintf('	SELECT *,
										'._QrySisSlcF([ 'als'=>'gtwy', 'als_n'=>'gtwy' ]).',
								 	 	'.GtSlc_QryExtra(['t'=>'fld', 'p'=>'gtwy', 'als'=>'gtwy']).'
								FROM '.TB_MDL_CNT_PAY_LNK.'
									 INNER JOIN '._BdStr(DBM).TB_CL_GTWY_PAY.' ON mdlcntpaylnk_gtwy = id_clgtwypay
									 '.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clgtwypay_gtwy', 'als'=>'gtwy' ]).'
								WHERE mdlcntpaylnk_mdlcnt=%s', GtSQLVlStr($___Ls->dt->rw['id_mdlcnt'],'int'));
	
	$BuyLnk = $__cnx->_qry($query_BuyLnk);

	if($BuyLnk){
		$row_BuyLnk = $BuyLnk->fetch_assoc(); 
		$Tot_BuyLnk = $BuyLnk->num_rows;	
	}

?>
<div id="Links_ToBuy_Bx">
    <section class="--lnk-buy _anm">   
	    <?php echo h2('Links '.Spn('de Pago'). '<button class="add" id="lnk_buy'.$___Ls->id_rnd.'"></button>'); ?>
	    <ul class="--lnk-buy-items">
			<?php 
				if($Tot_BuyLnk > 0){

					do{	
						if($row_BuyLnk['mdlcntpaylnk_sndbx'] == 1){ $__snd = '<span class="sndbx">Sandbox</span>'; }else{ $__snd = ''; };

						if(mBln($row_BuyLnk['mdlcntpaylnk_sndbx']) != 'ok' || ChckSESS_superadm()){

							echo '<li>
									<figure style="background-image:url('.DMN_FLE_SIS_SLC.ctjTx($row_BuyLnk['gtwy_sisslc_img'],'in').');"></figure>
									<span class="qty">'.ctjTx($row_BuyLnk['mdlcntpaylnk_qty'],'in').'</span>
									<div class="_tt">'.ctjTx($row_BuyLnk['gtwy_sisslc_tt'],'in').$__snd.'</br><span>'.ctjTx($row_BuyLnk['mdlcntpaylnk_fi'],'in').'</span></div>
									<button class="_cpy" lnk-go="'.ctjTx($row_BuyLnk['mdlcntpaylnk_lnk'],'in').'" title="'.ctjTx($row_BuyLnk['mdlcntpaylnk_lnk'],'in').'">Copiar</button>
								</li>';

						}

					} while ($row_BuyLnk = $BuyLnk->fetch_assoc());

				}
			?>
		</ul>
	</section>
</div>
<?php 
	
	$__cnx->_clsr($BuyLnk);

	$CntJV .= "

		function Dom_LnkToBuy(){
			
			$('#Links_ToBuy_Bx .--lnk-buy-items li button._cpy').off('click').click(function(e) {
				
				e.preventDefault();
		
				if(e.target != this){
					e.stopPropagation();
					return;
				}else{
					var _this = $(this);
					var _lnk = _this.attr('lnk-go');

					SUMR_Main.cpy.cpb({
						_t:_lnk,
						_c:function(){
							swal('Proceso exitoso', 'El link fue copiado al portapapeles', 'success');
						}
					});
				}	

			});

		}
		
		Dom_LnkToBuy();

	";

?>
<style>
	
	
	
	/*-------------- PEDIDOS - CALIFICACIÓN --------------*/
	
	.--lnk-buy{ padding: 10px 30px 30px 30px; margin-top: 30px; margin-bottom: 30px; border:none; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-color: #eef0f1; }
	
	.--lnk-buy h2{ text-align: center !important; width: 100%; border: none !important; background-color: transparent !important; margin-bottom: 20px; padding-bottom: 20px !important; }
	.--lnk-buy h2 span{ color: #b4b3b3; font-size: 0.8em; }
	.--lnk-buy h2 button.add{ margin-left:10px; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; border:none; background-color:var(--main-bg-color); width:20px; height:20px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>tra_add_white.svg'); background-repeat:no-repeat; background-position:center center; background-size: auto 40%; }
	.--lnk-buy h2 button.add:hover{ width:24px; height:24px; }

	.--lnk-buy ul{ list-style: none; margin: 0; padding: 0; }
	.--lnk-buy ul li{ text-align: left; position: relative; width: 100%; padding: 0 30px 10px 0; margin-bottom: 10px; border-bottom: 2px solid white;  }

	.--lnk-buy .--lnk-buy-items{}
	.--lnk-buy .--lnk-buy-items:empty{ width:100%; min-height:100px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>lnk_buy_empty.svg'); opacity:0.3; background-repeat:no-repeat; background-position:center center; background-size: auto 40%; }
	
	.--lnk-buy .--lnk-buy-items li{ width:100%; display:flex; padding-right:40px; position:relative; }
	.--lnk-buy .--lnk-buy-items li figure{ min-width:30px; min-height:30px; width:30px; height:30px; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; background-repeat:no-repeat; background-position:center center; background-size: auto 60%; background-color:#fff; border:2px solid #ccc; margin: 0 15px 0 0; }
	.--lnk-buy .--lnk-buy-items li button._cpy{ width:40px; border:none; background-color:#999; color:#fff; font-family:Economica; text-transform:lowercase; font-size:11px; font-weight:500; position:absolute; right:0; top:0; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; }
	.--lnk-buy .--lnk-buy-items li button._cpy:hover{ background-color:#000; }
	.--lnk-buy .--lnk-buy-items li ._tt{ font-family:Economica; font-size:16px; width:100%; text-align:center; line-height: 14px; }
	.--lnk-buy .--lnk-buy-items li ._tt span{ font-size:10px; color:#afafaf; font-family:Roboto; }

	.--lnk-buy .--lnk-buy-items li .qty{text-align: center;padding: 4px 0;background-color: #bbbbbb;color: white;font-size: 10px;min-width: 18px;min-height: 18px;width: 18px;height: 18px;border-radius: 200px;-webkit-border-radius: 200px;background-size: auto 60%;position: absolute;top: 16px;left: 20px;}
	.--lnk-buy .--lnk-buy-items li .sndbx{height: 15px;min-height: 15px;margin-right: 6px;padding: 3px 6px;font-size: 9px !important;vertical-align: middle;color: black !important;background-color: #eac000;border-radius: 5px;-webkit-border-radius: 5px;margin-left: 3px;}

</style>	