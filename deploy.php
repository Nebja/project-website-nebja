<?php
namespace Deployer;

require 'recipe/symfony.php';
require 'contrib/yarn.php';

// Config

set('repository', 'https://github.com/Nebja/project-website-nebja.git');
set('project_path', '');
set('keep_releases', 3);
add('shared_files', ['.env']);
add('shared_dirs', ['public/Videos', 'public/subs', 'public/img/posters']);
add('writable_dirs', []);

// Hosts
host('dev')
    ->set('project_path', '/var/www/nebja.eu/dev')
    ->setHostname('185.224.139.185')
    ->setIdentityFile('~/.ssh/vps_rsa')
    ->setRemoteUser('root')
    ->setPort(22)
    ->set('deploy_path', '{{project_path}}');

host('prod')
    ->set('project_path', '/var/www/nebja.eu/prod')
    ->setHostname('185.224.139.185')
    ->setIdentityFile('~/.ssh/vps_rsa')
    ->setRemoteUser('root')
    ->setPort(22)
    ->set('deploy_path', '{{project_path}}');

host('local')
    ->set('project_path', '/var/www/nebja.eu/dev')
    ->setHostname('192.168.178.40')
    ->setIdentityFile('~/.ssh/id_local_server_rsa.pub')
    ->setRemoteUser('nebja')
    ->setPort(22)
    ->set('deploy_path', '{{project_path}}');
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
    cd('{{project_path}}/current');
    run('yarn run build');
});
