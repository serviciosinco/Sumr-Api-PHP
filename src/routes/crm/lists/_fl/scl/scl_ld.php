<?php 
	
if(class_exists('CRM_Cnx')){

	$_enc = $___Ls->gt->i;
	        
?>

<div class="Dsh_Scl_Ld" id="Dsh_Scl_Ld">

    <div class="_ovr _anm"></div>

	
	<?php			       		
							
		$___Ls->_dvlsfl_all([
			['n'=>'dsh', 'l'=>TX_DSH ],
			['n'=>'lists', 't'=>'mdl_cnt', 't2'=>$___Ls->gt->tsb, 'wrp'=>'ok', 'l'=>'Listado' ]
		],[
			'idb'=>'ok'
		]);
	?>

	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny ignr DshSclTab">
		<ul class="TabbedPanelsTabGroup">	
			<?php if(_ChckMd('scl_ld')){ echo $___Ls->tab->dsh->l; } ?>
			
		</ul>
		<div class="TabbedPanelsContentGroup">
			
				<div class="TabbedPanelsContent">
                    <?php include('scl_dsh.php'); ?>
				</div> 

               
		</div>
	</div>   
	    
</div>
<style>
    .Dsh_Scl_Ld{ width: 100%;height: 100%;background: #f3efef;position: relative; }
    .Dsh_Scl_Ld ._ovr{ width: 100%; height: 0px; }
    .Dsh_Scl_Ld .VTabbedPanels.DshSclTab {display: flex;}
    .Dsh_Scl_Ld .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ width: 100%;  }
    .Dsh_Scl_Ld .VTabbedPanels.DshSclTab.mny > .TabbedPanelsTabGroup {width: 53px !important;background-color: #252525 !important;min-height: var(--tra-col-mh);padding-left: 0;margin-top: 0;}
    .Dsh_Scl_Ld .VTabbedPanels.DshSclTab.mny .TabbedPanelsTabGroup li{ cursor: pointer;margin: 5px;height: 43px;width: 43px;background-size: 75% auto;background-repeat: no-repeat;background-position: center center; }      

	.Dsh_Scl_Ld .VTabbedPanels .TabbedPanelsTab._dsh{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_dsh.svg); }
	.Dsh_Scl_Ld .VTabbedPanels .TabbedPanelsTab._todo{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_todo.svg); }
    .Dsh_Scl_Ld .VTabbedPanels .TabbedPanelsTab._lists{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_list.svg); }
    

