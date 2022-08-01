<?php
namespace Deployer;

require 'recipe/common.php';

// Config

set('repository', 'git@github.com:Nebja/project-website-nebja.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('Dev')
    ->setHostname('45.84.206.195')
    ->setForwardAgent(true)
    ->setRemoteUser('u463018380')
    ->setPort(65002)
    ->setIdentityFile('~/.ssh/nebjaeu_id_rsa')
    ->set('deploy_path', '~/domains/nebja.eu/dev');
// Hooks

after('deploy:failed', 'deploy:unlock');

desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:symlink',
]);
