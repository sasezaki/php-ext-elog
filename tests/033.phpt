--TEST--
elog_remove_filter
--INI--
--SKIPIF--
--FILE--
<?php
require 'test.inc';

if (!extension_loaded('elog')) {
    dl('elog.' . PHP_SHLIB_SUFFIX);
}

echo "=== Filter register ===\n";
function filter_test($val) {
    return $val;
}
class Test {
    public function hoge($val) {
        return $val;
    }
    static public function foo($val) {
        return $val;
    }
}
$test = new Test;
elog_register_filter('function_filter', 'filter_test');
elog_register_filter('method_filter', array($test, 'hoge'));
elog_register_filter('static_method_filter', 'Test::foo');
elog_register_filter('closure_filter', function($val) { return $val; });

elog_append_filter(
    array("elog_filter_to_string", "elog_filter_add_eol",
          "function_filter", "method_filter", "closure_filter"));
var_dump(elog_get_filter());

echo "=== Filter remove: elog_filter_to_string ===\n";
var_dump(elog_remove_filter("elog_filter_to_string"));
var_dump(elog_get_filter());

echo "=== Filter remove: function_filter ===\n";
var_dump(elog_remove_filter("function_filter"));
var_dump(elog_get_filter());

echo "=== Filter remove: closure_filter ===\n";
var_dump(elog_remove_filter("closure_filter"));
var_dump(elog_get_filter());

?>
--EXPECTF--
=== Filter register ===
array(4) {
  ["builtin"]=>
  array(9) {
    [0]=>
    string(21) "elog_filter_to_string"
    [1]=>
    string(19) "elog_filter_to_json"
    [2]=>
    string(25) "elog_filter_to_http_query"
    [3]=>
    string(20) "elog_filter_to_array"
    [4]=>
    string(19) "elog_filter_add_eol"
    [5]=>
    string(24) "elog_filter_add_fileline"
    [6]=>
    string(25) "elog_filter_add_timestamp"
    [7]=>
    string(23) "elog_filter_add_request"
    [8]=>
    string(21) "elog_filter_add_level"
  }
  ["registers"]=>
  array(4) {
    [0]=>
    string(15) "function_filter"
    [1]=>
    string(13) "method_filter"
    [2]=>
    string(20) "static_method_filter"
    [3]=>
    string(14) "closure_filter"
  }
  ["execute"]=>
  array(0) {
  }
  ["enabled"]=>
  array(5) {
    [0]=>
    string(21) "elog_filter_to_string"
    [1]=>
    string(19) "elog_filter_add_eol"
    [2]=>
    string(15) "function_filter"
    [3]=>
    string(13) "method_filter"
    [4]=>
    string(14) "closure_filter"
  }
}
=== Filter remove: elog_filter_to_string ===
bool(true)
array(4) {
  ["builtin"]=>
  array(9) {
    [0]=>
    string(21) "elog_filter_to_string"
    [1]=>
    string(19) "elog_filter_to_json"
    [2]=>
    string(25) "elog_filter_to_http_query"
    [3]=>
    string(20) "elog_filter_to_array"
    [4]=>
    string(19) "elog_filter_add_eol"
    [5]=>
    string(24) "elog_filter_add_fileline"
    [6]=>
    string(25) "elog_filter_add_timestamp"
    [7]=>
    string(23) "elog_filter_add_request"
    [8]=>
    string(21) "elog_filter_add_level"
  }
  ["registers"]=>
  array(4) {
    [0]=>
    string(15) "function_filter"
    [1]=>
    string(13) "method_filter"
    [2]=>
    string(20) "static_method_filter"
    [3]=>
    string(14) "closure_filter"
  }
  ["execute"]=>
  array(0) {
  }
  ["enabled"]=>
  array(4) {
    [0]=>
    string(19) "elog_filter_add_eol"
    [1]=>
    string(15) "function_filter"
    [2]=>
    string(13) "method_filter"
    [3]=>
    string(14) "closure_filter"
  }
}
=== Filter remove: function_filter ===
bool(true)
array(4) {
  ["builtin"]=>
  array(9) {
    [0]=>
    string(21) "elog_filter_to_string"
    [1]=>
    string(19) "elog_filter_to_json"
    [2]=>
    string(25) "elog_filter_to_http_query"
    [3]=>
    string(20) "elog_filter_to_array"
    [4]=>
    string(19) "elog_filter_add_eol"
    [5]=>
    string(24) "elog_filter_add_fileline"
    [6]=>
    string(25) "elog_filter_add_timestamp"
    [7]=>
    string(23) "elog_filter_add_request"
    [8]=>
    string(21) "elog_filter_add_level"
  }
  ["registers"]=>
  array(4) {
    [0]=>
    string(15) "function_filter"
    [1]=>
    string(13) "method_filter"
    [2]=>
    string(20) "static_method_filter"
    [3]=>
    string(14) "closure_filter"
  }
  ["execute"]=>
  array(0) {
  }
  ["enabled"]=>
  array(3) {
    [0]=>
    string(19) "elog_filter_add_eol"
    [1]=>
    string(13) "method_filter"
    [2]=>
    string(14) "closure_filter"
  }
}
=== Filter remove: closure_filter ===
bool(true)
array(4) {
  ["builtin"]=>
  array(9) {
    [0]=>
    string(21) "elog_filter_to_string"
    [1]=>
    string(19) "elog_filter_to_json"
    [2]=>
    string(25) "elog_filter_to_http_query"
    [3]=>
    string(20) "elog_filter_to_array"
    [4]=>
    string(19) "elog_filter_add_eol"
    [5]=>
    string(24) "elog_filter_add_fileline"
    [6]=>
    string(25) "elog_filter_add_timestamp"
    [7]=>
    string(23) "elog_filter_add_request"
    [8]=>
    string(21) "elog_filter_add_level"
  }
  ["registers"]=>
  array(4) {
    [0]=>
    string(15) "function_filter"
    [1]=>
    string(13) "method_filter"
    [2]=>
    string(20) "static_method_filter"
    [3]=>
    string(14) "closure_filter"
  }
  ["execute"]=>
  array(0) {
  }
  ["enabled"]=>
  array(2) {
    [0]=>
    string(19) "elog_filter_add_eol"
    [1]=>
    string(13) "method_filter"
  }
}
