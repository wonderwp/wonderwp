# Changelog

## 1.5.0

- wonderwp/form pushed to version 1.4.0, in which a new color input field has been made available.
- wonderwp/asset pushed to version 2.0.0. This is a new major version, which includes breaking changes.
- wonderwp/plugin-skeleton pushed to version 1.4.0, in which the reference to wonderwp/asset has been updated to ^2.0.


### Migration path

If you have errors in your code about assets enqueuer declaration, check the [asset component documentation](http://wonderwp.net/Framewok_components/Assets/index.html) to verify that the way you declare enqueuers is the same as what is shown in the documentation because the constructor parameters have changed.

## 1.4.0

This version is solely aimed at raising the minimum PHP version to >= 7.1 across the entire framework.

- wonderwp/api pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/asset pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/cache pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/customposttype pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/dependency-injection pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/filter pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/form pushed to version 1.3.0 : raising minimum PHP version to >= 7.1
- wonderwp/functions pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/hook pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/http pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/logging pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/mailing pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/media pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/notification pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/panel pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/plugin-skeleton pushed to version 1.3.0 : raising minimum PHP version to >= 7.1
- wonderwp/repository pushed to version 1.3.0 : raising minimum PHP version to >= 7.1
- wonderwp/routing pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/search pushed to version 1.2.0 : raising minimum PHP version to >= 7.1
- wonderwp/service pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/shortcode pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/task pushed to version 1.1.0 : raising minimum PHP version to >= 7.1
- wonderwp/template pushed to version 1.2.0 : raising minimum PHP version to >= 7.1


## 1.3.0

- wonderwp/generator-wwp pushed to version 2.0.0
  - In which a very big refactoring has been made for a better generator overridability via ContentProviders.
  - /!\ Warning, this is probably a breaking change if you've overridden/extended the generator in the past for your own use. Otherwise, it shouldn't be.
- wonderwp/plugin-skeleton pushed to version 1.2.0 then 1.2.1
  - At 1.2.0 the default admin action has been improved.
  - At 1.2.1 a dependency version issue has been fixed.
- wonderwp/template pushed to version 1.1.0
  - In which back-office views have been made more flexible, and new template frag (t_content) is available
- wonderwp/asset pushed to version 1.0.6
  - In which a minor fix has been applied to the JsonAssetsExporter if no JS files are provided.
- wonderwp/logging pushed to version 1.1.0
  - In which :
    - A new `success` method has been added to the `LoggerInterface`
    - A new logger `WpCliLogger` has been created. It uses WP_CLI logging functions under the interface declaration
    - A new logger `VoidLogger` has been created. It respects the interface but does not output anything.
- wonderwp/cache pushed to version 1.0.1
  - In which a bug has been fixed in the `TransientCache`::`has` method.
- wonderwp/CPT pushed to version 1.0.12
  - In which a bug when a CPT registers an existing taxonomy has been fixed.
- wonderwp/form pushed to version 1.2.0 then 1.2.1
  - At 1.2.0 :
    - The `getCategories` method has been changed from private to protected to allow overrides.
    - The Select Category Field now represents hierarchy in options with the use of a spacer.
  - At 1.2.1 :
    - Validator : better exception handling - new exception filter - fieldErrors more specific keys
- wonderwp/search pushed to version 1.1.0
  - In which the search query has been changed from a string concatenation mechanism to a basic array query builder to ease its manipulation and overridability.
- wonderwp/api pushed to version 1.1.0 then 1.1.1
  - At 1.1.0 : You can now use annotations on Api Services to register methods to execute via the wp JSON API instead of the admin_ajax endpoint.
  - At 1.1.1 : Better WP JSON API annotations handling of required parameters (esp `permission_callback`)
- wonderwp/repository pushed to version 1.2.0
  - In which a new repository has been added: the `UserRepository`

## 1.2.0

- wonderwp/form pushed to version 1.1.1
  - In which the textdomain can now be set in the constructor of `CategoryRadioField` and `CategoriesCheckBoxesField` objects.
- wonderwp/repository pushed to version 1.1.0
  - In which a new `TaxonomyRespository` has been added.
- wonderwp/media pushed to version 1.1.0
  - In which a new `mediaSrcAtSize` method has been added to the `Medias` class.
- wonderwp/notification pushed to version 1.0.1
  - In which constructor parameters have been made optional.
- wonderwp/form pushed to version 1.1.0
  - In which a new `TimeField` has been created.
- wonderwp/generator pushed to version 1.0.6
  - In which a chown warning upon folder generation has been fixed.
- wonderwp/asset pushed to version 1.0.4 then 1.0.4
  - At 1.0.4 `array_key_exists` conditions have been replaced by `property_exists` conditions to fix PHP 7.4 deprecated warnings.
  - At 1.0.5 the specific used protocol has been added to assets URLs when encoded by the `jsonAssetsEnqueur`. It's not relative anymore. Also a new filter (`wwp.JsonAssetsEnqueur.blogUrl`) is present on
    this enqueuer blogUrl in the constructor.
- wonderwp/customposttype pushed to version 1.0.11
  - In which the saving of a boolean field with empty value has been improved
- wonderwp/panel pushed to version 1.0.1 then 1.1.0
  - At 1.0.1 : two minor checks have been added in the PanelManager
  - At 1.1.0 : The serialization and unserialization of structured data to and from the database are now delegated to the panel object. It's a non-breaking change allowing developers to specify their own serialization mechanism per panel if needed. The default one stays `serialize`/`unserialize`

## 1.1.0

Can contain minor breaking changes due to the following :

- wonderwp/plugin-skeleton pushed to version 1.1.2.<br/>
  - New `Registrable` interface
  - Hook Services, Shortcode Services, and Task services must now implement the `Registrable` Interface
- wonderwp/hook pushed to version 1.0.2
  - In which Hook Services now implement the `Registrable` Interface
- wonderwp/shortcode pushed to version 1.0.1
  - In which Shortcode Services now implement the `Registrable` Interface
- wonderwp/task pushed to version 1.0.1
  - In which Task Services now implement the `Registrable` Interface
- wonderwp/generator pushed to version 1.0.6
  - In which the generator now generates those services with the right register method to implement the `Registrable` interface properly

### Migration path

If you have errors in your code about :

- Hooks Services that have a missing register method: rename the `run` method by `register` instead. You may have `parent::run` calls that need to be replaced by `parent::register` as well.
- Shortcode services that have a missing register method: rename the `registerShortcodes` method by `register` instead. You may have `parent::registerShortcodes` calls that need to be replaced
  by `parent::register` as well.
- Task services that have a missing register method: rename the `registerCommands` method by `register` instead. You may have `parent::registerCommands` calls that need to be replaced
  by `parent::register` as well.
