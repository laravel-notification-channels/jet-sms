# Changelog

All notable changes to `JetSms` will be documented in this file

## 2.0.0 - 2017-02-28

_This update includes api-breaking changes._

- JetSms client functionality is not handed by this package anymore.
- Inherits the common functionality from `erdemkeren/jet-sms-php`.
- Replaces the `JetSMSMessage` class with `ShortMessage` class.
- Adds `MessagesWereSent` and `SendingMessages` events.
- All class names and namespaces which contains `JetSMS` has been changed with `JetSms` for better camel case support.
- Updates test for new implementations.
- Updates docs.

## 1.0.0 - 2016-11-22
- First release of the package.
