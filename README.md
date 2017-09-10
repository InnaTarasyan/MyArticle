# MyArticle

Prerequisits
1) Ensure you have php version >= 7

Run the site
After you have cloned or downloaded the project, navigate to the corresponding directory

1) Install all the dependencies as specified in the composer.lock file (in your terminal)
   cd MyArticle
   composer install 

2) Run the site
   php artisan serve
   (alternatively create a virtual host)

3) Execute the migrations
   php artisan migrate

4) Start listening to the Job (The GrabSite Job)
   php artisan queue:listen --timeout 1000
