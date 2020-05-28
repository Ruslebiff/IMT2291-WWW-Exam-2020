<?php
/**
 * Returns an array containing all registered users on the system.
 * For each user uid, uname, firstName, lastName and hasAvatar will be returned.
 */

header("Content-Type: application/json; charset=utf-8");

require_once ('../classes/DB.php');
$db = DB::getDBConnection();
$sql = 'SELECT uid, uname, firstName, lastName, !ISNULL(NULLIF(avatar,"")) as hasAvatar FROM user';
$stmt = $db->prepare($sql);
$result = $stmt->execute(array());
if ($result) {
  echo json_encode ($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
  echo json_encode (array('status'=>'FAIL', 'msg'=>'Unable to get users', 'status'=>$stmt->errorInfo()));
}
