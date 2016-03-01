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

    try {
      // Send email.
      $email_status = mail(
        'eatfatgetthin@drhyman.com',
        'Participant: Question from Eat Fat, Get Thin Challenge',
        $message,
        $headers
      );
<<<<<<< HEAD
      $result = $mandrill->messages->send($message);

      if( in_array( $result['status'], array( 'rejected', 'invalid' ) ) ) {
        $result['status'] = 'error';
      }else{
        $result['status'] = 'success';
      }

=======
>>>>>>> parent of 6351b03... adding mandrill api library
    } catch (Exception $e) {
      error_log( print_r( "[$date] [$email] ". $e->getMessage() . "\n", true )."\n", 3, WP_CONTENT_DIR.'/debug_email.log' );
    }
<<<<<<< HEAD
=======


    if( ! $email_status ) {
      $result['status'] = 'error';
    }else{
      $result['status'] = 'success';
    }
>>>>>>> parent of 6351b03... adding mandrill api library
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
