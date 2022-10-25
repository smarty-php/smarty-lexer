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

$lex = new LexerGenerator();
$lex->create("{$lexerPath}smarty_internal_configfilelexer.plex", "{$smartyPath}smarty_internal_configfilelexer.php");
unset($lex);

$parser = new ParserGenerator();
$parser->setQuiet();
$parser->main("{$lexerPath}smarty_internal_configfileparser.y", "{$smartyPath}smarty_internal_configfileparser.php");
unset($parser);

$content = file_get_contents("{$smartyPath}smarty_internal_configfileparser.php");
$content = preg_replace(array('#/\*\s*\d+\s*\*/#', "#'lhs'#", "#'rhs'#"), array('', 0, 1), $content);
file_put_contents("{$smartyPath}smarty_internal_configfileparser.php", $content);
