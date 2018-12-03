<?php
namespace Laragento\Sales\Managers;

interface OrderManagerInterface
{
    public function saveOrderFromQuote($quote);
}