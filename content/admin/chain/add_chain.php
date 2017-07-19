<?php
require('Application.php');
require('../../header.php');

if (isset($_GET['ch_id'])) {
    $ch_id = $_GET['ch_id'];
    $sql = "select * from tbl_chain where  ch_id = '$ch_id'";
    if (!($result = pg_query($connection, $sql))) {
        $return_arr['error'] = pg_last_error($connection);
        echo json_encode($return_arr);
        return;
    }
    while ($row = pg_fetch_array($result)) {
        $datalist = $row;
    }
    pg_free_result($result);
}

if ($isEdit) {
    $query = ("SELECT * from tbl_chain " .
            "WHERE ch_id = $ch_id ");
    if (!($result = pg_query($connection, $query))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $datalist = $row;
    }
    pg_free_result($result);
	 
}
?>
<table width="90%" >
    <tr>
        <td align="left">
            <input type="button" value="Back" onclick="location.href ='list_chain.php'" />
        </td>  
        <td>&nbsp;</td>
    </tr>
</table>

<?php
echo "<font face=\"arial\">";
echo "<blockquote>";
echo "<center><font size=\"5\">Chain Category</font><br/><br/>";
echo "</blockquote>";
echo "</font>";

?>

<form action="chain_submit.php" id="chain_form" method="post">
<div id="message" class="message_fixed"></div>
<div id="loading" class="message_fixed"><img src="<?php echo $mydirectory; ?>/images/loading.gif" alt="Loading..." /></div>
  <table align="center">
         
        <tr>
           <td align="right">Chain Name:</td>
            <td><input type="text" name="chain_name" value="<?php echo stripslashes($datalist['chain']); ?>" size="20"><input type="hidden" name="ch_id" value= "<?php 
			if(isset($_GET['ch_id']) && $_GET['ch_id']!='') echo $_GET['ch_id']; ?>"  /> </td>
            <td></td>            
        </tr>
        <tr>
        <td align="right">Status:</td>
        <td><select name="status">                    
                    <option <?php if(strtolower(trim($datalist['status'])) == '1') {echo 'selected ="selected"';}?>  value="1">Enable</option>
                    <option <?php if(strtolower(trim($datalist['status'])) == '0') {echo 'selected ="selected"';}?> value="0">Disable</option>
                    </select>
                    </td>
        </tr>
        <tr>
        <td colspan=5 align="center"><br>
          <input type="button" onclick="javascript:frmSubmit();" value="Save" />
          <br></td>
        </tr>
        </table>
 </form>
 
                    
 <script type="text/javascript" src="<?php echo $mydirectory; ?>/js/jquery.min.js"></script>
<script type="text/javascript">
 var loading = $("#loading");
 var msg = $("#message");
function frmSubmit()
{
	
dataString=$("#chain_form").serialize();
showLoading();
   $.ajax({
            type: "POST",
            url: "chain_submit.php",
            data: dataString,
            dataType: "json",
            success:function(data)
            {
				hideLoading();
               if(data.error != ''){show_msg('error', data.error);}
				else if(data.msg != '') {show_msg('success',data.msg);
				//location.href='add_chain.php?ch_id='+data.ch_id;
				}
            },
          
        });
}
 function showLoading(){loading .css({visibility:"visible"}) .css({opacity:"1"}) .css({display:"block"});msg .css({visibility:"hidden"})}
//hide loading bar
function hideLoading(){loading.fadeTo(1000, 0, function(){loading .css({display:"none"});msg .css({visibility:"visible"});});};
window.message_display = null;
function show_msg(cl,ms)
{
    msg.addClass(cl).html(ms).fadeIn();
    window.message_display = setInterval(function() {msg.fadeOut(1600,remove_msg);}, 6000);
}
function remove_msg()
{
    msg.removeClass('success').removeClass('error').html('');
    clearInterval(window.message_display);window.message_display = null;
}
</script>
    
<?php
require('../../trailer.php');
?>