<div class="_shdw"></div>

<?php if(!isMobile()){ ?>
<div class="_src _bx"> 
	<?php 
	$browser = new Browser(); 
	if(isMobile()){ $_icn_c = 'mbl'; }elseif(isIPad()||isTablet()){ $_icn_c = 'ipd'; }else{ $_icn_c = 'pc'; } 
	?>
	<div class="dsp <?php echo $_icn_c ?>"></div>
	<div class="_c">
		<?php echo Strn($browser->getPlatform()) ?>
        <?php echo Spn($browser->getVersion(),'ok') ?>
    </div>    
</div>
<?php } ?>

<div class="_pdfbx _bx"> 
	<a title="Version PDF" href="<?php echo DMN_FLE_EC_HTML.$__dtec->dir.'/src.pdf' ?>" target="_blank">
    <div class="_icn _pdf"></div>
      <div class="_c">
      		<span class="_t">Versión PDF</span>
      </div>	
    </a>
</div>
  
<div class="_shrbx _bx">
	  <div class="_icn _rds"></div>
      <div class="_c">
                <?php if(!isMobile()){ ?><span class="_t">Compartir</span><?php } ?>
                <?php if(!isMobile()){ $__cls_bx = 'md'; }else{ $__cls_bx = 'bg'; } ?>
                <div class="_d">
                        <?php 
                                $__shr_lnk = urlencode($__dtec->shr);
                                $__shr_tt = urlencode($__dtec->tt);
                                
                                if(!isMobile()){ 
                                    $_shr_fb = "javascript:__pop('https://www.facebook.com/sharer/sharer.php?u=".$__shr_lnk."&display=popup'); return false;";
                                    $_shr_tw = "javascript:__pop('https://twitter.com/intent/tweet?text=".$__shr_tt."&tw_p=&url=".$__shr_lnk."&via=SUMR'); return false;";
                                    $_shr_ld = "javascript:__pop('http://www.linkedin.com/shareArticle?mini=true&url=".$__shr_lnk."&title=".$__shr_tt."&source=SUMR'); return false;";
                                    $_shr_go = "javascript:__pop('https://plus.google.com/share?url=".$__shr_lnk;
                                    $_shr_pn = "javascript:__pop('http://pinterest.com/pin/create/button/?url=".$__shr_lnk."&media=".urlencode($__img)."&description=".$__shr_tt."'); return false";
								  $__trg = '';
							  }else{
                                    $_shr_fb = "https://www.facebook.com/sharer/sharer.php?u=".$__shr_lnk."&display=popup";
                                    $_shr_tw = 'twitter://post?message='.$__shr_tt.' '.$__shr_lnk;
                                    $_shr_ld = "http://www.linkedin.com/shareArticle?mini=true&url=".$__shr_lnk."&title=".$__shr_tt."&source=SUMR";
                                    $_shr_go = "https://plus.google.com/share?url=".$__shr_lnk;
                                    $_shr_pn = "http://pinterest.com/pin/create/button/?url=".$__shr_lnk."&media=".urlencode($__img)."&description=".$__shr_tt;
									$__trg = 'target="blank"';
                                }
                            ?>
                        <div class="_rdicn_<?php echo $__cls_bx ?>">
                                
                            <a class="tw" <?php echo _href($_shr_tw) ?> <?php echo $__trg ?>></a>
                            <a class="fb" <?php echo _href($_shr_fb) ?> <?php echo $__trg ?>></a>
                            <a class="ld" <?php echo _href($_shr_ld) ?> <?php echo $__trg ?>></a>
                            <a class="pn" <?php echo _href($_shr_pn) ?> <?php echo $__trg ?>></a>
                            <a class="go" <?php echo _href($_shr_go) ?> <?php echo $__trg ?>></a>
                                
                        </div>
            </div>   
      </div>	
</div>
      
<div class="_lkebx _bx"> 
      <?php if(!isMobile()){ ?><div class="_icn _lke"></div><?php } ?>
      <div class="_c">
            <?php if(!isMobile()){ ?><span class="_t">Me gusta</span><?php } ?>
            <?php if(!isMobile()){ $_tplke = 'box_count'; $_wdlke = 80; }else{ $_tplke = 'button_count'; $_wdlke = 120; } ?>
        	<div class="_d">             
            		<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(DMN_EC.PrmLnk('bld', $__dtec->pml)) ?>&amp;width=<?php echo $_wdlke ?>&amp;layout=<?php echo $_tplke ?>&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=65&amp;appId=<?php echo APP_FB_ID ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $_wdlke ?>px; height:65px;" allowTransparency="true"></iframe>
            </div>
      </div>	
</div>     

<div class="_flwbx _bx"> 
  <div class="_icn _twt"></div>
      <div class="_c">
        <?php if(!isMobile()){ ?><span class="_t">Siganos</span><?php } ?>
        <?php if(!isMobile()){ $__cls_bx = 'md'; }else{ $__cls_bx = ''; } ?>
        <div class="_d">    
   		</div>
      </div>	
</div>     

<!--
<div class="_tllbx _bx"> 
      <a href="javascript:__tll('<?php echo $__dtec->enc ?>');" target="_self" id="SvBtnFrnd">
      <div class="_icn _tll"></div>
      <div class="_c">
        	<span class="_t">Contar a un amigo</span> 	
      </div> 
      </a> 
</div>-->

<?php if(!isMobile()){ ?>     
<div class="_onlbx _bx">
  <a href="#" target="_self" class="SvBtnOnl">
      <div class="_spc">
      	   <div id="_onl_ld" class="_icn _onl"></div>
      	   <div id="_onl_nm" class="_nm"></div>
      </div>
          <div class="_c">
                <span class="_t">En Línea</span>
          </div>
  </a>     
</div>


<div class="_statbx _bx">
  <a href="#" target="_self" class="SvBtnStat">
      <div class="_spc">
            <div id="_stat_ld" class="_icn _stat"></div>
            <div id="_stat_nm" class="_nm"></div>
      </div>
      <div class="_c">
                <span class="_t">Visitas</span>
      </div> 
  </a>      
</div>
<?php } ?> 
   
<?php  

$_CntJQ .= "
		
		$('#_SvMn').hover(
		  function() {
			$('._cnt_html').addClass('_htmlop');
		  }, function() {
			$('._cnt_html').removeClass('_htmlop');
		  }
		);
"; 
		 
?>