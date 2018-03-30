# Plugin Deactivator

Create a class that implements the `DeactivatorInterface`.

```
class MyPluginDeactivator implements DeactivatorInterface{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {

	}

}
```
The code within the deactivate method will be executed upon plugin deactivation