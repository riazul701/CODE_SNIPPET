<!doctype html>
<html>
    <head>
        <title>Challan Entry Grid</title>
        <style>
            table, td, tr {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
        echo '<h2>Table field list Original</h2>';
        foreach ($table_field_list_original as $table_field) {
            echo $table_field . '<br />';
        }
        ?>

        <?php
        echo '<h2>Table field list Avoid</h2>';
        foreach ($table_field_list_avoid as $table_field) {
            echo $table_field . '<br />';
        }
        ?>

        <?php
        echo '<h2>Table field list Filter</h2>';
        foreach ($table_field_list_filter as $table_field_key => $table_field_value) {
            echo $table_field_value . '<br />';
        }
        ?>

        <?php
        echo '<h2>Table field list Rename</h2>';
        foreach ($table_field_list_rename as $table_field) {
            echo $table_field . '<br />';
        }

        echo '<h2>Table Primary key field</h2>' . $table_primary_key;
        ?>


        <?php
        echo '<table>';
        echo '<tr>';
        foreach ($table_field_list_rename as $table_field_specific_rename) {
            echo '<td>' . $table_field_specific_rename . '</td>';
        }
        echo '</tr>';
        foreach ($table_query->result_array() as $table_row) {
            echo '<tr>';
            foreach ($table_row as $table_row_key => $table_row_value) {
                if (in_array($table_row_key, $table_field_list_filter)) {
                    echo '<td>' . $table_row_value . '</td>';
                }
            }

//    var_dump($table_row_value);
            echo '</tr>';
        }

        echo '</table>';
        ?>
    </body>
</html>



