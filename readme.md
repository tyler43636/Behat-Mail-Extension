# Behat Mail Extension
## Supported Drivers
- [MailCatcher](http://mailcatcher.me/)
- [Mailtrap.io](https://mailtrap.io/)

## Installation
Require `tpayne/behat-mail-extension` using composer
```
composer require tpayne/behat-mail-extension --dev
```
or add it manually to the require-dev section of your `composer.json` file.
```
"require-dev": {
  	"tpayne/behat-mail-extension": "~1.0"
},
```

## Configure your context
Setup your feature context to use the Behat Mail Extension

1) Implement the MailAwareContext in your feature context.

2) Use the Mail [trait](http://php.net/manual/en/language.oop5.traits.php) in your context.

```
use tPayne\BehatMailExtension\Context\MailAwareContext;
use tPayne\BehatMailExtension\Context\MailTrait;

class FeatureContext implements MailAwareContext {
    use MailTrait;
```
Using the mail trait will add a mail property to your feature context.

## behat.yml
Chose one of the following configurations for your `behat.yml` file.

### Defaults
If no drivers are specified the following defaults will be used:

- `driver`: **mailcatcher** 
- `base_url`: **localhost**
- `http_port`: **1080**

```
default:
    extensions:
        tPayne\BehatMailExtension\ServiceContainer\MailExtension
```
 
### MailCatcher
Add the MailExtension to your `behat.yml` file:

```
default:
    extensions:
        tPayne\BehatMailExtension\ServiceContainer\MailExtension:
            driver: mailcatcher
            base_url: localhost # optional
            http_port: 1080 # optional
```
### Mailtrap.io
Add the MailExtension to your `behat.yaml` file:

```
default:
    extensions:
        tPayne\BehatMailExtension\ServiceContainer\MailExtension:
            driver: mailtrap
            api_key: MAIL_TRAP_KEY
            mailbox_id: MAILBOX_ID
```

## Usage

The Behat Mail Extension will automatically clear messages from the inbox when runing scenarios tagged with `@mail`

```
Feature: App Registration
  In order to join the site
  As a guest
  I want to register for an account

  @mail
  Scenario: Register an account
    Given I am a guest
    When I register for an account
    Then I should receive a welcome email
    
```

Access the mail property from your feature context to test any emails sent.

```
    /**
     * @Then I should receive a welcome email
     */
    public function iShouldReceiveAWelcomeEmail()
    {
        $message = $this->mail->getLatestMessage();

        PHPUnit_Framework_Assert::assertEquals('Welcome!', $message->subject());
        PHPUnit_Framework_Assert::assertContains('Please confirm your account', $message->plainText());
    }
```

### The Mail Driver API
The mail driver, accessible via the mail property on the feature context, offers the following methods:

- `getMessages()`
- `getLatestMessage()`
- `deleteMessages()` (This is called automatically after scenarios tagged `@mail`)

### The Message API
The mail driver will return a message object with the following API:

- `to()`
- `from()`
- `subject()`
- `plainText()`
- `html()`
- `date()`
