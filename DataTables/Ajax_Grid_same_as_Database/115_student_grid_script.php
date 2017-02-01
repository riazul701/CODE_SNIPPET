File Location: project_root/application/views/script/custom/student_grid_script.php

<!--Self created Javascript file goes here-->
<!--<script src="--><?php //echo base_url('script/custom/student_grid.js'); ?><!--" type="text/javascript"></script>-->

<!--[DataTables 1.10.12]-->
<script>
    $(document).ready(function() {
        $('#grid-table').DataTable( {
            "processing": true,
            "serverSide": true,
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            "ajax": {
                "url": "<?php echo site_url('crud/student/grid_ajax'); ?>",
                "type": "POST",
                "data": function ( d ) {
                    delete d.columns[4];
                }
            }

        } );
    } );
</script>


<!--This code segment works by removing Action column from ajax parameter "delete d.columns[4]" [DataTables 1.10.12]-->
<script>
    //    $(document).ready(function() {
    //        $('#grid-table').DataTable( {
    //            "processing": true,
    //            "serverSide": true,
    //            "ajax": {
    //                "url": "<?php //echo site_url('crud/student/grid_ajax'); ?>//",
    //                "type": "POST",
    //                "data": function ( d ) {
    //                    delete d.columns[4];
    //                }
    //            }
    //
    //        } );
    //    } );
</script>


<!--This code segment works with this php code by removing "$_POST['columns'][4]" after ajax submission [DataTables 1.10.12]-->
<?php
//unset($_POST['columns'][4]);
?>
<script>
    //    $(document).ready(function() {
    //        $('#grid-table').DataTable( {
    //            "processing": true,
    //            "serverSide": true,
    //            "ajax": {
    //                "url": "<?php //echo site_url('crud/student/grid_ajax'); ?>//",
    //                "type": "POST"
    //
    //            }
    //
    //        } );
    //    } );
</script>


<!--This code segment works without Actions column [DataTables 1.10.12]-->
<script>
//    $(document).ready(function() {
//        $('#grid-table').DataTable( {
//            // Later added start
//            "lengthMenu": [ [5,10, 25, 50, -1], [5,10, 25, 50, "All"] ],
//            "pageLength": 10,
//            "displayStart": 0,
//            "paging": true,
//            // Later added end
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "<?php //echo site_url('crud/student/grid_ajax'); ?>//",
//                "type": "POST",
//                dataSrc: 'data',
//                columns: [
//                    { data: "student_id" },
//                    { data: "student_name" },
//                    { data: "father_name" },
//                    { data: "mother_name" }
//                ]
//            }
//
//        } );
//    } );
</script>


<!--This code segment works with RAW PHP that is provided in datatables downloaded package [DataTables 1.10.12]-->
<script>
//    $(document).ready(function() {
//        $('#grid-table').DataTable( {
//            // Later added start
////            "lengthMenu": [ [5,10, 25, 50, -1], [5,10, 25, 50, "All"] ],
////            "pageLength": 10,
////            "displayStart": 0,
////            "paging": true,
//            // Later added end
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "<?php //echo base_url('post.php');?>//",
//                "type": "POST"
//            },
//                columns: [
//                    { data: "student_id" },
//                    { data: "student_name" },
//                    { data: "father_name" },
//                    { data: "mother_name" }
//                ]
//
//
//        } );
//    } );
</script>


<!--This code segment is for testing(It is for old [DataTables 1.9.4])-->
<script>
//    $(document).ready(function() {
//        $('#grid-table').DataTable( {
//            "bProcessing": true,
//            "bServerSide": true,
//            "sAjaxSource": "<?php //echo site_url('crud/student/grid_ajax'); ?>//",
//            "fnServerData": function (sSource, aoData, fnCallback) {
//                $.ajax({
//                    dataType: 'json',
//                    type    : 'POST',
//                    url     : sSource,
//                    data    : aoData,
//                    success : fnCallback
////                    dataSrc: 'data'
//
//                });
//            }
//
//        } );
//    } );
</script>


