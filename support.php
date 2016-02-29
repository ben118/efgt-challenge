<?php
$result = array();

// Check form data.
if( ! empty( $_POST['email'] ) && ! empty( $_POST['message'] ) ) {

  // validate form data.
  if(
    ( $email = filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
    &&  ( $message = filter_var( $_POST['message'], FILTER_SANITIZE_STRING ) )
  ) {
    $fname = ( $fname = filter_var( $_POST['fname'], FILTER_SANITIZE_STRING ) ) ? $fname : '';
    // Send from email param.
    $headers = "From: $fname <$email>". "\r\n";

    // Send email.
    $email_status = mail(
      'ravinder@anattadesign.com',
      'Participant: Question from Eat Fat, Get Thin Challenge',
      $message,
      $headers
    );

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
