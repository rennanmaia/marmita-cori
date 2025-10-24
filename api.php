<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "marmita_cori");

function response($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

switch ($uri[0]) {
    case 'user_type':
        if ($method == 'GET') {
            $result = $mysqli->query("SELECT * FROM user_type");
            response($result->fetch_all(MYSQLI_ASSOC), 200);
        } elseif ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $mysqli->prepare("INSERT INTO user_type (name) VALUES (?)");
            $stmt->bind_param("s", $data['name']);
            $stmt->execute();
            response(['id' => $stmt->insert_id], 201);
        }
        break;
    case 'user':
        if ($method == 'GET') {
            $result = $mysqli->query("SELECT * FROM user");
            response($result->fetch_all(MYSQLI_ASSOC), 200);
        } elseif ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $mysqli->prepare("INSERT INTO user (name, user_type_id) VALUES (?, ?)");
            $stmt->bind_param("si", $data['name'], $data['user_type_id']);
            $stmt->execute();
            response(['id' => $stmt->insert_id], 201);
        }
        break;
    case 'menu':
        if ($method == 'GET') {
            $result = $mysqli->query("SELECT * FROM menu");
            response($result->fetch_all(MYSQLI_ASSOC), 200);
        } elseif ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $mysqli->prepare("INSERT INTO menu (date) VALUES (?)");
            $stmt->bind_param("s", $data['date']);
            $stmt->execute();
            response(['id' => $stmt->insert_id], 201);
        }
        break;
    case 'menu_option':
        if ($method == 'GET') {
            // Filtros opcionais
            $where = [];
            $params = [];
            $types = '';
            if (isset($_GET['menu_id'])) {
                $where[] = 'menu_id = ?';
                $params[] = $_GET['menu_id'];
                $types .= 'i';
            }
            if (isset($_GET['user_type_id'])) {
                $where[] = 'user_type_id = ?';
                $params[] = $_GET['user_type_id'];
                $types .= 'i';
            }
            $sql = 'SELECT * FROM menu_option';
            if ($where) {
                $sql .= ' WHERE ' . implode(' AND ', $where);
            }
            $stmt = $mysqli->prepare($sql);
            if ($where) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === false) {
                response(['error' => 'Erro na consulta SQL: ' . $mysqli->error, 'sql' => $sql], 500);
            }
            response($result->fetch_all(MYSQLI_ASSOC), 200);
        } elseif ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $mysqli->prepare("INSERT INTO menu_option (menu_id, user_type_id, description) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $data['menu_id'], $data['user_type_id'], $data['description']);
            $stmt->execute();
            response(['id' => $stmt->insert_id], 201);
        }
        break;
    case 'delivery':
        if ($method == 'GET') {
            $result = $mysqli->query("SELECT * FROM delivery");
            response($result->fetch_all(MYSQLI_ASSOC), 200);
        } elseif ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $mysqli->prepare("INSERT INTO delivery (user_id, menu_option_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $data['user_id'], $data['menu_option_id']);
            $stmt->execute();
            response(['id' => $stmt->insert_id], 201);
        }
        break;
    default:
        response(['error' => 'Endpoint não encontrado'], 404);
}
?>
