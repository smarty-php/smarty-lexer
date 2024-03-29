<?php

namespace SmartyGenerator\ParserGenerator;

/**
 * \Smarty\ParserGenerator, a php 5 parser generator.
 *
 * This is a direct port of the Lemon parser generator, found at
 * {@link http://www.hwaci.com/sw/lemon/}
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2006, Gregory Beaver <cellog@php.net>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in
 *       the documentation and/or other materials provided with the distribution.
 *     * Neither the name of the \Smarty\ParserGenerator nor the names of its
 *       contributors may be used to endorse or promote products derived
 *       from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   php
 * @package    \Smarty\ParserGenerator
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2006 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id: Action.php,v 1.2 2007/03/04 17:52:05 cellog Exp $
 * @since      File available since Release 0.1.0
 */
/**
 * Every shift or reduce operation is stored as one of the following objects.
 *
 * @package    \Smarty\ParserGenerator
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2006 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version    0.1.5
 * @since      Class available since Release 0.1.0
 */
class Action
{
    const SHIFT = 1,
    ACCEPT = 2,
    REDUCE = 3,
    ERROR = 4,
    /**
           * Was a reduce, but part of a conflict
           */
    CONFLICT = 5,
    /**
           * Was a shift.  Precedence resolved conflict
           */
    SH_RESOLVED = 6,
    /**
           * Was a reduce.  Precedence resolved conflict
           */
    RD_RESOLVED = 7,
    /**
           * Deleted by compression
           *
     * @see \SmartyGenerator\ParserGenerator::CompressTables()
           */
    NOT_USED = 8;
    /**
     * The look-ahead symbol that triggers this action
     * @var Smarty\ParserGenerator\Symbol
     */
    public $sp;       /* The look-ahead symbol */
    /**
     * This defines the kind of action, and must be one
     * of the class constants.
     *
     * - {@link Smarty\ParserGenerator\Action::SHIFT}
     * - {@link Smarty\ParserGenerator\Action::ACCEPT}
     * - {@link Smarty\ParserGenerator\Action::REDUCE}
     * - {@link Smarty\ParserGenerator\Action::ERROR}
     * - {@link Smarty\ParserGenerator\Action::CONFLICT}
     * - {@link Smarty\ParserGenerator\Action::SH_RESOLVED}
     * - {@link Smarty\ParserGenerator\Action:: RD_RESOLVED}
     * - {@link Smarty\ParserGenerator\Action::NOT_USED}
     */
    public $type;
    /**
     * The new state, if this is a shift,
     * the parser rule index, if this is a reduce.
     *
     * @var Smarty\ParserGenerator\State|Smarty\ParserGenerator\Rule
     */
    public $x;
    /**
     * The next action for this state.
     * @var Smarty\ParserGenerator\Action
     */
    public $next;

    /**
     * Compare two actions
     *
     * This is used by {@link Action_sort()} to compare actions
     */
    public static function actioncmp(Action $ap1,
                              Action $ap2)
    {
        $rc = $ap1->sp->index - $ap2->sp->index;
        if ($rc === 0) {
            $rc = $ap1->type - $ap2->type;
        }
        if ($rc === 0) {
            if ($ap1->type == self::SHIFT) {
                if ($ap1->x->statenum != $ap2->x->statenum) {
                    throw new Exception('Shift conflict: ' . $ap1->sp->name .
                        ' shifts both to state ' . $ap1->x->statenum . ' (rule ' .
                        $ap1->x->cfp->rp->lhs->name . ' on line ' .
                        $ap1->x->cfp->rp->ruleline . ') and to state ' .
                        $ap2->x->statenum . ' (rule ' .
                        $ap2->x->cfp->rp->lhs->name . ' on line ' .
                        $ap2->x->cfp->rp->ruleline . ')');
                }
            }
            if ($ap1->type != self::REDUCE &&
            $ap1->type != self::RD_RESOLVED &&
            $ap1->type != self::CONFLICT) {
                throw new Exception('action has not been processed: ' .
                $ap1->sp->name . ' on line ' . $ap1->x->cfp->rp->ruleline .
                ', rule ' . $ap1->x->cfp->rp->lhs->name);
            }
            if ($ap2->type != self::REDUCE &&
            $ap2->type != self::RD_RESOLVED &&
            $ap2->type != self::CONFLICT) {
                throw new Exception('action has not been processed: ' .
                $ap2->sp->name . ' on line ' . $ap2->x->cfp->rp->ruleline .
                ', rule ' . $ap2->x->cfp->rp->lhs->name);
            }
            $rc = $ap1->x->index - $ap2->x->index;
        }

        return $rc;
    }

    public function display($processed = false)
    {
        $map = array(
            self::ACCEPT => 'ACCEPT',
            self::CONFLICT => 'CONFLICT',
            self::REDUCE => 'REDUCE',
            self::SHIFT => 'SHIFT'
        );
       $sep = "\n";
        echo $map[$this->type] . ' for ' . $this->sp->name;
        if ($this->type == self::REDUCE) {
            echo ' - rule ' . $this->x->lhs->name . $sep;
        } elseif ($this->type == self::SHIFT) {
            echo ' - state ' . $this->x->statenum . ', basis ' . $this->x->cfp->rp->lhs->name . $sep;
        } else {
            echo $sep;
        }
    }

    /**
     * create linked list of Actions
     *
     * @param Action|null
     * @param int one of the class constants from Action
     * @param Symbol
     * @param State|Rule
     */
    public static function Action_add($app, $type, Symbol $sp, $arg)
    {
        $new = new Action;
        $new->next = $app;
        $new->type = $type;
        $new->sp = $sp;
        $new->x = $arg;
//        echo ' Adding ';
//        $new->display();
		return $new;
    }

    /**
     * Sort parser actions
     * @see Data::FindActions()
     */
    public static function Action_sort(Action $ap)
    {
	    $ap = \SmartyGenerator\ParserGenerator::msort($ap, 'next', array(Action::class, 'actioncmp'));

        return $ap;
    }

    /**
     * Print an action to the given file descriptor.  Return FALSE if
     * nothing was actually printed.
     * @see Data::ReportOutput()
     */
    public function PrintAction($fp, $indent)
    {
        if (!$fp) {
            $fp = STDOUT;
        }
        $result = 1;
        switch ($this->type) {
            case self::SHIFT:
                fprintf($fp, "%${indent}s shift  %d", $this->sp->name, $this->x->statenum);
                break;
            case self::REDUCE:
                fprintf($fp, "%${indent}s reduce %d", $this->sp->name, $this->x->index);
                break;
            case self::ACCEPT:
                fprintf($fp, "%${indent}s accept", $this->sp->name);
                break;
            case self::ERROR:
                fprintf($fp, "%${indent}s error", $this->sp->name);
                break;
            case self::CONFLICT:
                fprintf($fp, "%${indent}s reduce %-3d ** Parsing conflict **", $this->sp->name, $this->x->index);
                break;
            case self::SH_RESOLVED:
            case self::RD_RESOLVED:
            case self::NOT_USED:
                $result = 0;
                break;
        }

        return $result;
    }
}
