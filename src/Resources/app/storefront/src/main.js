import AgeRestrictionPlugin from './plugin/age-restriction.plugin';

const PluginManager = window.PluginManager;
PluginManager.register('AgeRestrictionPlugin', AgeRestrictionPlugin, '[data-sy-age-restriction-plugin="true"]');