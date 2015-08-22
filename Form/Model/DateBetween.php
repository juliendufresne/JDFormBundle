<?php

namespace JD\FormBundle\Form\Model;

use DateTime;

final class DateBetween
{
    /**
     * @var DateTime|null
     */
    private $from;

    /**
     * @var DateTime|null
     */
    private $to;

    /**
     * @param DateTime|null $from
     * @param DateTime|null $to
     */
    public function __construct(DateTime $from = null, DateTime $to = null)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * @return DateTime|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param DateTime|null $from
     */
    public function setFrom(DateTime $from = null)
    {
        $this->from = $from;
    }

    /**
     * @return DateTime|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param DateTime|null $to
     */
    public function setTo(DateTime $to = null)
    {
        $this->to = $to;
    }
}
