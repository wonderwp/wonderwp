# Generator

The purpose of the WonderWp framework is to allow you to write plugins rapidly, with modern development capabilities and concepts such as :

- Full object approach
- Namespacing
- Autoloading
- Dependency injection 
- Command line tools
 
To help you get started quickly, WonderWp embarks a plugin generator as a wp-cli command. Invoking the command with a few parameters will generate for you the folder structure as well as the required files to kick start your plugin evelopment..

The good thing with a generator besides the fact that is makes you gain time, is that it ensures that the generated code follows the framework guidelines. It will create the bare minimum folders and classes necessary for the plugin to work, then leaves you up and running, ready to build on top of its foundations. 

It's also an interesting way to discover what the code of a WonderWp plugin looks like with the concepts we've talked about in place (namespacing, dependency injection etc).

## How to generate a plugin? 

WonderWp provides a wp-cli command to help you generate your plugin skeleton.
It's the `generate-plugin` command and you can invoke it like so :

`wp generate-plugin --name="myPluginName" --desc="This is my plugin description" --namespace="WonderWp\Plugin\MyPluginNameSpace"`

As you can see it takes a few parameters based on which it generates the minimum files and folders:
- name : The name of your future plugin - required
- namespace : Its php object namespace - required
- Other WordPress plugin header values : 
    - desc :  A short description of the plugin, as displayed in the Plugins section in the WordPress Admin. Keep this description to fewer than 140 characters.
    - uri : The home page of the plugin, which should be a unique URL, preferably on your own website. This must be unique to your plugin. You cannot use a WordPress.org URL here.
    - version : The current version number of the plugin, such as 1.0 or 1.0.3.
    - licence : The short name (slug) of the plugin’s license (e.g. GPL2). More information about licensing can be found in the WordPress.org guidelines.
    - licence_uri : A link to the full text of the license (e.g. https://www.gnu.org/licenses/gpl-2.0.html).
    - author : The name of the plugin author. Multiple authors may be listed using commas.
    - author_uri : The author’s website or profile on another website, such as WordPress.org.
    - textdomain : The gettext text domain of the plugin. More information can be found in the Text Domain section of the How to Internationalize your Plugin page.
    - domain_path :   The domain path let WordPress know where to find the translations. More information can be found in the Domain Path section of the How to Internationalize your Plugin page.
