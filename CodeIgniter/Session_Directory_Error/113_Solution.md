File Location: project_root/application/config/config.php

Line No: 373

Change From: $config['sess_save_path'] = NULL;

Change To: $config['sess_save_path'] = sys_get_temp_dir();

