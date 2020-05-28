<?php
/**
 * Used to update information about the user, must be called with method=POST.
 *
 * If oldpwd is not set, the only information that can be changed is firstName
 * and lastName, uname and uid must be provided to be able to update this
 * information.
 *
 * If oldpwd is provided but no new pwd (pwd), username (uname), firstName and lastName can
 * be updated. The user id (uid) must be provided.
 *
 * Called with oldpwd, new pwd (pwd), username (uname), firstName, lastName and
 * user id (uid) all information can be updated.
 *
 * Returns status=>success on success or status=>fail on failure. On failure more
 * information can be found in msg=>.
 */
header("Content-Type: application/json; charset=utf-8");

require_once ('../classes/DB.php');
$db = DB::getDBConnection();

if ($_POST['oldpwd']=='') { // No old password, update only first and last name
  $sql ='UPDATE user SET firstName=?, lastName=? WHERE uname=? AND uid=?';
  $stmt = $db->prepare ($sql);
  $stmt->execute (array($_POST['firstName'], $_POST['lastName'], $_POST['uname'], $_POST['uid']));
  if ($stmt->rowCount()==1) {
    echo json_encode(array('status'=>'success'));
  } else {
    echo json_encode(array('status'=>'fail', 'msg'=>'Unable to update user'));
  }
} else { // Password set, update details needing pwd
  if ($_POST['pwd']=='') { // No new pwd, only update username, first and last name
    $sql = 'SELECT pwd FROM user WHERE uid=?';
    $stmt = $db->prepare ($sql);
    $stmt->execute (array($_POST['uid']));
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {  // Check existing pwd
      if (password_verify($_POST['oldpwd'], $res['pwd'])) { // pwd OK
        $sql ='UPDATE user SET uname=?, firstName=?, lastName=? WHERE uid=?';
        $stmt = $db->prepare ($sql);
        $stmt->execute (array($_POST['uname'], $_POST['firstName'], $_POST['lastName'], $_POST['uid']));
        if ($stmt->rowCount()==1) {
          echo json_encode(array('status'=>'success'));
        } else {
          echo json_encode(array('status'=>'fail', 'msg'=>'Unable to update user1'));
        }
      } else {
        echo json_encode(array('status'=>'fail', 'msg'=>'Incorrect PWD for user'));
      }
    } else {
      echo json_encode(array('status'=>'fail', 'msg'=>'Unable to find user'));
    }
  } else { // Update password, username, first and last name
    $sql = 'SELECT pwd FROM user WHERE uid=?';
    $stmt = $db->prepare ($sql);
    $stmt->execute (array($_POST['uid']));
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {  // Check existing pwd
      if (password_verify($_POST['oldpwd'], $res['pwd'])) { // pwd OK
        $sql ='UPDATE user SET uname=?, pwd=?, firstName=?, lastName=? WHERE uid=?';
        $stmt = $db->prepare ($sql);
        $stmt->execute (array($_POST['uname'], password_hash($_POST['pwd'], PASSWORD_DEFAULT), $_POST['firstName'], $_POST['lastName'], $_POST['uid']));
        if ($stmt->rowCount()==1) {
          echo json_encode(array('status'=>'success'));
        } else {
          echo json_encode(array('status'=>'fail', 'msg'=>'Unable to update user'));
        }
      } else {
        echo json_encode(array('status'=>'fail', 'msg'=>'Incorrect PWD for user'));
      }
    } else {
      echo json_encode(array('status'=>'fail', 'msg'=>'Unable to find user'));
    }
  }
}
