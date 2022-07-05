import './service/apiTestService';
import './component/api-test-button';

import localeDE from '../../../snippet/de_DE/wordline.de-DE.json';
import localeEN from '../../../snippet/en_GB/wordline.en-GB.json';

Shopware.Locale.extend('de-DE', localeDE);
Shopware.Locale.extend('en-GB', localeEN);
