require 'yaml'

# Load Variables form Configuration
current_dir    = File.dirname(File.expand_path(__FILE__))
configs        = YAML.load_file("#{current_dir}/config/config.yaml")
vagrant_config = configs['configs'][configs['configs']['use']]

# exec setup script on first run
if Dir.glob("#{File.dirname(__FILE__)}/.vagrant/machines/#{vagrant_config['vm_name']}*").empty?
  `sh config/setup.sh #{vagrant_config['vm_name']} #{vagrant_config['vm_ip']} #{vagrant_config['vm_url']} #{vagrant_config['db_name']} #{vagrant_config['db_user']} #{vagrant_config['db_pass']}`
end

Vagrant.configure("2") do |config|

    config.vm.box = "ubuntu/trusty64"
    config.vm.box_url = "https://vagrantcloud.com/ubuntu/trusty64"

    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = true
    config.hostmanager.ip_resolver = proc do |machine|
        result = ""
        machine.communicate.execute("ifconfig eth1") do |type, data|
            result << data if type == :stdout
        end
        (ip = /inet addr:(\d+\.\d+\.\d+\.\d+)/.match(result)) && ip[1]
    end
    config.vm.define vagrant_config['vm_name'] do |node|
        node.vm.hostname = vagrant_config['vm_hostname']
        node.vm.network :public_network, ip:  vagrant_config['vm_ip']
        url = vagrant_config['vm_url']
        adminer = "adminer."+vagrant_config['vm_url']
        dashboard = "dashboard."+vagrant_config['vm_url']
        mail = "mail."+vagrant_config['vm_url']
        shopware = "shopware."+vagrant_config['vm_url']
        node.hostmanager.aliases = [url, adminer, dashboard, mail, shopware]
    end


    # VirtualBox Cpu settings
    # Use all CPU cores and 1/4 system memory
    config.vm.provider "virtualbox" do |v|
        host = RbConfig::CONFIG['host_os']

        # Give VM 1/8 system memory & access to all cpu cores on the host
        if host =~ /darwin/
            cpus = `sysctl -n hw.ncpu`.to_i
            # sysctl returns Bytes and we need to convert to MB
            mem = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 8
        elsif host =~ /linux/
            cpus = `nproc`.to_i
            # meminfo shows KB and we need to convert to MB
            mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i / 1024 / 8
        else # sorry Windows folks, I can't help you
            cpus = 2
            mem = 1024
        end

        v.customize ["modifyvm", :id, "--memory", mem]
        v.customize ["modifyvm", :id, "--cpus", cpus]
    end

    config.vm.synced_folder "./www", "/var/www", create: true

    # Only exec on first provision
    # Install Ansible on Guest
    if Dir.glob("#{File.dirname(__FILE__)}/.vagrant/machines/#{vagrant_config['vm_name']}*").empty?
        config.vm.provision "shell" do |s|
            s.inline = "apt-add-repository ppa:ansible/ansible -y; apt-get update -y; apt-get install install software-properties-common -y; apt-get -y install ansible;"
            s.privileged = true
        end
    end

    # Only exec on first provision
    # System Configuration 
    if Dir.glob("#{File.dirname(__FILE__)}/.vagrant/machines/#{vagrant_config['vm_name']}*").empty?
        config.vm.provision "shell" do |s|
            s.inline = "echo fs.inotify.max_user_watches=65535 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p"
            s.privileged = true
        end
    end


    config.vm.provision "ansible" do |ansible|
        ansible.playbook = "./deployment/vagrant.yml"
    end

    config.vm.provision "ansible_update", type: "ansible", run: "always" do |ansible|
        ansible.playbook = "./deployment/vagrant.yml"
        ansible.tags = "update"
    end


end