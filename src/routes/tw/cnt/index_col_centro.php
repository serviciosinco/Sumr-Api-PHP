<?php if($_dttw->id != NULL){ ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $_hshtg_tt ?></title>
<link href="inc/sty/all.css?_h=<?php echo $_hshtg_tx ?>&_t=col_centro" rel="stylesheet" type="text/css">
<base href="<?php echo DMN_TW ?>" target="_self">
</head>

<body>
	<?php if($_dttw->frm == 'cls_2' && PrmLnk('rtn', 2) == 'dv'){ ?>
    <div class="_dv"></div>
    <?php } ?>
    
    <div class="__wrp_center">
            <header style="background-color:#<?php echo $_hshtg_tx_svclr ?>" class="_hdr" id="_Hdr" >
                        <?php if($_dttw->frm == 'cls_2'){ ?>
	                        <div id="LsRgLdr">
	                                <div id="LsTot"><span></span> Mensajes</div>
	                        </div>  
	                        <div class="_data"> 
	                              
	                            <div id="LsQus"></div>
	                        </div>
                        <?php } ?>
                        
                        <div id="_ImgHdr">
                            <?php /*?>
                            <img src="<?php echo DR_IMG_TW.'enchsh_'.$_dttw->id ?>.jpg" <?php if($_dttw->sng != true){ ?>width="100%"<?php }else{ ?> width="1" height="1" <?php }?>>
                            <?php */ ?>
                            <?php include('cnt/dt/swf.php'); ?>
                        </div>
          </header> 
          <div class="container">
                  <input name="Strm_Lst" type="hidden" id="Strm_Lst" />
                     
                  <div id="LsRgAdd"></div> 
                  <input id="FrsNwTw" name="FrsNwTw" type="hidden" />
                  <input id="LstNwTw" name="LstNwTw" type="hidden" /> 
          </div>
          <footer>
                <?php if($_dttw->frm != 'cls_2'){ ?>
                <div id="LsRgLdr"></div>
                <div id="LsTot"><span></span> Mensajes</div>     
                <div id="LsQus"></div> 
                <div class="pwrd"></div>
                <?php } ?>
          </footer>
    </div>
        
		<script type="text/javascript" src="<?php echo DMN_JS; ?>jquery.js"></script>
		<script type="text/javascript" src="<?php echo DMN_JS; ?>jquery-ui.js"></script>
        <script type="text/javascript" src="inc/js/js2.js?_h=<?php echo $_hshtg_tx ?>"></script>
        <script type="text/javascript" src="<?php echo DMN_JS; ?>modernizr.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS; ?>jquery.colorbox.js"></script>
		<script type="text/javascript">
            $(document).ready(function(){
                
                
            });	
        </script>   
</body>
</html> 
<?php } ?>