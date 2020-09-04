<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class ArticlesDHLController extends AbstractAdminDHLController
{

    /**
     * @return string
     */
    protected function moDHLGetTemplateName() : string
    {
        return 'mo_dhl__article_dhl.tpl';
    }

    /**
     * @return string
     */
    protected function moDHLGetBaseClassName() : string
    {
        return \OxidEsales\Eshop\Application\Model\Article::class;
    }
}
