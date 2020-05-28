<?php
/**
 * Returns all information for given user id, send the user id as a GET parameter
 * with the name *id*.
 *
 * An assosiative array with items uid, uname, firstName, lastName and hasAvatar
 * will be returned. If no user with given id is found status=>fail will be returned.
 */
header("Content-Type: application/json; charset=utf-8");

require_once ('../classes/DB.php');
$db = DB::getDBConnection();
$sql = 'SELECT uid, uname, firstName, lastName, !ISNULL(NULLIF(avatar,"")) as hasAvatar FROM user WHERE uid = ?';
$stmt = $db->prepare($sql);
$result = $stmt->execute(array($_GET['id']));
if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo json_encode ($res);
} else {
  echo json_encode (array('status'=>'FAIL', 'msg'=>'Unable to get user', 'status'=>$stmt->errorInfo()));
}
