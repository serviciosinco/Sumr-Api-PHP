<?php

	Hdr_HTML();
	ob_start("compress_code");

	$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

    if($_SERVER['HTTP_HOST'] == 'monitor.sumr.cloud'){
        header("Location: https://monitor.sumr.co/status/?Rnd=1.2");

	}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <base href="https://<?php echo 'monitor.'.DMN; ?>; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo DMN_CSS; ?>sb/mntr/main.css?Rnd=1.11">
    </head>
    <body>
        <section class="main it_1">
			<section id="server" class="server col sec_3">
				<div class="cont_server">

				</div>
				<div class="video">
					<div id="player"></div>
					<ul>
						<li class="ec user_cxc users">
							<div class="tit">
								<figure></figure>
								<p class="cntr">Social</p>
							</div>
							<div class="social">
								<div id="wmdl" class="wscl">
									<h2 id="wout_mdl" class="cantidad">-</h2>
									<div><figure></figure><p>Sin modulo</span></p></div>
								</div>
								<div id="wplcy" class="wscl">
									<h2 id="wout_plcy" class="cantidad">-</h2>
									<div><figure></figure><p>Sin politica</span></p></div>
								</div>
							</div>
							<!--<ul>
								<li><span class="ws">WS > </span> <span class="est2"> 3% - 12/12/2012</span>  2cc9e0a92964f3462173a3ac5447f1e1ccce9dfb</li>
								<li><span class="ws">WS > </span> <span class="est2"> 5% - 12/12/2012</span>  2cc9e0a92964f3462173a3ac5447f1e1ccce9dfb</li>
								<li><span class="ws">WS > </span> <span class="est2"> 7% - 12/12/2012 </span>  2cc9e0a92964f3462173a3ac5447f1e1ccce9dfb</li>
								<li><span class="ws">WS > </span> <span class="est2"> 9% - 12/12/2012 </span>  2cc9e0a92964f3462173a3ac5447f1e1ccce9dfb</li>
							</ul>-->
						</li>
					</ul>
					<!--<iframe width="100%" height="250" src="https://www.youtube.com/embed/playlist?list=UUX9NJ471o7Wie1DQe94RVIg&autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
				</div>
            </section>
            <section id="conteos" class="conteos col">
	            <div class="prcs">
	                <div class="cont1 col1">
	                    <ul>
	                        <li class="ec"><h2 id="lead_ads" class="cantidad">-</h2><div><figure></figure><p>Leads AD<span></span></p></div></li>
	                        <li class="eml_fll"><h2  id="emls_wrg" class="cantidad">-</h2><div><figure></figure><p>Mails</p></div></li>
	                        <li class="eml_rbt"><h2 id="eml_rbt" class="cantidad">-<span>%</span></h2><div><figure></figure><p>Mails<span>de rebote</span></p></div></li>
	                    </ul>
	                </div>
	                <div class="cont1 col2">
	                    <ul>
	                       	<li class="ec"><h2 id="ec_prc_aprd" class="cantidad">-</h2><div><figure></figure><p class="cntr">Pushmail<span>en aprobación</span></p></div></li>
	                        <li class="cd"><h2 id="cds_vrf" class="cantidad">-</h2><div><figure></figure><p class="cntr">Ciudades</p></div></li>
	                        <li class="clg"><h2 id="org_vrf" class="cantidad">-</h2><div><figure></figure><p class="cntr">Colegios<span>/ empresas</span></p></div></li>
	                    </ul>
	                </div>
	                <div class="slc_tot col3">
	                    <ul>
							<li class="cmpg"><h2 id="ec_snd_cmpg" class="cantidad">-</h2><div><figure></figure><p class="cntr">Campañas enviando</p></div></li>
	                        <li class="cmpg"><h2 id="cmpg_cla" class="cantidad">-</h2><div><figure></figure><p>Campañas<span>en cola</span></p></div></li>
							<li class="cmpg"><h2 id="ec_snd_pnd" class="cantidad">-</h2><div><figure></figure><p class="cntr">Campañas por aprobar</p></div></li>
							<li class="cmpg"><h2 id="auto_rqu" class="cantidad">-</h2><div><figure></figure><p>Auto Locks</p></div></li>
	                    </ul>
	                </div>
	            </div>
                <div class="user">
                    <ul>
                        <li class="cmpg user_cx users">
							<div class="__data">
								<ul>
									<li class="d_1"></li>
									<li class="d_2"></li>
								</ul>
							</div>
							<div id="container" style="width: 100%; height: 280px; margin: 0 auto"></div>
						</li>
                    </ul>
                </div>
            </section>
            <section id="tareas" class="tareas col">
                <div class="logo">
	                <figure></figure>
	                <p id="time" class="time">

	                </p>
	            </div>
                <div class="tra">
                    <div><figure></figure><p class="cntr">Tareas / Tickets</p><figure class="tck"></figure></div>
                    <ul id="ls_tra"></ul>
                </div>
                <div class="mre_err">
	                <div class="sis_err errors">
	                    <h2 id="sis_err" class="cantidad">-</h2>
						<div ><figure></figure><p>Sistema<span>de error</span></p></div>

	                </div>
	                <div class="sis_err dwn">
						<h2 id="dwn_est" class="cantidad">-</h2>
	                    <div ><figure></figure><p>Descargas<span>sin completar</span></p></div>
	                </div>
                </div>
            </section>
        </section>
        <!--<p id="play">prueba</p>-->
    </body>
</html>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/7.2.0/highcharts.js"></script>

