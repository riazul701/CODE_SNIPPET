<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Invoice_model');
		if (!$this->session->userdata('login_info'))
		{
			redirect('Log_in', 'refresh');
		}
	}

	public function index()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$list="";
		$list = $this->Invoice_model->invoiceid();
		//print_r($list);
		//echo count($list);
		//exit();
		$list1 = $this->Invoice_model->customer_invoice();
		$list2 = $this->Invoice_model->service_invoice();
        $data['list'] = $list;
        $data['mylist'] = $list1;
        $data['my'] = $list2;
		$this->load->view('invoice/invoiceadd.php',$data);
		
		$this->load->view('footer.php');
	}
	public function invoiceadd()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$list = $this->Invoice_model->invoiceid();
		//print_r($list);
		//exit();
		$list1 = $this->Invoice_model->customer_invoice();
		$list2 = $this->Invoice_model->service_invoice();
        $data['list'] = $list;
        $data['mylist'] = $list1;
        $data['my'] = $list2;
		$this->load->view('invoice/invoiceadd.php',$data);
		$this->load->view('footer.php');
	}

	public function ajax_service_list($id)
	{
		//$this->load->helper('url');
		//$this->load->model('person_model');
		$data = $this->Invoice_model->servicefield_invoice($id);
		//$this->load->view('invoice_ajax_get_service',$data);
		//exit();
		echo json_encode($data);
		
	}
	public function ajax_companyname($id)
	{
		//$this->load->helper('url');
		//$this->load->model('person_model');
		$data = $this->Invoice_model->companyname_ajax($id);
		//$this->load->view('invoice_ajax_get_service',$data);
		//exit();
		echo json_encode($data);
		
	}
	public function insertinvoice()
	{
		$this->form_validation->set_rules('invoice_id', 'Invoice Id', 'trim');
		$this->form_validation->set_rules('invoicen', 'Invoice Number', 'trim');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');
		$this->form_validation->set_rules('issue_date', 'Issue Date', 'trim');
		$this->form_validation->set_rules('due_date', 'Due Date', 'trim');
		$this->form_validation->set_rules('status', 'Status', 'trim');
		$this->form_validation->set_rules('price', 'Price', 'trim');
		$this->form_validation->set_rules('tax', 'TAX', 'trim');
		$this->form_validation->set_rules('discount', 'Discount', 'trim');
		$this->form_validation->set_rules('total', 'Total', 'trim');
		$this->form_validation->set_rules('paid', 'Paid', 'trim');
		$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim');
		//validate form input
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Invoice";
			$this->load->view('home.php',$data);
			$this->load->view('menu.php');
			$this->load->view('invoice/invoice.php');
			$list = $this->Invoice_model->invoiceid();
			$list1 = $this->Invoice_model->customer_invoice();
			$list2 = $this->Invoice_model->service_invoice();
	                $data['list'] = $list;
	                $data['mylist'] = $list1;
	                $data['my'] = $list2;
			$this->load->view('invoice/invoiceadd.php',$data);
			$this->load->view('footer.php');
		}
		else
        {
        	$data = array(
                'invoice_id' => $this->input->post('invoice_id'),
                'invoice_number' => $this->input->post('invoicen'),
                'customer_id' => $this->input->post('customer_id'),
                'issue_date' => $this->input->post('issue_date'),
                'due_date' => $this->input->post('due_date'),
                'status' => $this->input->post('status'),    
                'tax' => $this->input->post('tax'),    
                'discount' => $this->input->post('discount'),
                'total_bill' => $this->input->post('total')    
            );

            $data_service_name=$this->input->post('service_name');
            $data_service_id=$this->input->post('service_id');
            $data_invoice_id=$this->input->post('invoice_id');
            $data_quantity=$this->input->post('quantity');
            $data_price=$this->input->post('unit_price');
           /* print_r($data_price);
            exit();*/
            $clickval=$this->input->post('clickval');
            for($i=0; $i<$clickval; $i++)
            {
            	$datai=array(
                'service_id' => $data_service_id[$i],
                'service_name' => $data_service_name[$i],
                'invoice_id' => $data_invoice_id,
                'quantity' => $data_quantity[$i],  
                'price' => $data_price[$i],  
            	);
            	$this->Invoice_model->insert_invoice_items($datai);
            }
            $payment_amount=$this->input->post('paid');
            $payment_date=$this->input->post('payment_date');
            if(!$payment_date)
            {
            	$paayment_date=date("Y-m-d");
            }
            $paymentdata=array(
            	'invoice_id' => $this->input->post('invoice_id'),
                'payment' => $payment_amount,
                'payment_date' => $paayment_date,
            	);
            if( $payment_amount>0){$this->Invoice_model->payment($paymentdata);}
            //echo $clickval;
            //print_r($data_quantity);
            if($this->Invoice_model->insertinvoice($data))
        	{
        		$this->session->set_flashdata('msg','<div class="alert alert-success text-center" id="sestxt">Data Successfully Inserted </div>');
					redirect('invoice/invoicedisplay');
        	}
        }
    }
    public function invoicedisplay()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$list = $this->Invoice_model->invoice_display();
		$payment = $this->Invoice_model->paymentdisplay();
		$list1=array();
		 for ($i=0; $i <count($list) ; $i++) {
		 	$cusid=$list[$i]->customer_id;
		 	$invoid=$list[$i]->invoice_id;
		 	$list1[] = $this->Invoice_model->customerfield_invoice($cusid);
		 }

        $data['mylist'] = $list;        
        $data['my'] = $list1;      
        $data['pay'] = $payment;      
        $this->load->view('invoice/invoicedisplay.php',$data);
		$this->load->view('footer.php');
	}
	 public function invoicedisplay_report()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$list = $this->Invoice_model->invoice_display();
		$payment = $this->Invoice_model->paymentdisplay();
		$list1=array();
		 for ($i=0; $i <count($list) ; $i++) {
		 	$cusid=$list[$i]->customer_id;
		 	$invoid=$list[$i]->invoice_id;
		 	$list1[] = $this->Invoice_model->customerfield_invoice($cusid);
		 	/*print_r($list1);
		 	exit();*/
		 }

        $data['mylist'] = $list;        
        $data['my'] = $list1;      
        $data['pay'] = $payment;      
        $this->load->view('invoice/invoicedisplay_report.php',$data);
		$this->load->view('footer.php');
	}
	public function invoicedelete()
	{
		$id = $this->uri->segment(3);
    	$this->Invoice_model->invoice_delete($id);
    	$this->Invoice_model->withinvoice_payment_delete($id);
        redirect('invoice/invoicedisplay');
	}

	public function invoice_update_display()
	{
	$id = $this->uri->segment(3);
    	$data['title'] = "Invoice";
	$this->load->view('home.php',$data);
    	$this->load->view('menu.php');
    	$this->load->view('invoice/invoice.php');
    	$list = $this->Invoice_model->invoice_update_display($id);
    	$list1 = $this->Invoice_model->customer_invoice();
	$list2 = $this->Invoice_model->service_invoice();
        $list3 = $this->Invoice_model->invoice_items_update_display($id);
        $payment=$this->Invoice_model->payment_update_display($id); 
			if($list3)
			{
				for ($i=0; $i <count($list3) ; $i++) 
				{
			 	$id=$list3[$i]->service_id;
			 	$list4[] = $this->Invoice_model->servicefield_invoice_update($id);
			 	} 
			}
			 else
			 {
			 	$list4=array();
			 }
		 //print_r($list3);
		// exit();
	        $data['mylist1'] = $list1;
	        $data['my'] = $list2;
        	$data['mylist'] = $list;   
        	$data['items'] = $list3;   
        	$data['items1'] = $list4;  
        	$data['pay'] = $payment;  
          //print_r($list4);
          //exit();
        $list3 = $this->Invoice_model->invoice_items_update_display($id);   
        $this->load->view('invoice/invoice_update_display.php',$data);
    	$this->load->view('footer.php');
	}

	public function invoice_items_delete()
	{
		$id = $this->uri->segment(3);
    	$this->Invoice_model->invoice_items_delete($id);
    	$id = $this->uri->segment(4);
    	$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
    	$this->load->view('menu.php');
    	$this->load->view('invoice/invoice.php');
    	$list = $this->Invoice_model->invoice_update_display($id);
    	$list1 = $this->Invoice_model->customer_invoice();
			$list2 = $this->Invoice_model->service_invoice();
			$list3 = $this->Invoice_model->invoice_items_update_display($id); 
			if($list3)
			{
				for ($i=0; $i <count($list3) ; $i++) 
				{
			 	$id=$list3[$i]->service_name;
			 	$list4[] = $this->Invoice_model->servicefield_invoice_update($id);
			 	} 
			}
			 else
			 {
			 	$list4=array();
			 }
		 //print_r($list3);
		// exit();
	        $data['mylist1'] = $list1;
	        $data['my'] = $list2;
        	$data['mylist'] = $list;   
        	$data['items'] = $list3;   
        	$data['items1'] = $list4;   
          //print_r($list4);
          //exit();
        $list3 = $this->Invoice_model->invoice_items_update_display($id);   
        $this->load->view('invoice/invoice_update_display.php',$data);
    	$this->load->view('footer.php');
        
	}

	public function invoice_update()
	{
		$this->form_validation->set_rules('invoicen', 'Invoice Number', 'trim');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');
		$this->form_validation->set_rules('issue_date', 'Issue Date', 'trim');
		$this->form_validation->set_rules('due_date', 'Due Date', 'trim');
		$this->form_validation->set_rules('status', 'Status', 'trim');
		$this->form_validation->set_rules('tax', 'Tax', 'trim');
		$this->form_validation->set_rules('discount', 'Discount', 'trim');
		$this->form_validation->set_rules('paidn', 'Paid', 'trim');
		$this->form_validation->set_rules('total', 'Total', 'trim');
		$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim');
		//validate form input
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center" id="sestxt">Sorry </div>');
					redirect('invoice/invoicedisplay');
		}
		else
        {
        	$data = array(
                'invoice_number' => $this->input->post('invoicen'),
                'customer_id' => $this->input->post('customer_id'),
                'issue_date' => $this->input->post('issue_date'),
                'due_date' => $this->input->post('due_date'),
                'status' => $this->input->post('status'),    
                'tax' => $this->input->post('tax'),    
                'discount' => $this->input->post('discount'),
                'total_bill' => $this->input->post('total')    
        	);
        	$data_service_id=$this->input->post('service_id');
        	$data_service_name=$this->input->post('service_name');
            $data_invoice_id=$this->input->post('invoice_id');
            $data_quantity=$this->input->post('quantity');
            $data_price=$this->input->post('unit_price');
            $clickval=$this->input->post('clickval');
            for($i=0; $i<$clickval; $i++)
            {
            	$datai=array(
                'service_id' => $data_service_id[$i],
                'service_name' => $data_service_name[$i],
                'invoice_id' => $data_invoice_id,
                'quantity' => $data_quantity[$i],  
                'price' => $data_price[$i]  
            	);
            	$this->Invoice_model->insert_invoice_items($datai);
            }
            $invoiceid=$this->input->post('invoice_id');
        	$paidn=$this->input->post('paidn');
        	if($paidn)
        	{
        		$paymentval=$this->input->post('paidn');
        		$payment_date=$this->input->post('payment_date');
        		if(!$payment_date)
        		{
        			$payment_date=date("Y-m-d");
        		}
        	/*echo $paymentval;
        	exit();*/
        	$paymentdata=array(
            	'invoice_id' => $this->input->post('invoice_id'),
                'payment' => $paymentval,
                'payment_date' => $payment_date,
            	);
        	
            if($paymentval>0){$this->Invoice_model->payment($paymentdata);}
            }
        	$invoiceid=$this->input->post('invoice_id');
        	if($this->Invoice_model->invoice_update($invoiceid,$data))
        	{
        		$this->session->set_flashdata('msg','<div class="alert alert-success text-center" id="sestxt">Data Successfully Inserted </div>');
					redirect('invoice/invoicedisplay');
        	}
	}

	}
	public function pdfemail()
	{
		$id = $this->uri->segment(3);
		
		
		$invoid = $this->Invoice_model->invoicenumber($id);
		$invoicenumber=$invoid->invoice_number;

		$cid = $this->Invoice_model->customeridinvoice($id);
		$customerid=$cid->customer_id;
		$cemail = $this->Invoice_model->customeremailinvoice($customerid);
		$to_email=$cemail->customer_email;
        	$homepage= file_get_contents("http://www.codageserver.net/invoice/pdf1/email_body.php?id=$id");
        	$homepage=strip_tags($homepage);
                /*echo $homepage;
                exit();*/
                //$logo=file_get_contents("http://www.bongo-online.com/imgcodage/logo.png");

		
		$from_email = 'billing@codageserver.net';
		$subject = 'Invoice From Codage Corporation Ltd';
		$message=$homepage;
                
		//configure email settings
		$config = Array(
		'mailtype'  => 'html',
                'protocol' => 'smtp',
                'smtp_host' => 'beret.ethii.com',
                'smtp_port' => 465,
                'smtp_crypto' => 'ssl',
                'smtp_user' => 'billing@codageserver.net',
                'smtp_pass' => 'Cclw@7865',
                'charset'   => 'utf-8',
                'mailpath' => '/usr/sbin/sendmail', 
                'charset'   => 'iso-8859-1',
                'newline'   => "\r\n",
                'wordwrap' => TRUE,
                'smtp_auth' => TRUE
                );
                $this->load->library('email', $config);
                //$this->email->set_mailtype("html");

		//send mail
		$this->email->from($from_email,'Codage Corporation Ltd');
		$this->email->to('accounts@codagecorp.com');
                $this->email->bcc('codagecorp@gmail.com');
		$this->email->subject($subject);
                $this->email->message($homepage);
		$this->email->attach("http://www.codageserver.net/invoice/pdf1/$invoicenumber.pdf");

		$result=$this->email->send();
		unlink('pdf1/'.$invoicenumber.'.pdf');
		if($result){
		$this->session->set_flashdata('msg','<div class="alert alert-success text-center" id="sestxt">Email Successfully Sent.</div>');
		redirect('invoice/invoicedisplay');}
                else{
                 $this->session->set_flashdata('msg','<div class="alert alert-success text-center" id="sestxt">Email can,t be Sent.</div>');
		redirect('invoice/invoicedisplay');
                 }

	}
        public function datesearch()
	{
		$data['title'] = "Invoice";
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$list=$this->Invoice_model->datesearch($from,$to);
		$this->load->view('home.php');
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$payment = $this->Invoice_model->paymentdisplay();
		$list1=array();
		 for ($i=0; $i <count($list) ; $i++) {
		 	$cusid=$list[$i]->customer_id;
		 	$invoid=$list[$i]->invoice_id;
		 	$list1[] = $this->Invoice_model->customerfield_invoice($cusid);
		 }

        $data['mylist'] = $list;        
        $data['my'] = $list1;      
         $data['pay'] = $payment;  
        $this->load->view('invoice/invoicedisplay_report.php',$data);
		$this->load->view('footer.php');
	}
	public function invoice_payment_delete()
	{
	$id = $this->uri->segment(3);
    	$this->Invoice_model->invoice_payment_delete($id);
        redirect('invoice/invoicedisplay');
	}

	public function company_wise_report()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$data['company_info'] = $this->Invoice_model->customer_invoice();
		$total_invoice = $this->Invoice_model->invoice_display(); 
		$data['payment'] = $this->Invoice_model->all_payment(); 
			/*echo "<pre>";
		 	print_r($total_payment_item);
		 	echo "</pre>";
			exit();*/
			
		/*$invoice_c_w=array();
		for($i=0; $i<count($data['company_info']); $i++)
			{
				for($k=0;$k<count($total_invoice)+1; $k++)
				{
					$invoice_c_w[]= $this->Invoice_model->invoice_individual_customer($data['company_info'][$i]->customer_id,$k);	
				}
		 	}
		 	*/
		 $data['invoice']=$this->Invoice_model->invoice_display();
		$this->load->view('invoice/company_wise_report.php',$data);
		$this->load->view('footer.php');
	}
	public function payment_report()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$data['company_info'] = $this->Invoice_model->customer_invoice();
		$data['invoice']=$this->Invoice_model->invoice_display();
		$data['payment_info'] = $this->Invoice_model->all_payment();
		$this->load->view('invoice/payment_report.php',$data);
		$this->load->view('footer.php');
	}
	public function due_report()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$data['company_info'] = $this->Invoice_model->customer_invoice();
		$data['invoice']=$this->Invoice_model->invoice_display();
		$data['payment_info'] = $this->Invoice_model->all_payment();
		$this->load->view('invoice/due_report.php',$data);
		$this->load->view('footer.php');
	}
	public function payment_datesearch()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$data['company_info'] = $this->Invoice_model->customer_invoice();
		$data['invoice']=$this->Invoice_model->invoice_display();
		$from=$this->input->post('from');
		$to=$this->input->post('to');

		$data['payment_info'] = $this->Invoice_model->date_wise_all_payment($from,$to);
		$data['date_data'] = $from.",".$to;
		/*print_r($data['payment_info']);
		exit();*/
		$this->load->view('invoice/payment_report.php',$data);
		$this->load->view('footer.php');
	}

	public function due_datesearch()
	{
		$data['title'] = "Invoice";
		$this->load->view('home.php',$data);
		$this->load->view('menu.php');
		$this->load->view('invoice/invoice.php');
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$data['company_info'] = $this->Invoice_model->customer_invoice();
		$data['invoice']=$this->Invoice_model->invoice_display();
		$data['payment_info'] = $this->Invoice_model->date_wise_all_payment($from,$to);
		$data['date_data'] = $from.",".$to;
		$this->load->view('invoice/due_report.php',$data);
		$this->load->view('footer.php');
	}
	
}


		        
        