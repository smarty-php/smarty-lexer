<?php
namespace SmartyGenerator\LexerGenerator\Regex;

class Lexer
{
    const MATCHSTART = Parser::MATCHSTART;
    const MATCHEND = Parser::MATCHEND;
    const CONTROLCHAR = Parser::CONTROLCHAR;
    const OPENCHARCLASS = Parser::OPENCHARCLASS;
    const FULLSTOP = Parser::FULLSTOP;
    const TEXT = Parser::TEXT;
    const BACKREFERENCE = Parser::BACKREFERENCE;
    const OPENASSERTION = Parser::OPENASSERTION;
    const COULDBEBACKREF = Parser::COULDBEBACKREF;
    const NEGATE = Parser::NEGATE;
    const HYPHEN = Parser::HYPHEN;
    const CLOSECHARCLASS = Parser::CLOSECHARCLASS;
    const BAR = Parser::BAR;
    const MULTIPLIER = Parser::MULTIPLIER;
    const INTERNALOPTIONS = Parser::INTERNALOPTIONS;
    const COLON = Parser::COLON;
    const OPENPAREN = Parser::OPENPAREN;
    const CLOSEPAREN = Parser::CLOSEPAREN;
    const PATTERNNAME = Parser::PATTERNNAME;
    const POSITIVELOOKBEHIND = Parser::POSITIVELOOKBEHIND;
    const NEGATIVELOOKBEHIND = Parser::NEGATIVELOOKBEHIND;
    const POSITIVELOOKAHEAD = Parser::POSITIVELOOKAHEAD;
    const NEGATIVELOOKAHEAD = Parser::NEGATIVELOOKAHEAD;
    const ONCEONLY = Parser::ONCEONLY;
    const COMMENT = Parser::COMMENT;
    const RECUR = Parser::RECUR;
    const ESCAPEDBACKSLASH = Parser::ESCAPEDBACKSLASH;
    private $input;
    private $N;
    public $token;
    public $value;
    public $line;

    public function __construct($data)
    {
        $this->input = $data;
        $this->N = 0;
    }

    public function reset($data, $line)
    {
        $this->input = $data;
        $this->N = 0;
        // passed in from parent parser
        $this->line = $line;
        $this->yybegin(self::INITIAL);
    }

    private $_yy_state = 1;
    private $_yy_stack = array();

    public function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    public function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    public function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    public function yybegin($state)
    {
        $this->_yy_state = $state;
    }

