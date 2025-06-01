<?php
/**
 * Define application routes
 * Format: 'route' => 'controller/method'
 */

$routes = [
    // Home routes
    '/' => 'HomeController/index',
    '/home' => 'HomeController/index',
    
    // Auth routes
    '/login' => 'AuthController/login',
    '/register' => 'AuthController/register',
    '/logout' => 'AuthController/logout',
    '/forgot-password' => 'AuthController/forgotPassword',
    '/reset-password' => 'AuthController/resetPassword',
    
    // Dashboard routes
    '/dashboard' => 'DashboardController/index',
    
    // Profile routes
    '/profile' => 'ProfileController/index',
    '/profile/edit' => 'ProfileController/edit',
    '/profile/update' => 'ProfileController/update',
    '/profile/change-password' => 'ProfileController/changePassword',
    
    // Account routes
    '/accounts' => 'AccountController/index',
    '/accounts/create' => 'AccountController/create',
    '/accounts/store' => 'AccountController/store',
    '/accounts/view' => 'AccountController/viewAccount',
    
    // Transaction routes
    '/transactions' => 'TransactionController/index',
    '/transactions/details' => 'TransactionController/details',
    
    // Fund Transfer routes
    '/fund-transfer' => 'FundTransferController/index',
    '/fund-transfer/process' => 'FundTransferController/process',
    
    // Bill Payment routes
    '/bill-payment' => 'BillPaymentController/index',
    '/bill-payment/process' => 'BillPaymentController/process',
    '/bill-payment/success' => 'BillPaymentController/success',
    
    // Admin routes
    '/admin' => 'AdminController/index',
    '/admin/users' => 'AdminController/users',
    '/admin/accounts' => 'AdminController/accounts',
    '/admin/transactions' => 'AdminController/transactions',
    
    // Contact us routes
    '/contact-us' => 'ContactUsController/index',
    '/contact-us/submit' => 'ContactUsController/submit',
    
    // Notification routes
    '/notifications' => 'NotificationController/index',
    '/notifications/mark-read' => 'NotificationController/markAsRead',
    
    // Search and filtering
    '/search' => 'SearchFilterController/search',
    
    // Error routes
    '/404' => 'ErrorController/notFound',
    '/403' => 'ErrorController/forbidden',
    '/500' => 'ErrorController/serverError'

];

return $routes;
