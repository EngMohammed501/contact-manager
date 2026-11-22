<?php

class ContactController
{
    private Contact $contactModel;
    private string $adminUsername = 'admin';
    private string $adminPasswordHash;

    public function __construct(PDO $pdo)
    {
        $this->contactModel = new Contact($pdo);
        $this->adminPasswordHash = password_hash('Admin@123', PASSWORD_DEFAULT);
    }

    private function isLoggedIn(): bool
    {
        return !empty($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    private function requireAdmin(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function index(): void
    {
        $contacts = $this->contactModel->getAll();
        $isLoggedIn = $this->isLoggedIn();
        require __DIR__ . '/../views/contacts/index.php';
    }

    public function login(): void
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim((string)($_POST['username'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            if ($username === $this->adminUsername && password_verify($password, $this->adminPasswordHash)) {
                session_regenerate_id(true);
                $_SESSION['is_admin'] = true;
                header('Location: index.php');
                exit;
            }

            $error = 'Invalid username or password.';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: index.php');
        exit;
    }

    public function create(): void
    {
        $this->requireAdmin();
        $error = '';
        $old = [];
        require __DIR__ . '/../views/contacts/create.php';
    }

    public function store(): void
    {
        $this->requireAdmin();
        $error = '';

        $name  = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $phone = trim((string)($_POST['phone'] ?? ''));
        $old   = ['name' => $name, 'email' => $email, 'phone' => $phone];

        if ($name === '' || mb_strlen($name) > 100) {
            $error = 'Name is required and must be at most 100 characters.';
        } elseif ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $error = 'Please enter a valid email address.';
        } elseif ($phone === '' || !preg_match('/^[0-9+\-\s()]{6,25}$/', $phone)) {
            $error = 'Please enter a valid phone number.';
        }

        if ($error !== '') {
            require __DIR__ . '/../views/contacts/create.php';
            return;
        }

        $this->contactModel->create($name, $email, $phone);
        header('Location: index.php');
        exit;
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $contact = $this->contactModel->findById($id);
        if (!$contact) {
            header('Location: index.php');
            exit;
        }

        $error = '';
        require __DIR__ . '/../views/contacts/edit.php';
    }

    public function update(): void
    {
        $this->requireAdmin();
        $error = '';

        $id    = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name  = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $phone = trim((string)($_POST['phone'] ?? ''));

        if (!$id) {
            header('Location: index.php');
            exit;
        }

        if ($name === '' || mb_strlen($name) > 100) {
            $error = 'Name is required and must be at most 100 characters.';
        } elseif ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $error = 'Please enter a valid email address.';
        } elseif ($phone === '' || !preg_match('/^[0-9+\-\s()]{6,25}$/', $phone)) {
            $error = 'Please enter a valid phone number.';
        }

        if ($error !== '') {
            $contact = ['id' => $id, 'name' => $name, 'email' => $email, 'phone' => $phone];
            require __DIR__ . '/../views/contacts/edit.php';
            return;
        }

        $this->contactModel->update($id, $name, $email, $phone);
        header('Location: index.php');
        exit;
    }

    public function delete(): void
    {
        $this->requireAdmin();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $this->contactModel->delete($id);
        }

        header('Location: index.php');
        exit;
    }
}