    public function yylex1()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
              14 => 0,
              15 => 0,
              16 => 0,
              17 => 0,
              18 => 0,
              19 => 0,
              20 => 0,
              21 => 0,
              22 => 0,
              23 => 0,
            );
        if ($this->N >= strlen($this->input)) {
            return false; // end of input
        }
        $yy_global_pattern = '/\G(\\\\\\\\)|\G([^[\\\\^$.|()?*+{}]+)|\G(\\\\[][{}*.^$|?()+])|\G(\\[)|\G(\\|)|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)/';

        do {
            if (preg_match($yy_global_pattern,$this->input, $yymatches, null, $this->N)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->input,
                        $this->N, 5) . '... state INITIAL');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->input)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {
                    $yy_yymore_patterns = array(
        1 => array(0, "\G([^[\\\\^$.|()?*+{}]+)|\G(\\\\[][{}*.^$|?()+])|\G(\\[)|\G(\\|)|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        2 => array(0, "\G(\\\\[][{}*.^$|?()+])|\G(\\[)|\G(\\|)|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        3 => array(0, "\G(\\[)|\G(\\|)|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        4 => array(0, "\G(\\|)|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        5 => array(0, "\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        6 => array(0, "\G(\\\\[0-9][0-9])|\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        7 => array(0, "\G(\\\\[abBGcedDsSwW0C]|\\\\c\\\\)|\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        8 => array(0, "\G(\\^)|\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        9 => array(0, "\G(\\\\A)|\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        10 => array(0, "\G(\\))|\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        11 => array(0, "\G(\\$)|\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        12 => array(0, "\G(\\*\\?|\\+\\?|[*?+]|\\{[0-9]+\\}|\\{[0-9]+,\\}|\\{[0-9]+,[0-9]+\\})|\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        13 => array(0, "\G(\\\\[zZ])|\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        14 => array(0, "\G(\\(\\?)|\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        15 => array(0, "\G(\\()|\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        16 => array(0, "\G(\\.)|\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        17 => array(0, "\G(\\\\[1-9])|\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        18 => array(0, "\G(\\\\p\\{\\^?..?\\}|\\\\P\\{..?\\}|\\\\X)|\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        19 => array(0, "\G(\\\\p\\{C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        20 => array(0, "\G(\\\\p\\{\\^C[cfnos]?|L[lmotu]?|M[cen]?|N[dlo]?|P[cdefios]?|S[ckmo]?|Z[lps]?\\})|\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        21 => array(0, "\G(\\\\p[CLMNPSZ])|\G(\\\\)"),
        22 => array(0, "\G(\\\\)"),
        23 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              $this->input, $yymatches, null, $this->N)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                        $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
                    if ($r === true) {
                        // we have changed state
                        // process this token in the new state
                        return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->input)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
                    } else {
                        // accept
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");

                        return true;
                    }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->input[$this->N]);
            }
            break;
        } while (true);

    } // end function

    const INITIAL = 1;
    public function yy_r1_1($yy_subpatterns)
    {

    $this->token = self::ESCAPEDBACKSLASH;
    }
    public function yy_r1_2($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r1_3($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_4($yy_subpatterns)
    {

    $this->token = self::OPENCHARCLASS;
    $this->yybegin(self::CHARACTERCLASSSTART);
    }
    public function yy_r1_5($yy_subpatterns)
    {

    $this->token = self::BAR;
    }
    public function yy_r1_6($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r1_7($yy_subpatterns)
    {

    $this->token = self::COULDBEBACKREF;
    }
    public function yy_r1_8($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_9($yy_subpatterns)
    {

    $this->token = self::MATCHSTART;
    }
    public function yy_r1_10($yy_subpatterns)
    {

    $this->token = self::MATCHSTART;
    }
    public function yy_r1_11($yy_subpatterns)
    {

    $this->token = self::CLOSEPAREN;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r1_12($yy_subpatterns)
    {

    $this->token = self::MATCHEND;
    }
    public function yy_r1_13($yy_subpatterns)
    {

    $this->token = self::MULTIPLIER;
    }
    public function yy_r1_14($yy_subpatterns)
    {

    $this->token = self::MATCHEND;
    }
    public function yy_r1_15($yy_subpatterns)
    {

    $this->token = self::OPENASSERTION;
    $this->yybegin(self::ASSERTION);
    }
    public function yy_r1_16($yy_subpatterns)
    {

    $this->token = self::OPENPAREN;
    }
    public function yy_r1_17($yy_subpatterns)
    {

    $this->token = self::FULLSTOP;
    }
    public function yy_r1_18($yy_subpatterns)
    {

    $this->token = self::BACKREFERENCE;
    }
    public function yy_r1_19($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_20($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_21($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_22($yy_subpatterns)
    {

    $this->token = self::CONTROLCHAR;
    }
    public function yy_r1_23($yy_subpatterns)
    {
    return false;
    }

    public function yylex2()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
            );
        if ($this->N >= strlen($this->input)) {
            return false; // end of input
        }
        $yy_global_pattern = '/\G(\\^)|\G(\\])|\G(.)/';

        do {
            if (preg_match($yy_global_pattern,$this->input, $yymatches, null, $this->N)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->input,
                        $this->N, 5) . '... state CHARACTERCLASSSTART');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->input)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {
                    $yy_yymore_patterns = array(
        1 => array(0, "\G(\\])|\G(.)"),
        2 => array(0, "\G(.)"),
        3 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              $this->input, $yymatches, null, $this->N)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                        $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
                    if ($r === true) {
                        // we have changed state
                        // process this token in the new state
                        return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->input)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
                    } else {
                        // accept
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");

                        return true;
                    }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->input[$this->N]);
            }
            break;
        } while (true);

    } // end function

    const CHARACTERCLASSSTART = 2;
    public function yy_r2_1($yy_subpatterns)
    {

    $this->token = self::NEGATE;
    }
    public function yy_r2_2($yy_subpatterns)
    {

    $this->yybegin(self::CHARACTERCLASS);
    $this->token = self::TEXT;
    }
    public function yy_r2_3($yy_subpatterns)
    {

    $this->yybegin(self::CHARACTERCLASS);

    return true;
    }

    public function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
            );
        if ($this->N >= strlen($this->input)) {
            return false; // end of input
        }
        $yy_global_pattern = '/\G(\\\\\\\\)|\G(\\])|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)/';

        do {
            if (preg_match($yy_global_pattern,$this->input, $yymatches, null, $this->N)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->input,
                        $this->N, 5) . '... state CHARACTERCLASS');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->input)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {
                    $yy_yymore_patterns = array(
        1 => array(0, "\G(\\])|\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        2 => array(0, "\G(\\\\[frnt]|\\\\x[0-9a-fA-F][0-9a-fA-F]?|\\\\[0-7][0-7][0-7]|\\\\x\\{[0-9a-fA-F]+\\})|\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        3 => array(0, "\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        4 => array(0, "\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        5 => array(0, "\G(\\\\[1-9])|\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        6 => array(0, "\G(\\\\[]\.\-\^])|\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        7 => array(0, "\G(-(?!]))|\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        8 => array(0, "\G([^\-\\\\])|\G(\\\\)|\G(.)"),
        9 => array(0, "\G(\\\\)|\G(.)"),
        10 => array(0, "\G(.)"),
        11 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              $this->input, $yymatches, null, $this->N)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                        $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
                    if ($r === true) {
                        // we have changed state
                        // process this token in the new state
                        return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->input)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
                    } else {
                        // accept
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");

                        return true;
                    }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->input[$this->N]);
            }
            break;
        } while (true);

    } // end function

    const CHARACTERCLASS = 3;
    public function yy_r3_1($yy_subpatterns)
    {

    $this->token = self::ESCAPEDBACKSLASH;
    }
    public function yy_r3_2($yy_subpatterns)
    {

    $this->yybegin(self::INITIAL);
    $this->token = self::CLOSECHARCLASS;
    }
    public function yy_r3_3($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r3_4($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r3_5($yy_subpatterns)
    {

    $this->token = self::COULDBEBACKREF;
    }
    public function yy_r3_6($yy_subpatterns)
    {

    $this->token = self::BACKREFERENCE;
    }
    public function yy_r3_7($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r3_8($yy_subpatterns)
    {

    $this->token = self::HYPHEN;
    $this->yybegin(self::RANGE);
    }
    public function yy_r3_9($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }
    public function yy_r3_10($yy_subpatterns)
    {
    return false; // ignore escaping of normal text
    }
    public function yy_r3_11($yy_subpatterns)
    {

    $this->token = self::TEXT;
    }

    public function yylex4()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
            );
        if ($this->N >= strlen($this->input)) {
            return false; // end of input
        }
        $yy_global_pattern = '/\G(\\\\\\\\)|\G(\\\\\\])|\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G([^\-\\\\])|\G(\\\\)/';

        do {
            if (preg_match($yy_global_pattern,$this->input, $yymatches, null, $this->N)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->input,
                        $this->N, 5) . '... state RANGE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r4_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->input)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {
                    $yy_yymore_patterns = array(
        1 => array(0, "\G(\\\\\\])|\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G([^\-\\\\])|\G(\\\\)"),
        2 => array(0, "\G(\\\\[bacedDsSwW0C]|\\\\c\\\\|\\\\x\\{[0-9a-fA-F]+\\}|\\\\[0-7][0-7][0-7]|\\\\x[0-9a-fA-F][0-9a-fA-F]?)|\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G([^\-\\\\])|\G(\\\\)"),
        3 => array(0, "\G(\\\\[0-9][0-9])|\G(\\\\[1-9])|\G([^\-\\\\])|\G(\\\\)"),
        4 => array(0, "\G(\\\\[1-9])|\G([^\-\\\\])|\G(\\\\)"),
        5 => array(0, "\G([^\-\\\\])|\G(\\\\)"),
        6 => array(0, "\G(\\\\)"),
        7 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              $this->input, $yymatches, null, $this->N)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                        $r = $this->{'yy_r4_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
                    if ($r === true) {
                        // we have changed state
                        // process this token in the new state
                        return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->input)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
                    } else {
                        // accept
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");

                        return true;
                    }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->input[$this->N]);
            }
            break;
        } while (true);

    } // end function

    const RANGE = 4;
    public function yy_r4_1($yy_subpatterns)
    {

    $this->token = self::ESCAPEDBACKSLASH;
    }
    public function yy_r4_2($yy_subpatterns)
    {

    $this->token = self::TEXT;
    $this->yybegin(self::CHARACTERCLASS);
    }
    public function yy_r4_3($yy_subpatterns)
    {

    $this->token = self::TEXT;
    $this->yybegin(self::CHARACTERCLASS);
    }
    public function yy_r4_4($yy_subpatterns)
    {

    $this->token = self::COULDBEBACKREF;
    }
    public function yy_r4_5($yy_subpatterns)
    {

    $this->token = self::BACKREFERENCE;
    }
    public function yy_r4_6($yy_subpatterns)
    {

    $this->token = self::TEXT;
    $this->yybegin(self::CHARACTERCLASS);
    }
    public function yy_r4_7($yy_subpatterns)
    {
    return false; // ignore escaping of normal text
    }

    public function yylex5()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
            );
        if ($this->N >= strlen($this->input)) {
            return false; // end of input
        }
        $yy_global_pattern = '/\G([imsxUX]+-[imsxUX]+|[imsxUX]+|-[imsxUX]+)|\G(:)|\G(\\))|\G(P<[^>]+>)|\G(<=)|\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)/';

        do {
            if (preg_match($yy_global_pattern,$this->input, $yymatches, null, $this->N)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->input,
                        $this->N, 5) . '... state ASSERTION');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r5_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->input)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {
                    $yy_yymore_patterns = array(
        1 => array(0, "\G(:)|\G(\\))|\G(P<[^>]+>)|\G(<=)|\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        2 => array(0, "\G(\\))|\G(P<[^>]+>)|\G(<=)|\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        3 => array(0, "\G(P<[^>]+>)|\G(<=)|\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        4 => array(0, "\G(<=)|\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        5 => array(0, "\G(<!)|\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        6 => array(0, "\G(=)|\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        7 => array(0, "\G(!)|\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        8 => array(0, "\G(>)|\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        9 => array(0, "\G(\\(\\?)|\G(#[^)]+)|\G(R)|\G(.)"),
        10 => array(0, "\G(#[^)]+)|\G(R)|\G(.)"),
        11 => array(0, "\G(R)|\G(.)"),
        12 => array(0, "\G(.)"),
        13 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              $this->input, $yymatches, null, $this->N)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                        $r = $this->{'yy_r5_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
                    if ($r === true) {
                        // we have changed state
                        // process this token in the new state
                        return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->input)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
                    } else {
                        // accept
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");

                        return true;
                    }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->input[$this->N]);
            }
            break;
        } while (true);

    } // end function

    const ASSERTION = 5;
    public function yy_r5_1($yy_subpatterns)
    {

    $this->token = self::INTERNALOPTIONS;
    }
    public function yy_r5_2($yy_subpatterns)
    {

    $this->token = self::COLON;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_3($yy_subpatterns)
    {

    $this->token = self::CLOSEPAREN;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_4($yy_subpatterns)
    {

    $this->token = self::PATTERNNAME;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_5($yy_subpatterns)
    {

    $this->token = self::POSITIVELOOKBEHIND;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_6($yy_subpatterns)
    {

    $this->token = self::NEGATIVELOOKBEHIND;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_7($yy_subpatterns)
    {

    $this->token = self::POSITIVELOOKAHEAD;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_8($yy_subpatterns)
    {

    $this->token = self::NEGATIVELOOKAHEAD;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_9($yy_subpatterns)
    {

    $this->token = self::ONCEONLY;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_10($yy_subpatterns)
    {

    $this->token = self::OPENASSERTION;
    }
    public function yy_r5_11($yy_subpatterns)
    {

    $this->token = self::COMMENT;
    $this->yybegin(self::INITIAL);
    }
    public function yy_r5_12($yy_subpatterns)
    {

    $this->token = self::RECUR;
    }
    public function yy_r5_13($yy_subpatterns)
    {

    $this->yybegin(self::INITIAL);

    return true;
    }

}
