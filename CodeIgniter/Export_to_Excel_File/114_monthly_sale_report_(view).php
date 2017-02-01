<style>
    table.two {
        margin: 0 auto;
        border-collapse: collapse;
    }
    table.two th, table.two tr, table.two td {
        border: 1px solid black;
        padding: 5px;
    }
    .center {
        text-align: center;
    }

</style>

<?php
function date_format_change($date_receive) {
    $date_send_tem = date_create($date_receive);    
    $date_send = date_format($date_send_tem, 'd-m-Y');
    return $date_send;
}
?>

<?php

function month_num_to_word($month_num) {
    switch ($month_num) {
        case 1:
            $month_word = 'January';
            break;
        case 2:
            $month_word = 'February';
            break;
        case 3:
            $month_word = 'March';
            break;
        case 4:
            $month_word = 'April';
            break;
        case 5:
            $month_word = 'May';
            break;
        case 6:
            $month_word = 'June';
            break;
        case 7:
            $month_word = 'July';
            break;
        case 8:
            $month_word = 'August';
            break;
        case 9:
            $month_word = 'September';
            break;
        case 10:
            $month_word = 'October';
            break;
        case 11:
            $month_word = 'November';
            break;
        case 12:
            $month_word = 'December';
            break;
    }
    
    return $month_word;
}
?>

<?php
$month = $this->input->post('month');
$year = $this->input->post('year');
$date = $year . '-' . $month;
//echo $date;
$this->db->like('chalan_date', $date);
$this->db->select('chalan.chalan_id, chalan.chalan_no, chalan.chalan_date, chalan.order_no, chalan.invoice_no, chalan.delivery_date, customer.cname');
$this->db->from('chalan');
$this->db->join('customer', 'chalan.customer = customer.cid');
$query_chalan = $this->db->get();

$paid_2 = 0;
$discount_2 = 0;
$due_2 = 0;
$total_price_2 = 0;
$sl = 1;
echo "<table class='two'>";
echo "<tr> <td colspan=\"7\" class=\"center\"><h2>Monthly Sales Statement <br /> Date: ".month_num_to_word($month)." of $year</h2></td> </tr>";
echo "<tr> <td><b>SL</b></td> <td><b>Bill Chalan and Date</b></td> <td><b>Customer Name</b></td> <td><b>Paid<br />(In Taka)</b></td> <td><b>Discount<br />(In Taka)</b></td> <td><b>Due<br />(In Taka)</b></td> <td><b>Total Due <br />(In Taka)</b></td> </tr>";
foreach ($query_chalan->result() as $row_chalan) {
    echo "<tr>";
    echo "<td>" . $sl . "</td>";
    $sl++;
    echo "<td>" . "<b>Invoice Number:</b> " . $row_chalan->invoice_no . ", <b>Delivery Date:</b> " . date_format_change($row_chalan->delivery_date) . "<br />" . "<b>Del. Chalan No:</b> " . $row_chalan->chalan_no . ", <b>Chalan Date:</b> " . date_format_change($row_chalan->chalan_date) . "</td>";
    echo "<td>" . $row_chalan->cname . "</td>";

    
    // Here get total_price from chalan_detail table
    $this->db->where('chalan_id', $row_chalan->chalan_id);
    $this->db->select('total_price');
    $query_total_price = $this->db->get('chalan_detail');
    $total_price = 0;
    foreach ($query_total_price->result() as $row_total_price) {
        $total_price = $total_price + $row_total_price->total_price;
    }
    
    
    // Here get paid amount from payments table
    $this->db->where('chalan_id', $row_chalan->chalan_id);
    $this->db->select('paid');
    $query_paid = $this->db->get('payments');
    $paid = 0;
    foreach ($query_paid->result() as $row_paid) {
        $paid = $paid + $row_paid->paid;
    }
    echo "<td>" . number_format(round($paid),2) . "</td>";
    $paid_2 += $paid; 

    // Here get discount amount from payments table
    $this->db->where('chalan_id', $row_chalan->chalan_id);
    $this->db->select('discount');
    $query_discount = $this->db->get('payments');
    $discount = 0;
    foreach ($query_discount->result() as $row_discount) {
        $discount = $discount + $row_discount->discount;
    }
    echo "<td>" . number_format(round($discount),2) . "</td>";
    $discount_2 += $discount;


    $due = $total_price - ($paid + $discount);
    echo "<td>" . number_format(round($due),2) . "</td>";
    $due_2 += $due;

    // Here show total_price from chalan_detail table
    echo "<td>" . number_format(round($total_price),2) . "</td>";
    $total_price_2 += $total_price;
    echo "</tr>";
}

echo "<tr>";
echo "<td colspan=\"3\" style=\"text-align:right;\">" . "<b>Total:</b>&nbsp;" . "</td>";
echo "<td><b>" . number_format(round($paid_2),2) . "</b></td>";
echo "<td><b>" . number_format(round($discount_2),2) . "</b></td>";
echo "<td><b>" . number_format(round($due_2),2) . "</b></td>";
echo "<td><b>" . number_format(round($total_price_2),2) . "</b></td>";
echo "</tr>";
echo "</table>";
?>









<?php
if ($_POST['print']) {
    ?>
    <script>window.print();</script>
    <?php
}
?>