<?php

namespace Mediaopt\DHL\Api;

use GuzzleHttp\Exception\RequestException;
use Mediaopt\DHL\Exception\WebserviceException;

class Warenpost extends Base
{
    /**
     * @var string
     */
    const PARTNER_ID = 'DP_LT';

    /**
     * @var string
     */
    const KEY_PHASE = '1';

    /**
     * @var string
     */
    protected $authorizationKey;

    /**
     * @var string
     */
    protected $authorizationName;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getOAuthToken(): string
    {
        $credentials = $this->getCredentials();
        $this->authorizationKey = base64_encode($credentials->getUsername() . ':' . $credentials->getPassword());
        $this->authorizationName = 'Basic';
        $authString = $this->callApi('v1/auth/accesstoken');
        $auth = explode('userToken>', $authString);//todo nice xml parser
        return substr($auth[1], 0, strlen($auth) - 2);
    }

    /**
     * @return string
     */
    public function createShipmentOrder($order)
    {
        $this->authorizationKey = $this->getOAuthToken();
        $this->authorizationName = 'Bearer';
        $order = $order->getOrder();
        $credentials = $this->credentials;
        $order['customerEkp'] = $credentials->getEkp();
        $order = $this->callApi(
            'dpi/shipping/v1/orders',
            ['body' => json_encode($order)],
            'post'
        );
        $order = json_decode($order);
        return $order;
    }

    public function getLabel($awb)
    {
        $this->authorizationKey = $this->getOAuthToken();
        $this->authorizationName = 'Bearer';
        $buildRequestOptions = $this->buildRequestOptions();
        $headers = [];
        foreach ($buildRequestOptions['headers'] as $key => $header) {
            $headers[] = "$key: $header";
        }
        $fileUrl = "https://api-qa.deutschepost.com/dpi/shipping/v1/shipments/$awb/itemlabels";
        $label = tempnam(sys_get_temp_dir(), 'label') . '.pdf';// . '.pdf';
        $fp = fopen($label, 'w+');
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $fileUrl,
            CURLOPT_FILE => $fp,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=\"" . basename($label) . "\";");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($label));
        ob_clean();
        flush();
        readfile($label);
    }

    protected function buildRequestOptions()
    {
        $requestTimestamp = date('dmY-His');
        $partnerSignature = $this->buildPartnerSignature($requestTimestamp);

        return [
            'headers' => [
                'KEY_PHASE' => self::KEY_PHASE,
                'PARTNER_ID' => self::PARTNER_ID,
                'REQUEST_TIMESTAMP' => $requestTimestamp,
                'PARTNER_SIGNATURE' => $partnerSignature,
                'Authorization' => "$this->authorizationName $this->authorizationKey",
            ]
        ];
    }

    /**
     * @param $requestTimestamp
     * @return string
     */
    protected function buildPartnerSignature($requestTimestamp): string
    {
        $string = implode('::', [self::PARTNER_ID, $requestTimestamp, self::KEY_PHASE, $this->authorizationKey]);
        $md5 = md5($string);
        return substr($md5, 0, 8);
    }

    /**
     * @param string $relativeUrl
     * @param array $options
     * @param string $method
     *
     * @return \stdClass
     * @throws WebserviceException
     */
    protected function callApi($relativeUrl, $options = [], $method = 'get')
    {
        if ($options === [] && array_key_exists($relativeUrl, $this->memoizations)) {
            return $this->memoizations[$relativeUrl];
        }

        $url = $this->buildUrl($relativeUrl);
        $requestOptions = array_merge($options, $this->buildRequestOptions());
        $this->getLogger()->debug(__METHOD__ . " - API call with $url", ['options' => $requestOptions]);

        try {
            $response = $this->getClient()->{$method}($url, $requestOptions);
            $body = $response->getBody();
            $payload = $body !== null ? $body->getContents() : '';
            if ($payload === '') {
                $message = __METHOD__ . " - The API call to $url returned an empty body";
                $this->getLogger()->error($message, ['response' => $response]);
                throw new WebserviceException('API returned an empty body.');
            }

            return $payload;
        } catch (RequestException $exception) {
            $message = __METHOD__ . " - The API call to $url failed due to {$exception->getMessage()}";

            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
    }


    /**
     * @param string $relativeUrl
     * @return string
     */
    protected function buildUrl($relativeUrl): string
    {
        return "{$this->getCredentials()->getEndpoint()}/$relativeUrl";
    }
}