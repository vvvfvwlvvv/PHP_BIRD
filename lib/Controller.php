<?php

namespace Felix\StudyProject;

class Controller
{
    /**
     * Обработка запроса от пользователя
     *
     * todo Распарсить $_REQUEST['REQUEST_URI'] и понять какую страницу показывать
     * todo Проверку надо усложнить, чтобы учитывался http метод
     * todo Подключать хедер и футер
     *
     * @return void
     */
    public function process(): void
    {
        
        $page = str_replace('/', '', $_SERVER['REQUEST_URI']);
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        
        if ($httpMethod === "GET") {
            switch ($page) {
                case 'form':
                    $result = $this->formAction();
                    break;
                case 'list':
                    $result = $this->listAction();
                    break;
                default:
                    header('Location: /form');
                    $result = null;
            }
        }
        else {
            switch ($page) {
                case 'send':
                    $result = $this->sendAction();
                    break;
                default:
                    header('Location: /form');
                    $result = null;
            }
        }

        if (!is_null($result)) {
            echo $result;
        }
        
    
    }

    /**
     * Вызывается на запрос GET /form
     *
     * todo Показ формы
     *
     * @return string
     */
    protected function formAction(): string {
        $var = "";
        require_once './template/header.php';
        require_once './template/form.php';
        require_once './template/footer.php';

        return '';
    }

    /**
     * Вызывается на запрос GET /list
     *
     * todo Показ списка сохранённых в базу форм
     *
     * @return string
     */
    protected function listAction(): string
    {
        $createTableSql = <<<SQL
        SELECT * FROM form
        SQL;
        try {
            $database = new Database();
            $result = $database->query($createTableSql);
        } catch (\Throwable $throwable) {
            
        }

        while ($row = $result->fetchArray()) {
        var_dump($row);}
        return '';
    }

    /**
     * Вызывается на запрос POST /send
     *
     * todo Обработка и сохранение данных формы, ответ в формате json с обработкой на js
     *
     * @return string
     */
    protected function sendAction(): string
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $createTableSql = <<<SQL
        INSERT INTO form (name_person, email_person, link_person) VALUES ('{$data['name']}', '{$data['email']}', '{$data['link']}')
SQL;
        

        try {
            $database = new Database();
            $database->query($createTableSql);
        } catch (\Throwable $throwable) {
           $result = ['error' => 'database error'];
           return json_encode($result);
        }

        

        return $json;
    }
}