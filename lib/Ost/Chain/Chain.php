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
 * Chain class.
 * @author Oleg Stepura <github@oleg.stepura.com>
 */
class Chain implements \Iterator
{
    /**
     * @var int
     */
    protected $length = 0;

    /**
     * @var ChainElement
     */
    protected $first;

    /**
     * @var ChainElement
     */
    protected $last;

    /**
     * @var ChainElement
     */
    protected $current;

    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @param null|mixed $element
     */
    public function __construct($element = null)
    {
        if (null !== $element) {
            $this->add($element);
        }
    }

    /**
     * @param mixed $element
     * @return Chain
     */
    public function add($element)
    {
        $chainElement = new ChainElement($element, $this);
        if (null === $this->first) {
            $this->first = $chainElement;
            $this->current = $chainElement;
        } else {
            $this->last->setNext($chainElement);
            $chainElement->setPrev($this->last);
        }
        $this->last = $chainElement;
        $this->length ++;

        return $this;
    }

    /**
     * @param int $index
     * @return null|ChainElement
     * @throws \OutOfBoundsException
     */
    protected function getElement($index)
    {
        if ($index >= $this->length || $index < 0) {
            throw new \OutOfBoundsException(sprintf(
                'No elements at index "%s"',
                $index
            ));
        }

        if ($index === $this->index) {
            return $this->current;
        }
        if ($index === 0) {
            return $this->first !== null ? $this->first : null;
        }
        if ($index === $this->length - 1) {
            return $this->last;
        }
        $forward = true;
        if ($index > $this->index) {
            if ($index > $this->length - 1 - $this->length / 2) {
                $curr = $this->last;
                $start = $this->length - 1;
                $forward = false;
            } else {
                $curr = $this->current;
                $start = $this->index;
            }
        } else if ($index < $this->index && $index > $this->index / 2) {
            $curr = $this->current;
            $start = $this->index;
            $forward = false;
        } else {
            $curr = $this->first;
            $start = 0;
        }

        if ($forward) {
            for ($i = $start; $i < $index; $i++) {
                $curr = $curr->getNext();
            }
        } else {
            for ($i = $start; $i > $index; $i--) {
                $curr = $curr->getPrev();
            }
        }

        return $curr;
    }

    /**
     * @param int $index
     * @return null|mixed
     */
    public function get($index)
    {
        $elem = $this->getElement($index);
        return $elem !== null ? $elem->is() : null;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return $this->first !== null ? $this->first->is() : null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        return $this->last !== null ? $this->last->is() : null;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return Chain
     */
    public function rewind()
    {
        $this->index = 0;
        $this->current = $this->first;

        return $this;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->current->is();
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @return Chain
     */
    public function next()
    {
        ++$this->index;
        $this->current = $this->current === null ? null : $this->current->getNext();

        return $this;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return null !== $this->current;
    }
}
