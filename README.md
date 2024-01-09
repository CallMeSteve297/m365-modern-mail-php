# Sending Email via Modern Auth on PHP

## Prerequisites

You need to create an app registration with application permission of User.SendMail
You need to grant admin consent

## Generating the Token

You'll need to include the token.php file to use the class. See example below:

```php
$token = new graph_GetToken();                  # Creates a new Object
$token->client_secret = 'secret_here';          # Generate a secret in Entra ID
$token->client_id = 'clientid_here';            # Get Client ID from Entra ID
$token->tenant_id = 'tenantid_here';            # Get Tenant ID from Entra ID
```

You can then get the token using _one_ of the following:

```php
$token->fetch("token")                          # Fetches just the token
$token->fetch("array")                          # Fetches all info as a PHP array
$token->fetch("json")                           # Fetches all info as a JSON object
```

## Sending an Email

You can then send as many emails as required using the token.

First create the object:

```php
$email = new graph_sendMail();                  # Creates a new Email object
```

### Recipients

You can either set a single recipient:

```php
$recipients = "user1@example.com";              # Sets a single recipient
```

Or multiple recipients using an array:

```php
$recipients = array(                            # Sets multiple recipients in an array
    "user1@example.com",
    "user2@example.com"
);
```

### Message Content

You can either use plaintext with these:

```php
$email->bodytype = "text";                      # Sets body type to plain text
$email->body = $myContent;                      # Sets the body of the email, this can be a string or a variable containing a string.
```

Or with HTML

```php
$email->bodytype = "html";                      # Sets body type to HTML
$email->body = $htmlContent;                    # Sets the body of the email, this can be a string of HTML of a variable containing HTML.
```

_HTML is automatically encoded for use in a JSON_

To be helpful, the variable to turn a HTML file to HTML variable is below:

```php
$htmlContent = file_get_contents("test.html");
```

### Properties

```php
$email->token = $token->fetch("token");         # Sets the token for authentication
$email->sender = "user@example.com";            # Sets the sender of the email
$email->subject = "My Test";                    # Sets the subject
$email->recipients = $recipients;               # Sets the recipients (see above), can be a string if just one user, or a variable containing a string or array.
```

### Final Step

Once you've set all the variables, you can then send the email:

```php
echo $email->construct();                       # NOT REQUIRED - this will output the message in its final JSON format, ready to be POSTed
$email->send();                                 # If you're confused about what this does, perhaps this isn't the repo for you.
```
