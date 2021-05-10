<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';

// Project name
set('application', 'joelson.org');

set('allow_anonymous_stats', false);

// Append to Deployer defaults (https://deployer.org/recipes/rsync.html#sample-configuration)
$rsyncOptions = get('rsync');
$rsyncOptions['exclude'] = array_merge($rsyncOptions['exclude'], [
    '.editorconfig',
    '.github',
    '.gitignore',
    'composer.json',
    'composer.lock',
    'LICENSE',
    'package-lock.json',
    'package.json',
    'README.md',
]);
$rsyncOptions['options'] = array_merge($rsyncOptions['options'], [
    'chown="'. getenv('DEPLOY_CHOWN') . '"',
    'chmod="Dugo=rx,Fugo=r"',
]);
set('rsync', $rsyncOptions);

set('rsync_src', function () {
    return __DIR__;
});

task('chown', function() {
    run('chown -R '. getenv('DEPLOY_CHOWN') . ' {{deploy_path}}');
});

// Hosts
host('prod')
    ->hostname(getenv('SSH_HOST'))
    ->stage('production')
    ->user(getenv('SSH_USER'))
    ->set('deploy_path', getenv('DEPLOY_PATH'));

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'rsync',
    'chown',
    'deploy:shared',
    'deploy:symlink',
    'cleanup',
    'success'
]);
