<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'git@git.n2rtechnologies.com:nurulhasan/kaolin.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('development')
    ->set('hostname', '38.242.196.238')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/var/www/php82/kaolin')
    ->set('keep_releases', 2);

host('production')
    ->set('hostname', '54.254.242.187')
    ->set('branch', 'main')
    ->set('remote_user', 'ubuntu')
    ->set('deploy_path', '/var/www/html');

// Hooks

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
]);

task('npm:run:prod', function () {
    cd('{{release_or_current_path}}');
    run('composer install');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');
