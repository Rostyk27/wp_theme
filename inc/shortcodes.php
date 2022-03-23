<?php

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

// helper function for G-map shortcode
function javascript_escape($str) {
    $new_str = '';
    $str_len = strlen($str);
    for($i = 0; $i < $str_len; $i++) {
        $new_str .= '\\x' . sprintf('%02x', ord(substr($str, $i, 1)));
    }
    return htmlspecialchars($new_str);
}

// shortcode Google Map
if(defined('GOOGLEMAPS')) {
    /* google map shortcode
        *** Using [googlemap id="somemapid" coordinates="1 ,1" zoom="17" height="500px" infobox="<p>Some Infobox Content</p>"]
        *** if need street view, please add 'streetview="true"';
        *** if you need satellite view in 45 angle add 'tilt="45"';
    */
    function google_map_js($atts, $content) {
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
            '.( $content ? ',styles:'.$content : '' ).'
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

// shortcode button
function content_btn($atts,$content){
    extract(shortcode_atts(array(
        'text' => 'Learn More',
        'link' => site_url(),
        'class' => false,
        'target' => false,
        'popup' => false,
        'video' => false
    ), $atts ));
	return '<a href="' . $link . '" class="button'.($class?' '.$class:'').'" '.($target?'target="'.$target.'"  rel="noopener"':'').' 
            '.($popup?' data-fancybox="" data-src="#'.$popup.'"':'').' '.($video?' data-fancybox=""':'').'>' . $text . '</a>';
}
add_shortcode("button", "content_btn");

// shortcode social media
function so_me() {
	$so_me = get_field('so_me', 'option');
	$soc = '';
	if($so_me) {
		$soc .= '<ul class="so_me">';
		foreach($so_me as $sm) {
			$host = parse_url( $sm['link'] );
			if ( array_key_exists('host', $host ) ) {
				$parts = explode( '.', $host['host'] );
				$label = $parts[0] == 'www' ? $parts[1] : $parts[0];
			} else {
				$label = get_bloginfo();
			}
			$soc .= '<li><a href="'.$sm['link'].'" class="i_'.$sm['icon'].'" target="_blank" rel="noopener" aria-label="'.$label.'"></a></li>';
		}
		$soc .= '</ul>';
	}
	return $soc;
}
add_shortcode('social', 'so_me');

// remove <p> and <br /> from shortcodes
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