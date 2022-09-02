<?php /** @noinspection All */
declare(strict_types=1);

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'nico-cards');

set('default_stage', 'production');

set('keep_releases', 3);

// Project repository
set('repository', 'git@angie.github.com:youhei-ushio/nico-cards.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

set('ssh_multiplexing', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['vendor']);

// Writable dirs by web server
add('writable_dirs', ['bootstrap/cache', 'storage']);
set('allow_anonymous_stats', false);

// Hosts

host('seasalt-deployer')
    ->stage('production')
    ->configFile('~/.ssh/config')
    ->set('deploy_path', '/var/app/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

before('deploy:symlink', 'npm:run');

task('npm:run', function (): void {
    run('cd {{release_path}} && chmod 707 public');
    run('cd {{release_path}} && npm install');
    run('cd {{release_path}} && npm run prod');
    run('cd {{release_path}} && chmod 705 public');
});
