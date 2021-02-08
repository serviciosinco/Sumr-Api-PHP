<?php 
	
	$__cl = GtClLs();
	
	/*foreach($__cl->ls as $__cl_k=>$__cl_v){
		$__ck_sch = CK_SES_C.$__cl_v->enc;
		
		if(!isN($_COOKIE[$__ck_sch])){
			$_enc = explode(".", $_COOKIE[$__ck_sch]);
			if($_enc[2] === $__cl_v->enc){ $_cl_nav_tab[]=$__cl_v; }
		}
		
	}*/
	
	$__id_tab = 'TabbedPanels_'.Gn_Rnd(20);	
	$_CntJQ .= "var $__id_tab = new Spry.Widget.TabbedPanels('$__id_tab');";

	$__gnrl_tabs = [
	];
	
	$__t = Php_Ls_Cln($_GET['_t']);

	foreach($__cl->ls as $__cl_k=>$__cl_v){

		if($__cl_v->enc == $__t){
			$_cl_nav_tab[]=$__cl_v;
		}
	}
?>		
<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<base href="<?php echo DMN_API; ?>" target="_self">
	<title>Api Docs</title>
</head>

<body>
	<style>
		*{ box-sizing: border-box; }
		.VTabbedPanels .TabbedPanelsContentGroup{ text-align: center }
	</style>
	<div id="<?php echo $__id_tab ?>" class="VTabbedPanels">
		
	    <ul class="TabbedPanelsTabGroup f_tab">
		    <?php if(!isN($_cl_nav_tab)){ ?>
		    
		    
		    	<?php $_i_tab = 1; ?>
				<?php foreach($_cl_nav_tab as $_cl_nav_tab_k=>$_cl_nav_tab_v){ ?>
					<?php if($_i_tab==1){ $__first_cl=$_cl_nav_tab_v->enc; } ?>
					<li rel="<?php echo $_cl_nav_tab_v->enc ?>" class="TabbedPanelsTab _cl _anm">
						<figure class="_anm" style="background-image:url(<?php echo $_cl_nav_tab_v->img->sm_s; ?>);" title="<?php echo $_cl_nav_tab_v->nm ?>"></figure>
					</li>
				<?php $_i_tab++; ?>
				<?php } ?>
				    
		    <?php }else{ ?>
			 	<li class="TabbedPanelsTab _anm"></li>	   
		    <?php } ?>
	    </ul>
	    <div class="TabbedPanelsContentGroup" style="width: 94.5%">
		    <?php if(!isN($_cl_nav_tab)){ ?>
		     	<?php foreach($_cl_nav_tab as $_cl_nav_tab_k=>$_cl_nav_tab_v){ ?>
					<div class="TabbedPanelsContent" id="tab_<?php echo $_cl_nav_tab_v->enc ?>">	
						
						<div id="main_navigator_<?php echo $_cl_nav_tab_v->enc ?>" class="main_navigator"></div>	
					</div>
				<?php } ?>    	
	        <?php }else{ ?>
		        <div class="TabbedPanelsContent">
					<?php echo TX_API_DOCS; ?> 
			    </div>  
	        <?php } ?>
	    </div>
	</div>

</body>

</html>
	


<script type="text/javascript">								
		
	var ibx={};

	var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){
		
		SUMR_Ld.f.css({     
			t:'p',  
	        h:'/css/all.css',
	        c:function(){ 
           		<?php $___font = __font(); ?> 		
		        var WebFontConfig = {google: {families: <?php echo $___font->js->string; ?>}, timeout: 2000};

				SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS; ?>sweetalert.css' });
				SUMR_Ld.f.js({ 
					t:'c',
					u:'jquery.js',
					c:function(){
						SUMR_Ld.f.js({ 

							t:'c',
							u:'SpryTabbedPanels.js',
							c:function(){

								$(document).ready(function () { 
									<?php echo $_CntJQ; ?>		
								});
							
			                    $(window).on('load',function(){								
									<?php echo $_CntLd; ?>
									$('body').addClass('rdy');
									__shw_mn_tabs({ cl:'<?php echo $__first_cl; ?>', c:'main_navigator_<?php echo $__first_cl; ?>' });
			                    });  
							}			            		                             
			            });            
		            }
		        });
            }                                       
        }); 
    }
    
    
    
    function _Rqu(p=null){

		if (SUMR_Ld.f.onl() && SUMR_Ld.f.isN( ibx['main'] ) && !SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.t)){
			
			_u = 'docs/'+p.t+'/';
			
			if(!SUMR_Ld.f.isN(p.c)){ 
				var _c = $('#'+p.c); 
			}else{ 
				var _c = $('#main_navigator');
			}
		
			var __opt = $.ajax({
						type:'POST',
						url: _u,
						data: p,
						beforeSend: function() {
							if(!SUMR_Ld.f.isN(p._bs)){ p._bs(); }
			 			},
			 			error:function(e){
				 			if(!SUMR_Ld.f.isN(p._w)){ p._w(e); }
			 			},
						success:function(_r){	
							$(_c).html(_r);
							if(!SUMR_Ld.f.isN(p._cl)){ p._cl(_r); }
						},
						complete:function(e){
							ibx['main'] = '';
							if(!SUMR_Ld.f.isN(p._cm)){ p._cm(e); }
						}
					});
	
			ibx['main'] = __opt;							
		}
	}

	

    
    function __shw_mn_tabs(p){
	    if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.cl)){ _Rqu({ t:'nav', cl:p.cl, c:p.c }); }
    }
    
    
    
    <?php echo $_CntJV; ?>
</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
	$("._cl").click(function(){
		var _cl = $(this).attr("rel");		
	    __shw_mn_tabs({ cl: _cl, c: 'main_navigator_'+_cl });
	});
</script>