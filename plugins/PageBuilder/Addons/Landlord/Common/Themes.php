<?php

namespace Plugins\PageBuilder\Addons\Landlord\Common;

use App\Facades\GlobalLanguage;
use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class Themes extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Landlord/common/themes.png';
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

        $output .= Image::get([
            'name' => 'background_shape',
            'label' => __('Background Shape Image'),
            'value' => $widget_saved_values['background_shape'] ?? null,
            'dimensions' => '416x520 | 400x500 px'
        ]);

        $output .= Text::get([
            'name' => 'theme_page_url',
            'label' => __('Theme Page URL'),
            'value' => $widget_saved_values['theme_page_url'] ?? null,
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
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $title = SanitizeInput::esc_html($this->setting_item('title')) ?? '';
        $subtitle = SanitizeInput::esc_html($this->setting_item('subtitle')) ?? '';
        $theme_url = SanitizeInput::esc_url($this->setting_item('theme_page_url')) ?? '';

        $bg_shape_image = $this->setting_item('background_shape') ?? '';

        $themes = \App\Models\Themes::where('status', 1)->orderBy('id', 'asc')->get();

        $section_id = SanitizeInput::esc_html($this->setting_item('section_id')) ?? '';
        $data = [
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'title' => $title,
            'subtitle' => $subtitle,
            'themes' => $themes,
            'theme_url' => $theme_url,
            'bg_shape_image' => $bg_shape_image,
            'section_id' => $section_id,
        ];

        return self::renderView('landlord.addons.common.theme', $data);

    }

    public function enable(): bool
    {
        return (bool)is_null(tenant());
    }

    public function addon_title()
    {
        return __('Themes: 01');
    }
}
