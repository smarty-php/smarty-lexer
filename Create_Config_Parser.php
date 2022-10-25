<?php
use Smarty\LexerGenerator;
use Smarty\ParserGenerator;

require_once 'vendor/autoload.php';

$smartyPath = '../smarty/libs/sysplugins/';
$lexerPath = '../smarty/lexer/';
if (!is_dir($lexerPath)) {
    echo '<br><br>Fatal error: Missing lexer / parser definition folder \'lexer\' in distribution <br>';
    exit(1);
}
copy("{$smartyPath}smarty_internal_configfilelexer.php", "{$lexerPath}smarty_internal_configfilelexer.php.bak");
copy("{$smartyPath}smarty_internal_configfileparser.php", "{$lexerPath}smarty_internal_configfileparser.php.bak");

$lex = new LexerGenerator();
$lex->create("{$lexerPath}smarty_internal_configfilelexer.plex");
unset($lex);

$parser = new ParserGenerator();
$parser->main("{$lexerPath}smarty_internal_configfileparser.y");
unset($parser);

$content = file_get_contents("{$lexerPath}smarty_internal_configfileparser.php");
$content = preg_replace(array('#/\*\s*\d+\s*\*/#', "#'lhs'#", "#'rhs'#"), array('', 0, 1), $content);
file_put_contents("{$lexerPath}smarty_internal_configfileparser.php", $content);

copy("{$lexerPath}smarty_internal_configfilelexer.php", "{$smartyPath}smarty_internal_configfilelexer.php");
copy("{$lexerPath}smarty_internal_configfileparser.php", "{$smartyPath}smarty_internal_configfileparser.php");

