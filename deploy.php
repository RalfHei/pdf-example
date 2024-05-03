<?php
namespace Deployer;

require 'recipe/laravel.php';

// Zone ühendus
set('application', 'pdf-example');
set('remote_user', 'virt83119');
set('http_user', 'virt83119');
set('keep_releases', 2);

host('ta19heinsoo.itmajakas.ee')
    ->setHostname('ta19heinsoo.itmajakas.ee')
    ->set('http_user', 'virt83119')
    ->set('deploy_path', '~/domeenid/www.ta19heinsoo.itmajakas.ee/pdf')
    ->set('branch', 'master');

set('repository', 'git@gitlab.com:RalfHei/hajusrakendus.git');

// tasks
task('opcache:clear', function () {
    run('killall php82-cgi || true');
})->desc('Clear opcache');

task('build:node', function () {
    cd('{{release_path}}');
    run('npm i');
    run('npx vite build');
    run('rm -rf node_modules');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'build:node',
    'deploy:publish',
    'opcache:clear',
    'artisan:cache:clear'
]);
// Hooks

after('deploy:failed', 'deploy:unlock');
