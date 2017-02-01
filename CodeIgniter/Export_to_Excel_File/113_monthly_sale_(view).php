
<link rel="stylesheet" href="<?php echo base_url('css/bootstrap.css'); ?>" type="text/css" />

<p>&nbsp</P>

    <form action="<?php echo site_url('report/monthly_sale_excel_or_print');?>" method="post" target="_blank" class="form-inline">

    
<table width="100%">
	<tr>
		<td align="right" width="40%">
			Month:
		</td>
		<td align="left" width="20px">
			<select name="month" id="month" class="form-control">
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
		</td>
		<td align="right" width="100px">
			Year:
		</td>
		<td align="left">
			<select name="year" id="year" class="form-control">
				<?php
					for($year=2015;$year<=2025;$year++)
					{
						echo "<option value='".$year."'>".$year."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
            <td colspan="4" style="padding: 10px 0px;">
			<button id="report" type="button">Report</button>
		</td>
	</tr>
	<tr>
		<td colspan="4" id="stock" align="center"></td>
	</tr>
	<tr>
		<td colspan="4" style="padding: 10px 0px;">
			<button id="report" type="submit" value="print" name="print">Print</button>
		</td>
	</tr>
        
        <!--Here testing start-->
        <tr>
            <td colspan="4">
                
                <button id="report" type="submit" value="excel" name="print">Export to Excel</button>
            </td>
</tr>
        <!--Here testing end-->
</table>
</form>
<script type="text/javascript">

  $(function()
  {
	  $("#report").click(function()
	  {
	  	var month=$("#month").val();
		var year=$("#year").val();
		$.ajax({
			type:"post",
			data:"month="+month+"&year="+year,
			url:"<?php echo site_url('report/monthly_sale_view')?>",
			success:function(msg)
			{
				$("#stock").html(msg);
			}
		});
	  });
  });
</script>