<?php

namespace Themeco\Cornerstone\Services;

/**
 * Classes that implement this interface will be stored as singletons
 * in the resolver.
 */

interface Service {

}

/**
 * Services can be registered in boot.php with the benefit of calling a
 * setup function. The Service constructors should not perform initialization code
 *
 * The keys are services and the values are WordPress hooks
 * where the service's setup function should be called. Value could also be the following
 * strings which run immediately, but under certain conditions
 *   'preinit' Runs immediately
 *   'debug' Runs is WP_DEBUG is enabled
 *   'is_admin' Runs if is_admin() is true, but not wp_doing_ajax()
 *   'is_ajax' Runs if both is_admin() and wp_doing_ajax() are true
 */
