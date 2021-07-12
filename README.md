# Groepsadmin PHP Client

This is a simple PHP package that can be used to peform API calls towards the 'scouts en gidsen vlaanderen' groepsadmin API. Please note that access to the API must be requested, for which you are responsible.

## Installation

For now, this package won't be published to packagist until I'm somewhat sattisfied with the state it is in. The preferred way of installing is through [composer repositories](https://getcomposer.org/doc/04-schema.md#repositories).

## Usage

You will always have to create a client in order to authenticate with the API. 

```php
use Wouterh\GroepsadminClient\Client;

$client = new Client(
	'resource', //This value will be provided by 'scouts en gidsen vlaanderen' when requesting API access.
  'https://myscoutssite.be/groepsadmin/callback' //The URI you'll be redirected to after authenticating with groepsadmin.
);
```

After setting up a client, you'll be able to create a URL to redirect to in order to authenticate.

```php
return new RedirectResponse(
	$client->getAuthenticationProvider()->getAuthenticationData()->getAuthenticationUrl()
);
```

Please note that the authentication data object not only contains the authentication URL, but also an oauth state, this state should be stored somewhere server-side (database, sessions,...) temporarily. After the authentication flow is completed, a state query parameter will be available on your redirect URI which should contain the same value. The wrapper does not perform this check for you, it should be checked in your application to prevent CSRF attacks!

After the authentication took place, you'll be redirected back to the specified redirect URI. A `code` query parameter will be added to the URL, you can use this variable to obtain an oauth token.

```php
$token = $client->getAuthenticationProvider()->getAccessToken(
	$_GET['code']
);
```

Now, we have everything to perform calls to get (or update) actual data. Please note that only a limited amount of calls is supported right now. If you need additional calls, don't hesitate to create an issue. Documentation for currently implemented calls won't be made available either, as most of them are pretty self explanatory and autocompletion should provide enough details.

```php
use Wouterh\GroepsadminClient\Call\GetMemberlist;

$call = new GetMemberlist($client);
$members = $call->perform();
```

## Token Storage

By default, you will receive a token from the library and you're responsible to perform the necessary access token refreshes. However, there's a way to make this somewhat less cumbersome. You can implement your own 'Token Storage' class. This should implement the `Wouterh\GroepsadminClient\Token\TokenStorageInterface` interface. You can then provide the token storage to the client constructor.

```php
use Wouterh\GroepsadminClient\Client;

$client = new Client(
	'resource' 
  'https://myscoutssite.be/groepsadmin/callback',
  new TokenStorage // or whatever you called your token storage class
);
```

Access token refreshes will now be made automatically and stored in your token storage.
