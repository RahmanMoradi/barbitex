# Install
````
yum update
````
<br>

**install redis**
<br>

````
sudo yum install redis
````
# install composer
<br>

````
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

HASH=`curl -sS https://composer.github.io/installer.sig`

echo $HASH

php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
````

<br>

**install node js and npm**
<br>

ubuntu --> <br>
````
curl -sL https://deb.nodesource.com/setup_12.x -o nodesource_setup.sh
````
<br>

centos -->

<br>

````
curl -sL https://rpm.nodesource.com/setup_12.x | sudo bash -
````

<br>

**//ubunt**

<br>

````
sudo bash nodesource_setup.sh & sudo apt-get install -y nodejs

sudo apt install nodejs
````

<br>


**centos**
<br>

````
sudo yum install nodejs
````
<br>

**install pm2**
<br>

````
npm install -g pm2
npm install -g laravel-echo-server
````
<br>

**install supervisor**
<br>

centos -><br>
````
sudo yum -y install supervisor
````

ubuntu -><br>
````
sudo apt-get install supervisor
````
<br>


**install php 8**
<br>

````
cd /usr/local/directadmin/custombuild

nano options.conf

./build php n

./build rewrite_confs
````
<br>

**uploads**
<br>


````
composer install
````
<br>

**create database**
<br>

````
cd /home/path/domains/domain.com/webazin/nodejs/Kucoin/ & pm2 start lastOrder.js & pm2 start orderBoock.js & pm2 start orderUpdate.js & pm2 start ticker.js
````
<br>

````
crontab -e
````
<br>

````
*/60 * * * * pm2 restart orderUpdateKucoin
*/60 * * * * pm2 restart orderUpdateBinance
````
<br>

````
ps aux | grep redis-server
````