<!--<script src="https://www.youtube.com/iframe_api"></script>-->
<script>
	/*var player,
    time_update_interval = 0;

	function onYouTubeIframeAPIReady() {
	    player = new YT.Player('player', {
	        width: '100%',
	        height: '250',
	        videoId: 'Xa0Q0J5tOP0',
	        playerVars: {
	            color: 'white',
	            playlist: 'PLxiARuba68F1400F_04xZ_VX3k6RY9KYm'
	        },
	        events: {
	            onReady: initialize
	        }
	    });
	}

	function initialize(){ }

	setInterval(function(){

		$('#play').off('click').on('click').click();

	}, 7000);

	$('#play').off('click').on('click').click(function(){
		player.playVideo();
	});*/

	/*function Ajax(){
		$.ajax({
		    type:'POST',
	    	url: 'https://<?php echo 'monitor.'.DMN; ?>json/listado/',
	    	dataType: 'json',
	    	success: function(e){
	    		if(!isN(e)){ if(!isN(e.dsh)){ ClSet(e.dsh); } }
				if(!isN(e)){ if(!isN(e.ls)){ ClSetLs(e.ls); } }
	    		document.getElementById("play").click();
			}
		});
	}

	Ajax();*/

	function ClSetLs(_r){

		$('#ls_tra').html('');

		if(!isN(_r.server.e)){
			$('.cont_server').html('').addClass('row_'+_r.server.tot);
			$.each(_r.server.ls, function(_k, _v) {
				$('.cont_server').append('<div class="serv serv'+_v.est+' _srvs"> <figure><img src="<?php echo DMN_IMG_ESTR ?>mntr/Server_'+_v.est+'.svg"></figure> <div class="info"> <h2>'+_v.nm+'</h2> <ul> <li class="est_2 est">'+_v.vl+'% en uso</li></ul> </div> </div>');
			});
		}

		if(!isN(_r.tck.e)){
			$.each(_r.tck.ls, function(k, v) {

				if(!isN(v.us_img)){ var us_img = '<?php echo DMN_FLE_US; ?>'+v.us_img; }else{ var us_img = ''; }

				var icn_cl = '<figure class="icn_cl" style=" background-image : url(<?php echo DMN_FLE_CL; ?>th/'+v.cl_img+') "></figure>';
				var icn_us = '<figure class="icn_us" style=" background-image : url('+us_img+') "></figure>';
				var us_nm = '<span>'+v.us_nm+'</span>';

				if(v.pqr == 1 || v.tck == 1){ var cls_tra = '__tck'; }else{ var cls_tra = '__tra'; }

				$('#ls_tra').append('<li class="'+cls_tra+'">'+icn_cl+icn_us+'<p>'+v.tt+us_nm+'</p></li>');

			});
		}

		$('#time').html(_r.time);


	}

	function ClSet(_r){

		$('#ec_prc_aprd').html(_r.dsh_ec_prc_aprb);
		$('#eml_rbt').html(_r.dsh_eml_rbt);
		$('#cmpg_cla').html(_r.dsh_cmpg_cla_tot+'<p> / '+_r.dsh_cmpg_cla_tots+'</p>');
		$('#cds_vrf').html(_r.dsh_cds_vrf);
		$('#sis_err').html(_r.dsh_sis_err);
		$('#emls_wrg').html(_r.dsh_emls_wrg_bad_w+' <p> / '+_r.dsh_emls_wrg_no_chck+' v</p>');
		$('#org_vrf').html(_r.dsh_org_vrf);
		$('#dwn_est').html(_r.dsh_dwn_est);
		$('#lead_ads').html(_r.dsh_lead_ads_dia+'<p> / '+_r.dsh_lead_ads_mes+'</p>');
		$('#ec_snd_cmpg').html(_r.dsh_ec_snd_cmpg_tot+'<p> / '+_r.dsh_ec_snd_cmpg_tots+'</p>');
		$('#ec_snd_pnd').html(_r.dsh_ec_snd_pnd);
		$('#wout_mdl').html(_r.dsh_scl_rcl_mdl);
		$('#wout_plcy').html(_r.dsh_scl_rcl_plcy);
		$('#auto_rqu').html(_r.dsh_auto_rqu);

		$('.d_1').html(_r.dsh_api_d_1);
		$('.d_2').html(_r.dsh_api_d_2);

		var d1 = JSON.parse(_r.dsh_api_1);
		var d2 = JSON.parse(_r.dsh_api_2);
		var c = JSON.stringify(_r.dsh_api_c);

		setTimeout(function(){
			Highcharts.chart('container', {
				chart: { type: 'spline', backgroundColor: "rgba(0,0,0,0)" },
				title: { text: '' },
				legend: {
					enabled:false
				},
				xAxis: {
					lineColor: '#2a3044',
					categories: c,
				},
				yAxis: {
					title: { text: '' },
					gridLineColor: '#474f6b'

				},
				tooltip: {
					shared: true,
					valueSuffix: ' units'
				},
				exporting: { enabled: false },
				credits: { enabled: false },
				plotOptions: {
					areaspline: { fillOpacity: 0.5 }
				},
				series: [{
					name: 'Good',
					data: d1,
					color:'#458c45'
				}, {
					name: 'Bad',
					data: d2,
					color:'#883f3f'
				}]
			});
		}, 3000);
	}

	setInterval(function() { /*Ajax();*/ }, 10000);

	var tareas = $('.tareas');
	var conteos = $('.conteos');
	var server = $('.server');

	setInterval(function() {
		if($('.main').hasClass('it_1')){
			$('.main').removeClass('it_1').addClass('it_2');
			tareas.insertAfter(conteos);
		}else if($('.main').hasClass('it_2')){
			$('.main').removeClass('it_2').addClass('it_3');
			tareas.insertBefore(server);
		}else{
			$('.main').removeClass('it_3').addClass('it_1');
			conteos.insertAfter(server);
		}
	}, 15000);

</script>
<?php ob_end_flush(); ?>