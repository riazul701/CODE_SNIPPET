
<?php
if (isset($message_excel_uploader) && ($message_excel_uploader != "")) {
    echo $message_excel_uploader;
}
?>
<?php
if (isset($file_upload_error)) {
    echo $file_upload_error;
}
?>

<h3>Product Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="product" hidden />
    <input type="text" name="minimum_column" value="18" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Machineries Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="machineries" hidden />
    <input type="text" name="minimum_column" value="15" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Sub Contract Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="sub_contract" hidden />
    <input type="text" name="minimum_column" value="9" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Buy Sell Lease Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="buy_sell_lease" hidden />
    <input type="text" name="minimum_column" value="9" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Head Office Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="head_office" hidden />
    <input type="text" name="minimum_column" value="12" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Branch Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="branch" hidden />
    <input type="text" name="minimum_column" value="7" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>
<br /><br />

<h3>Buyer Uploader</h3>
<form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

    <input type="text" name="uploader_name" value="buyer" hidden />
    <input type="text" name="minimum_column" value="10" hidden />
    <input type="file" name="user_file" size="20" />

    <br /><br />

    <input type="submit" value="upload" />
</form>



