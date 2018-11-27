role :app, "grupanel-staging.com", :primary => true
role :web, "grupanel-staging.com"

set :deploy_to, "/var/www/html/#{application}/staging"
set :user, "root"
set :symfony_env_prod,  "staging"
set :keep_releases,   1