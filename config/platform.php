<?php

return [
  'paginator' => [
    'per_page' => (string) env('APP_PAGINATOR_PER_PAGE_ATTRIBUTE', 'per_page'),
    'page' => (string) env('APP_PAGINATOR_PAGE_ATTRIBUTE', 'page'),
  ]
];
