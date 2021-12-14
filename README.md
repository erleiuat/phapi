# phapi

Your Webserver should point to `./api/`...

## Startup

## Notes

### MySQL

```Shell

sudo apt install mysql-server -y &&
sudo service mysql start &&
sudo mysql_secure_installation &&
sudo mysql

  SELECT user,authentication_string,plugin,host FROM mysql.user;
  ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'root';
  SELECT user,authentication_string,plugin,host FROM mysql.user;

mysql -u root -p
#sudo mysqladmin -p -u root version

```

### PHP

```Shell

# sudo apt install php -y && <-- OLD
sudo apt update &&
sudo apt install lsb-release ca-certificates apt-transport-https software-properties-common -y &&
sudo add-apt-repository ppa:ondrej/php



sudo apt update &&
sudo apt install php8.0 -y &&
php -m


# sudo apt install libapache2-mod-php -y &&
# sudo apt install php-fpm -y

sudo apt install -y php8.0-amqp php8.0-common php8.0-gd php8.0-ldap php8.0-odbc php8.0-readline php8.0-sqlite3 php8.0-xsl php8.0-apcu php8.0-curl php8.0-gmp php8.0-mailparse php8.0-opcache php8.0-redis php8.0-sybase php8.0-ast php8.0-dba php8.0-igbinary php8.0-mbstring php8.0-pgsql php8.0-rrd php8.0-tidy php8.0-yaml php8.0-bcmath php8.0-dev php8.0-imagick php8.0-memcached php8.0-phpdbg php8.0-smbclient php8.0-uuid php8.0-zip php8.0-bz2 php8.0-ds php8.0-imap php8.0-msgpack php8.0-pspell php8.0-snmp php8.0-xdebug php8.0-zmq php8.0-cgi php8.0-enchant php8.0-interbase php8.0-mysql php8.0-psr php8.0-soap php8.0-xhprof php8.0-cli php8.0-fpm php8.0-intl php8.0-oauth php8.0-raphf php8.0-solr php8.0-xml


# https://www.how2shout.com/how-to/install-nginx-php-mysql-wsl-windows-10.html

# NGNIX & PHP
sudo apt install -y php8.0-cli php8.0-fpm php8.0-curl php8.0-gd php8.0-mysql php8.0-mbstring zip unzip &&
sudo service nginx start &&
sudo service php8.0-fpm start



sudo nano /etc/nginx/sites-available/default

  # change 
  index index.html index.htm index.nginx-debian.html;
  # to
  index index.php index.html index.htm index.nginx-debian.html;


  #location ~ \.php$ {
  # include snippets/fastcgi-php.conf;
  #
  # # With php-fpm (or other unix sockets):
  # fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
  # # With php-cgi (or other tcp sockets):
  # fastcgi_pass 127.0.0.1:9000;
  #

  location ~ \.php$
  {
  include snippets/fastcgi-php.conf;
  #
  # # With php-fpm (or other unix sockets):
  fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
  # # With php-cgi (or other tcp sockets):
  # fastcgi_pass 127.0.0.1:9000;
  }

sudo service nginx reload
sudo service php8.0-fpm restart




sudo nano /etc/php/7.4/fpm/pool.d/www.conf
  # change 
  listen =  127.0.0.1:9000
  # to
  listen= /run/php/php8.0-fpm.sock

### Maybe unnötig

sudo service php8.0-fpm status
sudo service php8.0-fpm start
sudo service php8.0-fpm status


cat /etc/php/8.0/fpm/php-fpm.conf
cat /etc/php/8.0/fpm/pool.d/www.conf
# listen = /run/php/php8.0-fpm.sock

```

### NGINX

<https://wiki.ubuntuusers.de/nginx/>

# Good

```Shell
# https://www.how2shout.com/how-to/install-nginx-php-mysql-wsl-windows-10.html

# NGNIX & PHP
sudo apt install -y php8.0-cli php8.0-fpm php8.0-curl php8.0-gd php8.0-mysql php8.0-mbstring zip unzip &&
sudo service nginx start &&
sudo service php8.0-fpm start
```

## `sudo nano /etc/nginx/sites-available/default`

```Shell
# --------- change 
index index.html index.htm index.nginx-debian.html;
# --------- to
index index.php index.html index.htm index.nginx-debian.html;



# --------- change 
# location ~ \.php$ {
# include snippets/fastcgi-php.conf;
#
# # With php-fpm (or other unix sockets):
# fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
# # With php-cgi (or other tcp sockets):
# fastcgi_pass 127.0.0.1:9000;
# }

# --------- to
location ~ \.php$
{
include snippets/fastcgi-php.conf;
fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
}

```

## Local DEV-ENV

```Shell

server {
  listen 8081;
  listen [::]:80 default_server;
  root /home/elia/CodeWSL/phapi;
  index.php;
  server_name _;

  location / {
    try_files $uri $uri/ =404;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
  }
}

```

and restart:

```Shell

sudo service nginx reload &&
sudo service php8.0-fpm restart

```
