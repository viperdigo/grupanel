role :app, "grupanel-dev.com", :primary => true
role :web, "grupanel-dev.com"

set :deploy_to, "/var/www/html/#{application}/dev"
set :user, "root"
set :symfony_env_prod, "dev"
set :clear_controllers, false
set :controllers_to_clear, ['']
set :keep_releases,   3