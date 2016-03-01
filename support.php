<?php
// Load mandrill api lib.
require_once 'lib/mandrill/src/Mandrill.php';

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
    $headers = "From: $fname <$email>". "\r\n";
    $headers .= "MIME-version: 1.0\n";
    $headers .= "Content-type: text/html; charset= iso-8859-1\n";

    try {

      $mandrill = new Mandrill('fW1FprIIJOZYrUHv914Ghw');
      $email_date = array(
          'html' => $message,
          'subject' => 'Participant: Question from Eat Fat, Get Thin Challenge',
          'from_email' => $email,
          'from_name' => $fname,
          'to' => array(
              array(
                  'email' => 'ravinder@anattadesign.com',
                  //'name' =>  $toName,
                  'type' => 'to'
              )
          )
      );
      $result = $mandrill->messages->send($message);

    } catch (Exception $e) {
      error_log( print_r( "[$date] [$email] ". $e->getMessage() . "\n", true )."\n", 3, 'logs/debug_email.log' );
    }


    if( in_array( $result['status'], array( 'rejected', 'invalid' ) ) ) {
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
