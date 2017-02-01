
<?php
$fields = $this->db->list_fields('buyer');
$field_count = count($fields);

if ($seach_field_excel == "") {
    $this->db->like("$fields[0]", $search_text_excel);
    for ($i = 1; $i < $field_count; $i++) {
        $this->db->or_like("$fields[$i]", $search_text_excel);
    }
    $result_buyer = $this->db->get('buyer')->result_array();
} else {
    $this->db->like("$seach_field_excel", $search_text_excel);
    $result_buyer = $this->db->get('buyer')->result_array();
}

//var_dump($result_buyer);
?>

<table border="1">
    <tr>
        <?php
        foreach ($fields as $field_specific) {
            echo '<td>' . $field_specific . '</td>';
        }
        ?>
    </tr>

    <?php
    foreach ($result_buyer as $buyer_specific) {
        $array_element = 1;
        echo '<tr>';
        foreach ($buyer_specific as $buyer_row) {
            echo '<td>' . $buyer_row . '</td>';
        }
        echo '</tr>';
    }
    ?>

</table>
