# Api Service

Defining ajax entry points for your plugin can feel a bit messy in a sense that it works with hooks. Those hooks could be defined at multiple places (unless you create a hook service), and for each hook defined, you associate a callable that can be a function, an object method somewhere, or somewhere else.

The idea behind the Api Service is to provide a class that will act as an API controller to gather all the API logic, and that can be used to abstract and ease ajax endpoints registration.

## How to create an Api Service
Create a class that extends the `AbstractApiService` class. The `AbstractApiService` class implements the `ApiServiceInterface`.

```
class MyPluginApiService extends AbstractApiService
{
	//All the public methods defined in this service can be used as an ajax endpoint
}
```
All the public methods defined in this service can be used as an ajax endpoint! No more hook definition, you just create the API service, and then declare public methods in it. Those methods can now be accessed via JavaScript calls.

## Registering the Api Service
Add these few lines inside your plugin manager.

```
//Api
$this->addService(AbstractService::$APISERVICENAME, function(){
    return new MyPLuginApiService();
});
```

## How to access my ApiService method from the JavaScript

Make an ajax call to the ajaxurl global variable

```
jQuery.post(
	ajaxurl, //The ajaxurl global variable
	{ 
		action: 'MyApiServiceName.myApiServiceMethod', 
		otherParamKey: otherParamVal
	}, 
	function (response) {}
);
```

In this call, pass some object paramaters. This object should contain an action key, whose val should be the name of your api service class, then a '.', then the method you'd like to call. 

You can also defined som more parameters that will be passed to the service's method.

## Result

In an attempt to standardize api call responses, we've created a Result object that takes two arguments, an http response code, and an array of data.

In practice, in your api methods, you could end the method with something like this:

```
$response = new Result(
	200, //Your HTTP code
	[ 
    	'settings'=>$formView,
    	'visibleFields'=>$visibleFields
	] //Your array of data
);

return $this->respond($response); //The respond method is also a standard method to end api calls
```

I tend to find this Result object practical, and to use it even in not api related actions, (like form submission services for example).
