<?php
namespace Laragento\SalesRule\DataObjects;

/**
 * Interface RuleInterface
 * @package Laragento\SalesRule\DataObjects
 * @property float discount_amount
 * @property boolean active
 * @property string title
 * @property string discount_percent
 */

interface RuleInterface
{
    const FREE_SHIPPING_NONE = 'NONE';
    const FREE_SHIPPING_MATCHING_ITEMS_ONLY = 'MATCHING_ITEMS_ONLY';
    const FREE_SHIPPING_WITH_MATCHING_ITEMS = 'FREE_WITH_MATCHING_ITEMS';

    const DISCOUNT_ACTION_BY_PERCENT = 'by_percent';
    const DISCOUNT_ACTION_FIXED_AMOUNT = 'by_fixed';
    const DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART = 'cart_fixed';
    const DISCOUNT_ACTION_BUY_X_GET_Y = 'buy_x_get_y';

    const COUPON_TYPE_NO_COUPON = 'NO_COUPON';
    const COUPON_TYPE_SPECIFIC_COUPON = 'SPECIFIC_COUPON';
    const COUPON_TYPE_AUTO = 'AUTO';
}