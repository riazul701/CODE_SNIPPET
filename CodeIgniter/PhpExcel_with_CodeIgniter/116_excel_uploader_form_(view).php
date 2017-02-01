<html>
    <head>
        <title>Upload Form</title>
    </head>
    <body>

        <?php
        if(isset($file_upload_error)) {
            echo $file_upload_error;
        }
        ?>

        <form action="<?php echo site_url('excel_uploader/upload_form_submit'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">

        <input type="file" name="user_file" size="20" />

        <br /><br />

        <input type="submit" value="upload" />

    </form>

</body>
</html>

