<?php
class Cart
{
    public $cart;
    public $total;
    public $products;
    public function __construct()
    {
        $this->cart = array();
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function addToCart(Products $product)
    {
        $this->cart = $_SESSION['cart'];

        if (!$this->existP($product)) {
            $product->quantity = 1;
            array_push($this->cart, $product);
        }
        $_SESSION['cart'] = $this->cart;
    }
    public function deleteItem($id)
    {
        $this->cart = $_SESSION['cart'];
        $products = $_SESSION['products'];
        foreach ($this->cart as $key => $value) {
            if ($value->id == $id) {
                array_splice($this->cart, $key, 1);
            }
        }
        $_SESSION['cart'] = $this->cart;
    }

    public function existP($product)
    {
        foreach ($this->cart as $k => $p) {
            if ($p->id == $product->id) {
                $this->cart[$k]->quantity += 1;
                return true;
            }
        }
        return false;
    }

    public function displayCart()
    {
        $this->cart = $_SESSION['cart'];
        $_SESSION['total'] = 0;
        $total = $_SESSION['total'];
        if (isset($this->cart)) {
            if (count($this->cart) >= 1) {
                echo "<table><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Remove</th>
                    </tr>";
                foreach ($this->cart as $key => $product) {
                    $total =  $total + $product->price * $product->quantity;
                    $_SESSION['price'] = $product->price * $product->quantity;
                    echo "<tr>
                        <td>" . $product->id . "</td>
                        <td>" . $product->name . "</td>
                        <td>" . $product->quantity . "</td>
                        <td>" . $product->price * $product->quantity . "</td>
                        <td><button><a href=empty.php?id=" . $product->id . ">X</a></button></td>
                    </tr>";
                }
                echo "</table>";
                echo "<table id='total'><tr><th>TOTAL PRICE:</th><td>" . $total . "</td></table>";
            }
        }
        $_SESSION['cart'] = $this->cart;
        $_SESSION['total'] = $total;
    }
}
