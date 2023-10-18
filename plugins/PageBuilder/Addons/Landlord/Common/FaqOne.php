<?php

namespace Plugins\PageBuilder\Addons\Landlord\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class FaqOne extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/faq.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();
            $output .= Text::get([
                'name' => 'title',
                'label' => __('Title'),
                'value' => $widget_saved_values['title'] ?? null,
                'info' => __('To show the highlighted text, place your word between this code {h}YourText{/h]')
            ]);

            $output .= Text::get([
                'name' => 'subtitle',
                'label' => __('Subtitle'),
                'value' => $widget_saved_values['subtitle'] ?? null,
            ]);

            $output .= Text::get([
                'name' => 'question',
                'label' => __('Question'),
                'value' => $widget_saved_values['question'] ?? null,
            ]);

        $output .= Image::get([
            'name' => 'left_image',
            'label' => __('Left Image'),
            'value' => $widget_saved_values['left_image'] ?? '',
            'dimensions' => '526x482 | 520x480 px'
        ]);

        //repeater
        $output .= Repeater::get([
            'multi_lang' => false,
            'settings' => $widget_saved_values,
            'id' => 'faq_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_title',
                    'label' => __('Title')
                ],
                [
                    'type' => RepeaterField::TEXTAREA,
                    'name' => 'repeater_description',
                    'label' => __('Description')
                ],
            ]
        ]);


        // add padding option
        $output .= $this->section_id_and_class_fields($widget_saved_values);
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $title = SanitizeInput::esc_html($this->setting_item('title')) ?? '';
        $subtitle = SanitizeInput::esc_html($this->setting_item('subtitle')) ?? '';
        $qs = SanitizeInput::esc_html($this->setting_item('question')) ?? '';
        $left_image = $this->setting_item('left_image') ?? '';
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $repeater_data = $this->setting_item('faq_repeater');
        $section_id = $this->setting_item('section_id') ?? '';

        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'question' => $qs,
            'left_image' => $left_image,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'repeater_data' => $repeater_data,
            'section_id'=> $section_id,
        ];

        return self::renderView('landlord.addons.common.faq', $data);

    }

    public function enable(): bool
    {
        return (bool) is_null(tenant());
    }

    public function addon_title()
    {
        return __('Faq : 01');
    }
}
