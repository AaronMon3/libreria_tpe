<?php
class GuardMiddleware {
    public function run($req) {
        if (!$req->user) {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
        return $req;
    }
}
