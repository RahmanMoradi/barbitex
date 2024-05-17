<?php

return array(
    'action' => 'http://#/modules/forms/submit.php',
    'forms' => array(
        'mailchimp' => array(
            'inputs_allowed'   => array( 'email' ),
            'inputs_required' => array( 'email' ),
            'message_success' => 'عضویت با موفقیت انجام شد',
            'api_key' => '#',
            'list_id' => '#'
        ),
        'standard'  => array(
            'email'           => 'info@domain.com',
            'email_subject'   => 'Mail from site',
            'inputs_allowed'   => array( 'name', 'lastname', 'email', 'subject', 'message' ),
            'inputs_required' => array( 'name', 'lastname', 'email', 'message' ),
            'message_success' => 'ییام با موفقیت ارسال شد',
        )
    )
);
