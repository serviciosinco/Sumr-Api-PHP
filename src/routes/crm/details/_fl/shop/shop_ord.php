<div class="Dsh_Shop _anm">

	<header>
		<h1>Nuevo <span>Pedido</span></h1>
		<h2>#3445566</h2>
		<h3>			
			<button class="_save">Finalizar</button>
		</h3>
	</header>
	
	<div class="_wrp">
	
		<section class="cnt_data">
			<h2 class="_tt_sct">Datos Solicitante</h2>
			<ul class="_list">
				<li><?php echo HTML_inp_tx('cnt_nm', TT_FM_FLLNM, '', FMRQD); ?></li>
	            <li><?php echo HTML_inp_tx('cnt_eml', TT_FM_EML,'', ''); ?> </li>
	            <li class="doc">            	
					<div class="c1"> 
						<?php 
			                $l = __Ls([ 'k'=>'cnt_dc', 
			                			'opt_v'=>'itm-sg', 
			                			'id'=>'cntdc_tp', 
			                			'va'=>$___Ls->dt->rw['cnt_dctp'], 
			                			'ph'=>FM_LS_TPDOC,
			                			'slc'=>[ 
											'opt'=>[
													'attr'=>[
														'itm-sg'=>'sg'
													]	
												] 
											],
										'rq'=>2
			                		]); 
			                		
			                echo $l->html; $CntWb .= $l->js;    
		                ?>
					</div>	
					<div class="c2">
						<?php echo HTML_inp_tx('cntdc_dc', TT_FM_DC, '', FMRQD_NMR); ?>  
					</div>
	            </li>
	            <li><?php echo HTML_inp_tx('cnt_dir', TX_DIRC, ''); ?> </li>
	            
	            <li>
		            <div class="styled-select-bx">
			            <select name="cnt_stre" data-placeholder="Tienda" id="cnt_stre" autocomplete="off">
			            	<option class="_slc_opt" value=""></option>
			            	<option class="_slc_opt" value="177" rel="327ef6de7a28fc078ec3f4afa7219086cbdb86c1" itm-sg="CC">Tienda Jumbo</option>
			            	<option class="_slc_opt" value="178" rel="6399b641393e750db6213893c3342c7d997c683d" itm-sg="TI">Tienda Metro</option>
			            </select>
			        </div>
			        <?php $CntWb .= JQ_Ls('cnt_stre'); ?>
	            </li>
	            
	            
	            
	            <div><textarea rows="5" placeholder="¿Observaciones sobre el pedido?" rel="" class=""></textarea></div>
	            
	            
	            
	            <li style="white-space: nowrap; display: flex; ">
	            
		            <div class="opt bag">
		            	<div class="c _anm">	
		            	</div>
		            </div>
		            <div class="opt dtphn">
		            	<div class="c _anm">
		            	</div>
		            </div>
		            <div class="opt csh">
		            	<div class="c _anm">	
		            	</div>
		            </div>
	            
	            </li>
	            
			</ul>	
		</section>
		
		
		<section class="shop_itm_data">
			
			<h2 class="_tt_sct">Productos <button class="add_itm"></button></h2>
			
			<ul class="_list">
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/201620-92-92/7703812005623.jpg?v=636282277045770000');"></figure> 
					<div class="_name">Sal Refisal Marina x 800 g</div>
					<div class="_brand">REFISAL</div>
					<div class="_price">$3.190</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/175484-92-92/7702175108101-20-281-29.jpg?v=636114455443730000');"></figure> 
					<div class="_name">Rey Bolsa Pimienta Molida x 60 g - El Rey</div>
					<div class="_brand">EL REY</div>
					<div class="_price">$3.090</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/194552-92-92/7703616129013-1.jpg?v=636220893982000000');"></figure> 
					<div class="_name">Vinagre Maxima blanco x 500ml</div>
					<div class="_brand">MAXIMA MP</div>
					<div class="_price">$1.590</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/3323119-92-92/20641191-1.jpg?v=636670897246900000');"></figure> 
					<div class="_name">Cilantro X 100 g</div>
					<div class="_brand">JUMBO</div>
					<div class="_price">$1.880</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/201620-92-92/7703812005623.jpg?v=636282277045770000');"></figure> 
					<div class="_name">Sal Refisal Marina x 800 g</div>
					<div class="_brand">REFISAL</div>
					<div class="_price">$3.190</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/175484-92-92/7702175108101-20-281-29.jpg?v=636114455443730000');"></figure> 
					<div class="_name">Rey Bolsa Pimienta Molida x 60 g - El Rey</div>
					<div class="_brand">EL REY</div>
					<div class="_price">$3.090</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/194552-92-92/7703616129013-1.jpg?v=636220893982000000');"></figure> 
					<div class="_name">Vinagre Maxima blanco x 500ml</div>
					<div class="_brand">MAXIMA MP</div>
					<div class="_price">$1.590</div>
				</li>
				<li>
					<figure style="background-image:url('https://jumbocolombiafood.vteximg.com.br/arquivos/ids/3323119-92-92/20641191-1.jpg?v=636670897246900000');"></figure> 
					<div class="_name">Cilantro X 100 g</div>
					<div class="_brand">JUMBO</div>
					<div class="_price">$1.880</div>
				</li>
			</ul>
	
		</section>
		
		
		<section class="shop_status_ok">
			<figure></figure>
			<h1>Pedido Creado</h1>
			<p>Alistamiento de pedido y tracking en dispositivo Pickr</p>
		</section>	
		
	</div>
	
