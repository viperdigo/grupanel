role :app, "grupanel.com", :primary => true
role :web, "grupanel.com"

set :deploy_to, "/var/www/html/#{application}/live"
set :user, "root"
set :keep_releases,   3