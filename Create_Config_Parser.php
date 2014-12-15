<?php
// Create Lexer
require_once './LexerGenerator.php';
$lex = new PHP_LexerGenerator('smarty_internal_configfilelexer.plex');
$contents = file_get_contents('smarty_internal_configfilelexer.php');
file_put_contents('smarty_internal_configfilelexer.php', $contents."\n");


// Create Parser
passthru("php ./ParserGenerator/cli.php smarty_internal_configfileparser.y");

$contents = file_get_contents('smarty_internal_configfileparser.php');
$contents = '<?php
/**
* Smarty Internal Plugin Configfileparser
*
* This is the config file parser.
* It is generated from the internal.configfileparser.y file
* @package Smarty
* @subpackage Compiler
* @author Uwe Tews
*/
'.substr($contents,6);
file_put_contents('smarty_internal_configfileparser.php', $contents."\n");

if (is_dir('../smarty/libs/sysplugins')) {
    copy('smarty_internal_configfilelexer.php', '../smarty/libs/sysplugins/smarty_internal_configfilelexer.php');
    copy('smarty_internal_configfileparser.php', '../smarty/libs/sysplugins/smarty_internal_configfileparser.php');
}
