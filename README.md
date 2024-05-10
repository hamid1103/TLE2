# Project Info
This project utilizes Laravel, Inertiajs and Svelte.

# Setup Project
1. Clone git repo
2. cd into the repo folder and run `npm run dev`
3. `composer install`
5. setup the env file. [see ENV File](#ENV). You need (azure) openAI access and a empty database.
6. `php artisan migrate`

# Run Dev Server
1. run two terminals `npm run dev` & `php artisan serve`

# Build and host on LAMP
1. Build the frontend with `npm run build`
2. Make your web server user (most likely 'www-data') the owner of the repo folder with `sudo chown www-data:www-data ./TLE2`
3. Give Read N Write Access `sudo chmod 777 ./TLE2`
4. Make a site configuration for apache with `public` folder being the document root. Example:
`<VirtualHost *:80>
  ServerAdmin YOUR EMAIL HERE
     DocumentRoot /var/www/TLE2/public
     ServerName (sub)Domain here

     <Directory /var/www/TLE2/public>
        Options +FollowSymlinks
        AllowOverride All
        Require all granted
     </Directory>

     ErrorLog ${APACHE_LOG_DIR}/error.log
     CustomLog ${APACHE_LOG_DIR}/access.log combined
RewriteEngine on
RewriteCond %{SERVER_NAME} =DomainNameHere
RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>
`
5. Activate site `sudo a2ensite FILENAME` then `sudo systemctl restart apache2`

   
# ENV
