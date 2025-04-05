<?php
class CookieController {
    function encrypt($data) {
        $key = hash('sha256', 'macarrones', true);
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedData);
    }
    

    public function createBillingAddress(string $address) {
        $address ? setcookie('billing', $address, time() + 3600 * 7, '/') : throw new Exception('La dirección de facturación no es válida');
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    public function createDefaultAddress(string $address) {
        $address ? setcookie('defecto', $address, time() + 3600 * 7, '/') : throw new Exception('La dirección por defecto no es válida');
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    public function createCurrency(string $currency) {
        in_array($currency, ['eur', 'usd', 'gbp']) ? setcookie('divisa', $currency, time() + 3600 * 7, '/') : throw new Exception('La divisa no es válida');
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    public function createCardData(array $card) {
        $number = $this->encrypt($card['number']);
        $date = $this->encrypt($card['date']);
        $cvc = $this->encrypt($card['cvc']);
    
        setcookie('tarjeta', serialize(['number' => $number, 'date' => $date, 'cvc' => $cvc]), time() + 3600 * 7, '/');
    }
}