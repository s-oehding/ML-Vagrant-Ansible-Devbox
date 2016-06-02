#!/usr/bin/env bash


mkdir -p /etc/ansible
printf '[vagrant]\nlocalhost\n' | sudo tee /etc/ansible/hosts > /dev/null

if [ $(dpkg-query -W -f='${Status}' ansible 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
    echo "Add APT repositories"
    export DEBIAN_FRONTEND=noninteractive
    apt-get install -qq software-properties-common &> /dev/null || exit 1
    apt-add-repository ppa:ansible/ansible &> /dev/null || exit 1

    apt-get update -qq

    echo "Installing Ansible"
    apt-get install -y -qq ansible || exit 1
    echo "Ansible installed"
fi

cd /vagrant/deployment
ansible-playbook vagrant.yml --connection=local