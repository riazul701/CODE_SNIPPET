<section> 
	<div class="customer_area"> 
		<div class="row"> 
			<div class="customer_inner"> 
				<div class="col-md-12"> 
				<?php echo form_open_multipart('invoice/insertinvoice'); ?>
				<?php echo $this->session->flashdata('msg'); ?>
					<form class="form-horizontal">
					  <div class="form-group">
					  <?php 
							$year=date("Y");
							$month=date("m");
							$vid=$list->invoice_id+1;
						?>
						<label for="inputEmail3" class="col-sm-2 control-label">Invoice Number</label>
						<div class="col-sm-4">
						<input type="hidden" value="<?php echo $vid; ?>" name="invoice_id">
						<input type="hidden" value="" name="clickval" id="clickval">
						  <input type="text" class="form-control" id="" placeholder="" name="invoicen" value="C<?php echo $year.$month.$vid; ?>" readonly>
						  <span class="text-danger"><?php echo form_error('invoicen'); ?></span>
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Company Name</label>
						<div class="col-sm-4">
						  	<select class="form-control" name="customer_id" onchange="getcompanyname(this.value);">
							  <option selected>Company Name</option>
									  <?php 
										for ($i=0; $i <count($mylist) ; $i++) {
                        				
									  ?>
									  <option value="<?php echo $mylist[$i]->customer_id; ?>"><?php echo $mylist[$i]->company_name; ?></option>
									  <?php }?>
								</select>
						</div>
					  </div>
					  <div class="form-group">
						<label for="" class="col-sm-2 control-label">Contact Person Name</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="c_name" placeholder="Contact Person Name" name="company_name" value="" readonly>
						  <span class="text-danger"><?php echo form_error('company_name'); ?></span>
						</div>
					  </div>
					  <div class="form-group">
						<label for="" class="col-sm-2 control-label">Issue Date</label>
						<div class="col-sm-2">
						  <input type="date" class="form-control datepicker" id="" placeholder="Select Date" name="issue_date" value="<?php echo set_value('issue_date'); ?>">
						  <span class="text-danger"><?php echo form_error('issue_date'); ?></span>
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Due Date</label>
						<div class="col-sm-2">
						  <input type="date" class="form-control datepicker" id="" placeholder="Select Date" name="due_date" value="<?php echo set_value('due_date'); ?>">
						  <span class="text-danger"><?php echo form_error('due_date'); ?></span>
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Payment Status</label>
						<div class="col-sm-3">
						  	<select class="form-control" name="status">
							  <option selected>Select Payment Status</option>
							  <option value="1">Paid</option>
							  <option value="0">Due</option>
							</select>
						</div>
					  </div>
					  <table class="table">
	                		<tr>
			                    <th>Service Name</th>
			                    <th>Description</th>
			                    <th>Unit Price</th>
			                    <th>Total Unit</th>
			                    <th>Total price</th>
			                    <th></th>
	                		</tr>
	                		<tr>
	                			<td>
	                				<select class="form-control" id="servicename" onchange="getservice(this.value);unitpriceadd();">
									  <option value="selected" selected>Select Service</option>
									  <?php 
										for ($i=0; $i <count($my) ; $i++) {
                        				
									  ?>
									  <option value="<?php echo $my[$i]->service_id; ?>"><?php echo $my[$i]->service_name; ?></option>
									  <?php }?>
									</select>
	                			</td>
	                			<td> <textarea class="form-control" rows="3" id="description"></textarea></td>
	                			<td>
	                				<div >
									  <input type="text" class="form-control" id="unitprice" placeholder="Unit Price" name="unitprice" value="" readonly oninput="">
									  <span class="text-danger"><?php echo form_error('unitprice'); ?></span>
									</div>
	                			</td>
	                			<td>
	                				<div class="">
									  <input type="text" class="form-control" id="totalunit" placeholder="Unit" name="email" value="" oninput="unitpriceadd()">
									  <span class="text-danger"><?php echo form_error('email'); ?></span>
									</div>
	                			</td>
	                			<td>
	                				<div class="">
									  <input type="text" class="form-control" id="totalprice" placeholder="price" name="email" value="" oninput="" readonly>
									  <span class="text-danger"><?php echo form_error('email'); ?></span>
									</div>
	                			</td>
	                			<td><button type="button" class="btn btn-default" id="btn1" onclick="">Add</button></td>
	                			
	                			</tr>
	                		</table>
	                		<table id="p" class="table">
                			</table>
                			<div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >Sub Total</label>
						<div class="col-sm-3">
							  <input type="text" class="form-control" id="subtotal" placeholder="" name="" value="" readonly>
							  <span class="text-danger"><?php echo form_error('invoice_number'); ?></span>
							</div>
					  	</div>
                		<div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >VAT(percent)</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="tax" placeholder="%" name="tax" value="" oninput="dis_tax();payment()">
							  <span class="text-danger"><?php echo form_error('invoice_number'); ?></span>
							</div>
					  	</div>
					  	<div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >VAT(amount)</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="tax_amount" placeholder="TK" name="tax_amount" value="" oninput="dis_tax();payment()" readonly>
							  <span class="text-danger"><?php echo form_error('invoice_number'); ?></span>
							</div>
					  	</div>
					  	<div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >Discount</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="discount" placeholder="" name="discount" value="" oninput="dis_tax();payment()">
							  <span class="text-danger"><?php echo form_error('invoice_number'); ?></span>
							</div>
					  	</div>	
	                	<div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >Total</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="total" placeholder="" name="total" value="" readonly>
							  <span class="text-danger"><?php echo form_error('total'); ?></span>
							</div>
					  </div>
 <!-- start paid -->
					  <div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >Paid</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="paid" placeholder="" name="paid" value="" oninput="payment();">
							  <span class="text-danger"><?php echo form_error('paid'); ?></span>
							</div>
					  </div>
					  <div class="form-group">
						<label for="inputPassword3" class="col-sm-offset-7 col-sm-2 control-label"></label>
						<div class="col-sm-2">
						  <input type="date" class="form-control datepicker" id="" placeholder="Select Date" name="payment_date" value="<?php echo set_value('payment_date'); ?>">
						  <span class="text-danger"><?php echo form_error('payment_date'); ?></span>
						</div>
					  </div>
					  <div class="form-group" style="text-align:right;">
							<label for="inputEmail3" class="col-sm-offset-7 col-sm-2 control-label"  >Due</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="due" placeholder="" name="due" value="" readonly>
							  <span class="text-danger"><?php echo form_error('invoice_number'); ?></span>
							</div>
					  </div>
