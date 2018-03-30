# What if I want to ...

## ...add an admin or public controller
See the dedicated section in the controllers section.

## ...add a hook
If your plugin doesn't have a hook service yet, create one and register it in your manager (see the doc for this in the services > Hook Service section)

Add your hook inside the HookService `run` method

## ...add assets

If your plugin doesn't have an asset service yet, create one and register it in your manager (see the doc for this in the services > Asset Service section)

Add your assets inside the AssetService `getAssets` method

## ...work with Ajax

If your plugin doesn't have an api service yet, create one and register it in your manager (see the doc for this in the services > Api Service section).

Every public method defined in this file can then be used as an ajax ednpoint.

## ...create a new route

If your plugin doesn't have a route service yet, create one and register it in your manager (see the doc for this in the services > Route Service section)

Add your assets inside the RouteService `getRoutes` method

## ...create a wp-cli command

If your plugin doesn't have a task service yet, create one and register it in your manager (see the doc for this in the services > Task Service section)

## ...add a shortcode

If your plugin doesn't have a shortcode service yet, create one and register it in your manager (see the doc for this in the services > Shortcode Service section)

Add your shortcodes inside the AssetService `registerShortcodes ` method
