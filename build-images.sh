#!/usr/bin/env bash

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-80 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-80/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-80/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-74 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-74/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-74/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-73 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-73/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-73/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-72 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-72/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-72/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-71 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-71/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-71/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-70 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-70/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-70/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-56 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-56/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-56/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-55 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-55/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-55/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-54 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-54/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-54/base
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-53 -V 0.0.1-dev -L base -D ./docker/sandbox-instanses/php-sandbox-53/base/Dockerfile -C ./docker/sandbox-instanses/php-sandbox-53/base

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-hub -V 0.0.1-dev -L base -D ./docker/php-hub/base/Dockerfile -C ./docker/php-hub/base

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N mock-server -V 0.0.1-dev -L base -D ./docker/mock-server/base/Dockerfile -C ./docker/mock-server/base

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N entrypoint -V 0.0.1-dev -L base -D ./docker/entrypoint/base/Dockerfile -C .



./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-80 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-80/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-74 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-74/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-73 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-73/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-72 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-72/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-71 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-71/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-70 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-70/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-56 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-56/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-55 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-55/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-54 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-54/prod/Dockerfile -C .
./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-sandbox-53 -V 0.0.1 -L latest -D ./docker/sandbox-instanses/php-sandbox-53/prod/Dockerfile -C .

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N php-hub -V 0.0.1 -L latest -D ./docker/php-hub/prod/Dockerfile -C .

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N mock-server -V 0.0.1 -L latest -D ./docker/mock-server/prod/Dockerfile -C .

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N frontend -V 0.0.1 -L latest -D ./docker/frontend/prod/Dockerfile -C .

./pre-release.sh -Y -T d2fcbf12-259d-46bc-939e-ea28fb997d51 -N entrypoint -V 0.0.1 -L latest -D ./docker/entrypoint/prod/Dockerfile -C .



