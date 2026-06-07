<?php
function redirect(string $url): void {
    header('Location: ' . $url);
    exit();
}

function sanitize(string $val): string {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

function formatDate(string $date): string {
    return date('d/m/Y', strtotime($date));
}

function formatTime(string $time): string {
    return date('h:i A', strtotime($time));
}

function flashMessage(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
