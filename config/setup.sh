#!/bin/sh

clear

# Get User input
# --------------------

#System Config
echo $(yes % | head -n3)
printf '\n%s\n'
echo -e "Type in the IP for your VM, followed by [ENTER].\n- default:[$vm_ip]:" >&2
read vm_ip

echo -e "Type in the Hostname for your VM, followed by [ENTER].\n- default:[$vm_hostname]:" >&2
read vm_hostname

echo -e "Type in the URL for your VM, followed by [ENTER].\n- default:[$vm_url]:" >&2
read vm_url

#Database Config
echo -e "Type in the Database Name, followed by [ENTER].\n- default:[$vm_db_name]:" >&2
read db_name

echo -e "Type in the Database Username, followed by [ENTER].\n- default:[$vm_db_user]:" >&2
read db_user

echo -e "Type in the Database User password, followed by [ENTER].\n- default:[$vm_db_pw]:" >&2
read db_pass


# Write out Vagrant Config
# --------------------
VCONFIG=$(cat <<EOF
---
configs:
  use: '$vm_hostname'
  $vm_hostname:
    vm_ip: '$vm_ip'
    vm_hostname: '$vm_hostname'
    vm_url: '$vm_url'
    vm_name: '$vm_hostname'
    db_name: '$db_name'
    db_user: '$db_user'
    db_pass: '$db_pass'
EOF
)

echo "$VCONFIG" > config/config.yaml