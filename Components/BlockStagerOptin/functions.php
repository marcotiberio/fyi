<?php

namespace Flynt\Components\BlockStagerOptin;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

const REST_NAMESPACE = 'flynt/v1';
const REST_ROUTE = '/stager-optin';

add_filter('Flynt/addComponentData?name=BlockStagerOptin', function ($data) {
    // Never pass credentials to the template.
    unset($data['organization'], $data['token']);
    $data['endpoint'] = rest_url(REST_NAMESPACE . REST_ROUTE);
    // ACF defaults only apply once the options page is saved, so fill in empty labels.
    $data['labels'] = array_merge(getDefaultLabels(), array_filter($data['labels'] ?? []));
    return $data;
});

add_action('rest_api_init', function () {
    register_rest_route(REST_NAMESPACE, REST_ROUTE, [
        'methods' => 'POST',
        'callback' => 'Flynt\\Components\\BlockStagerOptin\\register',
        'permission_callback' => '__return_true',
        'args' => [
            'email' => [
                'required' => true,
                'sanitize_callback' => 'sanitize_email',
                'validate_callback' => fn ($value) => is_email($value),
            ],
            'firstname' => [
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'lastname' => [
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'consent' => [
                'required' => true,
                'validate_callback' => fn ($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            ],
            'website' => [
                'required' => false,
            ],
        ],
    ]);
});

function getDefaultLabels()
{
    return [
        'firstname' => __('First name', 'flynt'),
        'lastname' => __('Last name', 'flynt'),
        'email' => __('Email', 'flynt'),
        'submit' => __('Subscribe', 'flynt'),
        'consentHtml' => __('I agree to receive the newsletter and accept the privacy policy.', 'flynt'),
        'success' => __('Almost done! Check your inbox and click the link to confirm your subscription.', 'flynt'),
        'error' => __('Something went wrong. Please try again later.', 'flynt'),
    ];
}

function getCredentials()
{
    // Constants in wp-config.php take precedence over the Global Options.
    $organization = defined('STAGER_ORGANIZATION') ? STAGER_ORGANIZATION : Options::getGlobal('BlockStagerOptin', 'organization');
    $token = defined('STAGER_OPTIN_TOKEN') ? STAGER_OPTIN_TOKEN : Options::getGlobal('BlockStagerOptin', 'token');
    return [trim((string) $organization), trim((string) $token)];
}

function register(\WP_REST_Request $request)
{
    // Honeypot: bots fill hidden fields, pretend everything went fine.
    if (!empty($request->get_param('website'))) {
        return new \WP_REST_Response(['success' => true], 200);
    }

    [$organization, $token] = getCredentials();
    if (empty($organization) || empty($token)) {
        return new \WP_Error('stager_not_configured', 'Stager opt-in is not configured.', ['status' => 500]);
    }

    $url = add_query_arg(
        [
            'token' => rawurlencode($token),
            'email' => rawurlencode($request->get_param('email')),
            'firstname' => rawurlencode($request->get_param('firstname')),
            'lastname' => rawurlencode($request->get_param('lastname')),
        ],
        sprintf('https://%s.stager.co/api/ticketshop/optin/register', rawurlencode($organization))
    );

    $response = wp_remote_post($url, ['timeout' => 15]);

    if (is_wp_error($response)) {
        error_log('[Stager opt-in] ' . $response->get_error_message());
        return new \WP_Error('stager_request_failed', 'Could not reach Stager.', ['status' => 502]);
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code < 200 || $code >= 300) {
        error_log('[Stager opt-in] HTTP ' . $code . ': ' . wp_remote_retrieve_body($response));
        return new \WP_Error('stager_request_failed', 'Stager rejected the request.', ['status' => 502]);
    }

    return new \WP_REST_Response(['success' => true], 200);
}

Options::addGlobal('BlockStagerOptin', [
    [
        'label' => __('Organization', 'flynt'),
        'instructions' => __('The subdomain of your Stager account, e.g. "yourvenue" for yourvenue.stager.co. Ignored if STAGER_ORGANIZATION is defined in wp-config.php.', 'flynt'),
        'name' => 'organization',
        'type' => 'text',
    ],
    [
        'label' => __('Opt-in Token', 'flynt'),
        'instructions' => __('Generate it in Stager under Settings > Marketing > Opt-ins. Ignored if STAGER_OPTIN_TOKEN is defined in wp-config.php.', 'flynt'),
        'name' => 'token',
        'type' => 'password',
    ],
]);

Options::addTranslatable('BlockStagerOptin', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('First Name', 'flynt'),
                'name' => 'firstname',
                'type' => 'text',
                'default_value' => __('First name', 'flynt'),
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Last Name', 'flynt'),
                'name' => 'lastname',
                'type' => 'text',
                'default_value' => __('Last name', 'flynt'),
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Email', 'flynt'),
                'name' => 'email',
                'type' => 'text',
                'default_value' => __('Email', 'flynt'),
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Submit', 'flynt'),
                'name' => 'submit',
                'type' => 'text',
                'default_value' => __('Subscribe', 'flynt'),
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Consent', 'flynt'),
                'instructions' => __('Text shown next to the required consent checkbox. Link to your privacy policy here.', 'flynt'),
                'name' => 'consentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 1,
                'default_value' => __('I agree to receive the newsletter and accept the privacy policy.', 'flynt'),
                'required' => 1,
            ],
            [
                'label' => __('Success Message', 'flynt'),
                'name' => 'success',
                'type' => 'text',
                'default_value' => __('Almost done! Check your inbox and click the link to confirm your subscription.', 'flynt'),
                'required' => 1,
            ],
            [
                'label' => __('Error Message', 'flynt'),
                'name' => 'error',
                'type' => 'text',
                'default_value' => __('Something went wrong. Please try again later.', 'flynt'),
                'required' => 1,
            ],
        ],
    ],
]);

function getACFLayout()
{
    return [
        'name' => 'BlockStagerOptin',
        'label' => __('Block: Stager Opt-in', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ],
            ],
        ],
    ];
}
