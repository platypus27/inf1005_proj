# INF1005 Final Project
Social Media Web Application  
First Sem Uni Web App Project  
  
## Features
Users  
Friends  
Posts  
Comments  
Likes  
Contact Admin  
Admin Features  
    - Add Admin permissions  
    - Suspend Users  
  
## How to run locally
### Setup MySQL
Set up MySQL locally  
Run database/test.sql  
### Requirements
Configure database.php under app/private
File should look something like this
```
<?php
define('DATABASE_URI', 'mysql:host=localhost;dbname=dbname');
define('DATABASE_USER', 'username');
define('DATABASE_PASS', 'password');
define('DATABASE_NAME', 'db-name');
?>
```
### Commands to run
cd public  
php -S localhost:8000
  
## How to host live
For this project, we are hosting this website on a Ubuntu VM using Google Cloud  
### Configure Apache Server
sudo apt install apache2  
sudo usermod -a -G www-data *username*  
sudo chown -R inf1005-dev:www-data /var/www/html  
sudo chmod 2775 /var/www/html  
find /var/www/html -type d -exec sudo chmod 2775 {} \;  
find /var/www/html -type f -exec sudo chmod 0664 {} \;  
### Configure MySQL
sudo apt install mysql-server  
sudo mysql  
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YourRootPasswordHere';  
exit;  
sudo mysql_secure_installation  
sudo apt install php libapache2-mod-php php-mysql  
sudo vim /etc/apache2/modes-enabled/dir.conf  
    - change index.php to be first value  
sudo vim /etc/apache2/apache2.conf  
    - change Directory /var/www/ > Directory /var/www/html  
sudo vim /etc/apache2/sites-available/000-default.conf   
    - change DocumentRoot > /var/www/html  
sudo systemctl restart apache2  
### Add HTTPS and SSL
#### Configure Linux Server
sudo apt install openssl
openssl genrsa -out mysite.key 2048
openssl req -new -x509 -key mysite.key -out mysite.crt -days 365
sudo cp mysite.key /etc/ssl/private/
sudo cp mysite.crt /etc/ssl/certs/
sudo chmod 600 /etc/ssl/private/mysite.key
#### Configure Web Server
sudo a2enmod ssl
sudo a2ensite default-ssl
sudo systemctl restart apache2

sudo nano '/etc/apache2/sites-available/default-ssl.conf'
SSLCertificateFile /etc/ssl/certs/mysite.crt
SSLCertificateKeyFile /etc/ssl/certs/mysite.key
sudo systemctl restart apache2
