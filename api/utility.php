<?php
    function check_password_format(string $password) : bool {
        $password_matcher = '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!#\$%&\(\)\*\+,\-\.\/:;<=>\?@[\]_\{\|}~])[a-zA-Z0-9!#\$%&\(\)\*\+,\-\.\/:;<=>\?@[\]_\{\|}~]{8,16}$/';

        return preg_match($password_matcher, $password) === 1;
    }

    function check_email_format(string $email) : bool {
        $email_matcher = '/^([a-zA-Z0-9_\-.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(]?)$/';

        return preg_match($email_matcher, $email) === 1;
    }