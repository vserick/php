<form method="POST" enctype="multipart/form-data">

    <label for="cep">CEP <a style="color: red">*</a></label>
    <br>
    <input type="text" name="cep" required>

    <button type="submit">Send</button>

</form>

<?php

#Realiza a requisição à rotina ViaCEP, e retorna os dados do endereço.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    

    $cep = $_POST["cep"];

    if (!empty(trim($cep))) {

        $link = "https://viacep.com.br/ws/" . $cep . "/json/";

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data) == true) {

            if (array_key_exists("cep", $data)) {
                foreach ($data as $info => $value) {

                    echo ucfirst($info) . ": " . $value . "<br>";

                }
            }

        } else {

            echo "<br><b>Ooops!</b><br> Não encontramos esse CEP!";

        }
    }

}

?>
