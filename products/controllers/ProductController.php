<?php
require_once './models/Product.php';
require_once './config/database.php';

class ProductController {
    private $product;
    private $db;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->product = new Product($db);
    }

    public function index() {
        $result = $this->product->read();
        require_once './views/products/index.php';
    }

    public function create() {
        if ($_POST) {
            $this->product->name = $_POST['name'];
            $this->product->description = $_POST['description'];
            $this->product->price = $_POST['price'];
            $this->product->created = date('Y-m-d H:i:s');

            if ($this->product->create()) {
                header("Location: index.php");
            }
        }
        require_once './views/products/create.php';
    }

    public function update() {
        if ($_POST) {
            $this->product->id = $_POST['id'];
            $this->product->name = $_POST['name'];
            $this->product->description = $_POST['description'];
            $this->product->price = $_POST['price'];

            if ($this->product->update()) {
                header("Location: index.php");
            }
        }
        require_once './views/products/edit.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->product->id = $_GET['id'];
            if ($this->product->delete()) {
                header("Location: index.php");
            }
        }
    }
}
?>