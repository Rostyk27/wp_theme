<?php
function get_subpages($parent_id) {
    global $query_string;
    global $post;
    $subloop = get_pages($query_string.'&child_of='.$post->ID.'&sort_column=menu_order');
    $aa = 0;
    $sp = '';
    $sp .= '<div class="perpage cfx">';
    foreach($subloop as $sub) {
        setup_postdata($sub);
        $img = get_field('icon', $sub->ID, true);
        $sp .= '<div class="'.(($aa++%2==0)?'alignleft':'alignright').'" onClick="window.location=\''. get_permalink($sub->ID).'\'">';
        $sp .= '<h3 class="cfx"><img src="'. $img .'" class="alignleft" alt="'. $sub->post_title.'" />'. $sub->post_title.'</h3>';
        $sp .= '</div>';
    }
    $sp .= '</div>';
    return $sp;
}
/*
* using:
* [subpages]
*/
add_shortcode('subpages', 'get_subpages');

//User can enter e-mail for login
add_filter('authenticate', 'bainternet_allow_email_login', 20, 3);
function bainternet_allow_email_login( $user, $username, $password ) {
    if ( is_email( $username ) ) {
        $user = get_user_by( 'email', $username );
        if ( $user ) $username = $user->user_login;
    }
    return wp_authenticate_username_password(null, $username, $password );
}
add_filter( 'gettext', 'addEmailToLogin', 20, 3 );
function addEmailToLogin( $translated_text, $text, $domain ) {
    if ( "Username" == $translated_text )
        $translated_text .= __( ' Or Email');
    return $translated_text;
}

