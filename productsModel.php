<?php
class productsModel
{
    public $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli('localhost', 'root', '', 'api');
        mysqli_set_charset($this->conexion, 'utf8');
    }
    public function getproducts($id = null)
    {
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $products = [];
        $sql = "SELECT * FROM products " . $where;
        $registros = mysqli_query($this->conexion, $sql);
        while ($row = mysqli_fetch_assoc($registros)) {
            array_push($products, $row);
        }
        return $products;
    }

    public function saveProducts($name, $description, $price)
    {
        $valida = $this->validateProducts($name, $description, $price);
        $resultado = ['succes', 'Ya existe un producto con las mismas acaracteristicas'];
        if (count($valida) == 0) {
            $sql = "INSERT INTO products(name,description,price)VALUES('$name','$description','$price')";
            mysqli_query($this->conexion, $sql);
            $resultado = ['succes', 'Producto guardado'];
        }
        return $resultado;
    }

    public function updateProducts($id, $name, $description, $price)
    {
        $existe = $this->getproducts($id);
        $resultado = ['error', 'No existe el producto con ID' . $id];
        if (count($existe) > 0) {
            $valida = $this->validateProducts($name, $description, $price);
            $resultado = ['succes', 'Ya existe un producto con las mismas acaracteristicas'];
            if (count($valida) == 0) {
                $sql = "UPDATE products SET name='$name', description='$description', price='$price' where id='$id'";
                mysqli_query($this->conexion, $sql);
                $resultado = ['succes', 'Producto actualizado'];
            }
        }
        return $resultado;
    }

    public function deleteProducts($id)
    {
        $valida = $this->getProducts($id);
        $resultado = ['error', 'No existe el producto con ID' . $id];
        if (count($valida) > 0) {
            $sql = "DELETE FROM products where id='$id'";
            mysqli_query($this->conexion, $sql);
            $resultado = ['succes', 'Producto eliminado'];
        }

        return $resultado;
    }
    public function validateProducts($name, $description, $price)
    {
        $products = [];
        $sql = "SELECT * FROM products WHERE name='$name' AND description='$description' AND price='$price'";
        $registros = mysqli_query($this->conexion, $sql);
        while ($row = mysqli_fetch_assoc($registros)) {
            array_push($products, $row);
        }
        return $products;
    }
}