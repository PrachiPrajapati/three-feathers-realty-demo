<article class="elfsight-admin-page-api-key elfsight-admin-page" data-elfsight-admin-page-id="api-key">
    <div class="elfsight-admin-page-api-key-container">
        <form class="elfsight-admin-page-api-key-form">
            <div class="elfsight-admin-page-api-key-form-image"></div>

            <h4 class="elfsight-admin-page-api-key-form-title-connect elfsight-admin-page-api-key-form-title"><?php esc_html_e('Set your Google Maps API Key', $this->textDomain); ?></h4>
            <h4 class="elfsight-admin-page-api-key-form-title-success elfsight-admin-page-api-key-form-title"><?php esc_html_e('Your Google Maps API Key', $this->textDomain); ?></h4>
            <h4 class="elfsight-admin-page-api-key-form-title-fail elfsight-admin-page-api-key-form-title"><?php esc_html_e('Your Google Maps API Key is not valid', $this->textDomain); ?></h4>

            <div class="elfsight-admin-page-api-key-form-description-wrapper">
                <span class="elfsight-admin-page-api-key-form-description elfsight-admin-page-api-key-form-description-connect">
                    <?php esc_html_e('Setting your own Google Maps API Key is neccessary due to the changes of Google Maps policy that come into effect on July 16, 2018. Find out more at', $this->textDomain); ?> <a href="https://mapsplatform.googleblog.com/2018/05/introducing-google-maps-platform.html" target="_blank" rel="nofollow"><?php esc_html_e('link', $this->textDomain); ?></a>.<br><br>
                    <?php esc_html_e('The following tutorial explains how to get your API Key in an easy way:', $this->textDomain); ?> <a target="_blank" href="https://elfsight.com/blog/2018/06/how-to-get-google-maps-api-key-guide/"><?php esc_html_e('How to get Google Maps API Key', $this->textDomain); ?></a>
                </span>
                <span class="elfsight-admin-page-api-key-form-description elfsight-admin-page-api-key-form-description-success"><?php esc_html_e('You have set a valid Google Maps API Key and your plugin is working correctly now.', $this->textDomain); ?></span>
                <span class="elfsight-admin-page-api-key-form-description elfsight-admin-page-api-key-form-description-fail">
                    <span class="elfsight-admin-page-api-key-form-description-fail-message"></span><br><br>
                    <?php esc_html_e('Follow the steps of this tutorial to get your API Key:', $this->textDomain); ?> <a target="_blank" href="https://elfsight.com/blog/2018/06/how-to-get-google-maps-api-key-guide/"><?php esc_html_e('How to get Google Maps API Key', $this->textDomain); ?></a>
                </span>
            </div>

            <input class="elfsight-admin-page-api-key-form-input" value="<?php echo elfsight_google_maps_get_api_key(); ?>" data-nonce="<?php echo wp_create_nonce('elfsight_google_maps_update_api_key_nonce'); ?>" type="text" placeholder="<?php esc_html_e('Google Maps API Key', $this->textDomain); ?>">

            <a class="elfsight-admin-button elfsight-admin-button-large elfsight-admin-button-green elfsight-admin-page-api-key-form-button elfsight-admin-page-api-key-form-button-connect" href="javascript:void(0)"><?php esc_html_e('Save API key', $this->textDomain); ?></a>

            <div class="elfsight-admin-page-api-key-form-error-empty"><?php esc_html_e('Google Maps API Key is not specified', $this->textDomain); ?></div>
            <div class="elfsight-admin-page-api-key-form-reload"><?php esc_html_e('This page will be reload at few seconds..', $this->textDomain); ?></div>
        </form>
    </div>
</article>