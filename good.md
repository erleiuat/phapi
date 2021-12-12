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
