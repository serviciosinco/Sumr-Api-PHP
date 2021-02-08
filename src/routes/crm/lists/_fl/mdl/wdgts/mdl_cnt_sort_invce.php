<div id="Lead_Msj_Bx">
    <section class="--ord-dt _anm">

	    <?php echo h2( Spn('','','_tt_icn _tt_icn_itms').'Facturas', '__cmnt'); ?>
	    
		<div class="wrp">
			<div class="_detail">
				<div class="_cnt">
					
					<ul class="shop_itm_data">
						<li id="ord-1" class="_anm">
							<div class="_c">
								<div class="_qty">1P</div>
								<figure style="background-image:url('https://cdn2.bigcommerce.com/server1500/ac84d/products/1204/images/2688/Adidas_Logo_Flower__83153.1337144903.380.380.jpg?c=2');"></figure> 
								<div class="_name">$70.000</div>
								<div class="_brand">2019-21-01 4:05 pm</div>
							</div>								
						</li>
						<li id="ord-2" class="_anm">
							<div class="_c">
								<div class="_qty">1P</div>
								<figure style="background-image:url('https://pbs.twimg.com/profile_images/552450969326190592/FLplWKy1_400x400.png');"></figure> 
								<div class="_name">$236.050</div>
								<div class="_brand">2019-21-01 4:07 pm</div>
							</div>
						</li>
						<li id="ord-3" class="_anm">
							<div class="_c">
								<div class="_qty">2P</div>
								<figure style="background-image:url('http://2.bp.blogspot.com/-BUmS0PN3uWs/T_MiD31MOOI/AAAAAAAADq4/L7kFNY_1nZk/w1200-h630-p-k-no-nu/logo+Nuevo+K+TRONIX.jpg');"></figure> 
								<div class="_name">$750.000</div>
								<div class="_brand">2019-21-01 4:10 pm</div>
							</div>	
						</li>
					</ul>
				
				
				</div>
			</div>			
		</div>
	</section>
</div>
<style>
	
	
	/*-------------- PEDIDOS - LISTA --------------*/
	
	
	.--ord-dt .wrp{ position: relative; }
	.--ord-dt .wrp ._detail{ padding-top: 0px; width: 100%; margin-left: auto; margin-right: auto; padding-bottom: 20px; z-index: 1; position: relative; }
	.--ord-dt .wrp ._detail p{ color: white; margin-bottom: 20px; text-align: center; }
	.--ord-dt .wrp ._detail ._cnt{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-color: white; list-style-type: none; margin: 0; padding: 0; overflow: hidden;  }
	
	
	
	
	.--ord-dt .wrp ._detail .shop_itm_data{ width: 100%; padding: 0; margin: 0; list-style-type: none; z-index: 1; }
	.--ord-dt .wrp ._detail .shop_itm_data li{ border-bottom: 1px solid #b2aeae; position: relative; width: 100%; position: relative; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._c{ padding: 10px 30px 20px 100px; position: relative; width: 100%; min-height:inherit; text-align: left; font-size: 11px; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li:last-child{ border-bottom:none; }
	.--ord-dt .wrp ._detail .shop_itm_data li figure{ position: absolute; left: 50px; top: 10px; width: 35px; height: 35px; background-position: center center; background-size: auto 110%; background-repeat: no-repeat; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; margin:0; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li ._qty{ position: absolute; left: 0px; top: 15px; border-radius:100px; -moz-border-radius:100px; -webkit-border-radius:100px; color: #fff; font-family: Economica; font-weight: 300; font-size: 16px; line-height:30px; vertical-align: middle; width:30px; height:30px; background-color: #599cb8; text-align: center; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li ._name{ font-weight: bold; color: #4a4444; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._brand{ color: #989b9c; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li:after{ width: 20px; height: 20px; position: absolute; top: 10px; right: 0; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>shop_delete.svg); background-repeat: no-repeat; background-position: center center; background-size: 90% auto; }
	.--ord-dt .wrp ._detail .shop_itm_data li:after:hover{ background-size: 80% auto; }
	
	
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms{ display: flex; opacity: 0; pointer-events: none; max-height: 1px; overflow: hidden; /*position: absolute; left: 0; top: 0;*/ width: 99%; height: 100%; background-color:rgba(255, 255, 255, 1); overflow: hidden; text-align: center; border: none; margin-left: auto; margin-right: auto; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button{ width: 32.3%; font-size: 11px; text-align: center; background-color:#f1f4f7; border:none; cursor: pointer; /*color:white;*/ margin: 0.5%; padding: 15px 0; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button:before{ display: block; width: 20px; height: 20px; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; margin-left: auto; margin-right: auto; margin-bottom: 5px; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.eli{ color:#AB1616; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.eli:before{ background-image: url('img/ord_opt_del.svg'); pointer-events: none; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.mod{ color:#3B97D9; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.mod:before{ background-image: url('img/ord_opt_mod.svg'); pointer-events: none; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.ok{ color:#5BAB22; }
	.--ord-dt .wrp ._detail .shop_itm_data li ._opt_itms button.ok:before{ background-image: url('img/ord_opt_ok.svg'); pointer-events: none; }
	
	
	.--ord-dt .wrp ._detail .shop_itm_data li.-opt ._opt_itms{ opacity: 1; pointer-events: all; max-height: inherit; overflow: visible; /*margin-top: 30px;*/  }
	
	.--ord-dt .wrp ._detail .shop_itm_data li._eli{ background-color: #ffe8e8; opacity: 0.5; }
	.--ord-dt .wrp ._detail .shop_itm_data li._eli ._qty{ background-color: #8c0000; }
	.--ord-dt .wrp ._detail .shop_itm_data li._eli ._name{ color:#8c0000; text-decoration: line-through; }
	.--ord-dt .wrp ._detail .shop_itm_data li._eli ._brand{ text-decoration: line-through; }
	
	.--ord-dt .wrp ._detail .shop_itm_data li._ok ._qty{ background-color: #40c504; }
	.--ord-dt .wrp ._detail .shop_itm_data li._ok ._name{ color:#40c504; }
	
	
	
	.--ord-dt .wrp ._detail .shop_itm_data li._mod ._c,
	.--ord-dt .wrp ._detail .shop_itm_data li._mod ._opt_itms{ display: none; }
	
	

	
</style>	