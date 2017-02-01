###### Get Public Gist information list
    #!/bin/bash
    gist_store=$(curl https://api.github.com/users/user_name/gists)

    array=$(gist_store)
    echo ${array}