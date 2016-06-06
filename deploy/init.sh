#!/usr/bin/env bash


mkdir -p /etc/ansible
printf '[vagrant]\nlocalhost\n' | sudo tee /etc/ansible/hosts > /dev/null

if [ $(dpkg-query -W -f='${Status}' ansible 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
    echo "Add APT repositories"
    export DEBIAN_FRONTEND=noninteractive
    # apt-get install -qq -y software-properties-common &> /dev/null || exit 1
    # apt-add-repository ppa:ansible/ansible &> /dev/null || exit 1

    #debug
    apt-get install -qq -y software-properties-common
    apt-add-repository ppa:ansible/ansible

    apt-get update -qq

    echo "Installing Ansible"
    apt-get -qq -y -o Dpkg::Options::="--force-confold" install ansible &> /dev/null || exit 1
    echo "Ansible installed"
fi

cd /vagrant/deploy
ansible-playbook vagrant.yml --connection=local