<?php
namespace SmartyGenerator\ParserGenerator;

/**
 * The structure used to represent a state in the associative array
 * for a Smarty\ParserGenerator\Config.
 * @package    \Smarty\ParserGenerator
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2006 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version    0.1.5
 * @since      Class available since Release 0.1.0
 */
class StateNode
{
	public $key;
	public $data;
	public $from = 0;
	public $next = 0;
}