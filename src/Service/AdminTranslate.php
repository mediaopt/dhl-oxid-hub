<?php declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Service
 */

namespace MoptWordline\Service;

class AdminTranslate
{
    static public function trans($locale, $id)
    {
        $transJson = file_get_contents(__DIR__ . "/../Resources/snippet/storefront/wordline.$locale.json");
        $dictionary = json_decode($transJson, true);

        $exploded = explode('.', $id);

        $translation = $id;
        foreach ($exploded as $item) {
            $dictionary = self::getTranslation($item, $dictionary);
            if (is_string($dictionary)) {
                $translation = $dictionary;
            }
        }

        return $translation;
    }

    static private function getTranslation($id, $dictionary)
    {
        if (array_key_exists($id, $dictionary)) {
            return $dictionary[$id];
        }
        return false;
    }

}
