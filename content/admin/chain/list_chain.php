<?php
require('Application.php');
require('../../header.php');
$paging = 'paging=';
$limit = "";
if (isset($_GET['paging']) && $_GET['paging'] != "") {
    $paging .= $_GET['paging'];
} else {
    $paging .= 1;
}

$_SESSION['page'] = $current_page;

if(isset($_GET['ch_id']))
{
	$sql="Delete from tbl_chain where ch_id = ".$_GET['ch_id'];
	if(!($result=pg_query($connection,$sql)))
	{
		print("Failed delete_quote: " . pg_last_error($connection));
		exit;
	}
	
}

include('../../pagination.class.php');
$sql = 'SELECT * FROM "tbl_chain" ORDER BY chain';
//echo $sql;
if (!($resultp = pg_query($connection, $sql))) {
    print("Failed queryd: " . pg_last_error($connection));
    exit;
}
$items = pg_num_rows($resultp);
if ($items > 0) {
    $p = new pagination;
    $p->items($items);
    $p->limit(15); // Limit entries per page
    $uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '&paging'));
    if (!$uri) {
        $uri = $_SERVER['REQUEST_URI'] . $search_uri;
    }
    //echo "uri==>".$uri;
    $p->target($uri);
    $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
    $p->calculate(); // Calculates what to show
    $p->parameterName('paging');
    $p->adjacents(1); //No. of page away from the current page

    if (!isset($_GET['paging'])) {
        $p->page = 1;
    } else {
        $p->page = $_GET['paging'];
    }
    //Query for limit paging
    $limit = "LIMIT " . $p->limit . " OFFSET " . ($p->page - 1) * $p->limit;
}
$sql = $sql . " " . $limit;
if (!($resultp = pg_query($connection, $sql))) {
    print("Failed queryd: " . pg_last_error($connection));
    exit;
}
while ($rowd = pg_fetch_array($resultp)) {
    $datalist[] = $rowd;
}
?>
<?php
echo "<font face=\"arial\">";
echo "<blockquote>";
echo "<center><font size=\"5\">Chain Category</font><br/><br/>";
echo "</blockquote>";
echo "</font>";
?>
<table width="100%"> 
    <tr>
        <td align="left" valign="top"><center>
        <table width="100%">
            <tr>
                <td align="center" valign="top"><font size="5"><br>
                    <table border="0" width="20%">
                        <tr>
                            <td align="center"><input type="button" onmouseover="this.style.cursor = 'pointer';" value="Add Chain" onclick="location.href='add_chain.php';" /></td>
<!--<td align="center"><input type="button" value="Generate Spreadsheet" onmouseover="this.style.cursor = 'pointer';" onclick="javascript:spreadsheet();" style="cursor: pointer;"></td>-->   
                        </tr>
                    </table>
                    <br>
                    </font>
                    <table width="80%" border="0" cellspacing="1" cellpadding="1">
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td width="10">&nbsp;</td>
                            <td width="100">&nbsp;</td>
                            <td width="150">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="70%" border="0" cellspacing="1" cellpadding="1">
                        <tr>
                              <td class="grid001">Chain</td> 
                        	<td class="grid001">Status</td> 
                                <td width="5%" class="grid001">Edit</td> 
                                <td width="8%" class="grid001">Delete</td> 
                            
                          
                            </tr>

        <?php
			  if(count($datalist) > 0)
			  {
				  for($i = 0; $i < count($datalist); $i++)
				  {
			  ?>
                                <tr>
                                    <td class="gridVal"><?php echo $datalist[$i]['chain'];?></td>
                                    <td class="gridVal"><?php echo $datalist[$i]['status'];?></td>
                                   
                                   
                                    
                                    <td class="gridVal"><a href="add_chain.php?ch_id=<?php echo $datalist[$i]['ch_id'];?>"><img src="<?php echo $mydirectory;?>/images/edit.png" width="24" height="24" alt="edit" /></a></td>
                                   <?php echo '<td align="center" class="gridVal"><a href="list_chain.php?ch_id=' . $datalist[$i]['ch_id'] . '&' . $paging . '"><img src="' . $mydirectory . '/images/drop.png" width="28" height="28" alt="delete" /></a></td>'; ?>
                                    
                                </tr>              
        <?php
				  }
				  echo 	'<tr>
			<tr><td width="100%" class="grid001" colspan="13">' . $p->show() . '</td></tr>			
		  </tr>';
			  }
			  
			  else
			  {
				  echo '<tr><td colspan="7" class="gridVal">No Store found</td><tr>';
			  }
			 ?>       
                        <tr>
                          <td colspan="5">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>
    </center></td>
</tr>
</table>