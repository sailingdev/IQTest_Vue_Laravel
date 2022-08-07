<?php

return [
    'initial_price'     => env('INITIAL_PAY_AMOUNT', 1.9583),
    'extra_price'       => env('EXTRA_PAY_AMOUNT', 38.033),
    'stripe_pk_key'     => env('STRIPE_SECRET', null),
    'text_book_name'    => env('ADVANCED_TEXT_BOOK_NAME', null)
];