<?php

namespace craft\commerce\controllers;

/**
 * Class Base Admin Controller
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
class BaseAdminController extends BaseController
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        // All system setting actions require an admin
        $this->requireAdmin();

        parent::init();
    }
}