.DshSclMntr{width:100%;display:flex;background-color:#f5f6fb}
.DshSclMntr .cols{margin:10px;border-radius:5px;border:1px dashed #e0e0e0;padding:0 15px}
.DshSclMntr .cols.col1{width:60%;}
.DshSclMntr .cols.col2{width:40%;}

.DshSclMntr .cols .rows{background-color:#fff;width:calc(100%);display:flex;margin:20px 0;position:relative;border-radius:5px; } 
.DshSclMntr .cols .rows.bxt1{ min-height:250px; }
.DshSclMntr .cols .rows.bxt2{ max-height:250px; min-height:250px; }

.DshSclMntr .cols .rows ._cols{margin:10px;position:relative;cursor:move}
.DshSclMntr .cols .rows.__col_1 ._cols{width:100%}
.DshSclMntr .cols .rows.__col_2 ._cols{width:50%}
.DshSclMntr .cols .rows.__col_3 ._cols{width:33.3%}
.DshSclMntr .cols .rows.__col_4 ._cols{width:25%}
.DshSclMntr .cols .rows.__col_5 ._cols{width:20%}
.DshSclMntr .cols .rows ._cols.ui-sortable-helper{background-color:#dcdcdc78}
.DshSclMntr .cols .rows ._cols.ui-sortable-helper:before,
.DshSclMntr .cols .rows ._cols:first-of-type:before{background-color:transparent}
.DshSclMntr .cols .rows ._cols::before{content:"";width:2px;height:70%;background-color:#efefef;display:block;position:absolute;left:0;top:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}      
.DshSclMntr .cols .rows ._cols .card{position:absolute;width:100%;left:50%;top:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}
.DshSclMntr .cols .rows ._cols .card span{font-size:50px;text-align:center;display:block;font-weight:700}
.DshSclMntr .cols .rows ._cols .card p{font-size:11px;text-align:center;font-weight:700;text-transform: uppercase;}
.DshSclMntr .cols .rows ._cols .card.est_1 p{color:green}
.DshSclMntr .cols .rows ._cols .card.est_2 p{color:blue}
.DshSclMntr .cols .rows ._cols .card.est_3 p{color:gray}
.DshSclMntr .cols .rows ._cols .card.est_4 p{color:red}

.DshSclMntr .new-conten{margin:10px!important;width:100px;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}
.DshSclMntr .new-conten2{height:100px;width:500px;margin:10px!important;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}
.DshSclMntr .new-conten1{height:100px;margin:10px!important;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}

.DshSclMntr .cols .rows ._cols h2{text-align:center;font-family:Economica;color:#868686;margin:0;padding: 15px 0;}
.DshSclMntr .cols .rows ._cols ul{list-style-type:none; }
.DshSclMntr .cols .rows ._cols ul li{cursor:pointer;}
.DshSclMntr .cols .rows ._cols ul li{width:100%;font-size:13px;padding:6px 0;border-bottom:1px solid #e0e0e0}
.DshSclMntr .cols .rows ._cols ul li .round{font-size:12px;display:inline-block;width:20px;height:20px;background-color:#c7c7c7;border-radius:12px;float:left;margin-right:6px;text-align:center;padding: 2px 0 0px 0;}

.DshSclMntr #lstd_mdlcnt li{ position:relative; border-radius: 12px; display: flex; }
.DshSclMntr #lstd_mdlcnt li > .dte{ display:block;font-size:10px;position:relative;right:10px;color:#a5a5a5; padding-left: 20px; white-space: nowrap; }
.DshSclMntr #lstd_mdlcnt li > .dte:before{ content:"";display:block;position:absolute;width:14px;background-position:center; background-size:100% auto; background-repeat:no-repeat; height:14px; filter:grayscale(49%); top:0px; left:0px; background-image:url([FSVG]snd_cmpg_dte.svg); }
.DshSclMntr #lstd_mdlcnt li > .dte .hour{ display: block; width: 100%; text-align: right; }

.DshSclMntr #lstd_mdlcnt li > .icn {background-image:url([FSVG]tra_tickt.svg);width: 25px;height: 25px;background-size: 60% auto;background-position: center center;border: 1px solid #cecece;border-radius: 50%;margin-right: 5px;font-size: 0;vertical-align: middle;}
.DshSclMntr #lstd_mdlcnt li:hover {background-color: #e4e4e4;padding: 6px;}

.DshSclMntr #lstd_mdlcnt div.nm { display:flex !important;font-size: 12px !important;position: relative !important;color: black !important;padding: 5px !important;margin: 0 !important;vertical-align: middle;width: 195px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; width: 100%; }
.DshSclMntr #lstd_mdlcnt div.nm:before{ display: none }

.DshSclMntr #lstd_mdlcnt div.nm > div.n{ max-width: 77%; text-overflow: ellipsis; overflow: hidden; }
.DshSclMntr #lstd_mdlcnt div.nm > div.tckt{ margin-left:5px; border-radius: 6px !important;color:white !important; width: 22%; max-width: 22%; text-align: left; }
.DshSclMntr #lstd_mdlcnt div.nm > div.tckt > .bx{ border-radius: 6px !important; color:white !important; padding: 2px 4px; text-align: center; font-size: 10px; width:auto; display: inline-block; }
</style>
<?php include('scl_js.php'); ?>
<?php } ?>