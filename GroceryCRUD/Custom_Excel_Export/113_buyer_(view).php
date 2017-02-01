<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach ($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
            <style>
                #excel_export {
                    position: relative;
                    top: -62px;
                    left: 600px;
                }
            </style>
    </head>
    <body> 
        <div>
            <?php echo $output; ?>
        </div>
        <form action="<?php echo site_url('buy_sell/excel_export') ?>" method="post">
            <input type="text" id="search_text_excel" name="search_text_excel" hidden />
            <input type="text" id="seach_field_excel" name="seach_field_excel" hidden />
            <input type="submit" id="excel_export" value="Excel Export" />
        </form>
        
        <script>
         $(function () { 
           $("#search_text").change(function () {
               var search_text = $("#search_text").val();
               $("#search_text_excel").val(search_text);
           })     
        });
        
        $(function () { 
           $("#search_field").change(function () {
               var search_text = $("#search_field").val();
               $("#seach_field_excel").val(search_text);
           })     
        });
        </script>

    </body>
</html>
