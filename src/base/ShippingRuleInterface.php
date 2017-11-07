<?php

namespace craft\commerce\base;

use craft\commerce\elements\Order;

/**
 * Interface ShippingRule
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
interface ShippingRuleInterface
{
    // Public Methods
    // =========================================================================

    /**
     * Is this rule a match on the order? If false is returned, the shipping engine tries the next rule.
     *
     * @param Order $order
     *
     * @return bool
     */
    public function matchOrder(Order $order): bool;

    /**
     * Is this shipping rule enabled for listing and selection
     *
     * @return bool
     */
    public function getIsEnabled(): bool;

    /**
     * Stores this data as json on the orders shipping adjustment.
     *
     * @return mixed
     */
    public function getOptions();

    /**
     * Returns the percentage rate that is multiplied per line item subtotal.
     * Zero will not make any changes.
     *
     * @return float
     */
    public function getPercentageRate(): float;

    /**
     * Returns the flat rate that is multiplied per qty.
     * Zero will not make any changes.
     *
     * @return float
     */
    public function getPerItemRate(): float;

    /**
     * Returns the rate that is multiplied by the line item's weight.
     * Zero will not make any changes.
     *
     * @return float
     */
    public function getWeightRate(): float;

    /**
     * Returns a base shipping cost. This is added at the order level.
     * Zero will not make any changes.
     *
     * @return float
     */
    public function getBaseRate(): float;

    /**
     * Returns a max cost this rule should ever apply.
     * If the total of your rates as applied to the order are greater than this, an order level adjustment is made to reduce the shipping amount on the order.
     *
     * @return float
     */
    public function getMaxRate(): float;

    /**
     * Returns a min cost this rule should have applied.
     * If the total of your rates as applied to the order are less than this, the baseShippingCost
     * on the order is modified to meet this min rate.
     * Zero will not make any changes.
     *
     * @return float
     */
    public function getMinRate(): float;

    /**
     * Returns a description of the rates applied by this rule;
     * Zero will not make any changes.
     *
     * @return string
     */
    public function getDescription(): string;
}
