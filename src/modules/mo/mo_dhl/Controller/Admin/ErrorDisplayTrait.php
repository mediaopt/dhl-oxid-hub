<?php


namespace Mediaopt\DHL\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

trait ErrorDisplayTrait
{

    /**
     * @param mixed $errors
     */
    protected function displayErrors($errors)
    {
        $utilsView = Registry::get(\OxidEsales\Eshop\Core\UtilsView::class);
        $utilsView->addErrorToDisplay('MO_DHL__ERROR_WHILE_EXECUTION');
        if (!is_array($errors)) {
            $errors = [$errors];
        }
        foreach ($errors as $error) {
            if ($error instanceof \Exception) {
                $lang = Registry::getLang();
                $error = sprintf($lang->translateString('MO_DHL__ERROR_PRINT_FORMAT'), $lang->translateString($error->getMessage()), $error->getLine(), $error->getFile());
            }
            $utilsView->addErrorToDisplay($error);
        }
    }
}