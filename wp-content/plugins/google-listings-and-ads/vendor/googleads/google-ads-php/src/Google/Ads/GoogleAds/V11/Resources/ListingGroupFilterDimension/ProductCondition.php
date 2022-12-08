<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v11/resources/asset_group_listing_group_filter.proto

namespace Google\Ads\GoogleAds\V11\Resources\ListingGroupFilterDimension;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Condition of a product offer.
 *
 * Generated from protobuf message <code>google.ads.googleads.v11.resources.ListingGroupFilterDimension.ProductCondition</code>
 */
class ProductCondition extends \Google\Protobuf\Internal\Message
{
    /**
     * Value of the condition.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v11.enums.ListingGroupFilterProductConditionEnum.ListingGroupFilterProductCondition condition = 1;</code>
     */
    protected $condition = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $condition
     *           Value of the condition.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V11\Resources\AssetGroupListingGroupFilter::initOnce();
        parent::__construct($data);
    }

    /**
     * Value of the condition.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v11.enums.ListingGroupFilterProductConditionEnum.ListingGroupFilterProductCondition condition = 1;</code>
     * @return int
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Value of the condition.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v11.enums.ListingGroupFilterProductConditionEnum.ListingGroupFilterProductCondition condition = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCondition($var)
    {
        GPBUtil::checkEnum($var, \Google\Ads\GoogleAds\V11\Enums\ListingGroupFilterProductConditionEnum\ListingGroupFilterProductCondition::class);
        $this->condition = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ProductCondition::class, \Google\Ads\GoogleAds\V11\Resources\ListingGroupFilterDimension_ProductCondition::class);

