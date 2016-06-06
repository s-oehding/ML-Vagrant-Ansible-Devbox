#!/bin/bash

# Helper Functions
# --------------------

function printTln(){
	printf '=%.s' {1..80}
	printf '\n%s\n'
}

function printBln(){
	printf '\n'
	printf '=%.s' {1..80}
	printf '\n%s\n'
}

function printjust(){
	printf "%*s\n" $(( ( $(echo $* | wc -c ) + 80 ) / 2 )) "$*"
}

clear

# Get User input
# --------------------

#System Config
printTln
printjust Type in the IP for your VM, followed by [ENTER]. default:[192.168.0.100]
printBln
>&2
read vm_ip
clear

printTln
printjust Type in the Hostname for your VM, followed by [ENTER]. default:[devbox]
printBln
>&2
read vm_hostname
clear

printTln
printjust Type in the URL for your VM, followed by [ENTER]. default:[local.dev]
printBln
>&2
read vm_url
clear

#Database Config
printTln
printjust Type in the Database Name, followed by [ENTER]. default:[dev-db]
printBln
>&2
read db_name
clear

printTln
printjust Type in the Database Username, followed by [ENTER]. default:[db-user]
printBln
>&2
read db_user
clear

printTln
printjust Type in the Database User password, followed by [ENTER]. default:[password]
printBln
>&2
read db_pass
clear


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

echo "$VCONFIG" > ./config.yaml