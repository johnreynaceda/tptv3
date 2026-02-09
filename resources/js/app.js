import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)
window.Alpine = Alpine;

// Don't auto-start Alpine - let it be started after WireUI registers its components
// Alpine.start() will be called in the layout after @wireUiScripts
