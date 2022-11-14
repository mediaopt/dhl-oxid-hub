// Import all necessary Storefront plugins
import WorldlineIframePlugin from './iframe/worldline-iframe.plugin';

// Register your plugin via the existing PluginManager
const PluginManager = window.PluginManager;
PluginManager.register('WorldlineIframePlugin', WorldlineIframePlugin);
