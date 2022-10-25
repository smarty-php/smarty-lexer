<?php

use Smarty\LexerGenerator;
use Smarty\ParserGenerator;

ini_set('max_execution_time',300);
ini_set('xdebug.max_nesting_level',300);

require_once 'vendor/autoload.php';

$smartyPath = '../smarty/libs/sysplugins/';
$lexerPath = '../smarty/lexer/';
if (!is_dir($lexerPath)) {
    echo '<br><br>Fatal error: Missing lexer / parser definition folder \'lexer\' in distribution <br>';
    exit(1);
}

$lex = new LexerGenerator();
$lex->create("{$lexerPath}smarty_internal_templatelexer.plex", "{$smartyPath}smarty_internal_templatelexer.php");
unset($lex);

$parser = new ParserGenerator();
$parser->setQuiet();
$parser->main("{$lexerPath}smarty_internal_templateparser.y", "{$smartyPath}smarty_internal_templateparser.php");
unset($parser);

$content = file_get_contents("{$smartyPath}smarty_internal_templateparser.php");
$content = preg_replace(array('#/\*\s*\d+\s*\*/#', "#'lhs'#", "#'rhs'#"), array('', 0, 1), $content);
file_put_contents("{$smartyPath}smarty_internal_templateparser.php", $content);

