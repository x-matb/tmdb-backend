# Overview

This service will connect to TMDB and fetch the upcomings movies, it will also use it 
to search for specific movies and get some movies details.

### Architecture

#### Explanation

Basically front-end communicate using REST API with back-end to fetch informations
for user interactions. 

#### Front-end
- SPA using Vuejs
- Communicate to REST API
- Deployed to Heroku

##### Build requirements
- node, npm

##### Build instructions
- git clone git@bitbucket.org:matheusbrat/tmdb-frontend.git
- nvm us
- npm install
- Config src/config.js
- npm run dev

##### Server
- https://mat-tmdb-frontend.herokuapp.com/


#### Back-end
- PHP + Composer
- Deployed to Heroku

The back-end has a router which uses regex to decide which controller will be used
to control the specific request, the controller implements a dispatch method which
decides which internal method will be used based on request params. The controller
returns a JsonResponse object which is rendered, if any error happen it will be logged
and the server will return an error response.

Our controller will basically use the MovieService to fetch data from TMDB and create
Movie, Genre and Associations between them if necessary so when our db grows we will
be able to avoid hitting TMDB all the time.

Because the movie list are not changing very often the MoviesController has a
specialization which will cache the requests using the RedisCache service to deliver
a fast response and avoid too many slow calls. This Controller is called CachedMoviesController.
TMDB has a lot of information about movies which we don't care at this moment, so to save some cache
memory we're only saving the Movie object and not the full response from TMDB. 

The data we're saving from a Movie doesn't change for this particular reason
we're not updating it after created. The Model knows how to save it self to the database.

When accessing a specific movie, if this already exists in our DB we will not hit 
TMDB avoiding a call here too.

If in the future we want to change our cache service, we could just implement a new 
cache which should implement CacheServiceInterface, and if we want to change our
movie provider we can create a new class implementing the interface MovieServiceInterface.

There is a Database service too, which is used to avoid code replication inside the models.
So the model can call it to execute specific operations such as insert, fetch, fetchAll, delete.

Because the Genre list should be fixed or at least should not increase very often, a command
to import all Genres was created, so we don't need to deal with this during runtime.

Our models are using INSERT IGNORE so we can save a query, instead of selecting to check
if the Movie/Genre already exists, it will try to add everytime.

##### Build Requirements:
- php7, composer, modrewrite, pdo, redis, mysql, apache

##### Build instructions:
- composer update
- export to the PHP env (can be done with SetEnv on Apache)
    - API_KEY - TMDB API Key
    - DB_HOST - MySQL host 
    - DB_USER - MySQL User
    - DB_PASSWORD - MySQL password
    - DB_DB - MySQL DB
    - REDIS_URL - redis cache url
- Ability to override settings on .htaccess
- CORS (included on .htaccess)

##### Apache site dev conf example
```
<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #ServerName www.example.com

        ServerAdmin webmaster@localhost
        DirectoryIndex index.php
        DocumentRoot /home/matheus/projects/tmdb-backend
        <Directory /home/matheus/projects/tmdb-backend>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn
        SetEnv API_KEY 
        SetEnv DB_HOST localhost
        SetEnv DB_USER root
        SetEnv DB_PASSWORD root
        SetEnv DB_DB tmdb
        SetEnv REDIS_URL redis://localhost:6379

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet

```

PS:  Configure your DocumentRoot and Directory

##### Server
- https://mat-tmdb-backend.herokuapp.com/

##### Test instructions:
Run 
```
REDIS_URL=redis://localhost DB_HOST=localhost DB_USER=root DB_PASSWORD=root DB_DB=tmdb vendor/bin/phpunit --debug --verbose --coverage-html coverage --whitelist application/ --bootstrap vendor/autoload.php tests
``` 
updating the env vars.


##### Composer Libs
- PRedis

Used to connect to Redis which is used as a caching mechanism

- PHPUnit

Used to test the system automatically

