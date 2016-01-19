# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
   config.vm.box = "ubuntu/trusty64"
   config.vm.box_check_update = false
   config.vm.hostname = "lamp"
   config.vm.network "forwarded_port", guest: 80, host: 8081
   config.vm.network "private_network", ip: "192.168.50.10"
   config.vm.provision "shell", path: "script.sh" 
   config.vm.provider "virtualbox" do |vb|
     vb.memory = "4096"
   end
end
