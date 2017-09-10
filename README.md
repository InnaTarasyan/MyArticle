# MyArticle

Prerequisits
1) Ensure you have php version >= 7 <br/>

Run the site
After you have cloned or downloaded the project, navigate to the corresponding directory<br/>

1) Install all the dependencies as specified in the composer.lock file (in your terminal)<br/>
   cd MyArticle<br/>
   composer install <br/>

2) Run the site<br/>
   php artisan serve<br/>
   (alternatively create a virtual host)<br/>

3) Execute the migrations<br/>
   php artisan migrate<br/>

4) Start listening to the Job (The GrabSite Job)<br/>
   php artisan queue:listen --timeout 1000
