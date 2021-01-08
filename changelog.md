# Changelog

## 1.2.0
- wonderwp/form pushed to version 1.1.1
    - In which the textdomain can now be set in the constructor of CategoryRadioField and CategoriesCheckBoxesField objects.
- wonderwp/repository pushed to version 1.1.0
    - In which a new TaxonomyRespository has been added.
- wonderwp/media pushed to version 1.1.0
    - In which a new mediaSrcAtSize method has been added to the Medias class.
- wonderwp/notification pushed to version 1.0.1
    - In which constructor parameters have been made optional.
- wonderwp/form pushed to version 1.1.0
    - In which a new TimeField has been created.
- wonderwp/generator pushed to version 1.0.6
    - In which a chown warning upon folder generation has been fixed.
- wonderwp/asset pushed to version 1.0.4 then 1.0.4
    - At 1.0.4 array_key_exists conditions have been replaced by property_exists conditions to fix php 7.4 deprecated warnings.
    - At 1.0.5 the specific used protocol has been added to assets urls when encoded by the jsonAssetsEnqueur. It's not relative anymore. Also a new filter (wwp.JsonAssetsEnqueur.blogUrl) is present on this enqueur blogUrl in the cosntructor.
- wonderwp/customposttype pushed to version 1.0.11
    - In which the saving of a boolean field with empty value has been improved
- wonderwp/panel pushed to version 1.0.1 then 1.1.0
    - At 1.0.1 : two minor checks have been added in the PanelManager
    - At 1.1.0 : The serialisation and unserialiastion of structured data to and from the database is now delegated to the panel object. It's a non breaking change allowing developers to specify their own serialisation mechanism per panel if needed. Default stays `serialize`/`unserialize`

## 1.1.0

Can contain minor breaking changes due to the following :

- wonderwp/plugin-skeleton pushed to version 1.1.2.<br/>
    - New Registrable interface
    - Hook Services, Shortcode Services and Task services must now implement the Registrable Interface
- wonderwp/hook pushed to version 1.0.2
    - In which Hook Services now implement the Registrable Interface
- wonderwp/shortcode pushed to version 1.0.1
   - In which Shortcode Services now implement the Registrable Interface
- wonderwp/task pushed to version 1.0.1
    - In which Task Services now implement the Registrable Interface
- wonderwp/generator pushed to version 1.0.6
    - In which the generator now generates those services with the right register method to implement the Registrable interface properly

### Migration path

If you have errors in your code about :
- Hooks Services that have a missing register method : rename the `run` method by `register` instead. You may have `parent::run` calls that need to be replaced by `parent::register` as well.
- Shortcode services that have a missing register method : rename the `registerShortcodes` method by `register` instead. You may have `parent::registerShortcodes` calls that need to be replaced by `parent::register` as well.
- Task services services that have a missing register method : rename the `registerCommands` method by `register` instead. You may have `parent::registerCommands` calls that need to be replaced by `parent::register` as well.