if(defined('AJAXSIGN')) {

    //login shortcode
    add_shortcode('ajax_login','ajaxlogin_shortcode_handler');
    function ajaxlogin_shortcode_handler($atts,$content=null){
        $logform = '';
        $logform = '<div id="loginform">
            <form name="ajaxlogin" id="ajaxlogin" action="" method="post" class="wpcf7">
                <span class="login-username">
                    <label for="user_login">Email Address</label>
                    <input type="text" name="username" id="user_login" class="input" value="" size="20">
                </span>
                <span class="login-password">
                    <label for="user_pass">Password</label>
                    <input type="password" name="password" id="user_pass" class="input" value="" size="20">
                </span>
                <div class="login-submit cfx">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button" value="Login">
                    <input type="hidden" name="redirect_to" value="'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'">
                    '.wp_nonce_field( 'ajax-login-nonce', 'security', null, false ).'
                </div>
                <div id="login-result"><span></span></div>
                <p id="login-message"></p>
            </form>
        </div>';

        return $logform;
    }
    if (!is_admin()) add_action( 'init', 'ajax_login_init' );
    function ajax_login_init() {
        wp_register_script( 'ajax-login-script', get_bloginfo('stylesheet_directory').'/js/libs/wp-shortcode-sign.js', array('jquery'), '1.0', TRUE );
        wp_enqueue_script( 'ajax-login-script' );
        wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'redirecturl' => site_url().$_SERVER["REQUEST_URI"],
            'loadingmessage' => __( 'Please wait...' )
        ));
    }
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
    function ajax_login() {
        check_ajax_referer( 'ajax-login-nonce', 'security' );
        $info = array();
        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = true;
        $result = array();
        $user_signon = wp_signon($info, false);
        if (is_wp_error($user_signon)){
            $result['loggedin'] = false;
            $result['message'] = 'Your e-mail or password is not correct. Please try again';
        } else {
            $result['loggedin'] = true;
            $result['message'] = 'Logged in successfully. Please wait...';
        }
        echo json_encode($result);
        exit();
    }



    //user register
    add_action('register_form','addpass_register_form');
    function addpass_register_form (){
        $first_name = ( isset( $_POST['password'] ) ) ? $_POST['password']: ''; ?>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" size="20" />
    <?php
    }
    add_filter('registration_errors', 'addpass_registration_errors', 10, 3);
    function addpass_registration_errors ($errors, $sanitized_user_login, $user_email) {
        if ( empty( $_POST['password'] ) )
            $errors->add( 'password_error','Please enter the password' );
        return $errors;
    }
    add_action('user_register', 'addpass_user_register');
    function addpass_user_register($user_id) {
        if ( isset( $_POST['password'] ) )
            update_user_meta($user_id, 'password', $_POST['password']);
    }

    add_shortcode('ajax_register','ajax_regi_form');
    function ajax_regi_form($atts,$content=null){
        $reform = '';
        $reform .= '<form name="ajaxregi" id="ajaxregi" class="wpcf7">
            <span class="regi-username">
                <label for="regi_user_login">Full name</label>
                <input type="text" name="first_name" id="regi_user_name" class="input" value="" size="20" />
            </span>
            <span class="regi-username">
                <label for="user_login">Email Address</label>
                <input type="text" name="user_email" id="regi_user_email" class="input" value="" size="20" />
            </span>
            <span class="regi-password">
                <label for="regi_user_pass">Password</label>
                <input type="password" name="user_pass" id="regi_user_pass" class="input" value="" size="20" />
            </span>
            <div class="regi-submit cfx">
                <input type="hidden" name="action" value="custom_register" />
                <input type="submit" name="wp-submit" id="wp-submit" class="button" value="Create account" />
                <input type="hidden" name="redirect_to" value="'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'" />'
            .wp_nonce_field( 'ajax-login-nonce', 'reg_security', null, false ).
            '</div>
            <div id="regi-result"><span></span></div>
            <p id="regi-message"></p>
        </form>';
        return $reform;
    }
    add_action( 'wp_ajax_custom_register', 'custom_register_new_user' );
    add_action( 'wp_ajax_nopriv_custom_register', 'custom_register_new_user' );
    function custom_register_new_user() {
        $user_email = $_POST['user_email'];
        $user_pass = $_POST['user_pass'];
        $user_repass = $_POST['user_pass'];
        $first_name = $_POST['first_name'];
        $secury = $_POST['reg_security'];

        $result = array();
        $result['errorcode'] = true;
        $sanitized_user_login = sanitize_user( $user_email );
        $user_email = apply_filters( 'user_registration_email', $user_email );

        if ( $sanitized_user_login == '' ) {
            $result['error'] ='<strong>ERROR</strong>: Please type your e-mail address.';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        } elseif ( ! validate_username( $sanitized_user_login ) ) {
            $result['error'] ='<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.';
            $sanitized_user_login = '';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        } elseif ( username_exists( $sanitized_user_login ) ) {
            $result['error'] ='<strong>ERROR</strong>: This username is already registered. Please choose another one.';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        }

        if ( $user_email == '' ) {
            $result['error'] ='<strong>ERROR</strong>: Please type your e-mail address.';
            $result['errorcode'] = false;
        } elseif ( ! is_email( $user_email ) ) {
            echo json_encode($result);
            exit();
            $result['error'] ='<strong>ERROR</strong>: The email address isn&#8217;t correct.';
            $user_email = '';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        } elseif ( email_exists( $user_email ) ) {
            $errors .= '<strong>ERROR</strong>: This email is already registered, please choose another one.';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        }

        if ( $user_pass == '' AND $user_repass == '' ) {
            $result['error'] ='<strong>ERROR</strong>: Please type your password.';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        } elseif ( $user_pass != $user_repass ) {
            $result['error'] = '<strong>ERROR</strong>: The password not match.';
            $user_pass = '';
            $result['errorcode'] = false;
            echo json_encode($result);
            exit();
        }

        if($result['errorcode']){
            $user_id = wp_create_user($sanitized_user_login, $user_pass, $user_email);
            if ($user_id){
                wp_update_user(array(
                    'ID'  => $user_id,
                    'first_name' => $first_name,
                    'display_name' => $first_name
                ));
                $result['user_id'] = $user_id;
                $result['error'] ='You are registered successfully. Please wait...';
                $result['log_in'] = 1;
                $result['email'] = $user_email;
                $result['password'] = $user_pass;
                $result['security'] = $secury;
            }
            else $result['error'] = '<strong>ERROR</strong>: Add user in database.';
        }
        wp_new_user_notification($user_id, $user_pass);
        echo json_encode($result);
        exit();
    }

} //AJAXSIGN

function javascript_escape($str) {
    $new_str = '';
    $str_len = strlen($str);
    for($i = 0; $i < $str_len; $i++) {
        $new_str .= '\\x' . sprintf('%02x', ord(substr($str, $i, 1)));
    }
    return htmlspecialchars($new_str);
}

