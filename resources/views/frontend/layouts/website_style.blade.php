<style>
    :root{
        --header_background_color: {{$setting->header_background_color ?? '#070727'}};
        --header_text_color: {{$setting->header_text_color ?? 'white'}};
        --nav_background_color: {{$setting->nav_background_color ?? '#051f20'}};
        --nav_text_color: {{$setting->nav_text_color ?? '#ffffffcb'}};

        --dropdown_background_color: {{$setting->dropdown_background_color ?? '#163832'}};
        --dropdown_heading_color: {{$setting->dropdown_heading_color ?? '#82cc59'}};
        --dropdown_text_color: {{$setting->dropdown_text_color ?? '#ffffffcb'}};

        --website_brand_color: {{$setting->website_brand_color ?? '#e73c17'}};
        --website_text_color: {{$setting->website_text_color ?? '#353535'}};
        --website_text_hover_color: {{$setting->website_text_hover_color ?? '#e73c17'}};
        --website_hover_background_color: {{$setting->website_hover_background_color ?? '#e73c17'}};
    }
</style>
