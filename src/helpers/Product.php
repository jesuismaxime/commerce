<?php

namespace craft\commerce\helpers;

use craft\commerce\elements\Product as ProductModel;
use craft\commerce\elements\Variant;
use craft\commerce\Plugin;
use craft\helpers\DateTimeHelper;
use craft\helpers\Localization as LocalizationHelper;

/**
 * Class CommerceVariantMatrixHelper
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
class Product
{
    // Public Methods
    // =========================================================================

    /**
     * Populates a Product model from HUD or POST data
     *
     * @param ProductModel $product
     * @param              $data
     */
    public static function populateProductModel(ProductModel $product, $data)
    {
        if (isset($data['typeId'])) {
            $product->typeId = $data['typeId'];
        }

        if (isset($data['enabled'])) {
            $product->enabled = $data['enabled'];
        }

        $product->postDate = (($postDate = $data['postDate']) ? DateTimeHelper::toDateTime($postDate) : $product->postDate);
        if (!$product->postDate) {
            $product->postDate = new \DateTime();
        }
        $product->expiryDate = (($expiryDate = $data['expiryDate']) ? DateTimeHelper::toDateTime($expiryDate) : null);

        $product->promotable = $data['promotable'];
        $product->freeShipping = $data['freeShipping'];
        $product->taxCategoryId = $data['taxCategoryId'] ?: $product->taxCategoryId;
        $product->shippingCategoryId = $data['shippingCategoryId'] ?: $product->shippingCategoryId;
        $product->slug = $data['slug'] ?: $product->slug;
    }

    /**
     * Populates all Variant Models from HUD or POST data
     *
     * @param ProductModel  $product
     * @param               $variant
     * @param               $key
     *
     * @return Variant
     */
    public static function populateProductVariantModel(ProductModel $product, $variant, $key): Variant
    {
        $productId = $product->id;

        if ($productId && $key !== 'new') {
            $variantModel = Plugin::getInstance()->getVariants()->getVariantById($key, $product->siteId);
        } else {
            $variantModel = new Variant();
        }

        $variantModel->setProduct($product);
        $variantModel->enabled = $variant['enabled'] ?? 1;
        $variantModel->isDefault = $variant['isDefault'] ?? 0;
        $variantModel->sku = $variant['sku'] ?? '';
        $variantModel->price = LocalizationHelper::normalizeNumber($variant['price']);
        $variantModel->width = isset($variant['width']) ? LocalizationHelper::normalizeNumber($variant['width']) : null;
        $variantModel->height = isset($variant['height']) ? LocalizationHelper::normalizeNumber($variant['height']) : null;
        $variantModel->length = isset($variant['length']) ? LocalizationHelper::normalizeNumber($variant['length']) : null;
        $variantModel->weight = isset($variant['weight']) ? LocalizationHelper::normalizeNumber($variant['weight']) : null;
        $variantModel->stock = isset($variant['stock']) ? LocalizationHelper::normalizeNumber($variant['stock']) : null;
        $variantModel->unlimitedStock = $variant['unlimitedStock'];
        $variantModel->minQty = LocalizationHelper::normalizeNumber($variant['minQty']);
        $variantModel->maxQty = LocalizationHelper::normalizeNumber($variant['maxQty']);

        if (isset($variant['fields'])) {
            $variantModel->setFieldValuesFromRequest('fields');
        }

        if (isset($variant['title'])) {
            $variantModel->title = $variant['title'] ?: $variant->title;
        }

        return $variantModel;
    }
}
