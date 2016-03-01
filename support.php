<?php
$result = array();

// Check form data.
if( ! empty( $_POST['email'] ) && ! empty( $_POST['message'] ) ) {

  // validate form data.
  if(
    ( $email = filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
    &&  ( $message = filter_var( $_POST['message'], FILTER_SANITIZE_STRING ) )
  ) {

    $date = date('Y-m-d h:m:s');

    // full name
    $fname = ( $fname = filter_var( $_POST['fname'], FILTER_SANITIZE_STRING ) ) ? $fname : '';

    // Send from email param.
    $headers .= "MIME-version: 1.0\n";
    $headers .= "Content-type: text/html; charset= iso-8859-1\n";
    $headers .= "From: $fname <$email>". "\r\n";

    try {
      // Send email.
      $email_status = mail(
        'eatfatgetthin@drhyman.com',
        'Participant: Question from Eat Fat, Get Thin Challenge',
        $message,
        $headers
      );
    } catch (Exception $e) {
      error_log( print_r( "[$date] [$email] ". $e->getMessage() . "\n", true )."\n", 3, WP_CONTENT_DIR.'/debug_email.log' );
    }


    if( ! $email_status ) {
      $result['status'] = 'error';
    }else{
      $result['status'] = 'success';
    }
  }else {
    $result['status'] = 'error';
  }
} else{
  $result['status'] = 'error';
}

/**
 * Send json response
 */
header('Content-Type: application/json');
echo json_encode( $result );
?>
