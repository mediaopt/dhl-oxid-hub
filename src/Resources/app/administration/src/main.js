import './service/apiTestService';
import './service/transactionsControlService';

import './component/api-test-button';

import './extension/sw-order/view/sw-order-detail-base';

import localeDE from '../../../snippet/storefront/wordline.de-DE.json';
import localeEN from '../../../snippet/storefront/wordline.en-GB.json';

Shopware.Locale.extend('de-DE', localeDE);
Shopware.Locale.extend('en-GB', localeEN);