if(defined('GOOGLEMAPS')) {

    /* google map shortcode
        *** Using [googlemap id="somemapid" coordinates="1 ,1" zoom="17" height="500px" infobox="<p>Some Infobox Content</p>"]
        *** if need street view, please add 'streetview="true"';
        *** if you need satellite view in 45 angle add 'tilt="45"';
    */
    function google_map_js($atts) {
        extract(shortcode_atts(array(
            'id'                => 'map_canvas',
            'coordinates'       => '1, 1',
            'zoom'              => 15,
            'height'            => '350px',
            'zoomcontrol'       => 'false',
            'scrollwheel'       => 'false',
            'scalecontrol'      => 'false',
            'disabledefaultui'  => 'false',
            'infobox'           => '',
            'satellite'         => '',
            'tilt'              => '',
            'icon'              => theme().'/images/marker.png',
            'streetview'        => ''
        ), $atts));
        $mapid = str_replace('-','_',$id);

        $map = !$streetview?'<div class="googlemap" id="'.$id.'" '.($height?'style="height:'.$height.'"':'').'></div><script>
    var '.$mapid.';
    function initialize_'.$mapid.'() {
        var myLatlng = new google.maps.LatLng('.$coordinates.');
        var mapOptions = {
            '.($satellite?'mapTypeId: google.maps.MapTypeId.SATELLITE,':'').'
            zoom: '.$zoom.',
            center: myLatlng,
            zoomControl: '.$zoomcontrol.',
            scrollwheel: '.$scrollwheel.',
            scaleControl: '.$scalecontrol.',
            disableDefaultUI: '.$disabledefaultui.'
        };
        var '.$mapid.' = new google.maps.Map(document.getElementById("'.$id.'"), mapOptions);
        '.($tilt?$mapid.'.setTilt(45);':'').'
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: '.$mapid.',
            '.($icon?'icon:"'.$icon.'",':'').'
            animation: google.maps.Animation.DROP
        });
        '.($infobox?'marker.info = new google.maps.InfoWindow({content: \''.javascript_escape($infobox).'\'});
        google.maps.event.addListener(marker, "click", function() {marker.info.open('.$mapid.', marker);});':'').'

        google.maps.event.addListener('.$mapid.', "center_changed", function() {
            window.setTimeout(function() {
                '.$mapid.'.panTo(marker.getPosition());
            }, 15000);
        });
    };
    google.maps.event.addDomListener(window, "load", initialize_'.$mapid.');
    </script>':do_streetView_map($id, $coordinates, $height, $streetview);
        return $map;
    }
    add_shortcode('googlemap', 'google_map_js');

    function do_streetView_map($id, $pos, $height, $streetview){
        return '<div class="googlemap" id="street_'.$id.'" '.($height?'style="height:'.$height.'"':'').'></div><script>
        function street_init_'.$id.'() {


        var geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { "address": "'.$streetview.'" }, function(results, status) {
            var lookTo = results[0].geometry.location;
            if (status == google.maps.GeocoderStatus.OK) {
                  var panoOptions = {
                    position: lookTo,
                    panControl: false,
                    addressControl: false,
                    linksControl: false,
                    zoomControlOptions: false
                  };
                  var pano = new  google.maps.StreetViewPanorama(document.getElementById("street_'.$id.'"),panoOptions);
                  var service = new google.maps.StreetViewService;
                  service.getPanoramaByLocation(pano.getPosition(), 50, function(panoData) {
                    if (panoData != null) {
                      var panoCenter = panoData.location.latLng;
                      var heading = google.maps.geometry.spherical.computeHeading(panoCenter, lookTo);
                      var pov = pano.getPov();
                      pov.heading = heading;
                      pano.setPov(pov);
                      var marker = new google.maps.Marker({
                        map: pano,
                        position: lookTo
                      });
                    } else {
                      alert("Not Found");
                    }
                  });
            } else {
                alert("Could not find your address");
            }
        });
        }
        google.maps.event.addDomListener(window, "load", street_init_'.$id.');</script>';
    }
} //end GOOGLEMAPS

function content_btn($atts,$content){
    extract(shortcode_atts(array(
        'text' => 'Learn More',
        'link' => site_url(),
        'class' => false,
        'target' => false
    ), $atts ));
    return '<a href="' . $link . '" class="button'.($class?' '.$class:'').'" '.($target?'target="'.$target.'"':'').'>' . $text . '</a>';
}
add_shortcode("button", "content_btn");

function tree_children($absolute = false, $page_id = 0) {
    global $wp_query;
    if ($wp_query->is_posts_page) {
        $post = get_post(BLOG_ID);
    } else {
        global $post;
    }
    $ex_pages = null;
    $ex_args = array(
        'posts_per_page' => -1,
        'post_type' => 'page',
        'meta_key' => 'hide_page',
        'meta_value' => true
    );
    $excluded = new WP_Query($ex_args);
    if ($excluded->have_posts()): while ($excluded->have_posts()) : $excluded->the_post();
    $ex_pages .= get_the_ID() . ',';
    endwhile;
    $ex_pages = substr($ex_pages, 0, -1);
    endif;
    wp_reset_query();
    $childlist = get_pages('child_of=' . $post->ID . ($ex_pages ? '&exclude=' . $ex_pages : ''));
    $children = '';
    if ($post->post_parent) {
        $ancestors = get_post_ancestors($post->ID);
        $reverse = array_reverse($ancestors);
        $abs = $reverse[0];
        $children .= '<ul class="submenu">';
        $children .= wp_list_pages("title_li=&child_of=" . $abs . "&echo=0&sort_column=menu_order" . ($ex_pages ? '&exclude=' . $ex_pages : ''));
        $children .= '</ul>';
        echo $children;
    } elseif ($childlist) {
        echo '<ul class="submenu">' . wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0&sort_column=menu_order" . ($ex_pages ? '&exclude=' . $ex_pages : '')) . '</ul>';
    }
}

//remove <p> and <br /> from shortcodes
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content){
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
