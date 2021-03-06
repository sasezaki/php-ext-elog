--TEST--
elog tcp/ip: type=11,host=localhost
--INI--
--SKIPIF--
<?php require 'test.inc'; tcp_server_skipif('tcp://localhost:12342'); ?>
--FILE--
<?php
require 'test.inc';

$log = dirname(__FILE__) . "/tmp_006.log";
$host = "tcp://localhost:12342";

echo "=== $host ===\n";

$pid = tcp_server_test($host, $log);

elog("dummy", 11, $host);

file_wait($log);
file_dump($log);

server_finish($pid);
?>
--EXPECTF--
=== tcp://localhost:12342 ===
dummy
