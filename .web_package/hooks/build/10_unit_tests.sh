#!/usr/bin/env bash

./bin/setup_php73.sh
./bin/run_unit_tests.sh || build_fail_exception

./bin/setup_php74.sh
./bin/run_unit_tests.sh || build_fail_exception

./bin/setup_php80.sh
./bin/run_unit_tests.sh || build_fail_exception

./bin/setup_php81.sh
./bin/run_unit_tests.sh || build_fail_exception
