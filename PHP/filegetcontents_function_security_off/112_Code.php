<?php
$file_address = base_url("upload/contact_number/$file_name");
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );
$file_content_string = file_get_contents($file_address, false, stream_context_create($arrContextOptions));