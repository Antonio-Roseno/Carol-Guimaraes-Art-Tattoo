<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = ""; // Senha padrão do XAMPP é vazia
$dbname = "tatuagem";

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo e filtrando os dados do formulário
    $nome = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $telefone = htmlspecialchars($_POST['phone']);
    $dataNascimento = htmlspecialchars($_POST['birthdate']);
    $descricaoTatuagem = htmlspecialchars($_POST['tattooDescription']);
    $tamanhoTatuagem = htmlspecialchars($_POST['tattooSize']);
    $parteCorpo = htmlspecialchars($_POST['bodyPart']);
    $dataPreferencial = htmlspecialchars($_POST['preferredDate']);

    // Preparar a SQL para inserir os dados no banco
    $sql = "INSERT INTO agendamentos (nome, email, telefone, data_nascimento, descricao_tatuagem, tamanho_tatuagem, parte_corpo, data_preferencial)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar o statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar o SQL: " . $conn->error);
    }

    // Vincular os parâmetros
    $stmt->bind_param("ssssssss", $nome, $email, $telefone, $dataNascimento, $descricaoTatuagem, $tamanhoTatuagem, $parteCorpo, $dataPreferencial);

    // Executar a query
    if ($stmt->execute()) {
        // Enviar e-mail com os detalhes do agendamento
        $to = "netoduar@gmail.com"; // Email do destinatário
        $subject = "Novo Agendamento de Tatuagem";
        $message = "
        <h2>Agendamento realizado com sucesso!</h2>
        <p><strong>Nome Completo:</strong> $nome</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Telefone:</strong> $telefone</p>
        <p><strong>Data de Nascimento:</strong> $dataNascimento</p>
        <p><strong>Descrição da Tatuagem:</strong> $descricaoTatuagem</p>
        <p><strong>Tamanho da Tatuagem:</strong> $tamanhoTatuagem cm</p>
        <p><strong>Parte do Corpo:</strong> $parteCorpo</p>
        <p><strong>Data Preferencial:</strong> $dataPreferencial</p>
        ";
        
        // Cabeçalhos do e-mail
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@seudominio.com" . "\r\n";

        // Enviar o e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "<div style='color: green; text-align: center;'>E-mail enviado com sucesso para $to.</div>";
        } else {
            echo "<div style='color: red; text-align: center;'>Erro ao enviar e-mail.</div>";
        }

        // Exibir mensagem de sucesso com layout estilizado
        echo "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;'>
            <h2 style='color: #4CAF50; text-align: center;'>Agendamento realizado com sucesso!</h2>
            <p>Confira abaixo os detalhes do seu agendamento. Se precisar alterar alguma informação, edite e confirme novamente.</p>

            <form action='atualizar_agendamento.php' method='POST'>
                <label for='name'>Nome Completo:</label>
                <input type='text' id='name' name='name' value='" . $nome . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='email'>E-mail:</label>
                <input type='email' id='email' name='email' value='" . $email . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='phone'>Telefone:</label>
                <input type='tel' id='phone' name='phone' value='" . $telefone . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='birthdate'>Data de Nascimento:</label>
                <input type='date' id='birthdate' name='birthdate' value='" . $dataNascimento . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='tattooDescription'>Descrição da Tatuagem:</label>
                <textarea id='tattooDescription' name='tattooDescription' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>" . $descricaoTatuagem . "</textarea>

                <label for='tattooSize'>Tamanho da Tatuagem (cm):</label>
                <input type='text' id='tattooSize' name='tattooSize' value='" . $tamanhoTatuagem . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='bodyPart'>Parte do Corpo:</label>
                <input type='text' id='bodyPart' name='bodyPart' value='" . $parteCorpo . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <label for='preferredDate'>Data Preferencial:</label>
                <input type='date' id='preferredDate' name='preferredDate' value='" . $dataPreferencial . "' style='width: 100%; padding: 10px; margin: 5px 0; border-radius: 4px; border: 1px solid #ddd;' required>

                <div style='text-align: center; margin-top: 20px;'>
                    <button type='submit' style='padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>Atualizar Informações</button>
                </div>
            </form>
        </div>";
    } else {
        // Exibir mensagem de erro
        echo "<div style='color: red; text-align: center;'>Erro ao realizar agendamento: " . $stmt->error . "</div>";
    }

    // Fechar statement
    $stmt->close();
}

// Fechar conexão
$conn->close();
?>
