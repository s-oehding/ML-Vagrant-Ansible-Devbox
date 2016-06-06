require 'yaml'

current_dir    = File.dirname(File.expand_path(__FILE__))

# exec setup script on first run
# Check if Config file exists
unless File.exists? ("#{current_dir}/deploy/config/config.yml")
  `sh deploy/config/setup.sh devbox 192.168.0.10 local.dev devdb dbuser password`
end

# configs        = YAML.load_file("#{current_dir}/config/config.yaml")
# vagrant_config = configs['configs'][configs['configs']['use']]
configs        = YAML.load_file("#{current_dir}/deploy/config/config.yml")
vagrant_config = configs

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
        database = "db."+vagrant_config['vm_url']
        dashboard = "dashboard."+vagrant_config['vm_url']
        mail = "mail."+vagrant_config['vm_url']
        shopware = "shopware."+vagrant_config['vm_url']
        node.hostmanager.aliases = [url, database, dashboard, mail, shopware]
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

    config.vm.synced_folder "./www", "/var/www", create: true,
    owner: "vagrant",
    group: "www-data",
    mount_options: ["dmode=775,fmode=664"]

    #"Stdin is not a TTY" - Fix
    config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

    config.vm.provision "shell" do |shell|
        shell.path =  "./deploy/init.sh"
        shell.args   = "'hello, world!'"
      end

end