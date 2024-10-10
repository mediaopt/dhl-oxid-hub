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
            while ($error) {
                $nextError = method_exists($error, 'getPrevious') ?  $error->getPrevious() : null;
                if ($error instanceof \Exception) {
                    $lang = Registry::getLang();
                    $error = sprintf($lang->translateString('MO_DHL__ERROR_PRINT_FORMAT'), $lang->translateString($error->getMessage()), $error->getLine(), $error->getFile());
                }
                $utilsView->addErrorToDisplay($error);
                $error = $nextError;
            }
        }
    }


    /**
     * @param array     $payload
     * @param int|false $index   if specified only errors for the given index will be returned
     * @return string[]
     */
    public function extractErrorsFromResponsePayload(array $payload, $index = false): array
    {
        $errors = [];
        $items = $index !== false ? [$payload['items'][$index]] : $payload['items'];
        foreach ($items as $error) {
            if (\array_key_exists('validationMessages', $error)) {
                foreach ($error['validationMessages'] as $validationMessage) {
                    $errors[] = "{$validationMessage['validationMessage']} ({$validationMessage['property']})";
                }
                continue;
            }
            if (\array_key_exists('message', $error)) {
                $errors[] = "{$error['message']} ({$error['propertyPath']})";
            }
        }
        if ($errors !== []) {
            return $errors;
        }
        return \array_key_exists('detail', $payload) && $index === false ? [$payload['detail']] : [];
    }
}