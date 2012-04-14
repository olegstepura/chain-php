<?php
/**
 * @author Oleg Stepura <github@oleg.stepura.com>
 * @copyright Oleg Stepura <github@oleg.stepura.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @version $Id$
 */

namespace Ost\Chain;

/**
 * ChainElement class.
 * @author Oleg Stepura <github@oleg.stepura.com>
 */
class ChainElement implements \IteratorAggregate
{
    /**
     * Element itself
     * @var mixed
     */
    protected $elem;

    /**
     * Chain
     * @var Chain
     */
    protected $chain;

    /**
     * Next element.
     * @var ChainElement
     */
    protected $next;

    /**
     * Previous element.
     * @var ChainElement
     */
    protected $prev;

    /**
     * @param mixed $element
     * @param Chain $chain
     */
    public function __construct($element, Chain $chain)
    {
        $this->elem = $element;
        $this->chain = $chain;
    }

    /**
     * Returns initial data.
     * @return mixed
     */
    public function is()
    {
        return $this->elem;
    }

    /**
     * @return Chain
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @return ChainElement
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return ChainElement
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * @param $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * @param $prev
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;
    }

    /**
     * @return Chain
     */
    public function getIterator()
    {
        return $this->chain;
    }
}
