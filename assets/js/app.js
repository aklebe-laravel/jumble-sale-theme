import 'bootstrap';

// Important to avoid 'bootstrap is not defined' in product view
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import * as jumbleSale from '../../../../Modules/Market/resources/assets/js/jumbleSale';
window.jumbleSale = jumbleSale;

