<?php
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
trait ReponseHelper {
/* Return type response
 *
 */
function res_type($type)
{
    switch ($type) {
        case 'success':
            return 'success';
        case 'error':
            return 'error';
    }
}

/* Return title response
 *
 */
function res_title($title)
{
    switch ($title) {
        case 'success':
        case 'request_success':
            return ("Request successfully.");
        case 'create_success':
            return ("Create successfully.");
        case 'update_success':
            return ("Update successfully.");
        case 'upload_success':
            return ("Upload successfully.");
        case 'delete_success':
            return ("Delete successfully.");
        case 'clone_success':
            return ("Clone successfully.");
        case 'cancel_success':
            return ("Cancel successfully.");
        case 'reject_success':
            return ("Reject successfully.");
        case 'accept_success':
            return ("Accept successfully.");
        case 'transfer_success':
            return ("Transfer successfully.");
        case 'disable_success':
            return ("Disable successfully.");
        case 'refuse_success':
            return ("Refuse successfully.");
        case 'error':
            return ("There was an error in processing, please try again.");
        case 'validate_error':
            return ("There are some problems.");
        case 'notfound':
            return ("Resource does not exist.");
        case 'sent_email':
            return ("We have sent an email to your email address. May be in the spam box.");
        case 'permission':
            return ("You don't have permission to access this resource.");
        case 'notfound_or_permission':
            return ("Resource does not exist or you don't have permission to access this resource.");
        case 'status_watting':
            return ("Account not activated.");
        case 'status_block':
            return ("Account has been locked.");
        case 'account_problem':
            return ("Problems with the account.");
        case 'account_expired':
            return ("Your plan has expired. Please, upgrade your plan.");
        case 'upgrade_required':
            return ("Please upgrade your plan to use this feature.");
        case 'limit':
            return ("Usage limit has been reached. Please upgrade your Subscription Plan.");
        case 'limit_daily':
            return ("Usage limit daily has been reached. Please upgrade your Subscription Plan.");
        case 'transfer_waiting':
            return ("Some profiles are on the transfer waiting list.");
        case 'in_listing':
            return ("Some profiles are on the listing.");
        case 'listing_not_enough_quantity':
            return ("There are not enough quantities left in the listing.");
        case 'sync_success':
            return ("Sync successfully.");
        case 'remove_success':
            return ("Remove successfully.");
        case 'change_success':
            return ("Change successfully.");
    }
}

/**
 * Return content response
 *
 */
function res_content($content)
{
    switch ($content) {
        case 'empty':
            return [];
        case 'empty_string':
            return "[]";
        case 'status_watting':
            return ("Account not activated. Contact admin to activate your account.");
        case 'status_block':
return ("Account has been locked. Contact admin to unlock account.");
        case 'account_problem':
            return ("There is a problem with the account, contact the admin for help.");
    }
}

/**
 * Return http status code response
 *
 */
function res_code($code)
{
    switch ($code) {
        // Success
        case 200:
            return 200;

        // Validate failed
        case 400:
            return 400;

        // Unauthenticated
        case 401:
            return 401;

        // Payment Required
        case 402:
            return 402;

        // Forbidden
        case 403:
            return 403;

        // Notfound
        case 404:
            return 404;

        // Serve error
        case 500:
            return 500;
    }
}

/* Generate uuid
 *
 */
function uuid()
{
    return Str::orderedUuid()->toString();
}

/* Return default response from the application.
 * @return \Illuminate\Http\JsonResponse
 */
function defaultReponseError()
{
    return response()->json(
        [
            'type' => $this->res_type('error'),
            'title' => ('There was an error in processing, please try again.'),
            'content' => $this->res_content('empty'),
        ],
        $this->res_code('500')
    );
}

/**
 * Return success response
 */
function successResponse($message, $data = [], $code = 200): \Illuminate\Http\JsonResponse
{
    return response()->json([
        'type' => 'success',
        'title' => $this->res_title($message) ?: ($message),
        'data' => $data
    ], $code);
}

/**
 * Return error response
 */
function errorResponse($message, $data = [], $code = 400): \Illuminate\Http\JsonResponse
{
    return response()->json([
        'type' => 'error',
        'title' => $this->res_title($message) ?: __($message),
        'data' => $data,
    ], $code);
}
}

