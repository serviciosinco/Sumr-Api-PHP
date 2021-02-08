<?php if($_dttw->id != NULL){ ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $_hshtg_tt ?></title>
<link href="inc/sty/all.css?_h=<?php echo $_hshtg_tx ?>&_t=col_mtd" rel="stylesheet" type="text/css">
<base href="<?php echo DMN_TW ?>" target="_self">
</head>

<body>
	<?php if($_dttw->frm == 'cls_2' && PrmLnk('rtn', 2) == 'dv'){ ?>
    <div class="_dv"></div>
    <?php } ?>
    
    
    <header style="background-color:#<?php echo $_hshtg_tx_svclr ?>" class="_hdr" id="_Hdr">
                <?php if($_dttw->frm == 'cls_2'){ ?>
                
                
               
				
                
                <div class="_data">  
                    <div id="LsQus"></div>
                </div>
                <?php } ?>
                
               
					<?php /*?>
                    <img src="<?php echo DR_IMG_TW.'enchsh_'.$_dttw->id ?>.jpg" <?php if($_dttw->sng != true){ ?>width="100%"<?php }else{ ?> width="1" height="1" <?php }?>>
                    <?php */ ?>
                    
                    
					<iframe width="100%" height="100%"  src="<?php echo $_dttw->emb; ?>" frameborder="0" allowfullscreen></iframe>
                    
               
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
        
		<script type="text/javascript" src="<?php echo DMN_JS; ?>jquery.js"></script>
		<script type="text/javascript" src="<?php echo DMN_JS; ?>jquery-ui.js"></script>
        <script type="text/javascript" src="inc/js/js.js?_h=<?php echo $_hshtg_tx ?>"></script>
        <script type="text/javascript" src="<?php echo DMN_JS; ?>modernizr.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS; ?>jquery.colorbox.js"></script>
		<script type="text/javascript">
            $(document).ready(function(){
                 Strm_GtTw('<?php echo $_hshtg_tx ?>');
                 upd__strmtw = setInterval(function() { Strm_GtTw('<?php echo $_hshtg_tx ?>', 'upd'); }, 25000);
            });	
        </script>   
</body>
</html> 
<?php } ?>