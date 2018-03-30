# Plugin file architecture

This is a sample definition. Your plugin could have much less files (just the includes and admin folders for example)

- admin //All related admin resources
    - views
        - my-plugin-view-a.php
	- css
		- my-plugin-admin.css
	- js
		- my-plugin-admin.js 
- includes //All the autoloaded classes
	-  Controller
		- AdminController.php //Backend Controller
		- PublicController.php //FrontEnd Controller
    - [...]
	-  Services
		- HookService.php
		- Activator.php //Activation routine (table creation)
		- Deactivator.php //Deactivation routine (if any)
		- [...]
   - Manager.php //Main entry point
- languages //language files
    - myplugin.pot, .mo, .po
- public //All related public resources
	- css 
		- my-plugin-public.css
	- js
		- my-plugin-public.js  
	- views
- index.php //Silence is golden
- myplugin.php //Plugin bootstrap file
