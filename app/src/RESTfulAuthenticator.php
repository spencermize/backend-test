<?php
namespace Spencer\Booker;
use SilverStripe\Security\Security;

class SessionAuthenticator {
    public static function authenticate() {
        return Security::getCurrentUser();
    }
}