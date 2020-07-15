<div class="well">
<div class="table-responsive">          
				<table class="table">
					<thead>
					<tr>
					<th class="bg-success"><i class="glyphicon glyphicon-info-sign"></i> สภาพอากาศปัจจุบัน </th>
				   
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>
<?php

	for ($i = 1; $i <= 3; $i++) {
					
						
						
						$_call->data_xml($_cfg_xml[$i][0]);
					

					
						
					}

?>

</td>
</tr>
</tbody>
</table>
</div>		
</DIV>

</div>