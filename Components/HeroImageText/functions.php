<?php

namespace Flynt\Components\HeroImageText;

use Flynt\FieldVariables;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=HeroImageText', function ($data) {
    $data['oembed'] = Oembed::setSrcAsDataAttribute(
        $data['oembed'],
        [
            'autoplay' => 'false'
        ]
    );

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'HeroImageText',
        'label' => __('Hero: Image/Video/text', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image/Video', 'flynt'),
                'name' => 'imagevideoTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Preview Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg',
                'wrapper' =>  [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Video', 'flynt'),
                'name' => 'oembed',
                'type' => 'oembed',
                'required' => 0,
                'videoParams' => [
                    'autoplay' => 1,
                ],
                'wrapper' =>  [
                    'width' => 50,
                ],
            ],
            // [
            //     'label' => __('Video', 'flynt'),
            //     'instructions' => __('Video-Format: mp4.', 'flynt'),
            //     'name' => 'video',
            //     'type' => 'file',
            //     'return_format' => 'url',
            //     'mime_types' => 'mp4',
            //     'wrapper' => [
            //         'width' => 50,
            //     ]
            // ],
            [
                'label' => __('Text', 'flynt'),
                'name' => 'textTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'wrapper' =>  [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
                'wrapper' =>  [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Buttons', 'flynt'),
                'name' => 'buttonsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Button', 'flynt'),
                'instructions' => __('Use this button to link to another page or leave empty to use a contact form', 'flynt'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Contact Form', 'flynt'),
                'name' => 'formTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Open Button - Form', 'flynt'),
                'name' => 'openButtonText',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Close Button - Form ', 'flynt'),
                'name' => 'closeButtonText',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Contact Form', 'flynt'),
                'name' => 'contactForm',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'default',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'width' => 100
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getColorBackground(),
                ]
            ]
        ]
    ];
}
