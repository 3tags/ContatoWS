<?php
if (session_id()=='') session_start();

//  https://contato.ws/[usuario]
//                          |
//    copie o nome de       |
//    usuário e colque aqui |
//                          |
//                          ▼ 
$_usuario_contatows_ = "usuario"; 

function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {
    if ( is_object( $arrays ) ) {
        $arrays = get_object_vars( $arrays );
    }
    foreach ( $arrays AS $key => $value ) {
        $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
        if ( is_array( $value ) OR is_object( $value )  ) {
            http_build_query_for_curl( $value, $new, $k );
        } else {
            $new[$k] = $value;
        }
    }
}

	$ch2 = curl_init();
	
	if ($_SERVER['QUERY_STRING']!='') 
	    $_QUERY_STRING = '' . $_SERVER['SCRIPT_URL']; 
	else 
	    $_QUERY_STRING = '';

	curl_setopt($ch2, CURLOPT_URL, "https://contato.ws/{$_usuario_contatows_}{$_SERVER['SCRIPT_URL']}"); 
	
	curl_setopt($ch2, CURLOPT_COOKIE, session_name() . '=' . $_COOKIE[session_name()] . '; domain='.$_SERVER['SERVER_NAME'].'; path=/' ); 

	if (@!is_dir('../cookie')) 
	   mkdir('../cookie', 0755);
	
	$tmpfname = '../cookie/'.$_COOKIE['PHPSESSID'].'-cookie.txt'; 
	
	
    curl_setopt($ch2, CURLOPT_COOKIEJAR, $tmpfname);
    curl_setopt($ch2, CURLOPT_COOKIEFILE, $tmpfname);


	if (count($_POST)>0) {
		http_build_query_for_curl( $_POST, $post );	
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));	 
		curl_setopt($ch2, CURLOPT_POST, true);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $post);
	} 

	curl_setopt($ch2, CURLOPT_HEADER, false);
	
	curl_exec($ch2);
	curl_close($ch2);
	
?>



