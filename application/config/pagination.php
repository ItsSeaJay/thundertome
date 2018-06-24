<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Get a reference to CodeIgniter in order to load necessary assets
$CI = &get_instance();

// Initialize an array that determines how pagination should be configured
$config = array();


/*
|--------------------------------------------------------------------------
| Base URL
|--------------------------------------------------------------------------
|
| This is the full URL to the controller class/function containing your
| pagination. In the example above, it is pointing to a controller called
| “Test” and a function called “page”.
|
| Keep in mind that you can re-route your URI if you need a different structure.
|
*/
$config['base_url'] = base_url() . 'page';

/*
|--------------------------------------------------------------------------
| Total rows
|--------------------------------------------------------------------------
|
| By default, the URI segment will use the starting index for the items
| you are paginating. If you prefer to show the the actual page number,
| set this to TRUE.
|
*/
$config['total_rows'] = $CI->entry_model->total_entries();

/*
|--------------------------------------------------------------------------
| Results per page
|--------------------------------------------------------------------------
|
| The number of items you intend to show per page.
|
*/
$config['per_page'] = 4;

/*
|--------------------------------------------------------------------------
| Use page numbers
|--------------------------------------------------------------------------
|
| By default, the URI segment will use the starting index for the items
| you are paginating. If you prefer to show the the actual page number,
| set this to TRUE.
|
*/
$config['use_page_numbers'] = TRUE;

/*
|--------------------------------------------------------------------------
| Number of links
|--------------------------------------------------------------------------
|
| The number of “digit” links you would like before and after the selected
| page number. For example, the number 2 will place two digits on either side.
|
*/
$config['num_links'] = 0;

/*
|--------------------------------------------------------------------------
| First URL
|--------------------------------------------------------------------------
|
| An alternative URL to use for the "first page" link. leave blank 
|
*/
$config['first_url'] = base_url();
