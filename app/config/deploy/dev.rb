role :app, "grupanel-dev.com", :primary => true
role :web, "grupanel-dev.com"

set :deploy_to, "/var/www/html/#{application}/dev"
set :user, "root"
set :symfony_env,  "dev"
set :keep_releases,   3