</div>


<?php  
	
	
	$CntWb .= "	
		
		$('.Dsh_Shop .shop_itm_data h2 .add_itm').off('click').click(function() {  
			$('.Dsh_Shop .shop_itm_data ._list li:hidden:first').fadeIn();
			_DshRsze();
		});
		
		
		$('.Dsh_Shop button._save').off('click').click(function() {  
			$('.Dsh_Shop').addClass('_rdy');	
		});
		
		
		$('.Dsh_Shop .cnt_data ul._list li div .c').click(function(e) {
			if($(this).hasClass('_on')){
				$(this).removeClass('_on');
			}else{
				$(this).addClass('_on');
			}	
		});
		
		
	";
	
?>



<style>
	
	.Dsh_Shop{ padding: 20px 30px 100px 30px; position: relative;overflow: visible; }
	
	.Dsh_Shop .styled-select-bx label{ display: none !important; }
	
	.Dsh_Shop header{ display: flex; width: 100%; position: absolute; top: 0; left: 0; padding: 0 30px; border-bottom: 2px solid var(--main-bg-color); background-color: white; z-index: 10; }
	.Dsh_Shop header h1,
	.Dsh_Shop header h3,
	.Dsh_Shop header span{ font-family: Economica; text-transform: uppercase; font-weight: 300; display: block; }
	
	.Dsh_Shop header h1{ font-size: 16px; width: 30%; text-align: left; color: #b9b8b8; }
	.Dsh_Shop header h2{ font-size: 20px; width: 40%; text-align: center; padding-top: 10px; }
	
	.Dsh_Shop header h1 span{ font-size: 24px; font-weight: 500; text-align: left; width: 100%; color: #363434; }
	.Dsh_Shop header h3{ width: 30%; text-align: right; }
	
	.Dsh_Shop header button._save{ border: none; background-color:var(--main-bg-color); color: white; font-family: Economica; font-size: 14px; text-transform: uppercase; font-weight: 300; text-align: center; padding: 10px 15px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; }
	.Dsh_Shop header button._save:hover{ background-color:var(--second-bg-color); }
	
	.Dsh_Shop ._wrp{ margin-top: 80px; overflow: visible !important; }
	
	
	
	
	
	.Dsh_Shop ul._list{ padding:20px 0; list-style-type: none; margin: 0; }
	
	.Dsh_Shop ._tt_sct{ font-size: 20px; width: 100%; display: block; color: #a6a9aa; text-align: left; position: relative; }
	.Dsh_Shop ._tt_sct:before{ display: inline-block; width: 25px; height: 25px; background-repeat: no-repeat; background-position: center center; background-size: 100% auto; margin-right: 5px; opacity: 0.3; }
	
	
	.Dsh_Shop .cnt_data h2:before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_lead.svg); }
	.Dsh_Shop .shop_itm_data h2:before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>shop_basket.svg); }
	
	
	
	
	
	
	.Dsh_Shop .cnt_data ul._list{ width: 80%; margin-left: auto; margin-right: auto; }
	.Dsh_Shop .cnt_data ul._list li{ margin-bottom: 8px;  }
	.Dsh_Shop .cnt_data ul._list li input[type=text], 
	.Dsh_Shop .cnt_data ul._list li input[type=email], 
	.Dsh_Shop .cnt_data ul._list li textarea{ width: 100%; }
	
	
	.Dsh_Shop .cnt_data ul._list li.doc{ display: flex; }
	.Dsh_Shop .cnt_data ul._list li.doc .c1{ width: 30%; padding-right: 2%; }
	.Dsh_Shop .cnt_data ul._list li.doc .c2{ width: 68%; }
	
	
	.Dsh_Shop .cnt_data ul._list li .opt{ width: 33%;  display: inline-block; text-align: center; margin-top: 20px; }
	
	.Dsh_Shop .cnt_data ul._list li div{ text-align: center; }
	.Dsh_Shop .cnt_data ul._list li div .c{ background-repeat: no-repeat; background-position: center center; background-size: auto 50%; width: 50px; height: 50px; border:2px solid #9da8b2; -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.6; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; margin-left: auto; margin-right: auto; }
	
	
	.Dsh_Shop .cnt_data ul._list li div .c:hover,
	.Dsh_Shop .cnt_data ul._list li div .c._on{
		-webkit-filter: grayscale(0%); filter: grayscale(0%); opacity: 1; border-color: #09830b; cursor: pointer; background-size: auto 45%;
	}
	
	.Dsh_Shop .cnt_data ul._list li div.bag{ }
	.Dsh_Shop .cnt_data ul._list li div.bag .c{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/shopping-bag.svg'); }

	.Dsh_Shop .cnt_data ul._list li div.dtphn{ } 
	.Dsh_Shop .cnt_data ul._list li div.dtphn .c{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/cash.svg'); }
	
	.Dsh_Shop .cnt_data ul._list li div.csh{ }
	.Dsh_Shop .cnt_data ul._list li div.csh .c{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/point-of-service.svg'); }
	
	
	.Dsh_Shop .cnt_data ul._list li .opt .slideThree{ width: 45px; }
	
	
	
	.Dsh_Shop .cnt_data ul._list li .__slc_ok{ width: 100%; border: none; text-align: right; }
	.Dsh_Shop .cnt_data ul._list li .__slc_ok h2{ display: none !important; }
	
	
	.Dsh_Shop .cnt_data ::-webkit-input-placeholder{ text-align: center; }
	.Dsh_Shop .cnt_data ::-moz-placeholder{ text-align: center; }
	.Dsh_Shop .cnt_data :-ms-input-placeholder{ text-align: center; }
	.Dsh_Shop .cnt_data :-moz-placeholder { text-align: center; }
	
	.Dsh_Shop .cnt_data input[type=text]{ text-align: center; }
	
	.Dsh_Shop .shop_itm_data h2 .add_itm{ border: none; background-color: transparent; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg); background-repeat: no-repeat; background-position: center center; width: 30px; height: 30px; background-size: auto 90%; position: absolute; right: 0; top: 0; }
	
	.Dsh_Shop .shop_itm_data ul{  }
	.Dsh_Shop .shop_itm_data ul li{ display:none; border-bottom: 1px solid #b2aeae; padding: 10px 30px 10px 60px; position: relative; }
	.Dsh_Shop .shop_itm_data ul li figure{ position: absolute; left: 0; top: 10px; width: 50px; height: 50px; background-position: center center; background-size: cover; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	.Dsh_Shop .shop_itm_data ul li ._name{ font-weight: bold; }
	.Dsh_Shop .shop_itm_data ul li ._brand{ color: #989b9c; }
	
	.Dsh_Shop .shop_itm_data ul li:after{ width: 20px; height: 20px; position: absolute; top: 10px; right: 0; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>shop_delete.svg); background-repeat: no-repeat; background-position: center center; background-size: 90% auto; }
	.Dsh_Shop .shop_itm_data ul li:after:hover{ background-size: 80% auto; }
	
	
	.Dsh_Shop .shop_status_ok{ opacity: 0; height: 1px; max-height: 1px; pointer-events: none; padding: 100px 40px; }
	.Dsh_Shop .shop_status_ok figure{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>shop_ok.svg); width: 100px; height: 100px; margin-left: auto; margin-right: auto; background-repeat: no-repeat; background-position: center center; }
	.Dsh_Shop .shop_status_ok h1{ text-align: center; font-family: Economica; width: 100%; }
	.Dsh_Shop .shop_status_ok p{ font-family: Roboto; text-align: center; color: #8d9394; }
	
	.Dsh_Shop._rdy .cnt_data,
	.Dsh_Shop._rdy .shop_itm_data{ opacity: 0; height: 1px; max-height: 1px; overflow: hidden; pointer-events: none; }
	.Dsh_Shop._rdy .shop_status_ok{ opacity: 1; height: inherit; max-height: inherit; pointer-events: all; }
	
	.Dsh_Shop._rdy header h1{ width: 50%; }
	.Dsh_Shop._rdy header h2{ width: 50%; text-align: right; }
	.Dsh_Shop._rdy header h3{ opacity: 0; pointer-events: none; width: 1%; margin-right: -5%; }
	
</style>