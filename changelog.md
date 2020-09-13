# Changelog

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