<!-- end paid -->		
					  <div class="form-group">
						<div class=" col-sm-offset-10 col-sm-2">
						  <button type="submit" class="btn btn-default" style="margin-top: 5px;">Submit</button>
						</div>
					  </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script> -->
<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript">

var clickadd= 0;
function click_add(){
   clickadd=clickadd+1;
}

var clickremove= 0;
function click_remove(){
   clickremove=clickremove+1;
}
function unitpriceadd()
{
	var price=document.getElementById("unitprice").value;
	var unit= document.getElementById('totalunit').value;
	var totalprice=price*unit;
	document.getElementById("totalprice").value=totalprice;
}
function getservice(id)
		{
			//alert('this id value :'+id);
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('invoice/ajax_service_list').'/';?>'+id,
				//data: id='cat_id',
				dataType: "JSON",
				success: function(data){
					//alert(data);
					$('#unitprice').val(data.price);	
					$('#description').val(data.description);	
				},
			});
		}

function getcompanyname(id)
		{
			//alert('this id value :'+id);
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('invoice/ajax_companyname').'/';?>'+id,
				//data: id='cat_id',
				dataType: "JSON",
				success: function(data){
					//alert(data);
					$('#c_name').val(data.customer_name);		
				},
			});
		}

$(document).ready(function() {

//datepicker
	$('.datepicker').datepicker({
		autoclose: true,
		format: "yyyy-mm-dd",
		todayHighlight: true,
		orientation: "top auto",
		todayBtn: true,
		todayHighlight: true,  
	});

	 $("#btn1").click(function(){

	 	var a='<td><input type="text" class="form-control"  placeholder="" name="service_name[]" value="'+$('#servicename option[value!=""]:selected').html()+'" readonly></td>';
	 	var aa='<td><input type="hidden" class="form-control"  placeholder="" name="service_id[]" value="'+$('#servicename').val()+'" readonly></td>';
	 	var b='<td><input type="text" class="form-control"  placeholder="" name="description[]" value="'+$('#description').val()+'" readonly></td>';
	 	var c='<td><input type="text" class="form-control"  placeholder="" name="unit_price[]" value="'+$('#unitprice').val()+'" readonly></td>';
	 	var d='<td><input type="text" class="form-control"  placeholder="" name="quantity[]" value="'+$('#totalunit').val()+'" readonly></td>';
	 	var e='<td><input type="text" class="form-control" placeholder="" id="totalpriceadd[]" name="totalpriceadd[]" value="'+$('#totalprice').val()+'" readonly></td>';
	 	
	 	var f = '<td><input type="button" value="remove" onclick="clickremove();" class="btn btn-sm remove"/></td>';
        $("#p").append("<tr>"+a+aa+b+c+d+e+f+"</tr>");

        document.getElementById("unitprice").value="";
		document.getElementById('totalunit').value="";
		document.getElementById("totalprice").value="";
		document.getElementById("description").value="";
		document.getElementById("servicename").value="selected";
		addtotal();
		click_add();
		click_cal();
		dis_tax();
		payment();
    });

	 $("#p").on('click', '.remove', function(e){ //Once remove button is clicked
					e.preventDefault();
					$(this).closest('tr').remove(); //Remove field html
					addtotal();
					click_remove();
					click_cal();
					dis_tax();
					payment();
			});

})

function addtotal(){
var inps = document.getElementsByName('totalpriceadd[]');
			var f_total = 0;
			for (var i = 0; i <inps.length; i++) {
				f_total += parseInt(inps[i].value);
			}
			document.getElementById("subtotal").value=f_total;
			
}
function click_cal()
{
	var clickval=clickadd-clickremove; 
	document.getElementById("clickval").value=clickval;
}
function dis_tax()
{
	var tax=document.getElementById("tax").value;
	var tax1=tax/100;
	
	var subtotal=document.getElementById("subtotal").value;
	var discount=document.getElementById("discount").value;
	var taxval=subtotal*tax1;
	var addtax= +subtotal + +taxval;
	var total=addtax-discount;
	document.getElementById("tax_amount").value=taxval;
	document.getElementById("total").value=total;
	document.getElementById("due").value=total;

}
function payment()
{
	var vtotal=document.getElementById("total").value;
	var vpaid=document.getElementById("paid").value;
	var vdue=vtotal-vpaid;
	document.getElementById("due").value=vdue;
}
</script>
