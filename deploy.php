<?php
namespace Deployer;

require 'recipe/symfony.php';
require 'contrib/yarn.php';

// Config

set('repository', 'https://github.com/Nebja/project-website-nebja.git');
set('keep_releases', 3);
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('dev')
    ->setHostname('185.224.139.185')
    ->setIdentityFile('~/.ssh/id_rsa')
    ->setRemoteUser('root')
    ->setPort(22)
    ->set('deploy_path', '/var/www/nebja.eu/dev');

host('prod')
    ->setHostname('185.224.139.185')
    ->setRemoteUser('root')
    ->setPort(22)
    ->set('deploy_path', '/var/www/nebja.eu/prod');

// Hooks
after('deploy:failed', 'deploy:unlock');

//tasks
task( 'deploy', [
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'yarn:install',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success',
    'build'
]);
task('build', function (){
    cd('/var/www/nebja.eu/dev/current');
    run('yarn run build');
});
