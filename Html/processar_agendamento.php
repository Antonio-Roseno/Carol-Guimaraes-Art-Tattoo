<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Ajuste conforme necessário
$password = "";     // Ajuste conforme necessário
$dbname = "tatuagem";

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura dos dados do formulário
    $nome_completo = $_POST['name'];
    $email = $_POST['email'];
    $telefone = $_POST['phone'];
    $data_nascimento = $_POST['birthdate'];
    $descricao_tatuagem = $_POST['tattooDescription'];
    $tamanho_tatuagem = $_POST['tattooSize'];
    $parte_corpo = $_POST['bodyPart'];
    $data_preferencial = $_POST['preferredDate'];

    // Condições médicas (checkbox múltiplo)
    $condicoes_medicas = isset($_POST['conditions']) ? implode(', ', $_POST['conditions']) : '';

    // Outros campos opcionais
    $alergias = $_POST['allergies'] ?? '';
    $medicamentos = $_POST['medications'] ?? '';
    $gravida_amamentando = $_POST['pregnant'] ?? '';
    $condicoes_pele = $_POST['skinConditions'] ?? '';
    $sensibilidade_pele = $_POST['skin_sensitivity'] ?? '';
    $bronzeamento = $_POST['skin_bronzeamento'] ?? '';
    $informacoes_adicionais = $_POST['additionalInfo'] ?? '';

    // SQL para inserção dos dados
    $sql = "INSERT INTO agendamentos (nome_completo, email, telefone, data_nascimento, descricao_tatuagem, tamanho_tatuagem, parte_corpo, data_preferencial, condicoes_medicas, alergias, medicamentos, gravida_amamentando, condicoes_pele, sensibilidade_pele, bronzeamento, informacoes_adicionais)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparando e vinculando os parâmetros para evitar SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssss", $nome_completo, $email, $telefone, $data_nascimento, $descricao_tatuagem, $tamanho_tatuagem, $parte_corpo, $data_preferencial, $condicoes_medicas, $alergias, $medicamentos, $gravida_amamentando, $condicoes_pele, $sensibilidade_pele, $bronzeamento, $informacoes_adicionais);

    // Executando a query e verificando se foi bem-sucedida
    if ($stmt->execute()) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Fechando a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
