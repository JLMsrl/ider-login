<?php


class IDER_Shortcodes
{

    static function init()
    {
        add_shortcode('sso_button', [__CLASS__, 'single_sign_on_login_button_shortcode']);
        add_shortcode('ider_profile_summary', [__CLASS__, 'ider_profile_summary']);
    }


    static function single_sign_on_login_button_shortcode($atts = [])
    {
        $a = shortcode_atts(array(
            'title' => 'Login using Single Sign On',
            'class' => 'button button-primary button-large',
            'target' => '',
            'text' => 'Login with IDer',
            'loginonly' => ''
        ), $atts);


        if (!is_user_logged_in()) {
            return '<a class="' . $a['class'] . '" style="width: 100%; text-align: center" href="' . site_url('?auth=ider') . '" title="' . $a['title'] . '" target="' . $a['target'] . '"><img src="' . IDER_PLUGIN_URL . 'assets/images/logo_ider.png" style="display: inline; vertical-align: sub;margin-right: 5px">' . $a['text'] . '</a>';
        } else {
            if (!$a['loginonly']) {
                return '<a class="' . $a['class'] . '" style="width: 100%; text-align: center" href="' . wp_logout_url('/') . '" title="' . $a['title'] . '" target="' . $a['target'] . '"><img src="' . IDER_PLUGIN_URL . 'assets/images/logo_ider.png" style="display: inline; vertical-align: sub;margin-right: 5px"> Logout</a>';
            }
        }
    }


    static function ider_profile_summary()
    {

        $user = get_user_by('id', get_current_user_id());

        $usermetas = get_user_meta(get_current_user_id());

        $updated_fields = get_user_meta(get_current_user_id(), 'last_updated_fields', true);

        //print_r($user->user_email);

        $fields = [];
        $fields = array_keys(apply_filters('ider_fields_map', $fields));

        //print_r($usermetas);

        $tbody = '';
        foreach ($fields as $localfield) {

            // skip shipping fields
            //if (preg_match("/^shipping_(.*)/i", $localfield)) continue;

            $tbody .= '<tr class="' . (in_array($localfield, $updated_fields) ? 'warning' : '') . '"><th class="textright">' . ucfirst(str_replace(['-', '_'], ' ', $localfield)) . '</th><td>';
            if ($usermetas[$localfield]) {
                $tbody .= $usermetas[$localfield][0];
            } else {
                $tbody .= '--';
            }
            $tbody .= '</td></tr>';
        }

        $email_mismatch = '<div class="alert alert-warning">
                           <strong>Warning!</strong> Your local email (' . $user->user_email . ') is different than your IDer email (' . ($usermetas['email'][0] ?: 'none') . ').
                           </div>';

        $table = '<h3>Welcome ' . $usermetas['first_name'][0] . ' ' . $usermetas['last_name'][0] . '</h3>';
        $table .= '<h4>You have been authenticated via IDer<sup>&copy;</sup> system.</h4>';
        $table .= $usermetas['email'][0] == $user->user_email ? '' : $email_mismatch;
        $table .= '<table class="table table-condensed">';
        $table .= '<tbody>' . $tbody . '</tbody>';
        $table .= '</table>';

        return $table;
    }
}

