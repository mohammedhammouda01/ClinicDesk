<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';

class AuthController {
    public function showLogin(): void {
        if (Auth::check()) {
            redirect(BASE_URL . '/index.php?page=dashboard');
        }
        $pageTitle = 'Login';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function handleLogin(): void {
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=login');
        }
        $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $model    = new UserModel();
        $user     = $model->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            flashMessage('error', 'Invalid credentials.');
            redirect(BASE_URL . '/index.php?page=login');
        }
        if (!$user['is_active']) {
            flashMessage('error', 'Account suspended. Contact admin.');
            redirect(BASE_URL . '/index.php?page=login');
        }
        Auth::login($user);
        redirect(BASE_URL . '/index.php?page=dashboard');
    }

    public function handleLogout(): void {
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            redirect(BASE_URL . '/index.php?page=dashboard');
        }
        Auth::logout();
    }
}
