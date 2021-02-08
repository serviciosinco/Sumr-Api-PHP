<header>
	  <div id="LgIn_Hdr">
      	  
      </div>
</header>
  
<div id="LgIn">
  <div class="cmp">
    <form id="PrcLgin" name="PrcLgin" method="post" action="inc/prc/lgin.php">
      	<input type="email" name="TwLgIn_User" id="TwLgIn_User" placeholder="usuario" class="required email"/>
      	<input type="password" name="TwLgIn_Pass" id="TwLgIn_Pass" placeholder="clave" class="required"/>
      	<input type="submit" name="button" id="button" value="entrar" />
    </form>
  </div>
  <div class="ldr"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#PrcLgin').validate();
		$('#PrcLgin').ajaxForm({
				dataType:'json', 
				beforeSubmit: function(){ TwLgIn_InLd(); },
				success: function(data){ TwLgIn_RslLd(data); }
		});
	});	
</script>