<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = ""; // Senha padrão do XAMPP é vazia
$dbname = "tatuagem";

// Habilitando a exibição de erros para desenvolvimento (desativar em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificando se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturando os dados enviados via AJAX
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

    // Captura de campos opcionais
    $alergias = $_POST['allergies'] ?? '';
    $medicamentos = $_POST['medications'] ?? '';
    $gravida_amamentando = $_POST['pregnant'] ?? '';
    $condicoes_pele = $_POST['skinConditions'] ?? '';
    $sensibilidade_pele = $_POST['skin_sensitivity'] ?? '';
    $bronzeamento = $_POST['skin_bronzeamento'] ?? '';
    $informacoes_adicionais = $_POST['additionalInfo'] ?? '';

    // SQL para inserção dos dados no banco de dados
    $sql = "INSERT INTO agendamentos (nome_completo, email, telefone, data_nascimento, descricao_tatuagem, tamanho_tatuagem, parte_corpo, data_preferencial, condicoes_medicas, alergias, medicamentos, gravida_amamentando, condicoes_pele, sensibilidade_pele, bronzeamento, informacoes_adicionais)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparando e vinculando os parâmetros para evitar SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssssssssss", $nome_completo, $email, $telefone, $data_nascimento, $descricao_tatuagem, $tamanho_tatuagem, $parte_corpo, $data_preferencial, $condicoes_medicas, $alergias, $medicamentos, $gravida_amamentando, $condicoes_pele, $sensibilidade_pele, $bronzeamento, $informacoes_adicionais);

        // Executando a query e verificando se foi bem-sucedida
        if ($stmt->execute()) {
            echo "Agendamento realizado com sucesso!";
        } else {
            // Se houve erro na execução da query, exibe o erro
            echo "Erro ao executar a query: " . $stmt->error;
        }

        // Fechando a conexão
        $stmt->close();
    } else {
        // Se houve erro ao preparar a query, exibe o erro
        echo "Erro ao preparar a query: " . $conn->error;
    }

    // Fechando a conexão
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}

