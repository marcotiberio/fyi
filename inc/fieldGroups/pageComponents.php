<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => __('Page Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => __('Page Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    // Components\AccordionDefault\getACFLayout(),
                    // Components\BannerImageText\getACFLayout(),
                    Components\BlockAnchor\getACFLayout(),
                    // Components\BlockCollapse\getACFLayout(),
                    Components\BlockContactForm\getACFLayout(),
                    // Components\BlockCta\getACFLayout(),
                    Components\BlockImage\getACFLayout(),
                    Components\BlockImageText\getACFLayout(),
                    Components\BlockWysiwyg\getACFLayout(),
                    Components\BlockWysiwygTwoCol\getACFLayout(),
                    // Components\GridImageText\getACFLayout(),
                    // Components\GridPostSelector\getACFLayout(),
                    // Components\HeroContactForm\getACFLayout(),
                    // Components\ListTextLink\getACFLayout(),
                    Components\ListingArtists\getACFLayout(),
                    Components\ListingPastEvents\getACFLayout(),
                    Components\ListingFutureEvents\getACFLayout(),
                    // Components\SliderBoxToggle\getACFLayout(),
                    // Components\SliderImages\getACFLayout(),
                    // Components\SliderPosts\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'post'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'artist'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'reusable-components'
                ],
            ],
        ],
    ]);
});
