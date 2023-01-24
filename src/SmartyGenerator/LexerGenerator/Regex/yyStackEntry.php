<?php
namespace SmartyGenerator\LexerGenerator\Regex;

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class yyStackEntry
{
	public $stateno;       /* The state-number */
	public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
	public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};