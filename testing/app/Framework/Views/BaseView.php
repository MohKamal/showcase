<?php
/**
 * Includes must be on the views
 */
namespace Showcase;

use \Showcase\Framework\Initializer\VarLoader;
use \Showcase\Framework\Session\SessionAlert;
use \Showcase\Framework\HTTP\Links\URL;
use \Showcase\Framework\IO\Debug\Log;
use \Showcase\Framework\HTTP\Gards\Auth;
use \Showcase\Framework\HTTP\Gards\CSRF;
use \Showcase\Framework\Session\Session;
use \Showcase\Framework\Session\Cookie;
use \Showcase\Framework\Database\DB;
use \Showcase\Framework\IO\Storage\Storage;
use \Showcase\Framework\Utils\Utilities;

$csrf = new CSRF();