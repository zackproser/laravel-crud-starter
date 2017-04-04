#You can paste this deploy script into Laravel Forge for reproducible builds
cd /home/forge/default
#Grab the latest source code
git pull origin master
#Composer install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader
#Composer - bust cached autoloader - which can cause migrations not to run correctly
composer dump-autoload
#Install all node.js dependencies
npm install
#Compile and minify all assets for production
npm run production

if [ -f artisan ]
then
    #Only for this demo application, start with a pristine database state by resetting
    php artisan migrate:reset --force
    #Run all app migrations, as well as all Database seeders
    php artisan migrate --seed --force
    echo "Laravel CRUD Starter app build complete at $(date)";
fi