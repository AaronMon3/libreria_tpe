<?php
class SessionMiddleware {
    public function run($req) {
        if (isset($_SESSION['id'])) {
            $req->user = new StdClass();
            $req->user->id = $_SESSION['id'];
            $req->user->email = $_SESSION['email'];
        } else {
            $req->user = null;
        }
        return $req;
    }
}
