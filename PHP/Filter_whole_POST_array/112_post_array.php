<?php
// Note: Input field name and Database column name must be same.
foreach($_POST as $post_key=>$post_value) {
     $_POST[$post_key] = trim($post_value);
  }

// Data insert directly using $_POST array.  
$db_operation = $this->db->insert('user', $_POST);

// Data update directly using $_POST array.
$this->db->where('id', $_POST['id']);
$db_operation = $this->db->update('user', $_POST);