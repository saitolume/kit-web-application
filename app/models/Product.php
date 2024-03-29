<?
require_once dirname(__FILE__) . "/./ApplicationModel.php";

class Product extends ApplicationModel {
  public $id;
  public $name;
  public $description;
  public $image_url;
  public $category;
  public $price;
  public $created_at;

  public function __construct($params) {
    $this->name = $params['name'];
    $this->description = $params['description'];
    $this->image_url = $params['image_url'];
    $this->category = $params['category'];
    $this->price = $params['price'];
  }

  public function all() {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('SELECT * from products');
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }

  public function all_with_limit($count) {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('SELECT * from products LIMIT :count');
      $sth->bindValue(':count', "$count", PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }

  public function find_by_name($name) {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('SELECT * from products WHERE name LIKE :name');
      $sth->bindValue(':name', "%$name%", PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }
  public function find_by_category($category) {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('SELECT * from products WHERE category = :category');
      $sth->bindValue(':category', $category, PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }
  public function find_by_id($id) {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('SELECT * from products WHERE id = :id');
      $sth->bindValue(':id', $id, PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }
  public function get_category(){
      try {
         $db = parent::connect_db();
         $sth = $db->prepare('select distinct category from products;');
         $sth->execute();
         $result = $sth->fetchAll(PDO::FETCH_COLUMN);
         return $result;
       } catch (PDOException $e) {
         die('Error:' . $e->getMessage());
      }
  }

  public function save() {
    $db = parent::connect_db();
    $insert_sth = $db->prepare('
      INSERT INTO products (name, description, image_url, category, price)
      VALUES (:name, :description, :image_url, :category, :price)
    ');
    $insert_sth->bindValue(':name',        $this->name,        PDO::PARAM_STR);
    $insert_sth->bindValue(':description', $this->description, PDO::PARAM_STR);
    $insert_sth->bindValue(':image_url',   $this->image_url,   PDO::PARAM_STR);
    $insert_sth->bindValue(':category',    $this->category,    PDO::PARAM_STR);
    $insert_sth->bindValue(':price',       $this->price,       PDO::PARAM_STR);
    $insert_sth->execute();
    $this->id = $db->lastInsertId();

    $select_sth = $db->query("SELECT created_at FROM products WHERE id = $this->id");
    $select_result = $select_sth->fetch(PDO::FETCH_ASSOC);
    $this->created_at = $select_result['created_at'];
  }

  public function destroy($id) {
    try {
      $db = parent::connect_db();
      $sth = $db->prepare('DELETE from products where id = :id');
      $sth->bindValue(':id', $id, PDO::PARAM_INT);
      $sth->execute();
    } catch (PDOException $e) {
      die('Error:' . $e->getMessage());
    }
  }

  public function update($params) {
    $db = parent::connect_db();
    $insert_sth = $db->prepare('
      UPDATE products
      SET name=:name, description=:description, image_url=:image_url, category=:category, price=:price
      WHERE id = :id
    ');
    $insert_sth->bindValue(':id',          $params['id'],          PDO::PARAM_INT);
    $insert_sth->bindValue(':name',        $params['name'],        PDO::PARAM_STR);
    $insert_sth->bindValue(':description', $params['description'], PDO::PARAM_STR);
    $insert_sth->bindValue(':image_url',   $params['image_url'],   PDO::PARAM_STR);
    $insert_sth->bindValue(':category',    $params['category'],    PDO::PARAM_STR);
    $insert_sth->bindValue(':price',       $params['price'],       PDO::PARAM_STR);
    $insert_sth->execute();
    $this->id = $db->lastInsertId();

    $select_sth = $db->query("SELECT created_at FROM products WHERE id = $this->id");
    $select_result = $select_sth->fetch(PDO::FETCH_ASSOC);
    $this->created_at = $select_result['created_at'];
  }
}