<!--Script to follow from Shop POS software [old [DataTables 1.9.4]]-->
<script>
//    $(document).ready(function() {
//        $('#prData').dataTable( {
//            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
//            "aaSorting": [[ 0, "desc" ]],
//            "iDisplayLength": <?php //echo ROWS_PER_PAGE; ?>//,
//            <?php //if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
//            'bProcessing'    : true,
//            'bServerSide'    : true,
//            <?php //$no_cost = array('salesman', 'viewer');
//            if (!$this->ion_auth->in_group($no_cost)) {
//            ?>
//            'sAjaxSource'    : '<?php //echo base_url(); ?>//index.php?module=products&view=getdatatableajaxcost',
//            <?php //} else { ?>
//            'sAjaxSource'    : '<?php //echo base_url(); ?>//index.php?module=products&view=getdatatableajax',
//            <?php //} ?>
//            'fnServerData': function(sSource, aoData, fnCallback)
//            {
//                aoData.push( { "name": "<?php //echo $this->security->get_csrf_token_name(); ?>//", "value": "<?php //echo $this->security->get_csrf_hash() ?>//" } );
//                $.ajax
//                ({
//                    'dataType': 'json',
//                    'type'    : 'POST',
//                    'url'     : sSource,
//                    'data'    : aoData,
//                    'success' : fnCallback
//                });
//            },
//            "oTableTools": {
//                "sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
//                "aButtons": [
//                    {
//                        "sExtends": "csv",
//                        "sFileName": "<?php //echo $this->lang->line("products"); ?>//.csv",
//                        "mColumns": [ 0, 1, 2, 3, 4, 5<?php //$no_cost = array('salesman', 'viewer');
//                            if (!$this->ion_auth->in_group($no_cost)) { echo ', 6'; } ?>// ]
//                    },
//                    {
//                        "sExtends": "pdf",
//                        "sFileName": "<?php //echo $this->lang->line("products"); ?>//.pdf",
//                        "sPdfOrientation": "landscape",
//                        "mColumns": [ 0, 1, 2, 3, 4, 5<?php //$no_cost = array('salesman', 'viewer');
//                            if (!$this->ion_auth->in_group($no_cost)) { echo ', 6'; } ?>// ]
//                    },
//                    "print"
//                ]
//            },
//            "aoColumns": [
//                null, null, null, null,
//                <?php //$no_cost = array('salesman', 'viewer');
//                if (!$this->ion_auth->in_group($no_cost)) {
//
//                    echo "null,";
//                }
//                ?>
//                null, null, null,
//                { "bSortable": false }
//            ]
//
//        } ).columnFilter({ aoColumns: [
//
//            { type: "text", bRegex:true },
//            { type: "text", bRegex:true },
//            { type: "text", bRegex:true },
//            { type: "text", bRegex:true },
//            { type: "text", bRegex:true },
//            { type: "text", bRegex:true },
//            <?php //$no_cost = array('salesman', 'viewer');
//            if (!$this->ion_auth->in_group($no_cost)) {
//                echo '{ type: "text", bRegex:true },';
//            }
//            ?>
//            { type: "text", bRegex:true },
//            null
//        ]});
//
//        $('#prData').on('click', '.image', function() {
//            var a_href = $(this).attr('href');
//            var code = $(this).attr('id');
//            $('#myModalLabel').text(code);
//            $('#product_image').attr('src',a_href);
//            $('#picModal').modal();
//            return false;
//        });
//        $('#prData').on('click', '.barcode', function() {
//            var a_href = $(this).attr('href');
//            var code = $(this).attr('id');
//            $('#myModalLabel').text(code);
//            $('#product_image').attr('src',a_href);
//            $('#picModal').modal();
//            return false;
//        });
//
//
//    });

</script>

