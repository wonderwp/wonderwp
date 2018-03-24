# wonderwp

This is a WordPress **framework** whose goal is to give WordPress **industrial development capabilities**.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/16dde2bb-f6ce-4972-b924-1ca2e5d6f9cd/big.png)](https://insight.sensiolabs.com/projects/16dde2bb-f6ce-4972-b924-1ca2e5d6f9cd)

## Who is it for?

Probably not everyone.

This framework could interest you if

- You are willing to adopt an industrial and modern development process.
- You are faced with projects that are a true fit for a CMS but also include serious code challenges.
- You have industrial development needs such as high production volumes, repeatable solutions, in house production teams. 
- You are looking at capitalizing on previous projects to build up reusable plugins and themes. Plugins and themes produced with wonderwp are meant to be full object, consistent, predictable, composerable, testable, and durable.
- You are used to frameworks and less to CMSs

## What does wonderwp add to WordPress?

### Overview

- Composer capabilities / Autoloading
- Dependency injection container
- Convert procedurals concepts into Object Oriented Interfaces, and PSRs, and implementations such as
	- Routing
	- Cache
	- Forms
	- HTTP foundation
	- Logging
	- Emails
	- Medias
	- Notification
	- Post Panels
	- Search Engine
- Services, aka classes to work with
	- Activator / Deactivator
	- Routing
	- Assets Management
	- Ajax endpoints
	- Shortcodes
	- WP-CLI commands
- MVC mechanic
- Plugin blueprint (folder organisation, naming conventions, full object approach, empty function.php file) 

### In a bit more depth

#### Composer

We wanted to make sure our WonderWp based work could play well with composer. This framework is therefore on packagist here : [https://packagist.org/packages/wonderwp/framework]()

You can install it like this:

```
composer require wonderwo/framework
```

For the moment, the framework is only installable via composer but we've planned to release a plugin version as well in the future.

For a composer based WordPress architecture, we recommend [https://roots.io/bedrock/](bedrock).

Composer also embarks an autoloader to avoid the need for requiring files everywhere in your plugins. The framework encourages you to follow the PSR4 recommendation and to interact with the autoloader.

#### Dependency Injection / interfaces and services

We wanted our code to be as modular as possible and bring dependency injection capabilities to WordPress.

When working with a dependency injection container, you open up the possibility to switch the object that's going to be used behind the key you request from the container as long as it implements a given interface. Because if it does, you'll be sure that is object exposes the public methods required for your code to run properly.

That's why in addition to add a DI container, we've also added many interfaces to work with WordPress core concepts, and wider programming concepts, (Emails, Routing, Logging, Caching)...

#### Services 

Trying to follow good object oriented principles, we encourage developers throught the use of this framework to adopt a few concepts.

- Full object plugins, no procedural code
- One object per type of task, aka services, which aim is to have one responsibility only. This applies to Hook management, shortcode management, assets management, routing managements, shortcode management and so on.

#### MVC

Following the full object philosophy, shortcodes or custom routes resulting in a public or admin output are managed by controllers. Controllers work with services to get the data they need, and pass that to views. Views do not have a templating engine for the moment by default as dependency in this framework, but you could easily add your own.

#### Plugin blueprint

This framework proposes a way of organizing folders following the PSR4 recommendation for classes, an admin folder for your plugin admin side, and a public folder for your plugin public side, but nothing's sompulsary, you can do as you whish.

There's also a plugin generator to help you quick start your plugin development.

## Documentation

You can find much more detailled documentation within the documentation folder.

## Tests

Command to launch the tests : 

`vendor/bin/phpunit tests/suites --bootstrap tests/bootstrap.php  --coverage-html tests/reports/coverage.html --whitelist src/WonderWp/Framework --log-junit tests/reports/phunit.xml`

## Contributing

- You can contribute to this project by forking this repository and proposing pull requests
- We're looking for unit test contributors
