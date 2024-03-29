<?
require_once dirname(__FILE__) . "/./ApplicationController.php";
require_once dirname(__FILE__) . '/../models/User.php';

class RegistrationsController extends ApplicationController{
  public function new() {
    $title = "新規登録";
    $body = __DIR__ . '/../views/registrations/new.php';
    echo view($title, $body);
  }

  public function create() {
    if (
      !isset($_POST['lastname']) || $_POST['lastname'] === '' ||
      !isset($_POST['firstname']) || $_POST['firstname'] === '' ||
      !isset($_POST['email']) || $_POST['email'] === '' ||
      !isset($_POST['password']) || $_POST['password'] === '' ||
      !isset($_POST['password_re']) || $_POST['password_re'] === '' ||
      !isset($_POST['zip_code']) || $_POST['zip_code'] === '' ||
      !isset($_POST['address']) || $_POST['address'] === ''
    ) {
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/kit-web-application/sign-up', true, 302);
      exit();
    }

    if ($_POST['password'] != $_POST['password_re']) {
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/kit-web-application/sign-up', true, 302);
      echo "パスワードが異なります。";
      exit();
    }

    $params = array(
      'name'     => $_POST['lastname'] . ' ' . $_POST['firstname'],
      'email'    => $_POST['email'],
      'password' => $_POST['password'],
      'zip_code' => $_POST['zip_code'],
      'address'  => $_POST['address'],
      'is_admin' => false
    );

    $user = new User($params);
    $user->save();

    session_start();
    $_SESSION['id']       = $user->id;
    $_SESSION['name']     = $user->name;
    $_SESSION['is_admin'] = $user->is_admin;
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/kit-web-application/', true, 302);
    exit();
  }

  public function destroy() {
    parent::is_logged_in();
    $reg_result;
    $queries;

    preg_match('/\d+/', $_SERVER["REQUEST_URI"], $reg_result);
    $id = $reg_result[0];
    User::destroy($id);
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/kit-web-application/manegements?tab=users', true, 302);
    exit();
  }
}
