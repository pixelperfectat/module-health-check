<?php

namespace Deployer;

desc('Runs registered health checks against the released artifact');
task('pixelperfect:health-check', function () {
    run('{{bin/php}} {{release_or_current_path}}/{{bin/magento_remote}} pixelperfect:health:check --no-interaction');
});