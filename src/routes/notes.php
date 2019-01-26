<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todas las notes
$app->get('/api/notes', function(Request $request, Response $response){
    $sql = "SELECT * FROM notes";
    try {
        $db = new db();
        $db = $db->connectDB();
        $result = $db->query($sql);
        if ($result->rowCount() > 0){
            $notes = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($notes);
        } else {
            echo json_encode("No existen notes en la BBDD");
        }
        $result = null;
        $db = null;
    } catch(PDOException $e) {
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

// GET notes por ID
$app->get('/api/notes/{id}', function(Request $request, Response $response){
    $id_note = $request->getAttribute('id');
    $sql = "SELECT * FROM notes WHERE id = $id_note";
    try {
        $db = new db();
        $db = $db->connectDB();
        $result = $db->query($sql);
        if ($result->rowCount() > 0){
            $notes = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($notes);
        } else {
            echo json_encode("No existen notes en la BBDD");
        }
        $result = null;
        $db = null;
    } catch(PDOException $e) {
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

// POST Crear nueva note
$app->post('/api/notes/new', function(Request $request, Response $response){
    $title = $request->getParam('title');
    $content = $request->getParam('content');
    $book = $request->getParam('book');
    $user = $request->getParam('user');

    $sql = "INSERT INTO notes (title, content, book, user) VALUES (:title, :content, :book, :user)";
    try {
        $db = new db();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->bindParam(':title', $title);
        $result->bindParam(':content', $content);
        $result->bindParam(':book', $book);
        $result->bindParam(':user', $user);

        $result->execute();
        echo json_encode("New note added");

        $result = null;
        $db = null;
    } catch(PDOException $e) {
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

// DELETE note
$app->delete('/api/notes/delete/{id}', function(Request $request, Response $response){
    $id_note = $request->getAttribute('id');

    $sql = "DELETE FROM notes WHERE id = $id_note";

    try {
        $db = new db();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->execute();

        if ($result->rowCount() > 0){
            echo json_encode("Note deleted");
        } else {
            echo json_encode("Note doenst exist");
        }

        $result = null;
        $db = null;
    } catch(PDOException $e) {
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});